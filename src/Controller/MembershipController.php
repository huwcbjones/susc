<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

namespace SUSC\Controller;

use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Mailer\Email;
use Cake\ORM\TableRegistry;
use SUSC\Model\Entity\Membership;
use SUSC\Model\Table\MembershipsTable;
use SUSC\Model\Table\MembershipTypesTable;

/**
 * Author: Huw
 * Since: 05/10/2017
 *
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
        if (in_array($this->request->getParam('action'), ['index', 'confirm', 'faq', 'memberships', 'view'])) return 'membership.*';
        if (in_array($this->request->getParam('action'), ['details'])) return 'membership.order';

        return parent::getACL();
    }


    public function index()
    {

        $memberships = $this->MembershipTypes->find('currentMemberships');
        $this->set('memberships', $memberships);
    }

    public function details()
    {
        if (($membership = $this->request->session()->read('Membership.Details')) === null) {
            $membership = $this->Memberships->newEntity($this->request->getData(), ['validate' => $this->request->is(['patch', 'post', 'put'])]);
        }
        $membership->user_id = $this->currentUser->id;

        $membership_types = $this->Memberships->MembershipTypes->find('list', ['limit' => 200]);

        if ($membership->membership_type_id == null && $this->request->getQuery('type') != null) {
            try {
                $membership->membership_type_id = $this->MembershipTypes->find('slug', ['slug' => $this->request->getQuery('type')])->firstOrFail()->id;
            } catch (RecordNotFoundException $ex) {
            }
        }

        if ($membership->name == null) $membership->name = $this->currentUser->full_name;


        /** @var Membership $prior_membership */
        $prior_membership = $this->Memberships->find('user', ['user_id' => $this->currentUser->id])->order(['Memberships.created' => 'DESC'])->first();
        $email = strtolower($this->currentUser->email_address);
        if ($prior_membership !== null) {
            if ($membership->student_id == null) $membership->student_id = $prior_membership->student_id;
            if ($membership->soton_id == null) $membership->soton_id = $prior_membership->soton_id;
            if ($membership->name == null) $membership->name = $prior_membership->name;
            if ($membership->date_of_birth == null) $membership->date_of_birth = $prior_membership->date_of_birth;
        } else if (strpos($email, '@soton.ac.uk') !== false && $membership->soton_id === null) {
            $membership->soton_id = str_replace('@soton.ac.uk', '', $email);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->request->session()->write('Membership.Details', $membership);
            return $this->redirect(['_name' => 'membership_confirm']);
        }


        $this->set(compact('membership', 'membership_types', 'selected_membership'));
        $this->set('_serialize', ['membership']);
    }

    public function confirm()
    {
        /** @var Membership $membership */
        if (($membership = $this->request->session()->read('Membership.Details')) === null) {
            return $this->redirect(['_name' => 'membership_details']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            if ($this->Memberships->save($membership)) {
                $this->Flash->success('Your membership has been confirmed. Please now pay your membership fees.');
                $this->request->session()->delete('Membership.Details');

                $email = new Email();
                $email
                    ->setTo($this->currentUser->email_address, $this->currentUser->full_name)
                    ->setSubject('SUSC Membership Confirmation')
                    ->setTemplate('membership_confirm')
                    ->setViewVars(['membership' => $membership, 'user' => $this->currentUser])
                    ->send();

                return $this->redirect(['_name' => 'memberships']);
            } else {
                $this->Flash->error('Failed to confirm membership. Please try again.');
            }
        }

        $membership->membership_type = $this->MembershipTypes->get($membership->membership_type_id);
        $this->set('membership', $membership);
    }

    public function memberships()
    {
        $query = $this->Memberships
            ->find('user', ['user_id' => $this->currentUser->id])
            ->contain('MembershipTypes')
            ->order(['Memberships.created' => 'DESC']);
        $memberships = $this->paginate($query);

        $this->set('memberships', $memberships);
    }

    public function view($id = null)
    {
        $membership = $this->Memberships->get($id);

        $this->set('membership', $membership);
    }

}