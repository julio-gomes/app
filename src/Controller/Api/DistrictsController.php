<?php
namespace App\Controller\Api;

use App\Controller\Api\AppController;

/**
 * Districts Controller
 *
 * @property \App\Model\Table\CitiesTable $Districts
 *
 * @method \App\Model\Entity\City[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DistrictsController extends AppController
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
        $cityId = @$params['cityId'] ?: null;
        $stateId = @$params['stateId'] ?: null;
        $conditions = [];

        $query = $this->Districts->find()->order(['Districts.name' => 'ASC']);

        if ($cityId) {
            array_push($conditions, ['Districts.city_id' => $cityId]);
        }

        if ($stateId) {
            array_push($conditions, ['Districts.state_id' => $stateId]);
        }

        $response['data'] = $query->where($conditions);

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

        $params = $this->request->getQueryParams();
        $districtId = @$params['districtId'] ?: null;
        $cityId = @$params['cityId'] ?: null;
        $stateId = @$params['stateId'] ?: null;
        $name = @$params['name'] ?: null;


        $query = $this->Districts->find();


        if ($districtId) {
            $conditions['Districts.state_id'] = $districtId;
        }

        if ($cityId) {
            $conditions['Districts.city_id'] = $cityId;
        }

        if ($name) {
            $conditions['Districts.name LIKE'] = '%'.$name.'%';
        }

        $response['data'] = $query->where($conditions)->first();

        $this->set($response);
        $this->setJsonResponse($response);
    }
}
