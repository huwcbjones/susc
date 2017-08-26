<?php
/**
 * Created by PhpStorm.
 * User: huw
 * Date: 26/08/2017
 * Time: 11:08
 */

namespace SUSC\Controller;


use Cake\ORM\TableRegistry;

class UsersController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Users = TableRegistry::get('user');
    }

    public function login()
    {

    }
}