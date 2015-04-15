<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Questionnaires Controller
 *
 * @property \App\Model\Table\QuestionnairesTable $Questionnaires
 */
class QuestionnairesController extends AppController
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
		}else if(in_array($action, ['view', 'reply'])){
			//un étudiant peut voir et donc répondre à un questionnaire,
			//on doit aussi tester si l'étudiant est bien dans le groupe qui correspond au questionnaire
			if($role == 3){
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
        $this->set('questionnaires', $this->paginate($this->Questionnaires));
        $this->set('_serialize', ['questionnaires']);
    }

    /**
     * View method
     *
     * @param string|null $id Questionnaire id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $questionnaire = $this->Questionnaires->get($id, [
            'contain' => ['Groups', 'Questions', 'AnswersQuestionnaireUsers', 'AnswersQuestionnaireUsersPartials', 'QuestionnairesGroups', 'QuestionnairesQuestions']
        ]);
        $this->set('questionnaire', $questionnaire);
        $this->set('_serialize', ['questionnaire']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $questionnaire = $this->Questionnaires->newEntity();
        if ($this->request->is('post')) {
            $questionnaire = $this->Questionnaires->patchEntity($questionnaire, $this->request->data);
            if ($this->Questionnaires->save($questionnaire)) {
                $this->Flash->success('The questionnaire has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The questionnaire could not be saved. Please, try again.');
            }
        }
        $groups = $this->Questionnaires->Groups->find('list', ['limit' => 200]);
        $questions = $this->Questionnaires->Questions->find('list', ['limit' => 200]);
        $this->set(compact('questionnaire', 'groups', 'questions'));
        $this->set('_serialize', ['questionnaire']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Questionnaire id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $questionnaire = $this->Questionnaires->get($id, [
            'contain' => ['Groups', 'Questions']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $questionnaire = $this->Questionnaires->patchEntity($questionnaire, $this->request->data);
            if ($this->Questionnaires->save($questionnaire)) {
                $this->Flash->success('The questionnaire has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The questionnaire could not be saved. Please, try again.');
            }
        }
        $groups = $this->Questionnaires->Groups->find('list', ['limit' => 200]);
        $questions = $this->Questionnaires->Questions->find('list', ['limit' => 200]);
        $this->set(compact('questionnaire', 'groups', 'questions'));
        $this->set('_serialize', ['questionnaire']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Questionnaire id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $questionnaire = $this->Questionnaires->get($id);
        if ($this->Questionnaires->delete($questionnaire)) {
            $this->Flash->success('The questionnaire has been deleted.');
        } else {
            $this->Flash->error('The questionnaire could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
