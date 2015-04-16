<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Hash;
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
		
		//debug($action);
		if(in_array($action, ['index', 'add', 'edit', 'delete'])){
			if($role == 2){ // professeur
				return true;
			}
		}else if(in_array($action, ['view'])){
			//un étudiant peut voir un module pour consulter son/ses groupes dedans
			//on doit aussi tester si l'étudiant est bien dans ce module
			if($role >= 2){
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
            'contain' => ['Users', 'Groups']
        ]);
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
			
			$this->request->data['users'][0] = $currentUser; // on ajoute l'utilisateur actuel pour indiquer que c'est lui qui possède le module.
            $module = $this->Modules->patchEntity($module, $this->request->data);
            if ($this->Modules->save($module)) {
                $this->Flash->success('Le module a été sauvegardé.');
                return $this->redirect(['controller' => 'Users', 'action' => 'panel']);
            } else {
                $this->Flash->error('Le module n\'a pas été inséré.');
            }
        }
		
        $groups = $this->Modules->Groups->find('list', ['limit' => 200]);
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
    }
}
