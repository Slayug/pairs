<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Hash;
use Cake\ORM\TableRegistry;
use Cake\Core\App;
use Cake\Datasource\ConnectionManager;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class ModulesController extends AppController
{

	/**
	 * Methode permettant de gérer les droits pour
	 * ce controller
	 * on suppose d'abord que l'utilisateur est déjà connecté
	 * et on vérifie ensuite ses droits
	 * - Si il a accès à la page
	 * - et si c'est le propriétaire de contenu de la page
	 * 
	 **/
	public function isAuthorized($user){
		$role = $user['role_id'];
		$action = $this->request->params['action'];
		
		$idModule = null;
		if($this->request->pass != null){
			if(ctype_digit($this->request->pass['0'])){ // on vérifie que c'est bien un entier
				$idModule = $this->request->pass['0'];
			}
		}
		
		$canAccess = 0;
		$isOwner = 0;
		
		if(in_array($action, ['deleteGroup'])){
			$canAccess = $isOwner = GroupsController::isAuthorized($user);
			
		}else if($idModule != null){
			$modules = TableRegistry::get('modules');
			$queryAccess = $modules->find()->hydrate(false)
									 ->join([
										'mg' => [ // on join les modules
											'table' => 'modules_groups',
											'type' => 'INNER',
											'conditions' => 'mg.module_id = modules.id',
										],
										'gu' => [ // on join les users associés au join précédent
											'table' => 'groups_users',
											'type' => 'INNER',
											'conditions' => 'mg.group_id = gu.group_id',
										]
									
									])
									->where(['gu.user_id' => $user['id']])
									->andWhere(['modules.id' => $idModule]); // et on cible le module où on est
			
			$isOwner = $this->isOwner();
			$canAccess = $queryAccess->count() + $isOwner;
		}
		
		if(in_array($action, ['edit', 'delete', 'deleteGroup', 'add', 'importGroup'])){
			if($role == 2){ // professeur
				if(in_array($action, ['add'])){
					return true;
				}
				// on vérifie si le module est bien au professeur
				if($canAccess && $isOwner){
					return true;
				}
			}
		}else if(in_array($action, ['view'])){
			//un étudiant peut voir un module pour consulter son/ses groupes dedans
			//on doit aussi tester si l'étudiant est bien dans ce module de même pour le professeur
			if($role >= 2 && $canAccess){
				return true;
			}
		}
		
		return parent::isAuthorized($user);
		
	}
	
	/**
	*	Permet de vérifier si l'utilisateur actuellement connecté
	*	est le propriétaire de ce module
	*/
	private function isOwner(){
		$modules = TableRegistry::get('modules');
		$queryOwner = $modules->find()->matching('Owners', function($q){
			$session = $this->request->session();
			$currentUser = $session->read('Auth.User');
			$idUser = $currentUser['id'];
			$id = null;
			if($this->request->pass != null){
				if(ctype_digit($this->request->pass['0'])){ // on vérifie que c'est bien un entier
					$id = $this->request->pass['0'];
				}
			}
			return $q
						->select(['Owners.id', 'modules.name'])
						->where(['Owners.id' => $idUser,
								'modules.id' => $id]);
		});
		return $queryOwner->count();
	}
	
	
	/**
	*	Permet d'importer un ou plusieurs groupe(s) depuis un document .xlsx ou .ods
	*	trois types d'organisations de tableau peuvent être comprise
	*
	*	TYPE 1)
	*	Groupe | Etudiant
	*	1	   | Paul DUPONT
	*		   | Marie DUPONT
	*	2	   | Jean DUPONT
	*		   | Jim DUPONT
	*		   | Manon DUPONT
	*
	*	TYPE 2)
	*	Groupe | Etudiant 1 	| Etudiant 2
	*	1	   | Paul DUPONT	| Jim
	*	2	   | Alexis	DUPONT	| Manon
	*
	*	TYPE 3)
	*	1
	*	Paul DUPONT
	*	Marie DUPONT
	*	2
	*	Jim DUPONT
	*	Manon DUPONT
	*
	*/
	public function importGroup($idModule = null){
		require_once(ROOT . DS . 'vendor' . DS  . 'phpexcel' . DS . 'Classes' . DS . 'PHPExcel.php');
		require_once(ROOT . DS . 'vendor' . DS  . 'phpexcel' . DS . 'Classes' . DS . 'PHPExcel' . DS . 'IOFactory.php');
		$phpExcel = new \PHPExcel();
		
		//gestion de l'extension du fichier
		$name = $this->request->data['submittedfile']['name'];
		$ext = 'Excel2007';
		if(strstr($name, '.')){
			$names = explode('.', $name);
			if(count($names) == 2){
				if(strtolower($names[1]) == 'ods'){
					$ext = 'OOCalc';
				}else if(strtolower($names[1]) == 'xls'){
					$ext = 'Excel5';
				}
			}else{
				$this->Flash->error('Le nom du fichier contient une erreur.');
				return $this->redirect(['controller' => 'Modules', 'action' => 'view', $idModule]);			
			}
		}else{
            $this->Flash->error('Le nom du fichier contient une erreur.');
			return $this->redirect(['controller' => 'Modules', 'action' => 'view', $idModule]);	
		}
		
		$objReader = \PHPExcel_IOFactory::createReader($ext);
		$objReader->setReadDataOnly(true);

		$objPHPExcel = $objReader->load($this->request->data['submittedfile']['tmp_name']);
		$objWorksheet = $objPHPExcel->getActiveSheet();

		$highestRow = $objWorksheet->getHighestRow(); 
		$highestColumn = $objWorksheet->getHighestColumn();
		
		//tableau qui contiendra les groupes à créer.
		$groups = array();
		
		
		$firstCase = $objWorksheet->getCellByColumnAndRow('A', 1)->getValue();
		// on check déjà la première valeur pour savoir sur quel type de tableau on va tomber
		if(stristr($firstCase, 'groupe')){
			// Dans ce cas on se trouve soit dans le TYPE 1) ou le TYPE 2)
			$bOne = $objWorksheet->getCellByColumnAndRow(1, 1)->getValue();		
			if(containsInteger($bOne)){
				// On se trouve dans le TYPE 2)
				$highestColumn = ord($highestColumn)-65;
				$data = array();
				for($row = 2; $row <= $highestRow; $row++){
					array_push($groups,  $this->Modules->Groups->newEntity()); // on ajoute un groupe à la liste à ajouter
					$n = count($groups) - 1;
					$session = $this->request->session();						
					$currentUser = $session->read('Auth.User'); // on récupère l'utilisateur actuel pour l'associer avec le(s) groupe(s)
					$columnA = $objWorksheet->getCellByColumnAndRow(0, $row)->getValue();
					$data = [
						'name' => 'Groupe ' . $columnA,
						'description' => 'Groupe ' . $columnA,
						'owners' => [
							['id' => $currentUser['id']],
						],
						'users' => array()
					];
					for($column = 1; $column <= $highestColumn; $column++){
						$columnB = $objWorksheet->getCellByColumnAndRow($column, $row)->getValue();
						$n = count($groups) - 1;
						$names = $this->splitName($columnB);
						$user = null;
						if($names != null){
							$user = $this->getUserFromNames($names[0], $names[1]);
							if($user == null){
								$user = $this->createUser($names[0], $names[1]);
							}
						}
						if($user != null){
							array_push($data['users'], ['id' => $user->id]);						
						}
					}
					$groups[$n] = $this->Modules->Groups->patchEntity($groups[$n], $data);
					$moduleSelected = $this->Modules->get($idModule);
					$groups[$n]->modules = [$moduleSelected];
				}
			}else{
				// On se trouve dans le TYPE 1)
				$data = array();
				for($row = 2; $row <= $highestRow; $row++){
					$columnA = $objWorksheet->getCellByColumnAndRow(0, $row)->getValue();
					if($columnA != ''){
						array_push($groups,  $this->Modules->Groups->newEntity()); // on ajoute un groupe à la liste à ajouter
						$n = count($groups) - 1;
						$session = $this->request->session();						
						$currentUser = $session->read('Auth.User'); // on récupère l'utilisateur actuel pour l'associer avec le(s) groupe(s)
						$data = [
							'name' => 'Groupe ' . $columnA,
							'description' => 'Groupe ' . $columnA,
							'owners' => [
								['id' => $currentUser['id']],
							],
							'users' => array()
						];
						
					}
					$columnB = $objWorksheet->getCellByColumnAndRow(1, $row)->getValue();
					$n = count($groups) - 1;
					$names = $this->splitName($columnB);
					$user = null;
					if($names != null){
						$user = $this->getUserFromNames($names[0], $names[1]);
						if($user == null){
							$user = $this->createUser($names[0], $names[1]);
						}
					}
					if($user != null){
						array_push($data['users'], ['id' => $user->id]);						
					}
					$groups[$n] = $this->Modules->Groups->patchEntity($groups[$n], $data);
					$moduleSelected = $this->Modules->get($idModule);
					$groups[$n]->modules = [$moduleSelected];
				}
			}
		}else{
			// Dans ce cas on se trouve dans le TYPE 3)
			for($row = 1; $row <= $highestRow; $row++){
					$columnA = $objWorksheet->getCellByColumnAndRow(0, $row)->getValue();
					if(containsInteger($columnA)){
						array_push($groups,  $this->Modules->Groups->newEntity()); // on ajoute un groupe à la liste à ajouter
						$n = count($groups) - 1;
						$session = $this->request->session();						
						$currentUser = $session->read('Auth.User'); // on récupère l'utilisateur actuel pour l'associer avec le(s) groupe(s)
						$data = [
							'name' => 'Groupe ' . $columnA,
							'description' => 'Groupe ' . $columnA,
							'owners' => [
								['id' => $currentUser['id']],
							],
							'users' => array()
						];
						$row++;
						$columnA = $objWorksheet->getCellByColumnAndRow(0, $row)->getValue();
					}
					$n = count($groups) - 1;
					if($n < 0){
						$this->Flash->error('Le fichier contient une erreur, merci de le vérifier avec les exemples fournis.');
						return $this->redirect(['controller' => 'Modules', 'action' => 'view', $idModule]);
					}
					$names = $this->splitName($columnA);
					$user = null;
					if($names != null){
						$user = $this->getUserFromNames($names[0], $names[1]);
						if($user == null){
							$user = $this->createUser($names[0], $names[1]);
						}
					}
					if($user != null){
						array_push($data['users'], ['id' => $user->id]);						
					}
					$groups[$n] = $this->Modules->Groups->patchEntity($groups[$n], $data);
					$moduleSelected = $this->Modules->get($idModule);
					$groups[$n]->modules = [$moduleSelected];			
			}
			
		}
		$success = true;
		$transaction = ConnectionManager::get('default'); // permet de faire un rollback si une des insertions plantes
		$transaction->begin();
		for($i = 0; $i < count($groups); $i++){
			$success = $success AND $this->Modules->Groups->save($groups[$i]);
		}
		if($success){
			$transaction->commit();
			$this->Flash->success('Le(s) groupe(s) ont bien été ajouté(s) avec succès.');
			return $this->redirect(['controller' => 'Modules', 'action' => 'view', $idModule]);
		}else{
			$transaction->rollback();
			$this->Flash->success('Une erreur s\'est produite, merci de vérifier le fichier avec les exemples fournis.');
			return $this->redirect(['controller' => 'Modules', 'action' => 'view', $idModule]);
		}
	
	}
	
	
	
	/**
	*
	* @param $names censé contenir prénom nom
	*/
	private function splitName($names){
		$namesExploded = explode(' ', $names);
		if(count($namesExploded) == 2){
			return $namesExploded;
		}
	
	}
	
	/**
	*
	*	@return retourne une UserEntity si elle existe en BD
	*			sinon retourne null
	*/
	private function getUserFromNames($first_name, $last_name){
		$first_name = strtolower($first_name);
		$last_name = strtolower($last_name);
		$email = $first_name . '.' . $last_name . GroupsController::EXT_EMAIL;
		$users = TableRegistry::get('Users');
		$userQuery = $users->find()->where(['Users.email' => $email]);
		return $userQuery->first();
	}
	
	/**
	*
	*	@return UserEntity
	*/
	private function createUser($first_name, $last_name){
		$first_name = strtolower($first_name);
		$last_name = strtolower($last_name);
		
		$user = $this->Modules->Users->newEntity();
		
		$user->first_name = $first_name;
		$user->last_name = $last_name;
			
		$user->email = $first_name . '.' . $last_name . GroupsController::EXT_EMAIL;
		$user->role_id = 3;
		$user->password = null;
		$newUser = $this->Modules->Users->save($user);
		if($newUser){
			return $newUser;
		}
		return null;
	}
	
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
    }
	
	/**
	*	Permet de supprimer un groupe de ce module
	*/
	public function deleteGroup($id = null){
		if($id == null){
			return $this->redirect(['controller' => 'Users', 'action' => 'panel']);
		}
		$this->request->allowMethod(['post', 'delete']);
        $group = $this->Modules->Groups->get($id);
        if ($this->Modules->Groups->delete($group)) {
            $this->Flash->success('Le groupe a bien été supprimé.');
        } else {
            $this->Flash->error('Le groupe ne peut pas être supprimé, merci de réessayer plus tard.');
        }
		$this->redirect($this->referer());
	}

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null){
		$isOwner = $this->isOwner();
		if(!$isOwner){
			$session = $this->request->session();
			$currentUser = $session->read('Auth.User');
			
			$groups = TableRegistry::get('groups');
			$queryQuestionnaires = $groups->find()->hydrate(false)
									 ->join([
										'gm' => [ // on join les modules
											'table' => 'questionnaires_groups',
											'type' => 'INNER',
											'conditions' => 'gm.group_id = groups.id',
										],
										'gu' => [
											'table' => 'groups_users',
											'type' => 'INNER',
											'conditions' => 'gm.group_id = gm.group_id',
										]
									
									])
									->where(['gu.user_id' => $currentUser['id']])
									->andWhere(['mg.module_id' => $id]); // et on cible le module où on est
			
			
			$questionnaires = TableRegistry::get('questionnaires');
			$queryQuestionnaires = $questionnaires->find()->hydrate(false)
									 ->join([
										'qg' => [ // on join les groupes
											'table' => 'questionnaires_groups',
											'type' => 'INNER',
											'conditions' => 'qg.questionnaire_id = questionnaires.id',
										],
										'mg' => [
											'table' => 'modules_groups',
											'type' => 'INNER',
											'conditions' => 'mg.group_id = qg.group_id',
										],
										'gu' => [ // on join les users associés au join précédent
											'table' => 'groups_users',
											'type' => 'INNER',
											'conditions' => 'qg.group_id = gu.group_id',
										]
									
									])
									->where(['gu.user_id' => $currentUser['id']])
									->andWhere(['mg.module_id' => $id]); // et on cible le module où on est
			$this->set('questionnaires', $queryQuestionnaires);
		}else{
			$questionnaires = TableRegistry::get('questionnaires');
			$queryQuestionnaires = $questionnaires->find()->hydrate(false)
									 ->join([
										'qg' => [ // on join les groupes
											'table' => 'questionnaires_groups',
											'type' => 'INNER',
											'conditions' => 'qg.questionnaire_id = questionnaires.id',
										],
										'mg' => [
											'table' => 'modules_groups',
											'type' => 'INNER',
											'conditions' => 'mg.group_id = qg.group_id',
										]
									
									])
									->andWhere(['mg.module_id' => $id])
									->distinct(['id']); // et on cible le module où on est
			$this->set('questionnaires', $queryQuestionnaires);
		
		}
		$module = $this->Modules->get($id, [
			'contain' => ['Owners', 'Users', 'Groups']
		]);
		$this->set('module', $module);
		$this->set('_serialize', ['module']);
		$this->set('isOwner', $isOwner);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add(){
		$module = $this->Modules->newEntity();
        if ($this->request->is('post')) {
			
            $session = $this->request->session();
			$currentUser = $session->read('Auth.User');
			
			$this->request->data['owners'][0] = $currentUser; // on ajoute l'utilisateur actuel pour indiquer qu'il est lier au groupe
            $module = $this->Modules->patchEntity($module, $this->request->data);
			
            if ($this->Modules->save($module)) {
                $this->Flash->success('Le module a été sauvegardé.');
                return $this->redirect(['controller' => 'Users', 'action' => 'panel']);
            } else {
                $this->Flash->error('Le module n\'a pas été inséré.');
            }
        }
		
        $groups = $this->Modules->Groups->find('list')->matching('Users', function($q){
			$session = $this->request->session();
			$currentUser = $session->read('Auth.User');
			$idUser = $currentUser['id'];
						
			return $q
					->select(['Users.id', 'Groups.name'])
					->where(['Users.id' => $idUser]);
		});
		
        $this->set(compact('module', 'groups'));
        $this->set('_serialize', ['module']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		if($id == null){
			return $this->redirect(['controller' => 'Users', 'action' => 'panel']);
		}
        $module = $this->Modules->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $module = $this->Modules->patchEntity($module, $this->request->data);
            if ($this->Modules->save($module)) {
                $this->Flash->success('Le module a été sauvegardé.');
			return $this->redirect(['controller' => 'Users', 'action' => 'panel']);
            } else {
                $this->Flash->error('Le module n\'a pas pu être sauvegardé, merci de réessayer plus tard.');
            }
        }
        $this->set(compact('module'));
        $this->set('_serialize', ['module']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null){
        $this->request->allowMethod(['post', 'delete']);
        $module = $this->Modules->get($id);
			$session = $this->request->session();
			$currentUser = $session->read('Auth.User');
			$idUser = $currentUser['id'];
		
		$questionnaires = TableRegistry::get('questionnaires');
		$queryQuestionnaires = $questionnaires->find()->hydrate(false)
								 ->join([
									'qg' => [ // on join les groupes
										'table' => 'questionnaires_groups',
										'type' => 'INNER',
										'conditions' => 'qg.questionnaire_id = questionnaires.id',
									],
									'mg' => [
										'table' => 'modules_groups',
										'type' => 'INNER',
										'conditions' => 'mg.group_id = qg.group_id',
									],
									'gu' => [ // on join les users associés au join précédent
										'table' => 'groups_users',
										'type' => 'INNER',
										'conditions' => 'qg.group_id = gu.group_id',
									]])
									->where(['gu.user_id' => $currentUser['id']])
									->andWhere(['mg.module_id' => $id]); // et on cible le module où on est
		
		$questionnaireArray = $queryQuestionnaires->toArray();
		$questionnaire = new QuestionnairesController();
		for($i = 0;$i < count($questionnaireArray); $i++){
			$questionnaire->deleteAssociation($questionnaireArray[$i]['id']);
		}
		
        if ($this->Modules->delete($module)) {
            $this->Flash->success('Le module a bien été supprimé.');
        } else {
            $this->Flash->error('Le module ne peut pas être supprimé, merci de réessayer plus tard.');
        }
		return $this->redirect(['controller' => 'Users', 'action' => 'panel']);
    }
}
