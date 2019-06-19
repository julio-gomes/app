<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;


/**
 * User Entity
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $cellphone
 *
 * @property \App\Model\Entity\Person $person
 * @property \App\Model\Entity\UsersHasUser[] $users_has_users
 */
class User extends Entity
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
        'name' => true,
        'email' => true,
        'password' => true,
        'cellphone' => true,
        'person_seller' => true,
        'person_buyer' => true,
        'person_corporate' => true,
        'avatar_base64' => true,
        'avatar_mime_type' => true,
        'users_has_users' => true,
        'parent_users' => true,
        'child_users' => true,
        '_joinData' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];

    protected function _setPassword($value)
    {
        if (strlen($value) > 0) {
            return (new DefaultPasswordHasher)->hash($value);
        } else {
            return $this->password;
        }
    }
}
