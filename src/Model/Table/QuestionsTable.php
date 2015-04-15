<?php
namespace App\Model\Table;

use App\Model\Entity\Question;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Questions Model
 */
class QuestionsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('questions');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->hasMany('AnswersQuestionnaireUsers', [
            'foreignKey' => 'question_id'
        ]);
        $this->hasMany('AnswersQuestionnaireUsersPartials', [
            'foreignKey' => 'question_id'
        ]);
        $this->belongsToMany('Answers', [
            'foreignKey' => 'question_id',
            'targetForeignKey' => 'answer_id',
            'joinTable' => 'answers_questions'
        ]);
        $this->belongsToMany('Questionnaires', [
            'foreignKey' => 'question_id',
            'targetForeignKey' => 'questionnaire_id',
            'joinTable' => 'questionnaires_questions'
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
            ->requirePresence('contenu', 'create')
            ->notEmpty('contenu')
            ->add('type', 'valid', ['rule' => 'numeric'])
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        return $validator;
    }
}
