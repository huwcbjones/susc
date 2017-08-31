<?php
namespace SUSC\Controller\Admin;


use Cake\Controller\Component\AuthComponent;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use SUSC\Controller\AppController;
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
        //$this->Auth->
        $this->Users = TableRegistry::get('Users');
    }


    public function initialize()
    {
        parent::initialize();
        $this->Users = TableRegistry::get('user');
    }

    public function getACL()
    {
        if($this->request->getParam('action') == 'index') return 'admin.users.*';
        return parent::getACL();
    }


    public function index()
    {

    }
}