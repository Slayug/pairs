<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\App;
use Cake\Datasource\ConnectionManager;
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
			if($role == 2){
				return true;
			}else if($role == 3 && $canReply){
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
		$session = $this->request->session();
		$currentUser = $session->read('Auth.User');
		$idUser = $currentUser['id'];
		
        $questionnaire = $this->Questionnaires->newEntity();
		
        if ($this->request->is('put')){
			debug($this->request->data);
			if(array_key_exists('save', $this->request->data)){
				//juste sauvegarder les réponses présentes
				debug('save');
			}else{
				debug('valider');
				//sauvegarder les réponses
			}
		
		}
		
		$groups = TableRegistry::get('Groups');
		$groupsQuery = $groups->find()->hydrate(false)
									->join([
										'gu' => [ // on join les groupes associés à l'étudiant
											'table' => 'groups_users',
											'type' => 'INNER',
											'conditions' => 'gu.group_id = groups.id',
										],
										'qg' => [ // on join les groupes de l'étudiant à celui des questionnaires
											'table' => 'questionnaires_groups',
											'type' => 'INNER',
											'conditions' => 'qg.group_id = gu.group_id',
										]
									
									])
									->where(['qg.questionnaire_id' => $idQuestionnaire]) // où l'id questionnaire
									->andWhere(['gu.user_id' => $idUser]); // et on cible où c'est l'user actuel
		$users = TableRegistry::get('Users');
		$usersQuery = $users->find()->hydrate(false)
									->join([
										'gu' =>[
											'table' => 'groups_users',
											'type' => 'INNER',
											'conditions' => 'gu.user_id = users.id',
										]
									])
									->where(['gu.group_id' => $groupsQuery->first()['id']]);
									
		//chargement des associations contenu par ce questionnaire
		$associationTable = TableRegistry::get('answers_questions_questionnaires');
		$associations = $associationTable->find()->where(['questionnaire_id' => $idQuestionnaire]);
		//debug($associations->toArray());
		
		// on charge ensuite chaque questions et ses réponses.
		$questions = array();
		$associations = $associations->toArray();
		$questionTable = TableRegistry::get('Questions');
		$answerTable = TableRegistry::get('Answers');
		for($p = 0; $p < count($associations); $p++){
			$question = $questionTable->get($associations[$p]['question_id']);
			$answers = $answerTable->get($associations[$p]['answer_id']);
			if(!array_key_exists($question['id'], $questions)){
				$questions[$question['id']]['answers'] = array();
			}
			//on met les infos de la question (id, content)
			$questions[$question['id']]['content'] = $question['content'];
			$questions[$question['id']]['id'] = $question['id']; // plus simple d'y accéder comme ceci que par un index pour un for.
			// on place la question à la bonne position
			$questions[$question['id']]['answers'][$associations[$p]['position']] = $answers;
		}	
		$this->set('users', $usersQuery->toArray());
		$this->set('questions', $questions);
        $questionnaire = $this->Questionnaires->get($idQuestionnaire);
        $this->set('questionnaire', $questionnaire);
        $this->set('_serialize', ['questionnaire']);
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
    public function view($id = null){
		
		$isOwner = $this->isOwner();
	
		$this->set('isOwner', $isOwner);
        $questionnaire = $this->Questionnaires->get($id);
        $this->set('questionnaire', $questionnaire);
        $this->set('_serialize', ['questionnaire']);
    }

	
	private function dateTimePickerToDatetime($date){
		$months = ['Jan' => '01','Fev' =>'02','Mar' =>'03','Avr' =>'04','Mai'=> '05','Jui' => '06','Jul' => '07','Aou' => '08','Sep' => '09','Oct' => '10','Nov' => '11','Dec' => '12'];
		$tmp = explode(' - ', $date);
		$date = $tmp[0];
		$hour = $tmp[1] . ':00';
		$month = substr($date, 3, 3);
		$year = substr($date, 7, 4);
		$day = substr($date, 0, 2);
		return $year . '-' . $months[$month] . '-' . $day . ' ' . $hour;
	}
	
    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($idModule = null){
        $questionnaire = $this->Questionnaires->newEntity();
        if ($this->request->is('post')){
			$session = $this->request->session();
			$currentUser = $session->read('Auth.User');
			$success = true;
			$transaction = ConnectionManager::get('default'); // permet de faire un rollback si une des insertions plantes
			$transaction->begin();
			//on vide par les tableaux fournis par défault de cake
			$this->request->data['answers'] = array();
			$this->request->data['questions'] = array();
			//on save le questionnaire en vérifiant que titre et description ne sont pas null et de même pour les dates
			if(strlen($this->request->data['title']) > 0 && strlen($this->request->data['description']) > 0 &&
				strlen($this->request->data['date_creation']) > 0 &&
				strlen($this->request->data['date_limit']) > 0){
			
				$currentUser = $session->read('Auth.User');
				
				$this->request->data['date_creation'] = $this->dateTimePickerToDatetime($this->request->data['date_creation']);
				$this->request->data['date_limit'] = $this->dateTimePickerToDatetime($this->request->data['date_limit']);
				
				$this->request->data['owners'][0] = $currentUser; // on ajoute l'utilisateur actuel pour indiquer qu'il est lier au questionnaire
				
				$groups = TableRegistry::get('Groups');
				$queryGroups = $groups->find()->hydrate(false)
									 ->join([
										'gm' => [ // on join les modules
											'table' => 'modules_groups',
											'type' => 'INNER',
											'conditions' => 'gm.group_id = groups.id',
										]
									
									])
									->where(['gm.module_id' => $idModule]); // et on cible le module où on est
				$this->request->data['groups'] = $queryGroups->toArray();
				
				$questionnaire = $this->Questionnaires->patchEntity($questionnaire, $this->request->data);
				$questionnaire = $this->Questionnaires->save($questionnaire);
				if(!$questionnaire){
					$transaction->rollback();
					$this->Flash->error('Une erreur s\'est produite, merci de réessayer.');
					return $this->redirect(['controller' => 'Questionnaires', 'action' => 'add', $idModule]);
				}
			}else{
                $this->Flash->error('Le questionnaire doit contenir au moins un titre & une description.');
				return $this->redirect(['controller' => 'Questionnaires', 'action' => 'add', $idModule]);
			}
			
			foreach($this->request->data as $key => $value){
				if(strstr($key, '#-#')){
					/**
					*	Question:
					*	idQuestion#-#question
					*/
					$keySplitted = explode('#-#', $key);
					$idQuestion = $keySplitted[0];
					$question = str_replace('_', ' ', $keySplitted[1]);
					
					//on test si la question existe déjà en BDD
					$questionTable = TableRegistry::get('Questions');
					$questionTuple = $questionTable->find()->where(['Questions.id' => $idQuestion]);
					if($questionTuple->first() == null){
						debug('INSERT');
						$questionTuple = $questionTable->newEntity();
						$questionTuple->content = $question;
						$questionTuple->type = 0;
						$questionTuple = $questionTable->save($questionTuple);
						$success = $success AND $questionTuple;
					}else{
						$questionTuple->id = $idQuestion;
					}
					for($i = 1; $i < count($value); $i++){
						$valueSplitted = explode('#-#', $value[$i]);
						/**
						*	Answer:
						*	idAnswer#-#answer
						*/
						$idAnswer = $valueSplitted[0];
						$answer = $valueSplitted[1];
						//on test si la réponse existe déjà en BDD
						$answerTable = TableRegistry::get('Answers');
						$answerTuple = $answerTable->find()->where(['Answers.id' => $idAnswer]);
						if($answerTuple->first() == null){
							debug('insert answer ' . $idAnswer . ' '. $answer);
							$answerTuple = $answerTable->newEntity();
							$answerTuple->value = $answer;
							$answerTuple = $answerTable->save($answerTuple);
							$success = $success AND $answerTuple;
						}else{
							$answerTuple->id = $idAnswer;
						}
						
						//on save ensuite l'association avec la position de la question & le questionnaire
						$associationTable = TableRegistry::get('answers_questions_questionnaires');
						$association = $associationTable->newEntity();
						$association->question_id = $questionTuple->id;
						$association->answer_id = $answerTuple->id;
						$association->questionnaire_id = $questionnaire->id;
						$association->position = $i - 1;
						$success = $success AND $associationTable->save($association);
					}
				}
			}
			
			if($success){
				$transaction->commit();
				$this->Flash->success('Le questionnaire a bien été ajouté.');
				return $this->redirect(['controller' => 'Modules', 'action' => 'view', $idModule]);
			}else{
				$transaction->rollback();
				$this->Flash->success('Une erreur s\'est produite, merci de réessayer plus tard.');
				return $this->redirect(['controller' => 'Modules', 'action' => 'view', $idModule]);
			}
		
		}
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
    public function delete($id = null){
	
		
		$success = true;
		$transaction = ConnectionManager::get('default'); // permet de faire un rollback si une des insertions plantes
		$transaction->begin();
	
		//supprimer les associations dans answers_questions_questionnaires
		$associations = TableRegistry::get('answers_questions_questionnaires');
		$success = $success AND $associations->deleteAll(['questionnaire_id' => $id]);
		
		//supprimer les associations dans answers_questionnaires_users
		$associations = TableRegistry::get('answers_questionnaires_users_partials');
		$success = $success AND $associations->deleteAll(['questionnaire_id' => $id]);
		
		//supprimer les associations dans questionnaires_groups
		$associations = TableRegistry::get('questionnaires_groups');
		$success = $success AND $associations->deleteAll(['questionnaire_id' => $id]);
		
		//supprimer les associations dans answers_questionnaires_users
		$associations = TableRegistry::get('answers_questionnaires_users');
		$success = $success AND $associations->deleteAll(['questionnaire_id' => $id]);
		
		//supprimer l'association avec le proprio du questionnaire
		$associations = TableRegistry::get('questionnaires_owners');
		$success = $success AND $associations->deleteAll(['questionnaire_id' => $id]);
		
		//supprimer le questionnaire dans questionnaires
		$associations = TableRegistry::get('Questionnaires');
		$success = $success AND $associations->deleteAll(['id' => $id]);
		
		if($success){
			$transaction->commit();
			$this->Flash->success('Le questionnaire a bien été supprimé.');
		}else{
			$transaction->rollback();
			$this->Flash->success('Une erreur s\'est produite lors de la suppression du questionnaire.');		
		}
		$this->redirect($this->referer());
        /*$this->request->allowMethod(['post', 'delete']);
        $questionnaire = $this->Questionnaires->get($id);
        if ($this->Questionnaires->delete($questionnaire)) {
            $this->Flash->success('The questionnaire has been deleted.');
        } else {
            $this->Flash->error('The questionnaire could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);*/
    }
}
