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
class ModulesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('modules');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsToMany('Groups', [
            'foreignKey' => 'module_id',
            'targetForeignKey' => 'group_id',
            'joinTable' => 'modules_groups'
        ]);
		 $this->belongsToMany('Users', [
            'foreignKey' => 'module_id',
            'targetForeignKey' => 'user_id',
            'joinTable' => 'modules_users'
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
            ->requirePresence('name', 'create')
            ->notEmpty('name')
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        return $validator;
    }

}
