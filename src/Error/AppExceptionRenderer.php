<?php
/**
 * Author: Huw
 * Since: 01/09/2017
 */

namespace SUSC\Error;


use Cake\Error\ExceptionRenderer;
use Cake\Event\Event;
use SUSC\Controller\AppController;

class AppExceptionRenderer extends ExceptionRenderer
{
    protected function _getController()
    {
        return new ErrorController();
    }

}

class ErrorController extends AppController {
    /**
     * beforeRender callback.
     *
     * @param Event $event Event.
     * @return void
     */
    public function beforeRender(Event $event)
    {
        // TODO: Remove in 4.0.0
        $this->request->webroot = '/';
        $this->viewBuilder()->setTemplatePath('Error');
    }
}