<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Seller Entity
 *
 * @property int $id
 *
 * @property \App\Model\Entity\Person $person
 * @property \App\Model\Entity\Brand[] $brands
 * @property \App\Model\Entity\ProductCategory[] $product_categories
 * @property \App\Model\Entity\BranchOfActivity[] $branch_of_activities
 */
class Corporate extends Entity
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
        'brands' => true,
        'branch_of_activities' => true,
        'product_categories' => true,
        
        'addresses' => true,
    ];
}
