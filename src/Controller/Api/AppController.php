<?php
namespace App\Controller\Api;

use Cake\Controller\Controller;
use Cake\Event\Event;

class AppController extends Controller
{

    use \Crud\Controller\ControllerTrait;

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');

        $this->loadComponent('Crud.Crud', [
            'actions' => [
                'Crud.Index',
                'Crud.View',
                'Crud.Add',
                'Crud.Edit',
                'Crud.Delete',
            ],
            'listeners' => [
                'Crud.Api',
                //'CrudJsonApi.JsonApi',
                'Crud.ApiPagination',
                'Crud.ApiQueryLog',
            ],
        ]);

        $this->loadComponent('Auth', [
            'storage' => 'Memory',
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password',
                    ],
                ],
                'ADmad/JwtAuth.Jwt' => [
                    'parameter' => 'token',
                    'userModel' => 'Users',
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password',
                    ],
                    'queryDatasource' => true,
                ],
            ],
            'unauthorizedRedirect' => false,
            'checkAuthIn' => 'Controller.initialize',
            'loginAction' => false
        ]);
    }

    public function beforeFilter(Event $event)
    {
        //$this->setupCors();
        //$this->Auth->allow(['add', 'token', 'index']);
    }

    protected function setJsonResponse($responseData)
    {
        $this->loadComponent('RequestHandler');
        $this->RequestHandler->renderAs($this, 'json');
        $this->response->type('application/json');
        $this->set('_serialize', true);
        $this->set($responseData);
    }

    protected function setupCors()
    {
        $this->response->cors($this->request)
            ->allowOrigin(['*.cakephp.org'])
            ->allowMethods(['GET', 'POST', 'OPTIONS', 'PUT', 'PATCH', 'DELETE'])
            ->allowHeaders(['X-CSRF-Token'])
            ->allowCredentials()
            ->exposeHeaders(['Link'])
            ->maxAge(300)
            ->build();
    }

    protected function _outputMessage($template)
    {
        $this->controller->set('data', [
            'error' => $this->controller->viewVars['message'],
            'code' => $this->controller->viewVars['code']
        ]);
        $this->controller->set('_serialize', ['data']);

        return parent::_outputMessage($template);
    }
}
