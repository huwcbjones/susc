<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

namespace SUSC\Controller\Admin;

use Cake\HTTP\Response;
use Cake\I18n\FrozenTime;
use Cake\I18n\Time;
use Cake\Mailer\Email;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;
use DateTime;
use SUSC\Controller\AppController;
use SUSC\Controller\Component\MembershipProcessComponent;
use SUSC\Model\Entity\Membership;
use SUSC\Model\Entity\MembershipType;
use SUSC\Model\Table\MembershipsTable;
use SUSC\Model\Table\MembershipTypesTable;

/**
 * Author: Huw
 * Since: 07/10/2017
 *
 * @property MembershipProcessComponent $MembershipProcess
 * @property MembershipTypesTable $MembershipTypes
 * @property MembershipsTable $Memberships
 */
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
        if ($this->request->getParam('action') == 'editMembership') return 'admin.membership.edit';
        if (in_array($this->request->getParam('action'), ['paid', 'ordered', 'arrived', 'collected'])) {
            return 'admin.membership.status';
        }

        if (in_array($this->request->getParam('action'), ['processedOrders'])) {
            return 'admin.membership.process';
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
        $memberships = $this->Paginate($this->Memberships, ['order' => ['created' => 'DESC']]);

        $this->set('memberships', $memberships);
    }

    public function details($id = null)
    {
        $membership = $this->Memberships->get($id);
        $this->set('membership', $membership);
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
            $item->is_enable = false;
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

    /**
     * Cancels a membership
     *
     * @param string|null $id ID of membership to cancel
     * @return Response|null
     */
    public function cancel($id = null)
    {
        // Get ID from post data if not in URL
        if ($id === null) $id = $this->request->getData('id');

        /** @var Membership $membership */
        $membership = $this->Memberships->find('id', ['id' => $id])->firstOrFail();

        // Soft-delete the order
        $membership->is_cancelled = true;
        if ($this->Memberships->save($membership)) {
            $email = new Email();
            $email
                ->setTo($membership->user->email_address, $membership->user->full_name)
                ->setSubject('Cancelled Membership')
                ->setTemplate('membership_cancel')
                ->setViewVars(['membership' => $membership, 'user' => $membership->user])
                ->send();
            return $this->redirect(['action' => 'members']);
        } else {
            $this->Flash->error('Failed to cancel membership!');
            return $this->redirect($this->referer());
        }
    }

    /**
     * Marks a membership as paid
     * @param string|null $id ID of Membership to mark as paid
     * @return Response|null
     */
    public function paid($id = null)
    {
        if ($this->request->getMethod() != 'POST') {
            return $this->redirect(['action' => 'members']);
        }

        // Get ID from post data if not in URL
        if ($id === null) $id = $this->request->getData('id');

        /** @var Membership $membership */
        $membership = $this->Memberships->find('ID', ['id' => $id])->firstOrFail();
        if ($membership->is_paid) {
            $this->Flash->success('Membership has already been marked as paid.');
            return $this->redirect(['action' => 'index']);
        }

        $membership->paid = new DateTime();

        if ($this->Memberships->save($membership)) {
            $email = new Email();
            $email
                ->setTo($membership->user->email_address, $membership->user->full_name)
                ->setSubject('Membership Payment Received')
                ->setTemplate('membership_payment')
                ->setViewVars(['membership' => $membership, 'user' => $membership->user])
                ->send();

            $this->Flash->success('Membership has been marked as paid.');
            return $this->redirect(['action' => 'members']);
        } else {
            $this->Flash->error('Failed to mark membership as paid!');
            return $this->redirect($this->referer());
        }
    }

    public function editMembership($id = null)
    {
        $membership = $this->Memberships->get($id);
        $membership_types = $this->Memberships->MembershipTypes->find('list', ['limit' => 200]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            /** @var Membership $membership */
            $membership->membership_type_id = $this->request->getData('membership_type_id');
            if ($this->Memberships->save($membership)) {
                $this->Flash->success(__('The membership has been updated.'));

                $this->Memberships->loadInto($membership, ['MembershipTypes']);
                $email = new Email();
                $email
                    ->setTo($this->currentUser->email_address, $this->currentUser->full_name)
                    ->setSubject('SUSC Membership Confirmation')
                    ->setTemplate('membership_confirm')
                    ->setViewVars(['membership' => $membership, 'user' => $this->currentUser])
                    ->send();

                return $this->redirect(['action' => 'details', $membership->id]);
            } else {
                $this->Flash->error(__('The membership could not be saved. Please, try again.'));
            }
        }

        $this->set('membership', $membership);
        $this->set('membership_types', $membership_types);
        $this->set('_serialize', ['membership']);
    }

    public function list()
    {
        if (!$this->request->is(['patch', 'post', 'put'])) return;

        $this->loadComponent('MembershipProcess');


        $date = new FrozenTime($this->request->getData('date'));
        if(!$this->MembershipProcess->isDownloadExist($date)){
            $this->MembershipProcess->createDownload($date);
        }



        // Send the download
        $response = $this->response
            ->withType('application/zip')
            ->withDownload($this->MembershipProcess->getZipFileName($date))
            ->withFile($this->MembershipProcess->getZipFilePath($date));
        return $response;
    }
}