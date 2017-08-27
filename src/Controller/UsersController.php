<?php
namespace SUSC\Controller;


use Cake\Controller\Component\AuthComponent;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use SUSC\Model\Entity\User;
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
        /** @var User $user */
        $user = $this->Users->find('id', ['id' => $this->Auth->user('id')])->first();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, [
                'old_password' => $this->request->getData('old_password'),
                'password' => $this->request->getData('new_password'),
                'new_password' => $this->request->getData('new_password'),
                'conf_password' => $this->request->getData('conf_password')],
                ['validate' => 'changePassword']
            );
            if ($this->Users->save($user)) {
                // TODO: Email user to say password has been changed
                $this->Flash->success(__('Your password has been changed!'));
            } else {
                $this->Flash->error(__('Your password could not be changed. Please, try again.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    public function email()
    {
        /** @var User $user */
        $user = $this->Users->find('id', ['id' => $this->Auth->user('id')])->first();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, [
                'password' => $this->request->getData('password'),
                'email_address' => $this->request->getData('new_email_address'),
                'new_email_address' => $this->request->getData('new_email_address'),
                'conf_email_address' => $this->request->getData('conf_email_address')],
                ['validate' => 'changeEmail']
            );
            if ($this->Users->save($user)) {
                // TODO: Email to confirm new email address
                $this->Flash->success(__('An email has been sent to "' . $this->request->getData('new_email_address') . '", please click on the link to verify your email address.'));
            } else {
                $this->Flash->error(__('Your email address could not be changed. Please, try again.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }
}