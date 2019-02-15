<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Mailer\Email;
use Cake\Event\Event;
use ArrayObject;


/**
 * Users Model
 *
 * @property \App\Model\Table\PersonsTable|\Cake\ORM\Association\HasMany $Persons
 * @property \App\Model\Table\UsersHasUsersTable|\Cake\ORM\Association\HasMany $UsersHasUsers
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasOne('PersonSeller', [
                'className' => 'Persons'
            ])
            ->setDependent(true)
            ->setConditions(['PersonSeller.type' => 'seller'])
            ->setForeignKey('user_id')
            ->setProperty('person_seller');

        $this->hasOne('PersonBuyer', [
                'className' => 'Persons'
            ])
            ->setDependent(true)
            ->setConditions(['PersonBuyer.type' => 'buyer'])
            ->setForeignKey('user_id')
            ->setProperty('person_buyer');

        $this->hasOne('PersonCorporate', [
                'className' => 'Persons'
            ])
            ->setDependent(true)
            ->setConditions(['PersonCorporate.type' => 'corporate'])
            ->setForeignKey('user_id')
            ->setProperty('person_corporate');

        $this->belongsToMany('ParentUsers', [
            'className' => 'Users',
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'friend_id',
            'joinTable' => 'users_has_users'
        ]);

        $this->belongsToMany('ChildUsers', [
            'className' => 'Users',
            'foreignKey' => 'friend_id',
            'targetForeignKey' => 'user_id',
            'joinTable' => 'users_has_users'
        ]);

        // $this->addBehavior('Josegonzalez/Upload.Upload', [
        //     'photo' => [
        //         'path' => 'webroot{DS}img{DS}users{DS}{field-value:photo_dir}',
        //         'fields' => [],
        //         'nameCallback' => function ($data, $settings) {
        //             // filename
        //             $ext = substr(strrchr($data['name'], '.'), 1);
        //             return 'photo.' . $ext;
        //         },
        //     ],
        // ]);

        $this->addBehavior('Search.Search');
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
            ->notEmpty('name');

        $validator
            //->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmpty('password');

        $validator
            ->scalar('cellphone')
            ->maxLength('cellphone', 45)
            ->allowEmpty('cellphone');

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
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
       if (isset($data['cellphone'])) {
           $data['cellphone'] = preg_replace('/[^0-9]/', '', $data['cellphone']);
       }
    }

    public function getUserWithEmail($email)
    {
        $user = $this->find()
            ->contain([
                'PersonSeller' => [
                    'Addresses' => ['States'],
                    'Sellers' => [
                        'Brands',
                        'ProductCategories',
                    ]
                ],
                'PersonBuyer' => [
                    'Addresses' => ['States'],
                    'Buyers' => ['BranchOfActivities']
                ],
                'PersonCorporate' => [
                    'Addresses' => ['States'],
                    'Corporates' => [
                        'Brands',
                        'ProductCategories',
                        'BranchOfActivities'
                    ]
                ]
            ])
            ->where(['Users.email' => $email])
            ->first();

        return $user;
    }


    //todo: get only selected type
    public function getConnections($userId, $userType)
    {
        $response = [
            "pending" => [],
            "approved" => [],
        ];
        $ids = [];

        $user = $this->find()
            ->contain([
                'ParentUsers' => [
                    'PersonSeller.Sellers' => ['Brands', 'ProductCategories'],
                    'PersonBuyer' => ['Buyers' => ['BranchOfActivities'] ],
                ],
                'ChildUsers' => [
                    'PersonSeller.Sellers' => ['Brands', 'ProductCategories'],
                    'PersonBuyer' => ['Buyers' => ['BranchOfActivities'] ],
                ]
            ])
            ->where(['Users.id' => $userId])
            ->first();

        foreach ($user['child_users'] as $childUser) {
            if ($childUser['_joinData']['status'] == 0 ) continue;
            if ($childUser['id'] == $userId && $childUser['_joinData']['status'] == 2) continue;

            if (in_array($childUser['id'], $ids) ) continue;
            array_push($ids, $childUser['id']);

            if ($childUser['_joinData']['status'] === 1) {
                array_push($response['approved'], $childUser);
            } else {
                array_push($response['pending'], $childUser);
            }
        }

        foreach ($user['parent_users'] as $parentUser) {
            if ($parentUser['_joinData']['status'] === 0 ) continue;
            if ($parentUser['id'] == $userId && $parentUser['_joinData']['status'] == 2) continue;

            if (in_array($parentUser['id'], $ids) ) continue;
            array_push($ids, $parentUser['id']);


            if ($parentUser['_joinData']['status'] === 1) {
                array_push($response['approved'], $parentUser);
            } else {
                array_push($response['pending'], $parentUser);
            }

        }

        return $response;
    }


    public function checkDirExist($name)
    {
        $exists = $this->exists(['file_directory_name' => $name]);
        return $exists;
    }

    public function getNewDirName($length)
    {
        $dirAlreadyExists = true;
        $newDirName = null;

        while ($dirAlreadyExists) {
            $newDirName = $this->getRandomString($length);

            if (!$this->checkDirExist($newDirName)) {
                $dirAlreadyExists = false;
            }
        }

        return $newDirName;
    }

    public function getRandomString($length)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789_-.()";
        $generatedString = substr(str_shuffle($chars), 0, $length);
        return $generatedString;
    }

    public function sendNewPassword($user)
    {
        //return true;
        $email = new Email(['from' => 'gustavo.carvalho@clicksoft.com.br', 'transport' => 'default']);
        $email->template('password_recover', 'render-layout')
            ->viewVars(['user' => $user])
            ->from(['gustavo.carvalho@clicksoft.com.br' => 'Blinknet'])
            ->to($user->email)
            ->subject('Blinknet - Recuperação de Senha')
            ->emailFormat('html');

        if ($email->send()) {
            return true;
        } else {
            return false;
        }
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
