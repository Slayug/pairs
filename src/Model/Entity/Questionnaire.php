<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Questionnaire Entity.
 */
class Questionnaire extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'titre' => true,
        'description' => true,
        'date_creation' => true,
        'date_limite' => true,
        'answers_questionnaire_users' => true,
        'answers_questionnaire_users_partials' => true,
        'groups' => true,
        'questions' => true,
    ];
}
