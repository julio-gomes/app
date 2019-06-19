<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Sellers Model
 *
 * @property \App\Model\Table\OccupationAreasTable|\Cake\ORM\Association\HasMany $OccupationAreas
 * @property \App\Model\Table\BrandsTable|\Cake\ORM\Association\BelongsToMany $Brands
 * @property \App\Model\Table\ProductCategoriesTable|\Cake\ORM\Association\BelongsToMany $ProductCategories
 *
 * @method \App\Model\Entity\Seller get($primaryKey, $options = [])
 * @method \App\Model\Entity\Seller newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Seller[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Seller|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Seller|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Seller patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Seller[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Seller findOrCreate($search, callable $callback = null, $options = [])
 */
class SellersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('sellers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsToMany('Brands', [
            'foreignKey' => 'seller_id',
            'targetForeignKey' => 'brand_id',
            'joinTable' => 'sellers_brands'
        ]);

        $this->belongsToMany('ProductCategories', [
            'foreignKey' => 'seller_id',
            'targetForeignKey' => 'product_category_id',
            'joinTable' => 'sellers_product_categories'
        ]);

        $this->belongsTo('Persons', [
            'foreignKey' => 'id'
        ]);

        $this->belongsToMany('Addresses', [
            'foreignKey' => 'seller_id',
            'targetForeignKey' => 'address_id',
            'joinTable' => 'addresses_sellers'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        return $validator;
    }
}
