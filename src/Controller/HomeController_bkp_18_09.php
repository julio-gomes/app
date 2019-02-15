<?php
    namespace App\Controller;

    use App\Controller\AppController;
    use Cake\ORM\TableRegistry;

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

        $query = $this->Users
                ->find('search', ['search' => $searchValues])
                ->contain(['PersonSeller','PersonBuyer'])
                ->order(['Users.name'=>'asc']);

        $users = $this->paginate($query);

        $this->set(compact(['users']));
        $this->set('_serialize', ['users']);
      }

      public function allUsersReport()
      {
        $this->Users = TableRegistry::get('Users');

        $query = $this->Users->find()
                  ->contain(['PersonSeller','PersonBuyer'])
                  ->order(['Users.name'=>'asc']);

        $users = $this->paginate($query);

        $this->set(compact(['users']));
        $this->set('_serialize', ['users']);
      }
    }
