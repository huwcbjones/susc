<?php
/**
 * Author: Huw
 * Since: 07/06/2016
 */

namespace SUSC\Controller;


use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\View\Exception\MissingTemplateException;

class AboutController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Committee = TableRegistry::get('committee');
        //$this->Coaches = TableRegistry::get('coaches');
    }

    public function club()
    {

    }

    public function committee(){
        $this->set('committee', $this->Committee->find('published'));
    }

    public function coaches(){
        $this->set('committee', $this->Coaches->find('published'));
    }
}