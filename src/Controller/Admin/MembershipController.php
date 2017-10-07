<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

use SUSC\Model\Table\MembershipsTable;
use SUSC\Model\Table\MembershipTypesTable;

/**
 * Author: Huw
 * Since: 07/10/2017
 *
 * @property MembershipTypesTable $MembershipTypes
 * @property MembershipsTable $Memberships
 */

namespace SUSC\Controller\Admin;


use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;
use SUSC\Controller\AppController;
use SUSC\Model\Entity\MembershipType;

class MembershipController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->MembershipTypes = TableRegistry::get('MembershipTypes');
        $this->Memberships = TableRegistry::get('Memberships');
    }


    public function getACL()
    {
        if ($this->request->getParam('action') == 'index') return 'admin.membership.*';
        if (in_array($this->request->getParam('action'), ['paid', 'ordered', 'arrived', 'collected'])) {
            return 'admin.kit-orders.status';
        }
        if (in_array($this->request->getParam('action'), ['processedOrders'])) {
            return 'admin.kit-orders.process';
        }
        return parent::getACL();
    }

    public function index()
    {
        $membershipTypes = $this->paginate($this->MembershipTypes, ['order' => ['valid_from' => 'ASC', 'valid_to' => 'ASC', 'title' => 'ASC']]);

        $this->set('membershipTypes', $membershipTypes);
    }

    public function add()
    {
        $membership = $this->MembershipTypes->newEntity();

        if ($this->request->is(['patch', 'post', 'put'])) {
            /** @var MembershipType $membership */
            $membership = $this->MembershipTypes->patchEntity($membership, $this->request->getData());
            $membership->created = $membership->created = Time::now();

            $membership->valid_from = $this->request->getData('valid_from');
            if ($membership->valid_from === '') $membership->valid_from = null;

            $membership->valid_to = $this->request->getData('valid_to');
            if ($membership->valid_to === '') $membership->valid_to = null;


            if ($membership->valid_from !== null && $membership->valid_to !== null) {
                if ($membership->valid_from >= $membership->valid_to) {
                    $membership->setError('valid_to', ['Valid To date must be after Valid From']);
                }
            }

            $membership->slug = Text::slug(strtolower($membership->title));

            if ($this->MembershipTypes->save($membership)) {
                $this->Flash->success(__('The membership type has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {

                $this->Flash->error(__('The membership type could not be saved. Please, try again.'));
            }
        }

        $this->set('membership', $membership);
        $this->set('_serialize', ['membership']);

    }

    public function view($id)
    {
        $item = $this->MembershipTypes->get($id);

        $this->set('item', $item);
        $this->set('_serialize', ['item']);
    }

    public function edit($id)
    {
        $item = $this->MembershipTypes->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            /** @var MembershipType $item */
            $item = $this->MembershipTypes->patchEntity($item, $this->request->getData());

            $item->valid_from = $this->request->getData('valid_from');
            if ($item->valid_from === '') $item->valid_from = null;

            $item->valid_to = $this->request->getData('valid_to');
            if ($item->valid_to === '') $item->valid_to = null;


            if ($item->valid_from !== null && $item->valid_to !== null) {
                if ($item->valid_from >= $item->valid_to) {
                    $item->setError('valid_to', ['Valid To date must be after Valid From']);
                }
            }

            if ($this->MembershipTypes->save($item)) {
                $this->Flash->success(__('The membership type has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {

                $this->Flash->error(__('The membership type could not be saved. Please, try again.'));
            }
        }
        $this->set('item', $item);
        $this->set('_serialize', ['item']);
    }

    public function members()
    {

    }

    /**
     * Deletes a membership type
     * @param null|string $id
     * @return \Cake\Http\Response|null
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $item = $this->MembershipTypes->get($id);
        $this->MembershipTypes->loadInto($item, ['Memberships']);
        if (count($item->memberships) != 0) {
            $item->status = false;
            if ($this->MembershipTypes->save($item)) {
                $this->Flash->set(__('Cannot delete membership as there are memberships attached to this type. Membership type has been disabled instead.'), ['element' => 'warn']);
            } else {
                $this->Flash->error(__('Cannot delete membership as there are memberships attached to this item. Failed to disable membership type!'));
            }
            return $this->redirect($this->referer());
        }


        if ($this->MembershipTypes->delete($item)) {
            $this->Flash->success(__('The membership type has been deleted.'));
        } else {
            $this->Flash->error(__('The membership type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}