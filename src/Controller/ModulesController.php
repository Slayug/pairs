<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Hash;
use Cake\ORM\TableRegistry;
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
	 * 
	 **/
	public function isAuthorized($user){
		$role = $user['role_id'];
		$action = $this->request->params['action'];
		
		$canAccess = 0;
		$isOwner = 0;
		
		if(in_array($action, ['deleteGroup'])){
			$canAccess = $isOwner = GroupsController::isAuthorized($user);
			
		}else{
			$modules = TableRegistry::get('Modules');
			//permet de récupérer les modules de l'utilisateur
			$queryAccess = $modules->find()->matching('Users', function($q){
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
						->select(['Users.id', 'Modules.name'])
						->where(['Users.id' => $idUser,
								'Modules.id' => $id]);
			});
			
			
			$isOwner = $this->isOwner();
			$canAccess = $queryAccess->count() + $isOwner;
		}
		
		
		if(in_array($action, ['edit', 'delete', 'deleteGroup', 'add'])){
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
     * Index method
     *
     * @return void
     */
    public function index()
    {
    }
	
	/**
	*	Permet de supprimer un groupe de ce module
	*
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
