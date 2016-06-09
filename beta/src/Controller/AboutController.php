<?php
/**
 * Author: Huw
 * Since: 07/06/2016
 */

namespace SUSC\Controller;


use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

class AboutController extends AppController
{
    public function display()
    {
        $path = func_get_args();

        $count = count($path);

        $page = null;

        if(!$count){
            return $this->redirect('/about/club');
        }

        $this->set($page);

        try {
            $this->render(implode('/', $path));
        } catch (MissingTemplateException $e){
            if(Configure::read('debug')){
                throw $e;
            }

            throw new NotFoundException();
        }
    }
}