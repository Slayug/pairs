<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Hash;
use Cake\ORM\TableRegistry;
use Cake\Core\App;

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
		if($idModule == null){
			return false;
		}
		
		$canAccess = 0;
		$isOwner = 0;
		
		if(in_array($action, ['deleteGroup'])){
			$canAccess = $isOwner = GroupsController::isAuthorized($user);
			
		}else{
			$modules = TableRegistry::get('Modules');
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
		$modules = TableRegistry::get('Modules');
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
						->select(['Owners.id', 'Modules.name'])
						->where(['Owners.id' => $idUser,
								'Modules.id' => $id]);
		});
		return $queryOwner->count();
	}
	
	
	/**
	*	Permet d'importer un ou plusieurs groupe(s) depuis un document .xlsx ou .ods
	*	trois types d'organisations de tableau peuvent être comprise
	*
	*	TYPE 1)
	*	Groupe | Etudiant
	*	1	   | Paul
	*		   | Marie
	*	2	   | Jean
	*		   | Jim
	*		   | Manon
	*
	*	TYPE 2)
	*	Groupe | Etudiant 1 | Etudiant 2
	*	1	   | Paul		| Jim
	*	2	   | Alexis		| Manon
	*
	*	TYPE 3)
	*	1
	*	Paul
	*	Marie
	*	2
	*	Jim
	*	Manon
	*
	*/
	public function importGroup($idModule = null){
		require_once(ROOT . DS . 'vendor' . DS  . 'phpexcel' . DS . 'Classes' . DS . 'PHPExcel.php');
		require_once(ROOT . DS . 'vendor' . DS  . 'phpexcel' . DS . 'Classes' . DS . 'PHPExcel' . DS . 'IOFactory.php');
		$phpExcel = new \PHPExcel();
		
		
		$objReader = \PHPExcel_IOFactory::createReader('Excel2007');
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
			$containsInteger = false;
			$bOne = $objWorksheet->getCellByColumnAndRow(1, 1)->getValue();
			for($i = 0; $i < strlen($bOne); $i++){
				if(ctype_digit($bOne[$i])){
					$containsInteger = true;
				}
			}
			if($containsInteger){
				// On se trouve dans le TYPE 2)
				echo '2';
			}else{
				// On se trouve dans le TYPE 1)
				for($row = 1; $row < $highestRow; $row++){
					echo $row . '##';
					echo $objWorksheet->getCellByColumnAndRow('A', $row)->getValue() . ' - ';
					echo $objWorksheet->getCellByColumnAndRow(1, $row)->getValue();
					echo '<br/>';
				}
			}
		}else{
			// Dans ce cas on se trouve dans le TYPE 3)
			echo '3';
		}
		
		//debug($this->request->data['submittedfile']);
	
	
	}
	
	/**
	*
	* @param $names censé contenir prénom nom
	*/
	private function splitName($names){
	
	
	}
	
	/**
	*
	*	@return retourne une UserEntity si elle existe en BD
	*			sinon retourne null
	*/
	private function getUserFromNames($first_name, $last_name){
		
	}
	
	/**
	*
	*	@return UserEntity
	*/
	private function createUser($first_name, $last_name){
	
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
        $module = $this->Modules->get($id, [
            'contain' => ['Owners', 'Users', 'Groups']
        ]);
		$this->set('isOwner', $this->isOwner());
        $this->set('module', $module);
        $this->set('_serialize', ['module']);
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
        if ($this->Modules->delete($module)) {
            $this->Flash->success('Le module a bien été supprimé.');
        } else {
            $this->Flash->error('Le module ne peut pas être supprimé, merci de réessayer plus tard.');
        }
		return $this->redirect(['controller' => 'Users', 'action' => 'panel']);
    }
}
