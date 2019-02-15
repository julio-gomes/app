<?php
namespace App\Controller\Api;

use App\Controller\Api\AppController;

/**
 * Addresses Controller
 *
 * @property \App\Model\Table\AddressesTable $Addresses
 *
 * @method \App\Model\Entity\Address[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AddressesController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['add', 'index']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['States', 'Persons', 'Cities', 'Districts']
        ];
        $addresses = $this->paginate($this->Addresses);

        $this->set(compact('addresses'));
    }


}
