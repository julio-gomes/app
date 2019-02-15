<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UsersHasUser Entity
 *
 * @property int $user_id
 * @property int $friend_id
 * @property int $status
 *
 * @property \App\Model\Entity\User $user
 */
class UsersHasUser extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'status' => true,
        'user' => true,
        '_joinData' => true,
    ];
}
