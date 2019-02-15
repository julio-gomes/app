<?php
namespace App\Controller\Api;

use App\Controller\Api\AppController;

/**
 * Cities Controller
 *
 * @property \App\Model\Table\CitiesTable $Cities
 *
 * @method \App\Model\Entity\City[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CitiesController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['add', 'index', 'view']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $response = [
            'status' => 'ok',
            'data' => [],
            '_serialize' => ['data', 'status'],
        ];

        $params = $this->request->getQueryParams();
        $stateId = @$params['stateId'] ?: null;
        $conditions = [];

        if ($stateId) {
            array_push($conditions, ['Cities.state_id' => $stateId]);
        }

        $query = $this->Cities->find()->where($conditions);

        $response['data'] = $query;

        $this->set($response);
        $this->setJsonResponse($response);
    }


     /**
     * View method
     *
     * @return \Cake\Http\Response|void
     */
    public function view()
    {
        $response = [
            'status' => 'ok',
            'data' => null,
            '_serialize' => ['data', 'status'],
        ];

        $conditions = [];
        $params = $this->request->getQueryParams();
        $cityId = @$params['cityId'] ?: null;
        $name = @$params['name'] ?: null;

        $query = $this->Cities->find()
            ->contain(['Districts']);

        if ($cityId) {
            $conditions['Cities.id'] = $cityId;
        }

        if ($name) {
            $conditions['Cities.name LIKE'] = '%'.$name.'%';
        }

        $city = $query->where($conditions)->first();
        $response['data'] = $city;

        $this->set($response);
        $this->setJsonResponse($response);

    }


}
