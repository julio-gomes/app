<?php
namespace App\Controller\Api;

use App\Controller\Api\AppController;
use Cake\Core\Exception\Exception;

/**
 * States Controller
 *
 * @property \App\Model\Table\StatesTable $States
 *
 * @method \App\Model\Entity\State[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StatesController extends AppController
{
    public $paginate = [
        'page' => 1,
        'limit' => 30,
        'maxLimit' => 100,
        'fields' => [
            'id', 'name', 'initials',
        ],
        'sortWhitelist' => [
            'id', 'name', 'initials',
        ],
    ];

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['add', 'index']);
    }

    public function index()
    {
        $response = [
            'status' => 'ok',
            'data' => [],
            '_serialize' => ['data', 'status'],
        ];

        try {
            $query = $this->States->find();
            $response['data'] = $query;
        } catch (\Exception $e) {
            $response['status'] = 'error';
        }

        $this->set($response);
        $this->setJsonResponse($response);
    }

}
