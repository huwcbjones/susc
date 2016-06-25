<?php
/**
 * Author: Huw
 * Since: 24/06/2016
 */

namespace SUSC\Controller;


use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

class TrainingController extends Controller
{
    function display()
    {
        $path = func_get_args();

        $page = null;

        $this->set($page);

        try {
            $this->render(implode('/', $path));
        } catch (MissingTemplateException $e) {
            if (Configure::read('debug')) {
                throw $e;
            }

            throw new NotFoundException();
        }
    }
}