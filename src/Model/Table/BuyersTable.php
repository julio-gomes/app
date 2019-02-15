<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Buyers Model
 *
 * @property \App\Model\Table\BranchOfActivitiesTable|\Cake\ORM\Association\BelongsToMany $BranchOfActivities
 *
 * @method \App\Model\Entity\Buyer get($primaryKey, $options = [])
 * @method \App\Model\Entity\Buyer newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Buyer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Buyer|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Buyer|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Buyer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Buyer[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Buyer findOrCreate($search, callable $callback = null, $options = [])
 */
class BuyersTable extends Table
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

        $this->setTable('buyers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'id'
        ]);

        $this->belongsToMany('BranchOfActivities', [
            'foreignKey' => 'buyer_id',
            'targetForeignKey' => 'branch_of_activity_id',
            'joinTable' => 'branch_of_activities_buyers'
        ]);

        $this->belongsToMany('Addresses', [
            'foreignKey' => 'buyer_id',
            'targetForeignKey' => 'address_id',
            'joinTable' => 'addresses_buyers'
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

        $validator
            ->integer('number_of_boxes')
            ->allowEmpty('number_of_boxes');


        return $validator;
    }
}
