<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Corporates Model
 *
 * @property \App\Model\Table\OccupationAreasTable|\Cake\ORM\Association\HasMany $OccupationAreas
 * @property \App\Model\Table\BrandsTable|\Cake\ORM\Association\BelongsToMany $Brands
 * @property \App\Model\Table\ProductCategoriesTable|\Cake\ORM\Association\BelongsToMany $ProductCategories
 *
 * @method \App\Model\Entity\Corporate get($primaryKey, $options = [])
 * @method \App\Model\Entity\Corporate newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Corporate[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Corporate|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Corporate|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Corporate patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Corporate[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Corporate findOrCreate($search, callable $callback = null, $options = [])
 */
class CorporatesTable extends Table
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

        $this->setTable('corporates');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsToMany('Brands', [
            'foreignKey' => 'corporate_id',
            'targetForeignKey' => 'brand_id',
            'joinTable' => 'corporates_brands'
        ]);

        $this->belongsToMany('ProductCategories', [
            'foreignKey' => 'corporate_id',
            'targetForeignKey' => 'product_category_id',
            'joinTable' => 'corporates_product_categories'
        ]);

        $this->belongsToMany('BranchOfActivities', [
            'foreignKey' => 'corporate_id',
            'targetForeignKey' => 'branch_of_activity_id',
            'joinTable' => 'branch_of_activities_corporates'
        ]);

        $this->belongsTo('Persons', [
            'foreignKey' => 'id'
        ]);

        $this->belongsToMany('Addresses', [
            'foreignKey' => 'corporate_id',
            'targetForeignKey' => 'address_id',
            'joinTable' => 'addresses_corporates'
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
