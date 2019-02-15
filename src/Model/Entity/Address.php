<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Address Entity
 *
 * @property int $id
 * @property string $zip_code
 * @property string $street
 * @property string $complement
 * @property int $state_id
 * @property string $house_number
 * @property int $person_id
 * @property int $city_id
 * @property int $district_id
 *
 * @property \App\Model\Entity\State $state
 * @property \App\Model\Entity\Person $person
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\District $district
 * @property \App\Model\Entity\Person[] $persons
 */
class Address extends Entity
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
        'zip_code' => true,
        'street' => true,
        'complement' => true,
        'state_id' => true,
        'house_number' => true,
        'person_id' => true,
        'city_id' => true,
        'district_id' => true,
        'state' => true,
        'person' => true,
        'city' => true,
        'district' => true,
        'persons' => true
    ];
}
