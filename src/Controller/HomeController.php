<?php
    namespace App\Controller;

    use App\Controller\AppController;
    use Cake\ORM\TableRegistry;
    use Cake\Log\Log;
    use Cake\Core\Exception\Exception;

    class HomeController extends AppController
    {
      public function initialize()
      {
          parent::initialize();

          $this->loadComponent('Search.Prg', [
              // This is default config. You can modify "actions" as needed to make
              // the PRG component work only for specified methods.
              'actions' => ['index', 'lookup']
          ]);
      }

      public function index()
      {
        $this->Users = TableRegistry::get('Users');

        $searchValues = $this->request->getQueryParams();
        try {
          $query = $this->Users
                  ->find('search', ['search' => $searchValues])
                  ->contain(['PersonSeller', 'PersonBuyer'])
                  ->order(['Users.name'=>'asc']);

        } catch (\Exception $e) {
          echo $e;
        }

        $users = $this->paginate($query);

        $this->set(compact(['users']));
        $this->set('_serialize', ['users']);
      }

      public function buyersUsersReport()
      {
        $this->Users = TableRegistry::get('Users');

        $query = $this->Users->find()
                  ->contain(['PersonBuyer.Addresses', 'PersonBuyer.Addresses.Districts', 'PersonBuyer.Addresses.Cities', 'PersonBuyer.Addresses.States', 'PersonBuyer.Buyers.BranchOfActivities'])
                  ->where([ 'PersonBuyer.type' => 'buyer' ])
                  ->order([ 'Users.name' => 'asc' ]);

        $users = $this->paginate($query);

        $this->set(compact(['users']));
        $this->set('_serialize', ['users']);
      }

      public function sellersUsersReport()
      {
        $this->Users = TableRegistry::get('Users');

        $query = $this->Users->find()
                  ->contain(['PersonSeller.Addresses', 'PersonSeller.Addresses.Districts', 'PersonSeller.Addresses.Cities', 'PersonSeller.Addresses.States', 'PersonSeller.Sellers.ProductCategories', 'PersonSeller.Sellers.Brands'])
                  ->where([ 'PersonSeller.type' => 'seller' ])
                  ->order([ 'Users.name' => 'asc' ]);

        $users = $this->paginate($query);

        $this->set(compact(['users']));
        $this->set('_serialize', ['users']);
      }
    }
