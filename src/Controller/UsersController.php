<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Hash;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
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
		//debug($action);
		if(in_array($action, ['index', 'add', 'edit', 'view'])){
			if($role < 3){
				return true;
			}
		}else if(in_array($action, ['panel', 'logout'])){
			return true;
		}else if(in_array($action, ['delete'])){
			if($role == 1){
				return true;
			}
		}
		
		return parent::isAuthorized($user);
		
	}
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
		
        $this->paginate = [
            'contain' => ['Roles']
        ];
        $this->set('users', $this->paginate($this->Users));
        $this->set('_serialize', ['users']);
    }


	
	
	public function login(){
		if ($this->request->is('post')) {
			$user = $this->Auth->identify();
			$this->Flash->set($user);
			if ($user){
				$this->Auth->setUser($user);
				$this->Flash->set('Connexion réussie !');
				return $this->redirect($this->Auth->redirectUrl('/users/panel'));
			}
			$this->Flash->error('Votre email ou mot de passe est incorrect.');
		}
	}
	
	public function logout(){
		$this->Flash->success('Vous êtes maintenant déconnecté.');
		return $this->redirect($this->Auth->logout());
	}

	
	/**
	 * Panel method
	 **/
	public function panel(){
		$session = $this->request->session();
		$currentUser = $session->read('Auth.User');
		$role = $currentUser['role_id'];
		$id = $currentUser['id'];
		
		
		if($role > 1){ // c'est à dire que c'est un étudiant ou un professeur
			$user = $this->Users->get($id, [
            'contain' => ['Groups']
			]);
			$this->set('user', $user);
			$this->set('_serialize', ['user']);
		}
		
	}
	
    /**
     * View method
     *
     * @param string|null $id User id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Roles', 'Groups']
        ]);
        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
			debug($this->request->data);
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success('The user has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The user could not be saved. Please, try again.');
            }
        }
		
		$session = $this->request->session();
		$currentUser = $session->read('Auth.User');
		$role = $currentUser['role_id'];
		$rolePossible = '';
		 // on définie le rôle que peut attribuer l'utilisateur en cours.
		if($role == 2){
			$rolePossible .= '3';
		}else if($role == 3){
			$rolePossible .= '4';
		}else if($role == 1){
			$rolePossible .= '2';
		}
		$condition = array("Roles.id >=" => $rolePossible);
        $roles = $this->Users->Roles->find('list');
        $groups = $this->Users->Groups->find('all', ['limit' => 200]);
        $this->set(compact('user', 'roles', 'groups'));
        $this->set('_serialize', ['user']);
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
        $user = $this->Users->get($id, [
            'contain' => ['Groups']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success('The user has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The user could not be saved. Please, try again.');
            }
        }
		$session = $this->request->session();
		$currentUser = $session->read('Auth.User');
		$role = $currentUser['role_id'];
		$rolePossible = '';
		 // on définie le rôle que peut attribuer l'utilisateur en cours.
		if($role == 2){
			$rolePossible .= '3';
		}else if($role == 3){
			$rolePossible .= '4';
		}else if($role == 1){
			$rolePossible .= '2';
		}
		$condition = array("Roles.id >=" => $rolePossible);
        $roles = $this->Users->Roles->find('all', array('conditions' => $condition));
        $groups = $this->Users->Groups->find('list', ['limit' => 200]);
        $this->set(compact('user', 'roles', 'groups'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success('The user has been deleted.');
        } else {
            $this->Flash->error('The user could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
