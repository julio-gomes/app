<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Person Entity
 *
 * @property int $id
 * @property string $company_name
 * @property string $cnpj
 * @property string $telephone
 * @property string $house_number
 * @property int $address_id
 *
 * @property \App\Model\Entity\Address $address
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Buyer $buyer
 * @property \App\Model\Entity\Seller $seller
 */
class Person extends Entity
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
        'user_id' => true,
        'user' => true,
        'company_name' => true,
        'cnpj' => true,
        'telephone' => true,
        'house_number' => true,
        'addresses' => true,
        'buyer' => true,
        'seller' => true,
        'corporate' => true,
        'latitude' => true,
        'longitude' => true,
        'type' => true,
        'email' => true,
    ];
}
