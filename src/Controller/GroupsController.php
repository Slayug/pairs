<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use App\Model\Entity\Group;

/**
 * Groups Controller
 *
 * @property \App\Model\Table\GroupsTable $Groups
 */
class GroupsController extends AppController
{

	const EXT_EMAIL = '@etu.univ-tours.fr';
	
	/**
	 * Methode permettant de gérer les droits pour
	 * ce controller
	 * on suppose d'abord que l'utilisateur est déjà connecté
	 * 
	 **/
	public function isAuthorized($user){
		$role = $user['role_id'];
		$action = $this->request->params['action'];
		
		$groups = TableRegistry::get('Groups');
		//permet de récupérer les groups de l'utilisateur
		$queryAccess = $groups->find()->matching('Users', function($q){
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
					->select(['Users.id', 'Groups.name'])
					->where(['Users.id' => $idUser,
							 'Groups.id' => $id]);
		});
		
		/*$queryOwner = $groups->find()->matching('Owners', function($q){
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
					->select(['Owners.id', 'Groups.name'])
					->where(['Owners.id' => $idUser,
							 'Groups.id' => $id]);
		});
		*/
		
		$isOwner = $this->isOwner();
		$canAccess = $queryAccess->count() + $isOwner;
		if(in_array($action, ['edit', 'delete', 'deleteGroup', 'add', 'addUser'])){
			if($role == 2){ // professeur
				if(in_array($action, ['add'])){
					return true;
				}
				// on vérifie si le groupe est bien au professeur
				if($isOwner){
					return true;
				}
			}
		}else if(in_array($action, ['view'])){
			//un étudiant peut voir un groupe
			//on doit aussi tester si l'étudiant est bien dans ce groupê de même pour le professeur
			if($role >= 2 && $canAccess){
				return true;
			}
		}
		return parent::isAuthorized($user);
		
	}
	
