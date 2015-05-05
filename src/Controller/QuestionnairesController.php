<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
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
		
		$canReply = 0;
		$isOwner = 0;
		$idQuestionnaire = null;
		if($this->request->pass != null){
			if(ctype_digit($this->request->pass['0'])){ // on vérifie que c'est bien un entier
				$idQuestionnaire = $this->request->pass['0'];
			}
		}
		if($idQuestionnaire != null){
			$questionnaires = TableRegistry::get('Questionnaires');
			//permet de vérifier si l'utilisateur peut répondre au questionnaire
			//en vérifiant qu'il appartient bien au groupe, auquel le le questionnaire appartient lui aussi.
			$queryReply = $questionnaires->find()->hydrate(false)
									 ->join([
										'qg' => [ // on join les groupes associés aux questionnaires
											'table' => 'questionnaires_groups',
											'type' => 'INNER',
											'conditions' => 'qg.questionnaire_id = questionnaires.id',
										],
										'gu' => [ // on join les users associés au join précédent
											'table' => 'groups_users',
											'type' => 'INNER',
											'conditions' => 'gu.group_id = qg.group_id',
										]
									
									])
									->where(['gu.user_id' => $user['id']]) // où l'id de l'user est le même que celui qui est connecté
									->andWhere(['questionnaire_id' => $idQuestionnaire]); // et on cible le questionnaire voulu
			
			$canReply = $queryReply->count();
		}
		$isOwner = $this->isOwner();
		if(in_array($action, ['edit', 'delete', 'add'])){
			if($role == 2){ // professeur
				if(in_array($action, ['add'])){
					return true;
				}
				// on vérifie si le questionnaire est bien à  l'utilisateur
				if($isOwner){
					return true;
				}
			}
		}else if(in_array($action, ['view'])){
			//un étudiant peut voir un module pour consulter son/ses groupes dedans
			//on doit aussi tester si l'étudiant est bien dans ce module de même pour le professeur
			if($role >= 2){
				return true;
			}
		}else if(in_array($action, ['reply'])){
			if($canReply){
				return true;
			}
		}
		
		return parent::isAuthorized($user);
		
	}
	
	public function reply($idQuestionnaire = null){
	
	}
	
	private function isOwner(){
		$questionnaires = TableRegistry::get('Questionnaires');
		$queryOwner = $questionnaires->find()->matching('Owners',
			function($q){
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
						->select(['Owners.id', 'Questionnaires.title'])
						->where(['Owners.id' => $idUser,
								'Questionnaires.id' => $id]);
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
            'contain' => ['Groups', 'Questions']
        ]);
        $this->set('questionnaire', $questionnaire);
        $this->set('_serialize', ['questionnaire']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($idModule = null){
        $questionnaire = $this->Questionnaires->newEntity();
        if ($this->request->is('post')) {
			$session = $this->request->session();
			$currentUser = $session->read('Auth.User');
			debug($this->request->data);
			$this->request->data['owners'][0] = $currentUser; // on ajoute l'utilisateur actuel pour indiquer qu'il est lier au groupe
		
           /* $questionnaire = $this->Questionnaires->patchEntity($questionnaire, $this->request->data);
            if ($this->Questionnaires->save($questionnaire)) {
                $this->Flash->success('Le questionnaire a été sauvegardé.');
                return $this->redirect(['controller' => 'Users',
										'action' => 'panel']);
            } else {
                $this->Flash->error('The questionnaire could not be saved. Please, try again.');
                return $this->redirect(['controller' => 'Users',
										'action' => 'panel']);
            }*/
        }
        //$groups = $this->Questionnaires->Modules->find('list', ['limit' => 200]);
		
		//$modules = TableRegistry::get('Modules');
		
		//permet de récupérer les modules de l'utilisateur
		/*$query = $modules->find('list', array(
								'fields' =>
									array('Modules.name',
										  'Modules.id')));
		$query->matching('Users', function($q){
			$session = $this->request->session();
			$currentUser = $session->read('Auth.User');
			$idUser = $currentUser['id'];
			return $q
					->select(['Users.id', 'Modules.name'])
					->where(['Users.id' => $idUser]);
		});
		
		$this->set('modules', $query->all());*/
		
		
        $questions = TableRegistry::get('Questions');
		$questions = $questions->find('list');
		$answers = TableRegistry::get('Answers');
		$answers = $answers->find('list');
        $this->set(compact('questionnaire', 'questions', 'answers'));
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
