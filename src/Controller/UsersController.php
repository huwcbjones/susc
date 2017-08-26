<?php
/**
 * Created by PhpStorm.
 * User: huw
 * Date: 26/08/2017
 * Time: 11:08
 */

namespace SUSC\Controller;


use Cake\Controller\Component\AuthComponent;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use SUSC\Model\Table\UsersTable;

/**
 * Class UsersController
 * @package SUSC\Controller
 *
 * @property AuthComponent $Auth
 * @property UsersTable $Users
 */
class UsersController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['register', 'logout']);
        $this->Users = TableRegistry::get('Users');
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
        $user = $this->Users->find('id', ['id' => $this->Auth->user('id')])->first();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Your profile has been updated!'));
            } else {
                $this->Flash->error(__('Your profile could not be updated. Please, try again.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    public function password()
    {
        $this->set('user', $this->Users->find('id', ['id' => $this->Auth->user('id')])->first());
    }

    public function email()
    {
        $this->set('user', $this->Users->find('id', ['id' => $this->Auth->user('id')])->first());
    }
}