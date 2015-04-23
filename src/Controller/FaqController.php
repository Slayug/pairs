<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

class FaqController extends AppController
{

	function beforeFilter(Event $event){
		parent::beforeFilter($event);
		$this->Auth->allow('index');
	}

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
	$session = $this->request->session();
		$currentUser = $session->read('Auth.User');
		$role = $currentUser['role_id'];
		$id = $currentUser['id'];
		
		
		if($role > 1){ // c'est à dire que c'est un étudiant ou un professeur
			$users = TableRegistry::get('Users');
			$user = $users->get($id, [
            'contain' => ['Modules']
			]);
			$this->set('user', $user);
			$this->set('_serialize', ['user']);
		}
    }

    /**
     * View method
     *
     * @param string|null $id Group id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
    }

    /**
     * Edit method
     *
     * @param string|null $id Group id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
    }

    /**
     * Delete method
     *
     * @param string|null $id Group id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
    }
}
