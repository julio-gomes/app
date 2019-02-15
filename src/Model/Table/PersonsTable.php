<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use ArrayObject;


/**
 * Persons Model
 *
 * @property \App\Model\Table\AddressesTable|\Cake\ORM\Association\BelongsTo $Addresses
 *
 * @method \App\Model\Entity\Person get($primaryKey, $options = [])
 * @method \App\Model\Entity\Person newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Person[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Person|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Person|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Person patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Person[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Person findOrCreate($search, callable $callback = null, $options = [])
 */
class PersonsTable extends Table
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

        $this->setTable('persons');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);

        $this->hasOne('Sellers', [
            'foreignKey' => 'id',
        ]);

        $this->hasOne('Buyers', [
            'foreignKey' => 'id',
        ]);

        $this->hasOne('Corporates', [
            'foreignKey' => 'id',
        ]);

        $this->hasMany('Addresses')
            ->setForeignKey('person_id');
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
            ->scalar('company_name')
            ->maxLength('company_name', 45)
            ->allowEmpty('company_name');

        $validator
            ->scalar('type')
            ->maxLength('type', 45)
            ->allowEmpty('type');

        $validator
            ->scalar('cnpj')
            ->maxLength('cnpj', 45)
            ->allowEmpty('cnpj');

        $validator
            ->scalar('telephone')
            ->maxLength('telephone', 45)
            ->allowEmpty('telephone');

        $validator
            ->scalar('house_number')
            ->maxLength('house_number', 45)
            ->allowEmpty('house_number');

        $validator
            ->scalar('email')
            ->maxLength('email', 50)
            ->allowEmpty('email');

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
        //$rules->add($rules->existsIn(['address_id'], 'Addresses'));

        return $rules;
    }

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
       if (isset($data['cnpj'])) {
           $data['cnpj'] = preg_replace('/[^0-9]/', '', $data['cnpj']);
       }

       if (isset($data['telephone'])) {
           $data['telephone'] = preg_replace('/[^0-9]/', '', $data['telephone']);
       }
    }

    public function findSeller(\Cake\ORM\Query $query) {
        return $query->innerJoinWith('Sellers');
    }

    public function findBuyer(\Cake\ORM\Query $query) {
        return $query->innerJoinWith('Buyers');
    }
    /**
   * @return \Search\Manager
   */
    public function searchManager()
    {
        $searchManager = $this->behaviors()->Search->searchManager();
        $searchManager
            ->add('name', 'Search.Like', [
                 'before' => true,
                 'after' => true,
                 'fieldMode' => 'OR',
                 'comparison' => 'LIKE',
                 'wildcardAny' => '*',
                 'wildcardOne' => '?',
                 'field' => ['name']
             ])
             ->add('email', 'Search.Like', [
                  'before' => true,
                  'after' => true,
                  'fieldMode' => 'OR',
                  'comparison' => 'LIKE',
                  'wildcardAny' => '*',
                  'wildcardOne' => '?',
                  'field' => ['email']
              ])
            ->boolean('is_visible');

        return $searchManager;
    }
}
