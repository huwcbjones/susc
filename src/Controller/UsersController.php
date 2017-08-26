<?php
/**
 * Created by PhpStorm.
 * User: huw
 * Date: 26/08/2017
 * Time: 11:08
 */

namespace SUSC\Controller;


use Cake\Event\Event;
use Cake\ORM\TableRegistry;

class UsersController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['register', 'logout']);
    }


    public function initialize()
    {
        parent::initialize();
        $this->Users = TableRegistry::get('user');
    }

    public function login()
    {
        if (!$this->request->is('post')) {
            return;
        }

        $user = $this->Auth->identify();
        if ($user) {
            $this->Auth->setUser($user);
            return $this->redirect($this->Auth->redirectUrl());
        }

        $this->Flash->error('Invalid username and/or password.');
        $this->request->withData('password', '');

    }

    public function logout()
    {
        $this->Flash->success(__('You have successfully logged out'));
        $this->redirect($this->Auth->logout());
    }

    public function profile()
    {

    }
}