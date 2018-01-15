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

    public function view($id = null)
    {
        $code = $this->Codes->get($id, [
            'contain' => ['Groups']
        ]);

        $this->set('code', $code);
        $this->set('_serialize', ['code']);
    }

}