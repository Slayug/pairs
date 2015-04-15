<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Question Entity.
 */
class Question extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'contenu' => true,
        'type' => true,
        'answers_questionnaire_users' => true,
        'answers_questionnaire_users_partials' => true,
        'answers' => true,
        'questionnaires' => true,
    ];
}
