<?php
namespace App\Model\Table;

use App\Model\Entity\Questionnaire;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Questionnaires Model
 */
class QuestionnairesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('questionnaires');
        $this->displayField('title');
        $this->primaryKey('id');
        $this->hasMany('AnswersQuestionnaireUsers', [
            'foreignKey' => 'questionnaire_id'
        ]);
        $this->hasMany('AnswersQuestionnaireUsersPartials', [
            'foreignKey' => 'questionnaire_id'
        ]);
        $this->belongsToMany('Groups', [
            'foreignKey' => 'questionnaire_id',
            'targetForeignKey' => 'group_id',
            'joinTable' => 'questionnaires_groups'
        ]);
		
		// Users owners
		$this->belongsToMany('Owners', [
			'className' => 'Users',
            'foreignKey' => 'questionnaire_id',
            'targetForeignKey' => 'user_id',
            'joinTable' => 'questionnaires_owners',
			'propertyName' => 'owners'
        ]);
		
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create')
            ->requirePresence('title', 'create')
            ->notEmpty('title')
            ->requirePresence('description', 'create')
            ->notEmpty('description')
            ->add('date_creation', 'valid', ['rule' => 'datetime'])
            ->allowEmpty('date_creation')
            ->add('date_limit', 'valid', ['rule' => 'datetime'])
            ->allowEmpty('date_limit');

        return $validator;
    }
}
