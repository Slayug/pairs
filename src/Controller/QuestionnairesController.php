<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\App;
use Cake\Datasource\ConnectionManager;
use Cake\Network\Email\Email;
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
			$questionnaires = TableRegistry::get('questionnaires');
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
		if(in_array($action, ['edit', 'delete', 'add', 'copy', 'deleteAssociation'])){
			if($role == 2){ // professeur
				if(in_array($action, ['add', 'copy'])){
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
		}else if(in_array($action, ['index'])){
			if($role == 2){
				return true;
			}
		}
		
		return parent::isAuthorized($user);
		
	}
	
	/**
	*	Lors d'une requête PUT
	*	tableau key: idUser(for_who) - idQuestion
	*	tableau value: idAnswer
	*	exemple:
	*	1-5 => 6,
	*	25-5 => 5
	*/
	public function reply($idQuestionnaire = null){
		$session = $this->request->session();
		$currentUser = $session->read('Auth.User');
		$idUser = $currentUser['id'];
		
		$questionnaire = $this->Questionnaires->get($idQuestionnaire);
		$dateLimit = new \DateTime($questionnaire->date_limit);
		$dateCreation = new \DateTime($questionnaire->date_creation);
		$currentDate = new \DateTime('now');
		
		if($currentDate > $dateLimit){
			$this->Flash->error('La date limite pour ce questionnaire est passée.');
			return $this->redirect(['controller' => 'questionnaires', 'action' => 'view', $idQuestionnaire]);			
		}else if($currentDate < $dateCreation){
			$this->Flash->error('Vous ne pouvez pas encore accéder à ce questionnaire.');
			return $this->redirect(['controller' => 'questionnaires', 'action' => 'view', $idQuestionnaire]);
		}
		
		$answersTable = TableRegistry::get('answers_questionnaires_users');
		$answers = $answersTable->find()->where(['questionnaire_id' => $idQuestionnaire,
															'user_id' => $idUser]);
		if($answers->count()){
			$this->Flash->error('Vous avez déjà répondu(e) à ce formulaire.');
			return $this->redirect(['controller' => 'questionnaires', 'action' => 'view', $idQuestionnaire]);	
		}
		
        $questionnaire = $this->Questionnaires->newEntity();
        if ($this->request->is('put')){
			$success = true;
			$transaction = ConnectionManager::get('default'); // permet de faire un rollback si une des insertions plantes
			
			if(array_key_exists('save', $this->request->data) OR ($this->request->session()->read('nbreQuestion') != count($this->request->data))){
				$transaction->begin();
				//juste sauvegarder les réponses présentes
				$associations = TableRegistry::get('answers_questionnaires_users_partials');
				foreach($this->request->data as $key => $value){
					if(strstr($key, '-')){
						$keySplitted = explode('-', $key);
						$idForWho = $keySplitted[0];
						$idQuestion = $keySplitted[1];
						$idAnswer = $value;
						/*$associationTuple = $associations->find()->where(['question_id' => $idQuestion,
																		'questionnaire_id' => $idQuestionnaire,
																		'user_id' => $idUser,
																		'for_who' => $idForWho]);
																		*/
						$association = $associations->newEntity();
						$association->question_id = $idQuestion;
						$association->questionnaire_id = $idQuestionnaire;
						$association->user_id = $idUser;
						$association->for_who = $idForWho;
						$association->answer_id = $idAnswer;
						$success = $success && $associations->save($association);
					}
				}
				if($success){
					$transaction->commit();
					if(!array_key_exists('save', $this->request->data)){
						$this->Flash->error('Vos réponses ont bien été sauvegardées. Mais vous devez répondre à toutes les questions pour valider ce questionnaire.');
					return $this->redirect(['controller' => 'questionnaires', 'action' => 'reply', $idQuestionnaire]);	
					}else{
						$this->Flash->success('Vos réponses ont bien été sauvegardées.');
					}
					return $this->redirect(['controller' => 'questionnaires', 'action' => 'view', $idQuestionnaire]);				
				}else{
					$transaction->rollback();
					$this->Flash->error('Une erreur s\'est produite, merci de réessayer.');
					return $this->redirect(['controller' => 'questionnaires', 'action' => 'view', $idQuestionnaire]);
				}
				
			}else{
				$transaction->begin();
				$associationsPartials = TableRegistry::get('answers_questionnaires_users_partials');
				$associations = TableRegistry::get('answers_questionnaires_users');
				foreach($this->request->data as $key => $value){
					if(strstr($key, '-')){
						$keySplitted = explode('-', $key);
						$idForWho = $keySplitted[0];
						$idQuestion = $keySplitted[1];
						$idAnswer = $value;
						
						$associationsPartials->deleteAll(['questionnaire_id' => $idQuestionnaire,
																				'user_id' => $idUser]);
																				
						$association = $associations->newEntity();
						$association->question_id = $idQuestion;
						$association->questionnaire_id = $idQuestionnaire;
						$association->user_id = $idUser;
						$association->for_who = $idForWho;
						$association->answer_id = $idAnswer;
						$success = $success && $associations->save($association);
					}
				}
				//sauvegarder les réponses
				if($success){
					$transaction->commit();
					$this->Flash->success('Le questionnaire a bien été validé !');
					return $this->redirect(['controller' => 'questionnaires', 'action' => 'view', $idQuestionnaire]);				
				}else{
					$transaction->rollback();
					$this->Flash->error('Une erreur s\'est produite, merci de réessayer.');
					return $this->redirect(['controller' => 'questionnaires', 'action' => 'view', $idQuestionnaire]);
				}
			}		
		}
		
		$groups = TableRegistry::get('groups');
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
		$users = TableRegistry::get('users');
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
		$questionTable = TableRegistry::get('questions');
		$answerTable = TableRegistry::get('answers');
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
		
		//chargement des réponses partielles pour l'user
		$answersTable = TableRegistry::get('answers_questionnaires_users_partials');
		$answersPartialsQuery = $answersTable->find()->where(['questionnaire_id' => $idQuestionnaire,
															'user_id' => $idUser]);
		$answersPartials = array();
		$queryArray = $answersPartialsQuery->toArray();
		for($i = 0; $i < count($queryArray); $i++){
			$answersPartials[$queryArray[$i]['for_who'] . '-' . $queryArray[$i]['question_id']] = $queryArray[$i]['answer_id'];
		}		
		
		$this->set('users', $usersQuery->toArray());
		$this->set('questions', $questions);
		$this->set('answersPartials', $answersPartials);
        $questionnaire = $this->Questionnaires->get($idQuestionnaire);
        $this->set('questionnaire', $questionnaire);
        $this->set('_serialize', ['questionnaire']);
	}
	
	private function isOwner(){
		$session = $this->request->session();
		$currentUser = $session->read('Auth.User');
		$idUser = $currentUser['id'];
		$questionnaires = TableRegistry::get('questionnaires');
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
						->select(['Owners.id', 'questionnaires.title'])
						->where(['Owners.id' => $idUser,
								'questionnaires.id' => $id]);
		});
		return $queryOwner->count();
	}
	
    /**
     * Index method
     *
     * @return void
     */
    public function index(){
	
		$questionnaires = TableRegistry::get('questionnaires');
		$questionnairesQuery = $questionnaires->find()->matching('Owners');
		
		$questionnairesArray = $questionnairesQuery->toArray();
		
        $this->set('questionnaires', $this->paginate($questionnairesQuery));
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
		$session = $this->request->session();
		$currentUser = $session->read('Auth.User');
		$idUser = $currentUser['id'];
		$isOwner = $this->isOwner();
		if(!$isOwner){
			$hasPartialAnswer = false;
			$isValidated = false;
			
			$answersTable = TableRegistry::get('answers_questionnaires_users_partials');
			$answersPartials = $answersTable->find()->where(['questionnaire_id' => $id,
																'user_id' => $idUser]);
			if($answersPartials->count()){
				$hasPartialAnswer = true;
			}else{
				$answersTable = TableRegistry::get('answers_questionnaires_users');
				$answers = $answersTable->find()->where(['questionnaire_id' => $id,
																'user_id' => $idUser]);
				if($answers->count()){
					$isValidated = true;
				}
			}
			$this->set('isValidated', $isValidated);
			$this->set('hasPartialAnswer', $hasPartialAnswer);
		}else{
			$questions = TableRegistry::get('questions');
			$questionsQuery = $questions->find()
									->hydrate(false)
									->join([
										'aqq' => [ // on join associations avec les questions du questionnaires
											'table' => 'answers_questions_questionnaires',
											'type' => 'INNER',
											'conditions' => 'aqq.question_id = questions.id',
										]
									
									])
									->where(['aqq.questionnaire_id' => $id]) // et on cible le questionnaire où on est
									->distinct(['question_id']);
			$answers = TableRegistry::get('answers');						
			$answersQuery = $answers->find()
									->hydrate(false)
									->join([
										'aqq' => [ // on join associations avec les réponses du questionnaires
											'table' => 'answers_questions_questionnaires',
											'type' => 'INNER',
											'conditions' => 'aqq.answer_id = answers.id',
										]
									
									])
									->where(['aqq.questionnaire_id' => $id]) // et on cible le questionnaire où on est
									->distinct(['answer_id']);
									
			//$answersTable = TableRegistry::get('answers_questionnaires_users');
			//$answers = $answersTable->find()->where(['questionnaire_id' => $id]); //association des réponses par users pour le questionnaire
				
			
			//requête contenant tous les utilisateurs associés au questionnaire			
			$users = TableRegistry::get('users');
			$usersQuery = $users->find()->hydrate(false)
									->join([
										'gu' => [ // on join les groupes associés aux étudiant
											'table' => 'groups_users',
											'type' => 'INNER',
											'conditions' => 'gu.user_id = users.id',
										],
										'qg' => [ // on join les groupes à celui du questionnaire et du join précédent
											'table' => 'questionnaires_groups',
											'type' => 'INNER',
											'conditions' => 'qg.group_id = gu.group_id',
										]
									
									])
									->where(['qg.questionnaire_id' => $id]);
									// on cible le questionnaire
				
			$usersStats = array();
			$groupsStats = array();
			$questionsArray = $questionsQuery->toArray();
			$answersArray = $answersQuery->toArray();
			$answersTable = TableRegistry::get('answers_questionnaires_users');
			$answersQuestionsQuestionnaires = TableRegistry::get('answers_questions_questionnaires');
			$answersQuestionsQuestionnairesQuery = $answersQuestionsQuestionnaires->find()->where(['questionnaire_id' => $id]);
			$answersQuestionsQuestionnairesArray = $answersQuestionsQuestionnairesQuery->toArray();
			$usersArray = $usersQuery->toArray();
			
			// on parcours chaque étudiant contenu dans le questionnaire
			for($i = 0; $i < count($usersArray); $i++){
				$usersStats[$i] = array();
				$usersStats[$i]['user'] = $usersArray[$i];
				$answersAssociations = $answersTable->find()->where(['questionnaire_id' => $id,
														'for_who' => $usersArray[$i]['id']]);
				$answersAssociationsArray = $answersAssociations->toArray();
				$usersStats[$i]['questions'] = array();
				
				//ensuite chaque question du questionnaire pour lui ajouter
				for($p = 0; $p < count($answersQuestionsQuestionnairesArray); $p++){
					$question = $this->getValueFromId($questionsArray, $answersQuestionsQuestionnairesArray[$p]['question_id']);
					if($question != null){
						if(!array_key_exists($question['id'], $usersStats[$i]['questions'])){
							$usersStats[$i]['questions'][$question['id']] = $question;
						}
						// et on associe chaque réponse
						$answer = $this->getValueFromId($answersArray, $answersQuestionsQuestionnairesArray[$p]['answer_id']);
						$usersStats[$i]['questions'][$question['id']]['answers'][$answersQuestionsQuestionnairesArray[$p]['position']] = $answer;
						// et ensuite on ajoute le nombre de réponse des autres utilisateurs associés à chaque réponse
						
						if(!array_key_exists('users', $usersStats[$i]['questions'][$question['id']]['answers'][$answersQuestionsQuestionnairesArray[$p]['position']])){
							$usersStats[$i]['questions'][$question['id']]['answers'][$answersQuestionsQuestionnairesArray[$p]['position']]['users'] = array();
						}
						for($d = 0; $d < count($answersAssociationsArray); $d++){
							if($answersAssociationsArray[$d]['answer_id'] == $answersQuestionsQuestionnairesArray[$p]['answer_id'] &&
								$answersAssociationsArray[$d]['question_id'] == $answersQuestionsQuestionnairesArray[$p]['question_id']){
								$user = $this->getValueFromId($usersArray, $answersAssociationsArray[$d]['user_id']);
								if($user != null){
									$usersStats[$i]['questions'][$question['id']]['answers'][$answersQuestionsQuestionnairesArray[$p]['position']]['users'][$user['id']] = $user;
								}
							}
						}
					}
				}
				if(!empty($usersStats[$i])){
					$groups = TableRegistry::get('groups');
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
									->where(['qg.questionnaire_id' => $id]) // où l'id questionnaire
									->andWhere(['gu.user_id' => $usersStats[$i]['user']['id']]); // et on cible où c'est l'user
					$groupArray = $groupsQuery->first();
					if($groupArray != null){
						if(!array_key_exists($groupArray['id'], $groupsStats)){
							$groupsStats[$groupArray['id']] = array();
							$groupsStats[$groupArray['id']] = $groupArray;
							$groupsStats[$groupArray['id']]['usersStats'] = array();
						}
						array_push($groupsStats[$groupArray['id']]['usersStats'], $usersStats[$i]);
					}
				}
			}
			//debug($groupsStats);
			$this->set('groupsStats', $groupsStats);
			//$this->set('usersStats', $usersStats);
			
			$users = TableRegistry::get('users');
			$usersQuery = $users->find()
								->hydrate(false)
								->join([
									'aqu' => [ // on join associations avec les réponses validées
									'table' => 'answers_questionnaires_users',
									'type' => 'INNER',
									'conditions' => 'aqu.user_id = users.id',
								]])
								->where(['aqu.questionnaire_id' => $id]) // et on cible le questionnaire où on est
								->distinct(['user_id']);
			
			$this->set('usersValidated', $usersQuery->toArray());
		}
		$this->set('isOwner', $isOwner);
        $questionnaire = $this->Questionnaires->get($id);
        $this->set('questionnaire', $questionnaire);
        $this->set('_serialize', ['questionnaire']);
    }

	/**
	*	Permet de récupérer un tuple (en se basant sur son id) provenant d'un tableau
	*	qui lui même a été acquis depuis une requête sql
	*	si return null c'est que le tuple avec cet id n'est pas dans le tableau
	*/
	private function getValueFromId($array, $id){
		for($i = 0; $i < count($array); $i++){
			if($array[$i]['id'] == $id){
				return $array[$i];
			}
		}
		return null;
	}
	
	/**
	*	Convertie une date provenant d'un datetimepicker de bootstrap
	*	vers un DateTime de php
	*/
	private function dateTimePickerToDatetime($date){
		$months = [
		'Janvier' => '01',
		'Février' =>'02',
		'Mars' =>'03',
		'Avril' =>'04',
		'Mai'=> '05',
		'Juin' => '06',
		'Juillet' => '07',
		'Août' => '08',
		'Septembre' => '09',
		'Octobre' => '10',
		'Novembre' => '11',
		'Décembre' => '12'];
		
		$tmp = explode(' - ', $date);
		$date = $tmp[0];
		$hour = $tmp[1] . ':00';
		
		$day = substr($date, 0, 2);
		
		$dateExploded = explode(' ', $date);
		$month = $dateExploded[1];
		$year = $dateExploded[2];
		
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
			$msgError = '';
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
				
				$groups = TableRegistry::get('groups');
				$queryGroups = $groups->find()->hydrate(false)
									 ->join([
										'gm' => [ // on join les modules
											'table' => 'modules_groups',
											'type' => 'INNER',
											'conditions' => 'gm.group_id = groups.id',
										]
									
									])
									->where(['gm.module_id' => $idModule]); // et on cible le module où on est
				if($queryGroups->count()){
					$this->request->data['groups'] = $queryGroups->toArray();
				}else{
					$msgError .= 'Le questionnaire a été associé a aucun groupe.';
				}
				$questionnaire = $this->Questionnaires->patchEntity($questionnaire, $this->request->data);
				//debug($questionnaire);
				$questionnaire = $this->Questionnaires->save($questionnaire);
				if(!$questionnaire){
					$transaction->rollback();				
					$this->Flash->error('Une erreur s\'est produite, merci de réessayer..');
					$success = false;
					//return $this->redirect(['controller' => 'questionnaires', 'action' => 'add', $idModule]);
				}
			}else{
                $this->Flash->error('Le questionnaire doit contenir au moins un titre & une description.');
				$success = false;
				//return $this->redirect(['controller' => 'questionnaires', 'action' => 'add', $idModule]);
			}
			if($success){
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
						$questionTable = TableRegistry::get('questions');
						$questionTuple = $questionTable->find()->where(['questions.id' => $idQuestion]);
						if($questionTuple->first() == null){
							$questionTuple = $questionTable->newEntity();
							$questionTuple->content = $question;
							$questionTuple->type = 0;
							$questionTuple = $questionTable->save($questionTuple);
							$success = $success && $questionTuple;
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
							$answerTable = TableRegistry::get('answers');
							$answerTuple = $answerTable->find()->where(['answers.id' => $idAnswer]);
							if($answerTuple->first() == null){
								//debug('insert answer ' . $idAnswer . ' '. $answer);
								$answerTuple = $answerTable->newEntity();
								$answerTuple->value = $answer;
								$answerTuple = $answerTable->save($answerTuple);
								$success = $success && $answerTuple;
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
							$success = $success && $associationTable->save($association);
						}
					}
				}
			}
			
			if($success){
				$transaction->commit();
				
				// on envoi les mails si demandé
				/**if(array_key_exists('sendEmail', $this->request->data)){
					//tous les utilisateurs à notifier
					$users = TableRegistry::get('users');
					$usersQuery = $users->find()->hydrate(false)
									->join([
										'gu' => [ // on join les groupes associés aux étudiant
											'table' => 'groups_users',
											'type' => 'INNER',
											'conditions' => 'gu.user_id = users.id',
										],
										'qg' => [ // on join les groupes à celui du questionnaire et du join précédent
											'table' => 'questionnaires_groups',
											'type' => 'INNER',
											'conditions' => 'qg.group_id = gu.group_id',
										]
									
									])
									->where(['qg.questionnaire_id' => $questionnaire->id]);
					$usersArray = $usersQuery->toArray();
					for($i = 0;$i < count($usersArray); $i++){
						$to = $usersArray[$i]['email'];
						$from = 'alexis.puret@etu.univ-tours.fr';
						$subject = 'évaluation par les pairs.';
						$msg = 'Bonjour ' . $usersArray[$i]['last_name'] . ' ' . $usersArray[$i]['first_name']
						. '\nUn questionnaire a été crée pour votre groupe dans le module TODO et vous devait y répondre avant le '. $questionnaire->data_limit .'.\n\n'
						. $currentUser['last_name'] . ' ' . $currentUser['first_name'];
						$email = new Email('default');
						$email->to($to)
							->from([$from => 'Hello'])
							->subject('toast')
								->send();
					}
				}**/
				
				$this->Flash->success('Le questionnaire a bien été ajouté.' . $msgError);
				return $this->redirect(['controller' => 'Modules', 'action' => 'view', $idModule]);
			}else{
				$transaction->rollback();
				$this->Flash->error('Une erreur s\'est produite, merci de réessayer plus tard.');
				//return $this->redirect(['controller' => 'Modules', 'action' => 'view', $idModule]);
			}
		
		}
        $questions = TableRegistry::get('questions');
		$questions = $questions->find('list');
		$answers = TableRegistry::get('answers');
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
    public function edit($id = null){
        $questionnaire = $this->Questionnaires->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
			
			$success = true;
			$transaction = ConnectionManager::get('default'); // permet de faire un rollback si une des insertions plantes
			$transaction->begin();
			$associations = TableRegistry::get('answers_questions_questionnaires');
			$success = $success && $associations->deleteAll(['questionnaire_id' => $id]);
			
			//on vide par les tableaux fournis par défault de cake
			$this->request->data['answers'] = array();
			$this->request->data['questions'] = array();
			//on save le questionnaire en vérifiant que titre et description ne sont pas null et de même pour les dates
			if(strlen($this->request->data['title']) > 0 && strlen($this->request->data['description']) > 0 &&
				strlen($this->request->data['date_creation']) > 0 &&
				strlen($this->request->data['date_limit']) > 0){
			
				$session = $this->request->session();
				$currentUser = $session->read('Auth.User');
				
				$this->request->data['date_creation'] = $this->dateTimePickerToDatetime($this->request->data['date_creation']);
				$this->request->data['date_limit'] = $this->dateTimePickerToDatetime($this->request->data['date_limit']);
				
				$questionnaire = $this->Questionnaires->patchEntity($questionnaire, $this->request->data);
				//debug($questionnaire);
				$questionnaire = $this->Questionnaires->save($questionnaire);
				if(!$questionnaire){
					$transaction->rollback();				
					$this->Flash->error('Une erreur s\'est produite, merci de réessayer..');
					$success = false;
				}
			}else{
                $this->Flash->error('Le questionnaire doit contenir au moins un titre & une description.');
				$success = false;
			}
			if($success){
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
						$questionTable = TableRegistry::get('questions');
						$questionTuple = $questionTable->find()->where(['Questions.id' => $idQuestion]);
						if($questionTuple->first() == null){
							$questionTuple = $questionTable->newEntity();
							$questionTuple->content = $question;
							$questionTuple->type = 0;
							$questionTuple = $questionTable->save($questionTuple);
							$success = $success && $questionTuple;
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
							$answerTable = TableRegistry::get('answers');
							$answerTuple = $answerTable->find()->where(['Answers.id' => $idAnswer]);
							if($answerTuple->first() == null){
								//debug('insert answer ' . $idAnswer . ' '. $answer);
								$answerTuple = $answerTable->newEntity();
								$answerTuple->value = $answer;
								$answerTuple = $answerTable->save($answerTuple);
								$success = $success && $answerTuple;
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
							$success = $success && $associationTable->save($association);
						}
					}
				}
			}
			if($success){
				$transaction->commit();				
				$this->Flash->success('Le questionnaire a bien été modifié.');
				return $this->redirect(['controller' => 'questionnaires', 'action' => 'index']);
			}else{
				$transaction->rollback();
				$this->Flash->error('Une erreur s\'est produite, merci de réessayer plus tard.');
			}
        }
		
		//chargement des associations contenu par ce questionnaire
		$associationTable = TableRegistry::get('answers_questions_questionnaires');
		$associations = $associationTable->find()->where(['questionnaire_id' => $id]);
		// on charge ensuite chaque questions et ses réponses.
		$questionsQuestionnaire = array();
		$associations = $associations->toArray();
		$questionTable = TableRegistry::get('questions');
		$answerTable = TableRegistry::get('answers');
		for($p = 0; $p < count($associations); $p++){
			$question = $questionTable->get($associations[$p]['question_id']);
			$answers = $answerTable->get($associations[$p]['answer_id']);
			if(!array_key_exists($question['id'], $questionsQuestionnaire)){
				$questionsQuestionnaire[$question['id']]['answers'] = array();
			}
			//on met les infos de la question (id, content)
			$questionsQuestionnaire[$question['id']]['content'] = $question['content'];
			$questionsQuestionnaire[$question['id']]['id'] = $question['id']; // plus simple d'y accéder comme ceci que par un index pour un for.
			// on place la question à la bonne position
			$questionsQuestionnaire[$question['id']]['answers'][$associations[$p]['position']] = $answers;
		}
		
			
		$userHasAnswer = TableRegistry::get('answers_questionnaires_users');
		$userHasAnswerQuery = $userHasAnswer->find()->where(['questionnaire_id' => $id]);
		$dangerUserHasAnswer = false;
		if($userHasAnswerQuery->count()){
			$dangerUserHasAnswer = true;
		}
		$this->set('dangerUserHasAnswer', $dangerUserHasAnswer);
		$this->set('questionsQuestionnaire', $questionsQuestionnaire);
		
		
        $questions = TableRegistry::get('questions');
		$questions = $questions->find('list');
		$answers = TableRegistry::get('answers');
		$answers = $answers->find('list');
        $this->set(compact('questionnaire', 'questions', 'answers'));
        $this->set('_serialize', ['questionnaire']);
    }
	
	/**
	*
	*	Supprime complètement le questionnaire avec toutes ses associations
	*/
	public function delete($id = null){
		if($id != null){
			$this->deleteAssociation($id);
			//supprimer les associations dans answers_questions_questionnaires
			$associations = TableRegistry::get('answers_questions_questionnaires');
			$success = $success && $associations->deleteAll(['questionnaire_id' => $id]);
			//supprimer le questionnaire dans questionnaires
			$associations = TableRegistry::get('questionnaires');
			$success = $success && $associations->deleteAll(['id' => $id]);
			$this->Flash->success('Le questionnaire a bien été supprimé.');
			$this->redirect($this->referer());
		
		}
	}

    /**
     * Delete method
     *	Supprime les associations du questionnaire avec le/les groupes et les réponses associées avec les utilisateurs
     * @param string|null $id Questionnaire id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function deleteAssociation($id = null){
		//supprimer les associations dans answers_questions_questionnaires
		//$associations = TableRegistry::get('answers_questions_questionnaires');
		//$success = $success && $associations->deleteAll(['questionnaire_id' => $id]);
		
		//supprimer les associations dans answers_questionnaires_users
		$associations = TableRegistry::get('answers_questionnaires_users_partials');
		$associations->deleteAll(['questionnaire_id' => $id]);
		
		//supprimer les associations dans questionnaires_groups
		$associations = TableRegistry::get('questionnaires_groups');
		$associations->deleteAll(['questionnaire_id' => $id]);
		
		//supprimer les associations dans answers_questionnaires_users
		$associations = TableRegistry::get('answers_questionnaires_users');
		$associations->deleteAll(['questionnaire_id' => $id]);
		
		//supprimer l'association avec le proprio du questionnaire
		$associations = TableRegistry::get('questionnaires_owners');
		$associations->deleteAll(['questionnaire_id' => $id]);
		
		//supprimer le questionnaire dans questionnaires
		//$associations = TableRegistry::get('questionnaires');
		//$success = $success && $associations->deleteAll(['id' => $id]);
		
		$this->Flash->success('Le questionnaire a bien été supprimé.');
		if(!strstr($this->referer(), 'questionnaires')){
			$this->redirect($this->referer());
		}
    }
	
	
	public function copy($idQuestionnaire = null){
		if($idQuestionnaire != null){
		
			$questionnaire = $this->Questionnaires->get($idQuestionnaire);
			if ($this->request->is(['post', 'put'])) {				
				
				$session = $this->request->session();
				$currentUser = $session->read('Auth.User');
				$success = true;
				$transaction = ConnectionManager::get('default'); // permet de faire un rollback si une des insertions plantes
				$transaction->begin();
				
				//on copie chaque élément du questionnaire à copier SAUF son ID
				$questionnaireCopy = $this->Questionnaires->newEntity();
				$questionnaireCopy->title = $questionnaire->title;
				$this->request->data['title'] = $questionnaire->title;
				$questionnaireCopy->description = $questionnaire->description;
				$this->request->data['description'] = $questionnaire->description;
				$questionnaireCopy->date_creation = $questionnaire->date_creation;
				$questionnaireCopy->date_limit = $questionnaire->date_limit;
				
				$this->request->data['owners'][0] = $currentUser; // on ajoute l'utilisateur actuel pour indiquer qu'il est lier au questionnaire		
				//$questionnaireCopy = $this->Questionnaires->patchEntity($questionnaireCopy, $this->request->data);
				
				$this->request->data['groups'] = array();
				$countGroup = 0;
				for($m = 0; $m < count($this->request->data['modules']['ids']); $m++){
					//on associe le questionnaire avec le ou les modules voulus
					$groups = TableRegistry::get('groups');
					$idModule = $this->request->data['modules']['ids'][$m];
					$queryGroups = $groups->find()->hydrate(false)
										 ->join([
											'gm' => [ // on join les modules
												'table' => 'modules_groups',
												'type' => 'INNER',
												'conditions' => 'gm.group_id = groups.id',
											]])
										->where(['gm.module_id' => $idModule]); // et on cible le module où on est
					$groupsArray = $queryGroups->toArray();
					for($g = 0; $g < count($groupsArray); $g++){
						$this->request->data['groups'][$countGroup++] = $groupsArray[$g];
					}
				}
				//debug($this->request->data);
				$questionnaireCopy = $this->Questionnaires->patchEntity($questionnaireCopy, $this->request->data);
				
				$questionnaireCopy = $this->Questionnaires->save($questionnaireCopy);
				$success = $success && $questionnaireCopy;
				if($success){
					//chargement des associations du questionnaire à copier
					$associationTable = TableRegistry::get('answers_questions_questionnaires');
					$associations = $associationTable->find()->where(['questionnaire_id' => $idQuestionnaire]);
					//on copie les associations avec le nouvel id du questionnaire copié
					$associationsArray = $associations->toArray();
					for($i = 0; $i < count($associationsArray); $i++){
						$associationCopy = $associationTable->newEntity();
						$associationCopy['questionnaire_id'] = $questionnaireCopy->id;
						$associationCopy['position'] = $associationsArray[$i]['position'];
						$associationCopy['question_id'] = $associationsArray[$i]['question_id'];
						$associationCopy['answer_id'] = $associationsArray[$i]['answer_id'];
						$success = $success && $associationTable->save($associationCopy);
					}
				}
				if($success){
					$transaction->commit();
					$this->Flash->success('Le questionnaire a bien été copié !');
					return $this->redirect(['controller' => 'questionnaires', 'action' => 'edit', $questionnaireCopy->id]);
				}else{
					$transaction->rollback();
					$this->Flash->error('Une erreur s\'est produite, merci de réessayer plus tard.');
				}
			}
			
			$session = $this->request->session();
			$currentUser = $session->read('Auth.User');
			$role = $currentUser['role_id'];
			$usersTable = $associations = TableRegistry::get('users');
			$user = $usersTable->get($currentUser['id'], [
				'contain' => ['ModuleOwner']
			]);
			
			
			$questionnaire = $this->Questionnaires->get($idQuestionnaire);
			$modulesUser = $user->module_owner;
			$this->set(compact('modulesUser'));
			$this->set('questionnaire', $questionnaire);
		}
		//$this->redirect($this->referer());
	}
}
