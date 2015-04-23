<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Group Entity.
 */
class Module extends Entity
{


    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'description' => true,
        'users' => true,
        'groups' => true,
		'owners' => true,
		'members' => true,
    ];
}
