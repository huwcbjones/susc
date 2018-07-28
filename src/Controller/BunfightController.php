<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

/**
 * Author: Huw Jones
 * Date: 22/07/18
 * Time: 15:06
 */

namespace SUSC\Controller;


use Cake\Database\Exception;
use Cake\Event\Event;
use Cake\Mailer\MailerAwareTrait;
use Cake\ORM\TableRegistry;
use SUSC\Mailer\BunfightMailer;
use SUSC\Model\Entity\BunfightSignup;
use SUSC\Model\Table\BunfightSessionsTable;
use SUSC\Model\Table\BunfightSignupsTable;
use SUSC\Model\Table\BunfightsTable;
use SUSC\Model\Table\SquadsTable;

/**
 * Class BunfightController
 * @package SUSC\Controller
 *
 * @property BunfightsTable $Bunfights
 * @property BunfightSessionsTable $BunfightSessions
 * @property BunfightSignupsTable $BunfightSignups
 * @property SquadsTable $Squads;
 */
class BunfightController extends AppController
{

    use MailerAwareTrait;

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('bunfight');
        $this->Bunfights = TableRegistry::get('Bunfights');
        $this->BunfightSessions = TableRegistry::get('BunfightSessions');
        $this->BunfightSignups = TableRegistry::get('BunfightSignups');
        $this->Squads = TableRegistry::get('Squads');

        $mailer = new BunfightMailer();
        $this->BunfightSignups->getEventManager()->on($mailer);
    }

    public function getACL()
    {
        if ($this->request->getParam('action') == 'index') return 'bunfight.*';
        return parent::getACL();
    }

    public function index()
    {
        try {
            $bunfight_id = $this->Config->get('bunfight.current')['value'];
            if ($bunfight_id === null || trim($bunfight_id) == '') {
                return $this->redirect(['_name' => 'home']);
            }
            $bunfight = $this->Bunfights->get($bunfight_id);
        } catch (Exception $ex) {
            return $this->redirect(['_name' => 'home']);
        }


        $sessions = $this->BunfightSessions->find('bunfight', ['bunfight_id' => $bunfight_id]);
        $squads = $this->Squads->find();

        $signup = $this->BunfightSignups->newEntity();
        if ($this->request->is('POST')) {

            $priorSignup = $this->BunfightSignups->find('signup', [
                "email" => $this->request->getData("email_address"),
                "bunfight" => $bunfight_id
            ])->first();
            if ($priorSignup !== null) $signup = $priorSignup;

            $this->BunfightSignups->patchEntity($signup, $this->request->getData(), ['associated' => ['Squads']]);
            $signup->bunfight_id = $bunfight_id;

            if ($this->BunfightSignups->save($signup, ['associated' => ['Squads']])) {
                $this->Flash->success($this->Config->get('bunfight.confirmation_message')['value'], ['escape' => false]);
                return $this->redirect($this->request->getUri()->getPath());
            } else {
                $this->Flash->error('There was an issue processing your signup. Please correct any errors and try again.');
            }
        }
        $this->set(compact('bunfight', 'sessions', 'squads', 'signup'));
    }

    public function unsubscribe()
    {
        $this->viewBuilder()->setTemplate('unsub');
        $email_address = $this->request->getQuery('email_address');
        $this->set('email_address', $email_address);
        if (!$this->request->is('POST')) return;

        if (($post_email_address = $this->request->getData('email_address')) === null and $email_address === null) {
            $this->Flash->error('No email address provided!');
            return;
        }
        $email_address = $post_email_address != null ? $post_email_address : $email_address;

        /** @var BunfightSignup[] $signups */
        $signups = $this->BunfightSignups->find()->where(['email_address' => $email_address])->all();
        $to_save = [];
        foreach ($signups as $s) {
            $s->consent_to_emails = false;
            $to_save[] = $s;
        }

        if ($this->BunfightSignups->saveMany($to_save) !== false) {
            $this->Flash->success('You have been unsubscribed.');
            return $this->redirect("");
        } else {
            $this->Flash->error('We could not unsubscribe you, please email us to correct this issue.');
            return $this->redirect("?email_address=".$email_address);
        }
    }


}