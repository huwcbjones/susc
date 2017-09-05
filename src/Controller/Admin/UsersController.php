<?php

namespace SUSC\Controller\Admin;


use Cake\Controller\Component\AuthComponent;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\ORM\TableRegistry;
use DateTime;
use SUSC\Controller\AppController;
use SUSC\Model\Entity\Acl;
use SUSC\Model\Table\AclsTable;
use SUSC\Model\Table\GroupsTable;
use SUSC\Model\Table\UsersTable;

/**
 * Class UsersController
 * @package SUSC\Controller
 *
 * @property AuthComponent $Auth
 * @property UsersTable $Users
 * @property GroupsTable $Groups
 * @property AclsTable $Acls;
 */
class UsersController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Users = TableRegistry::get('Users');
        $this->Groups = TableRegistry::get('Groups');
        $this->Acls = TableRegistry::get('Acls');
    }


    public function initialize()
    {
        parent::initialize();
        $this->Users = TableRegistry::get('user');
    }

    public function getACL()
    {
        if ($this->request->getParam('action') == 'index') return 'admin.users.*';
        return parent::getACL();
    }


    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Groups']
        ];
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $all_acls = $this->Acls->find()->toArray();
        $all_acls = Acl::splattify($all_acls);
        $this->set('all_acls', $all_acls);

        $user = $this->Users->get($id, [
            'contain' => ['Groups', 'Acls', 'Articles', 'KitCompletedOrders', 'KitOrders']
        ]);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $all_acls = $this->Acls->find()->toArray();
        $all_acls = Acl::splattify($all_acls);
        $this->set('all_acls', $all_acls);

        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {

            $now = new DateTime;
            $timestamp = $now->getTimestamp();
            $reset_code = sha1(
                    $timestamp . $user->email_address
                ) . sha1(
                    $timestamp . $user->full_name
                );

            $user = $this->Users->patchEntity($user, $this->request->getData());
            $user->is_active = true;
            $user->activation_date = $now;
            $user->email_address = $this->request->getData('email_address');
            $user->reset_code = $reset_code;
            $user->reset_code_date = $timestamp;
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                $email = new Email();
                $email
                    ->setTo($user->email_address, $user->full_name)
                    ->setSubject('Set Password')
                    ->setViewVars(['user' => $user, 'reset_code' => $reset_code])
                    ->setTemplate('set_password')
                    ->send();
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $groups = $this->Users->Groups->find('list', ['limit' => 200]);
        $acls = $this->Users->Acls->find('list', ['limit' => 200]);
        $this->set(compact('user', 'groups', 'acls'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $all_acls = $this->Acls->find('all')->toArray();
        $all_acls = Acl::splattify($all_acls);
        $this->set('all_acls', $all_acls);

        $user = $this->Users->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user->setAccess('*', true);
            $user->setAccess('id', false);
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $groups = $this->Users->Groups->find('list', ['limit' => 200]);
        $acls = $this->Users->Acls->find('list', ['limit' => 200]);
        $this->set(compact('user', 'groups', 'acls'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        if($this->currentUser->id == $id){
            $this->Flash->error(__('Failed to delete user. You cannot delete yourself (unfortunately)!'));
            return $this->redirect(['action' => 'index']);
        }
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}