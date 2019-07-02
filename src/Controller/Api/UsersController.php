<?php
namespace App\Controller\Api;

use App\Controller\Api\AppController;
use Cake\Core\Exception\Exception;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Utility\Security;
use Firebase\JWT\JWT;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @property \App\Model\Table\AddressesTable $Addresses
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    public $paginate = [
        'page' => 1,
        'limit' => 10,
        'maxLimit' => 100,
        'fields' => [
            //'id', 'email'
        ],
        'sortWhitelist' => [
            //'id', 'email',
        ],
    ];

    public function initialize()
    {
        parent::initialize();
        //$this->Auth->allow();
        $this->Crud->addListener('relatedModels', 'Crud.RelatedModels');
        $this->Auth->allow(['add', 'token', 'index', 'updateConnectionStatus', 'getConnections', 'registerSeller', 'register', 'view', 'edit', 'addConnectionRequest', 'getBranchOfActivities', 'recuperatePassword', 'uploadAvatar', 'getUser', 'updatePassword', 'redirectToAppStore']);
    }

    public function beforeFilter(\Cake\Event\Event $event)
    {
        if ($this->request->params['action'] == 'index') {
            // Fetch related data from all table relations
            $this->Crud->listener('relatedModels')->relatedModels(true);
        }
    }

    public function redirectToAppStore()
    {
        $this->autoRender = false;
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $androidDevice = stripos($userAgent, "Android");

        if ($androidDevice) {
            return $this->redirect('https://play.google.com/store/apps/details?id=br.com.clicksoft.blinknet');

        } else {
            return $this->redirect('https://play.google.com/store/apps/details?id=br.com.clicksoft.blinknet');
        }
    }

    /**
     *   @param integer $userId - Mandatory
     *   @param string $userType - the type of users your want to get
     *   @param string $filterValue
     *   @param string $branchOfActivity
     *   @param string $locationFilter
     **/
    public function index()
    {
        $response = [
            'status' => 'ok',
            'request' => null,
            'data' => [],
            'error' => [],
            '_serialize' => ['success', 'data', 'request', 'error', 'status'],
        ];

        $response['request'] = $this->request->getQueryParams();
        $params = $this->request->getQueryParams();
        $userId = @$params['userId'] ?: null;
        $userType = @$params['userType'] ?: 'seller';
        $locationFilter = @$params['locationFilter'] ?: null;
        $filterValue = @$params['filterValue'] ?: null;
        $page = @$params['page'];

        $lengthPage = 10;

        $query = $this->Users->find()->distinct('Users.id');

        if ($params['userType'] == 'seller') {
            

            $query
                ->contain([
                    'ParentUsers',
                    'ChildUsers',
                    'PersonSeller.Sellers.Brands',
                ])
                // ->contain([
                //     'ParentUsers' => function ($q) use ($userId) {
                //         return $q->where(['ParentUsers.id' => $userId])
                //             ->limit(1);
                //     },
                //     'ChildUsers' => function ($q) use ($userId) {
                //         return $q->where(['ChildUsers.id' => $userId])
                //             ->limit(1);
                //     },
                //     'PersonSeller.Sellers.Brands',
                // ])
                ->innerJoinWith('PersonSeller', function ($q1) {
                    $q1->leftJoinWith('Addresses');

                    $q1->leftJoinWith('Addresses', function ($q2) {
                        $q2->leftJoinWith('States');
                        $q2->leftJoinWith('Districts');
                        $q2->leftJoinWith('Cities');
                        return $q2;
                    });

                    $q1->innerJoinWith('Sellers', function ($q2) {
                        $q2->leftJoinWith('Brands');
                        $q2->leftJoinWith('ProductCategories');
                        return $q2;
                    });
                    return $q1;
                });

            if ($filterValue) {
                $query->where([
                    'OR' => [
                        ['Brands.name LIKE' => "%" . $filterValue . "%"],
                        ['ProductCategories.name LIKE' => "%" . $filterValue . "%"],
                    ],
                ]);
            }

        } else if ($params['userType'] == 'buyer') {
            $branchOfActivity = @$params['branchOfActivity'] ?: null;

            $query
                ->contain([
                    'ParentUsers',
                    'ChildUsers',
                    'PersonBuyer.Buyers.BranchOfActivities',
                ])
                // ->contain([
                //     'ParentUsers' => function ($q) use ($userId) {
                //         return $q->where(['ParentUsers.id' => $userId])
                //             ->limit(1);
                //     },
                //     'ChildUsers' => function ($q) use ($userId) {
                //         return $q->where(['ChildUsers.id' => $userId])
                //             ->limit(1);
                //     },
                //     'PersonBuyer.Buyers.BranchOfActivities',
                // ])
                ->innerJoinWith('PersonBuyer', function ($q1) use ($locationFilter) {
                    $q1->leftJoinWith('Addresses');

                    if ($locationFilter) {
                        $q1->innerJoinWith('Addresses', function ($q2) {
                            $q2->leftJoinWith('States');
                            $q2->leftJoinWith('Districts');
                            $q2->leftJoinWith('Cities');
                            return $q2;
                        });
                    }

                    $q1->innerJoinWith('Buyers', function ($q2) {
                        $q2->leftJoinWith('BranchOfActivities');
                        return $q2;
                    });
                    return $q1;
                });

            if ($branchOfActivity) {
                $query->where(['BranchOfActivities.name LIKE' => "%" . $branchOfActivity . "%"]);
            }

            if ($locationFilter) {
                $query->where(['Users.id !=' => $userId])
                    ->andWhere([
                        'OR' => [
                            ['States.name LIKE' => '%' . $locationFilter . '%'],
                            ['Districts.name LIKE' => '%' . $locationFilter . '%'],
                            ['Cities.name LIKE' => '%' . $locationFilter . '%'],
                        ],
                    ]);
            }
        }

        // $query->leftJoinWith('ParentUsers', function ($q) use ($userId) {
        //         return $q;
        //         // ->where(['ParentUsers.id' => $userId])
        //         //     ->limit(1)
        //         //     ->enableAutoFields(true);
        //     })
        //     ->leftJoinWith('ChildUsers', function ($q) use ($userId) {
        //         return $q;
        //         // ->where(['ParentUsers.id' => $userId])
        //         //     ->limit(1)
        //         //     ->enableAutoFields(true);
        //     })
        //     ->enableAutoFields(true);

        // $query
        //        ->orWhere(['UsersHasUsers.user_id' => $userId])
        //        ->orWhere(['UsersHasUsers.friend_id' => $userId]);

        //$query->contain($containTables);
        // $query->leftJoinWith('ParentUsers', function ($q) use ($userId) {
        //         return $q->where(['Users.id' => $userId])
        //             ->limit(1);
        //     })
        //     ->leftJoinWith('ChildUsers', function ($q) use ($userId) {
        //         return $q->where(['Users.id' => $userId])
        //             ->limit(1);
        //     })
        //     ->enableAutoFields(true);

        //$response['query'] = debug($query);
        //$response['query'] = $query->sql();

        $query1 = $this->Users->find()->distinct('Users.id');

        $query1
            ->contain([
                'ParentUsers',
                'ChildUsers',
                'PersonCorporate.Corporates.Brands',
            ])
            ->innerJoinWith('PersonCorporate', function ($q1) {
                $q1->leftJoinWith('Addresses');

                $q1->leftJoinWith('Addresses', function ($q2) {
                    $q2->leftJoinWith('States');
                    $q2->leftJoinWith('Districts');
                    $q2->leftJoinWith('Cities');
                    return $q2;
                });

                $q1->innerJoinWith('Corporates', function ($q2) {
                    $q2->leftJoinWith('Brands');
                    $q2->leftJoinWith('ProductCategories');
                    return $q2;
                });
                return $q1;
            });

        if ($filterValue) {
            $query1->where([
                'OR' => [
                    ['Brands.name LIKE' => "%" . $filterValue . "%"],
                    ['ProductCategories.name LIKE' => "%" . $filterValue . "%"],
                ],
            ]);
        }

        try {
            $resultQuery1 = $query1->toList();
            $resultQuery = $query->toList();
            $resultData = [];
            $indexItem = 0;
            $begin = ($page - 1) * $lengthPage;
            $end  = (($page - 1) * $lengthPage) + $lengthPage;

             $resultQueryEnd = array_merge($resultQuery1, $resultQuery);

            //$resultQueryEnd;

            foreach($resultQueryEnd as $key => $user) {
                if ($begin <= $indexItem && $indexItem < $end) {
                    array_push($resultData, $user);
                }
                $response[$key] = $indexItem;
                $indexItem = $indexItem + 1;
            }

            //$response['data'] = array_merge($resultQuery1, $resultQuery);
            $response['data'] = $resultData;
        } catch (\Exception $e) {
            //debug($e);
            //exit;
            $response['error'] = $e;
            $response['status'] = 'error';
        }

        $this->set($response);
        $this->setJsonResponse($response);
    }

    public function getBranchOfActivities()
    {
        $response = [
            'status' => 'ok',
            'data' => [],
            '_serialize' => ['success', 'data', 'status'],
        ];

        $this->paginate = ['limit' => 40];

        try {
            //$query = $this->Users->PersonBuyer->Buyers->BranchOfActivities->find()->limit([5]);
            //$response['data'] = $this->paginate($query);
        } catch (\Exception $e) {
            $response['status'] = 'error';
        }

        $this->set($response);
        $this->setJsonResponse($response);
    }

    public function view($id)
    {
        $this->Crud->on('beforeFind', function (\Cake\Event\Event $event) {
            $event->subject->query->contain([
                // 'Persons.Sellers' => ['Brands', 'ProductCategories'],
                // 'Persons.Buyers.BranchOfActivities',
                // 'Persons.Addresses',
                'PersonSeller.Sellers' => ['Brands', 'ProductCategories', 'Addresses' => ['States']],
                'PersonBuyer' => ['Addresses', 'Buyers' => ['BranchOfActivities']],
            ]);
        });

        return $this->Crud->execute();
    }

    public function getUser($id)
    {
        $response = ['status' => 'error', 'data' => null];
        $user = $this->Users->find()
            ->where(['Users.id' => $id])
            ->contain([
                'PersonSeller' => [
                    'Addresses' => ['States', 'Districts', 'Cities'],
                    'Sellers' => [
                        'Brands',
                        'ProductCategories',
                    ],
                ],
                'PersonBuyer' => [
                    'Addresses' => ['States', 'Districts', 'Cities'],
                    'Buyers' => ['BranchOfActivities'],
                ],
                'PersonCorporate' => [
                    'Addresses' => ['States', 'Districts', 'Cities'],
                    'Corporates' => [
                        'Brands',
                        'ProductCategories',
                        'BranchOfActivities'
                    ],
                ],
            ])
            ->first();

        if (!empty($user)) {
            $response['data'] = $user;
            $response['status'] = 'ok';
        }

        $this->set($response);
        $this->setJsonResponse($response);
    }

    // public function edit($id)
    // {
    //     return $this->Crud->listener('relatedModels')->relatedModels(true);

    // }

    public function add()
    {
        $this->Crud->on('afterSave', function (Event $event) {
            if ($event->subject->created) {
                $this->set('data', [
                    'id' => $event->subject->entity->id,
                    'token' => JWT::encode(
                        [
                            'sub' => $event->subject->entity->id,
                            'exp' => time() + 604800,
                        ],
                        Security::salt()),
                ]);
                $this->Crud->action()->config('serialize.data', 'data');
            }
        });
        return $this->Crud->execute();
    }

    public function token()
    {
        $response = [
            'status' => 'ok',
            'data' => [],
            '_serialize' => ['success', 'data', 'status'],
        ];

        $user = $this->Auth->identify();

        if ($user) {
            $user = $this->Users
                ->find()
                ->where(['Users.id' => $user['id']])
                ->contain([
                    'PersonSeller.Addresses.States',
                    'PersonSeller.Sellers' => ['Brands', 'ProductCategories'],
                    'PersonBuyer' => ['Addresses.States', 'Buyers' => ['BranchOfActivities']],
                    'PersonCorporate.Addresses.States',
                    'PersonCorporate.Corporates' => ['Brands', 'ProductCategories', 'BranchOfActivities'],
                ])
                ->first();

            $response['data'] = $user;
            $response['data']['token'] = JWT::encode([
                'sub' => $user['id'],
                'exp' => time() + 604800,
            ],
                Security::salt());

        } else {
            $response['status'] = 'error';
            $response['data'] = $user;
            //throw new UnauthorizedException('Invalid username or password');
        }

        $this->setJsonResponse($response);
    }

    public function updateConnectionStatus()
    {
        $response = [
            'status' => 'ok',
            'data' => [],
            'requestData' => [],
            '_serialize' => ['success', 'data', 'status'],
        ];

        if (!$this->request->is('post')) {
            $response['status'] = 'error';
            $this->set($response);
            $this->setJsonResponse($response);
            return;
        }

        try {
            $userId = $this->request->getData('userId');
            $friendId = $this->request->getData('friendId');
            $status = $this->request->getData('status');

            $connectionTable = TableRegistry::get('UsersHasUsers');

            $connection = $connectionTable->find('connection', [
                'user_id' => $userId,
                'friend_id' => $friendId,
            ]);

            if ($status === 0) {
                if ($connectionTable->delete($connection)) {
                    $response['data'] = $connection;
                } else {
                    //throw new \Exception($user->errors());
                    $response['status'] = 'error';
                }
            } else {
                $connection->status = $status;
                if ($connectionTable->save($connection)) {
                    $response['data'] = $connection;
                } else {
                    //throw new \Exception($user->errors());
                    $response['status'] = 'error';
                }
            }

        } catch (\Exception $e) {
            $response['status'] = 'error';
        }

        $this->set($response);
        $this->setJsonResponse($response);
    }

    public function getConnections()
    {
        $response = [
            'success' => true,
            'data' => [],
            '_serialize' => ['success', 'data'],
        ];

        $userId = $this->request->getData('userId');
        $userType = @$this->request->getData('userType') ?: 'seller';

        $response['data'] = $this->Users->getConnections($userId, $userType);

        $this->set($response);
        $this->setJsonResponse($response);
    }

    public function register()
    {
        $response = [
            'data' => null,
            'status' => 'ok',
            '_serialize' => ['data', 'status']
        ];
        // hasMany => [Table ]
        // hasOne.Table
        //DONT CHANGE, FOR SOME FUCKED UP REASON ONLY DOT NOTATION WORKS HERE
        $associations = [
            'PersonSeller.Sellers.Brands',
            'PersonSeller.Sellers.ProductCategories',
            'PersonSeller.Addresses',
            'PersonBuyer.Addresses',
            'PersonBuyer.Buyers.BranchOfActivities',
            'PersonCorporate.Addresses',
            'PersonCorporate.Corporates.Brands',
            'PersonCorporate.Corporates.ProductCategories',
            'PersonCorporate.Corporates.BranchOfActivities',
        ];

        $this->loadModel('Addresses');
        $user = $this->Users->getUserWithEmail($this->request->getData('email'));

        $lengthUser = 0;
        $userOld = [];
        $lengthUserNew = 0;
        $userNew = [];
        $typeUser = '';

        if (empty($user)) {
            $user = $this->Users->newEntity();
        }

        if (!empty($user->person_corporate) && !empty($user->person_corporate->addresses)) {
            $lengthUser = count($user->person_corporate->addresses);
            $typeUser = "corporate";
        }

        if (!empty($user->person_seller) && !empty($user->person_seller->addresses)) {
            $lengthUser = count($user->person_seller->addresses);
            $typeUser = "seller";
        }

        for ($idxUser = 0; $idxUser < $lengthUser; $idxUser++) {            
            
            $addressItem = [];

            if ($typeUser == "corporate") {
                if (!empty($user->person_corporate) && !empty($user->person_corporate->addresses)) {
                    $addressItem = $user->person_corporate->addresses[$idxUser];
                }
            } else {
                if (!empty($user->person_seller) && !empty($user->person_seller->addresses)) {
                    $addressItem = $user->person_seller->addresses[$idxUser];
                }
            }

            if (!empty($addressItem)) {
                array_push($userOld, $addressItem->id);
            }
        } 

        $user = $this->Users->patchEntity($user, $this->request->getData(), [
            'associated' => $associations,
        ]);

        if ($typeUser == "corporate") {
            if (!empty($user->person_corporate) && !empty($user->person_corporate->addresses)) {
                $lengthUserNew = count($user->person_corporate->addresses);
            }
        } else {
            if (!empty($user->person_seller) && !empty($user->person_seller->addresses)) {
                $lengthUserNew = count($user->person_seller->addresses);
            }
        }

        for ($idxUser1 = 0; $idxUser1 < $lengthUserNew; $idxUser1++) {            
            
            if ($typeUser == "corporate") {
                if (!empty($user->person_corporate) && !empty($user->person_corporate->addresses)) {
                    $addressItem = $user->person_corporate->addresses[$idxUser1];
                }
            } else {
                if (!empty($user->person_seller) && !empty($user->person_seller->addresses)) {
                    $addressItem = $user->person_seller->addresses[$idxUser1];
                }
            }

            if (!empty($addressItem)) {
                array_push($userNew, $addressItem->id);
            }
        } 

        if ($lengthUser > 0) {

            $addressToDelete = [];

            for ($idxDelete=0; $idxDelete < count($userOld); $idxDelete++) { 
                if (!in_array($userOld[$idxDelete], $userNew)) {
                    array_push($addressToDelete, $userOld[$idxDelete]);
                }
            }

            for ($idxDeleteFinal=0; $idxDeleteFinal < count($addressToDelete); $idxDeleteFinal++) { 
                $entityDelete = $this->Addresses->get($addressToDelete[$idxDeleteFinal]);
                $result = $this->Addresses->delete($entityDelete);
            }
        }

        try {
            if ($this->Users->save($user)) {
                $response['data'] = $user;
            } else {
                throw new \Exception('Save user error');
            }
        } catch (\Exception $e) {
            // $response['data'] = $e;
            // debug($e);
            // exit;
            $response['data'] = $user->errors();
            $response['status'] = 'error';
        }

        $this->set($response);
        $this->setJsonResponse($response);
    }

    public function addConnectionRequest()
    {
        $response = [
            'status' => 'ok',
            'data' => null,
            'requestData' => [],
            '_serialize' => ['data', 'requestData', 'status'],
        ];

        $friendId = $this->request->getData('friendId');
        $userId = $this->request->getData('userId');

        $connectionTable = TableRegistry::get('UsersHasUsers');

        $connection = $connectionTable->find('connection', [
            'user_id' => $userId,
            'friend_id' => $friendId,
        ]);

        if (!$connection) {
            $connection = $connectionTable->newEntity();
            $connection->user_id = $userId;
            $connection->friend_id = $friendId;
        }

        $connection->status = 2;

        if ($connectionTable->save($connection)) {
            $response['data'] = $connection;
        } else {
            //throw new \Exception($connection->errors());
            $response['status'] = 'error';
        }

        $this->set($response);
        $this->setJsonResponse($response);
    }

    public function recuperatePassword()
    {
        $response = [
            'data' => ['success' => false],
            '_serialize' => ['data'],
        ];

        $email = $this->request->getData('email');

        $newPassword = $this->Users->getRandomString(6);
        $user = $this->Users->getUserWithEmail($email);

        if ($user) {
            $userToMail = [
                'email' => $user->email,
                'unencrypted_password' => $newPassword,
                'name' => $user->name,
            ];
            $user->password = $newPassword;
            $user->unencrypted_password = $newPassword;

            if ($this->Users->sendNewPassword($user)) {
                $this->Users->save($user);
                $response['data']['success'] = true;
            }
        }

        $this->set($response);
        $this->setJsonResponse($response);
    }

    public function uploadAvatar()
    {
        $response = [
            'requestData' => null,
            'data' => ['success' => false],
            '_serialize' => ['data', 'requestData'],
        ];

        $response['requestData'] = $this->request->getData();

        $this->set($response);
        $this->setJsonResponse($response);
    }

    public function updatePassword()
    {
        $response = [
            'status' => 'error',
            '_serialize' => ['status'],
        ];

        $requestData = $this->request->getData();
        $userId = @$requestData['userId'] ?: null;
        $newPassword = @$requestData['password'] ?: null;

        try {
            $user = $this->Users->get($userId);
            $user->password = $newPassword;
            $response['status'] = $this->Users->save($user) ? 'ok' : 'error';

        } catch (\Exception $e) {

        }

        $this->set($response);
        $this->setJsonResponse($response);
    }
}
