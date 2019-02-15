<?php

namespace App\Error;

use Cake\Error\ExceptionRenderer;

class AppExceptionRenderer extends ExceptionRenderer
{
    protected function _outputMessage($template)
    {
        $this->controller->set(['success', false]);
        $this->controller->set('error', [
            'message' => $this->controller->viewVars['message'],
            'errors' => $this->controller->viewVars,
            'code' => $this->controller->viewVars['code']
        ]);
        $this->controller->set('_serialize', ['error', 'success']);


        return parent::_outputMessage($template);
    }
}
