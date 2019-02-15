<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Buyer Entity
 *
 * @property int $id
 *
 * @property \App\Model\Entity\Person $person
 * @property \App\Model\Entity\BranchOfActivity[] $branch_of_activities
 */
class Buyer extends Entity
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
        'person' => true,
        'number_of_boxes' => true,
        'branch_of_activities' => true,
        'addresses' => true
    ];
}
