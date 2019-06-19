<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BranchOfActivities Model
 *
 * @property \App\Model\Table\BuyersTable|\Cake\ORM\Association\BelongsToMany $Buyers
 *
 * @method \App\Model\Entity\BranchOfActivity get($primaryKey, $options = [])
 * @method \App\Model\Entity\BranchOfActivity newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\BranchOfActivity[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BranchOfActivity|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BranchOfActivity|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BranchOfActivity patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BranchOfActivity[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\BranchOfActivity findOrCreate($search, callable $callback = null, $options = [])
 */
class BranchOfActivitiesTable extends Table
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

        $this->setTable('branch_of_activities');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsToMany('Buyers', [
            'foreignKey' => 'branch_of_activity_id',
            'targetForeignKey' => 'buyer_id',
            'joinTable' => 'branch_of_activities_buyers'
        ]);

        $this->belongsToMany('Corporates', [
            'foreignKey' => 'branch_of_activity_id',
            'targetForeignKey' => 'corporate_id',
            'joinTable' => 'branch_of_activities_corporates'
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
            ->scalar('name')
            ->maxLength('name', 45)
            ->requirePresence('name', 'create')
            ->notEmpty('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['name']));

        return $rules;
    }
}
