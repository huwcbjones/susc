<?php

namespace SUSC\Controller\Admin;


use Cake\Controller\Component\AuthComponent;
use Cake\ORM\TableRegistry;
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
class GroupsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Users = TableRegistry::get('Users');
        $this->Groups = TableRegistry::get('Groups');
        $this->Acls = TableRegistry::get('Acls');
    }

    public function getACL()
    {
        if ($this->request->getParam('action') == 'index') return 'admin.groups.*';
        return parent::getACL();
    }


    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        /*$this->paginate = [
            'contain' => ['Groups']
        ];*/
        $groups = $this->paginate($this->Groups);

        $this->set(compact('groups'));
        $this->set('_serialize', ['groups']);
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

        $group = $this->Groups->get($id, [
            'contain' => ['Acls', 'Users']
        ]);

        $this->set('group', $group);
        $this->set('_serialize', ['group']);
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

        $group = $this->Groups->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $group->setAccess('*', true);
            $group->setAccess('id', false);
            $group = $this->Groups->patchEntity($group, $this->request->getData());
            if ($this->Groups->save($group)) {
                $this->Flash->success(__('The group has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The group could not be saved. Please, try again.'));
        }
        $groups = $this->Groups->Groups->find('list', ['limit' => 200]);
        $acls = $this->Groups->Acls->find('list', ['limit' => 200]);
        $this->set(compact('group', 'groups', 'acls'));
        $this->set('_serialize', ['group']);
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