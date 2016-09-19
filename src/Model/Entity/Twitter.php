<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Tweet Entity.
 *
 * @property int $id
 */
class Twitter extends Entity
{

    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
