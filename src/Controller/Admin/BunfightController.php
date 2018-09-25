<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 */

/**
 * @author huw
 * @since 25/09/2018 12:15
 */

namespace SUSC\Controller\Admin;


use Cake\ORM\TableRegistry;
use SUSC\Controller\AppController;
use SUSC\Model\Table\BunfightSessionsTable;
use SUSC\Model\Table\BunfightSignupsTable;
use SUSC\Model\Table\BunfightsTable;
use SUSC\Model\Table\SquadsTable;

/**
 * Class BunfightController
 * @package SUSC\Controller\Admin
 *
 * @property BunfightsTable $Bunfights
 * @property BunfightSessionsTable $Sessions
 * @property BunfightSignupsTable $Signups
 * @property SquadsTable $Squads
 * @property string $CurrentBunfightID
 */
class BunfightController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Bunfights = TableRegistry::get('Bunfights');
        $this->Sessions = TableRegistry::get('BunfightSessions');
        $this->Signups = TableRegistry::get('BunfightSignups');
        $this->Squads = TableRegistry::get('Squads');
        $this->CurrentBunfightID = $this->Config->get('bunfight.current')->value;
        $this->set('current_bunfight_id', $this->CurrentBunfightID);
    }


    public function getACL()
    {
        if ($this->request->getParam('action') == 'index') return 'admin.bunfight.*';
        return parent::getACL();
    }

    public function index()
    {
        $this->paginate = [
            'contain' => ['BunfightSessions', 'BunfightSignups'],
        ];
        $bunfights = $this->paginate($this->Bunfights);

        $this->set(compact('bunfights'));
        $this->set('_serialize', ['bunfights']);
    }

    public function view($id = null)
    {
        $all_squads = $this->Squads->find('all');
        $squads = ["" => ["value" => 0, "name" => "No Interest"]];
        foreach ($all_squads as $squad) {
            $squads[$squad->id] = [
                "value" => 0,
                "name" => $squad->name
            ];
        }
        $bunfight = $this->Bunfights->get($id, [
            'contain' => ['BunfightSessions', 'BunfightSignups' => ['Squads']]
        ]);

        $this->set(compact('bunfight', 'squads'));
        $this->set('_serialize', ['bunfight', 'squads']);
    }

    public function edit($id = null)
    {
        $bunfight = $this->Bunfights->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $bunfight = $this->Bunfights->patchEntity($bunfight, $this->request->getData());
            if ($this->Bunfights->save($bunfight)) {
                $this->Flash->success(__('The bunfight has been saved.'));
                return $this->redirect(['action' => 'view', $bunfight->id]);
            }
            $this->Flash->error(__('The group could not be saved. Please, try again.'));
        }

        $this->set(compact('bunfight', 'squads'));
        $this->set('_serialize', ['bunfight', 'squads']);
    }


    public function add()
    {

    }

    public function add_session()
    {

    }

    public function email()
    {

    }

    public function config()
    {

    }
}