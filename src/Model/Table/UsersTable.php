<?php
namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 */
class UsersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('users');
        $this->displayField('first_name');
        $this->primaryKey('id');
        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id'
        ]);
		
		//Modules
		
		$this->belongsToMany('Modules', [
			'className' => 'Modules',
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'module_id',
            'joinTable' => 'modules_users',
        ]);
        $this->belongsToMany('ModuleOwner', [
			'className' => 'Modules',
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'module_id',
            'joinTable' => 'modules_owners',
			'propertyName' => 'module_owner'
        ]);
		
		//Groups
		
        $this->belongsToMany('Groups', [
			'className' => 'Groups',
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'group_id',
            'joinTable' => 'groups_users'
        ]);
		$this->belongsToMany('GroupOwner', [
			'className' => 'Groups',
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'group_id',
            'joinTable' => 'groups_owners',
			'propertyName' => 'group_owner'
        ]);
		
		// Questionnaires
		
		$this->belongsToMany('Questionnaires', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'questionnaires_id',
            'joinTable' => 'questionnaires_owners',
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
            ->add('role_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('role_id', 'create')
            ->notEmpty('role_id')
            ->add('email', 'valid', ['rule' => 'email'])
			->add('email', ['unique' => ['rule' => 'validateUnique', 'provider' => 'table']])
            ->requirePresence('email', 'create')
            ->notEmpty('email')
            ->requirePresence('first_name', 'create')
            ->notEmpty('first_name')
            ->requirePresence('last_name', 'create')
            ->notEmpty('last_name')
            ->requirePresence('password', 'create')
            ->notEmpty('password');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['role_id'], 'Roles'));
        return $rules;
    }
}
