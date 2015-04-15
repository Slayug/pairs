<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Questions Controller
 *
 * @property \App\Model\Table\QuestionsTable $Questions
 */
class QuestionsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('questions', $this->paginate($this->Questions));
        $this->set('_serialize', ['questions']);
    }

    /**
     * View method
     *
     * @param string|null $id Question id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $question = $this->Questions->get($id, [
            'contain' => ['Answers', 'Questionnaires', 'AnswersQuestionnaireUsers', 'AnswersQuestionnaireUsersPartials', 'AnswersQuestions', 'QuestionnairesQuestions']
        ]);
        $this->set('question', $question);
        $this->set('_serialize', ['question']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $question = $this->Questions->newEntity();
        if ($this->request->is('post')) {
            $question = $this->Questions->patchEntity($question, $this->request->data);
            if ($this->Questions->save($question)) {
                $this->Flash->success('The question has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The question could not be saved. Please, try again.');
            }
        }
        $answers = $this->Questions->Answers->find('list', ['limit' => 200]);
        $questionnaires = $this->Questions->Questionnaires->find('list', ['limit' => 200]);
        $this->set(compact('question', 'answers', 'questionnaires'));
        $this->set('_serialize', ['question']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Question id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $question = $this->Questions->get($id, [
            'contain' => ['Answers', 'Questionnaires']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $question = $this->Questions->patchEntity($question, $this->request->data);
            if ($this->Questions->save($question)) {
                $this->Flash->success('The question has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The question could not be saved. Please, try again.');
            }
        }
        $answers = $this->Questions->Answers->find('list', ['limit' => 200]);
        $questionnaires = $this->Questions->Questionnaires->find('list', ['limit' => 200]);
        $this->set(compact('question', 'answers', 'questionnaires'));
        $this->set('_serialize', ['question']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Question id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $question = $this->Questions->get($id);
        if ($this->Questions->delete($question)) {
            $this->Flash->success('The question has been deleted.');
        } else {
            $this->Flash->error('The question could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
