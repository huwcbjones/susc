<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 */

/**
 * @author huw
 * @since 15/01/2018 16:05
 */

namespace SUSC\Controller\Admin;


use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use SUSC\Controller\AppController;
use SUSC\Model\Table\RegistrationCodesTable;

/**
 * Class RegistrationController
 * @package SUSC\Controller\Admin
 *
 * @property RegistrationCodesTable $Codes
 */
class RegistrationController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
    }

    public function initialize()
    {
        parent::initialize();
        $this->Codes = TableRegistry::get('RegistrationCodes');
    }

    public function getACL()
    {
        if ($this->request->getParam('action') == 'index') return 'admin.users.*';
        return parent::getACL();
    }

    public function index()
    {
        $codes = $this->paginate($this->Codes, [
            'sortWhitelist' => [
                'id',
                'valid_from',
                'valid_to',
                'Groups.name',
                'enabled'
            ]
        ]);

        $this->set(compact('codes'));
        $this->set('_serialize', ['codes']);
    }

    public function add()
    {
        $code = $this->Codes->newEntity($this->request->getData());
        $groups = $this->Codes->Groups->find('list', ['limit' => 200]);
        if ($this->request->is(['patch', 'post', 'put'])) {

            $code->id = $this->request->getData('id');
            if(trim($code->id) === ''){
                $code->setError('id', ['ID must not be empty']);
            }

            $code->valid_from = $this->request->getData('valid_from');
            if ($code->valid_from === '') $code->valid_from = null;

            $code->valid_to = $this->request->getData('valid_to');
            if ($code->valid_to === '') $code->valid_to = null;


            if ($code->valid_from !== null && $code->valid_to !== null) {
                if ($code->valid_from >= $code->valid_to) {
                    $code->setError('valid_to', ['Valid To date must be after Valid From']);
                }
            }

            if ($this->Codes->save($code)) {
                $this->Flash->success(__('The registration code has been added.'));
                return $this->redirect(['action' => 'view', $code->id]);
            }
            $this->Flash->error(__('The registration code could not be added. Please, try again.'));
        }
        $this->set(compact('groups', 'code'));
        $this->set('_serialize', ['code']);
    }

    public function view($id = null)
    {
        $code = $this->Codes->get($id, [
            'contain' => ['Groups']
        ]);

        $this->set('code', $code);
        $this->set('_serialize', ['code']);
    }

    public function edit($id = null)
    {
        $code = $this->Codes->get($id, [
            'contain' => ['Groups']
        ]);
        $groups = $this->Codes->Groups->find('list', ['limit' => 200]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $code = $this->Codes->patchEntity($code, $this->request->getData());

            $code->valid_from = $this->request->getData('valid_from');
            if ($code->valid_from === '') $code->valid_from = null;

            $code->valid_to = $this->request->getData('valid_to');
            if ($code->valid_to === '') $code->valid_to = null;


            if ($code->valid_from !== null && $code->valid_to !== null) {
                if ($code->valid_from >= $code->valid_to) {
                    $code->setError('valid_to', ['Valid To date must be after Valid From']);
                }
            }

            if ($this->Codes->save($code)) {
                $this->Flash->success(__('The registration code has been saved.'));
                return $this->redirect(['action' => 'view', $code->id]);
            }
            $this->Flash->error(__('The registration code could not be saved. Please, try again.'));
        }
        $this->set(compact('groups', 'code'));
        $this->set('_serialize', ['code']);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $code = $this->Codes->get($id);


        if ($this->Codes->delete($code)) {
            $this->Flash->success(__('The signup code has been deleted.'));
        } else {
            $this->Flash->error(__('The signup code could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}