	/**
	*	Permet de vérifier si l'utilisateur actuellement connecté
	*	est le propriétaire de ce groupe
	*/
	private function isOwner(){
		$groups = TableRegistry::get('groups');
		$queryOwner = $groups->find()->matching('Owners', function($q){
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
					->select(['Owners.id', 'groups.name'])
					->where(['Owners.id' => $idUser,
							 'Groups.id' => $id]);
		});
		
		return $queryOwner->count();
	}

	
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('groups', $this->paginate($this->Groups));
        $this->set('_serialize', ['groups']);
    }

    /**
     * View method
     *
     * @param string|null $id Group id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null){
        $group = $this->Groups->get($id, [
            'contain' => ['Users', 'Questionnaires', 'Owners']
        ]);
		$this->set('isOwner', $this->isOwner());
        $this->set('group', $group);
        $this->set('_serialize', ['group']);
        
        
    }
	
	/**
	*	Ajoute un utilisateur à ce groupe,
	*	Si l'utilisateur n'existe pas, alors il est crée
	*/
	public function addUser($idGroup = null){
	
        if ($this->request->is('PUT')) {
			// on suppose d'abord que l'utilisateur n'existe pas donc on va le crée et l'associer puis le save
			$user = $this->Groups->Users->newEntity();
			$group = $this->Groups->get($idGroup);
			$currentGroup = array();
			$currentGroup['id'] = $group->id;
			$currentGroup['name'] = $group->name;
			$currentGroup['description'] = $group->description;
			$this->request->data['groups'][0] = $currentGroup;
			$user = $this->Groups->Users->patchEntity($user, $this->request->data);
			
			$first_name = strtolower($this->request->data['first_name']);
			$last_name = strtolower($this->request->data['last_name']);
			$user->first_name = $first_name;
			$user->last_name = $last_name;
			
			$user->email = $first_name . '.' . $last_name . self::EXT_EMAIL;
			$user->role_id = 3;
			$user->password = null;
			if($this->Groups->Users->save($user)){
                $this->Flash->success('L\'étudiant(e) a été ajouté avec succès.');
				return $this->redirect(['controller' => 'Groups', 'action' => 'view', $idGroup]);
			}
			// l'utilisateur existe déjà
			// on le récupère pour lui ajouter l'assocation avec le groupe et le save
			$users = TableRegistry::get('Users');
			$userQuery = $users->find()->where(['Users.email' => $user->email]);
			$newUser = $userQuery->first();
			if($newUser != null){
				$newUser = $this->Groups->Users->patchEntity($newUser, $this->request->data);
				$newUser->first_name = $first_name;
				$newUser->last_name = $last_name;
				if($this->Groups->Users->save($newUser)){
					$this->Flash->success('L\'étudiant a été ajouté avec succès.');
					return $this->redirect(['controller' => 'Groups', 'action' => 'view', $idGroup]);				
				}
			}
			
            $this->Flash->error('Une erreur s\'est produite l\'étudiant n\'a pas été ajouté.');
			return $this->redirect(['controller' => 'Groups', 'action' => 'view', $idGroup]);
					
		}
	}

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($idModule = null)
    {
        $group = $this->Groups->newEntity();
        if ($this->request->is('post')) {
		
			$session = $this->request->session();
			$currentUser = $session->read('Auth.User');
			
			$this->request->data['owners'][0] = $currentUser; // on ajoute l'utilisateur actuel pour indiquer que c'est lui qui possède le groupe.
			
			$group = $this->Groups->patchEntity($group, $this->request->data);
           	$fromModule = false;
			if($idModule != null){
				if(ctype_digit($idModule) == true){
					$moduleSelected = $this->Groups->Modules->get($idModule);
					$group->modules = [$moduleSelected];
					$fromModule = true;
				}
			}
           if ($this->Groups->save($group)) {
                $this->Flash->success('Le groupe a été sauvegardé.');
                if(!$fromModule){
					return $this->redirect(['controller' => 'Users',
										'action' => 'panel']);
				}else{
					return $this->redirect(['controller' => 'Modules',
										'action' => 'view', $idModule]);
				}
            } else {
                $this->Flash->error('Le groupe ne peut pas être sauvegardé, merci de réessayer.');
            }
        }
        $users = $this->Groups->Users->find('list', ['limit' => 200]);
        $questionnaires = $this->Groups->Questionnaires->find('list', ['limit' => 200]);
        $this->set(compact('group', 'users', 'questionnaires'));
        $this->set('_serialize', ['group']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Group id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null){
		if($id == null){
			return $this->redirect(['controller' => 'Users', 'action' => 'panel']);
		}
        $group = $this->Groups->get($id, [
            'contain' => ['Users', 'Questionnaires']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $group = $this->Groups->patchEntity($group, $this->request->data);
            if ($this->Groups->save($group)) {
                $this->Flash->success('Le groupe a été sauvegardé.');
				return $this->redirect(['controller' => 'Users', 'action' => 'panel']);
            } else {
                $this->Flash->error('Le groupe n\'a pas pu être sauvegardé, merci de réessayer plus tard.');
				return $this->redirect(['controller' => 'Users', 'action' => 'panel']);
            }
        }
        $users = $this->Groups->Users->find('list', ['limit' => 200]);
        $questionnaires = $this->Groups->Questionnaires->find('list', ['limit' => 200]);
        $this->set(compact('group', 'users', 'questionnaires'));
        $this->set('_serialize', ['group']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Group id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null){
        $this->request->allowMethod(['post', 'delete']);
        $group = $this->Groups->get($id);
        if ($this->Groups->delete($group)) {
            $this->Flash->success('Le groupe a bien été supprimé.');
        } else {
            $this->Flash->error('Le groupe ne peut pas être supprimé. Please, try again.');
        }
		return $this->redirect(['controller' => 'Users', 'action' => 'panel']);
    }
}
