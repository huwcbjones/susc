<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace SUSC\Controller {

    use Cake\Cache\Cache;
    use Cake\Controller\Component\AuthComponent;
    use Cake\Controller\Controller as BaseController;
    use Cake\Event\Event;
    use Cake\Network\Request;
    use Cake\ORM\TableRegistry;
    use Cake\Routing\Router;
    use Psr\Log\LogLevel;
    use SUSC\Model\Entity\User;
    use SUSC\Model\Table\ConfigTable;
    use SUSC\Model\Table\UsersTable;

    /**
     * Application Controller
     *
     * Add your application-wide methods in the class below, your controllers
     * will inherit them.
     *
     * @property Request $request
     * @property UsersTable $Users
     * @property ConfigTable $Config
     * @property User $currentUser
     * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
     */
    class AppController extends BaseController
    {

        public $helpers = [
            'BootstrapUI.Html',
            'BootstrapUI.Flash'
        ];

        /**
         * Initialization hook method.
         *
         * Use this method to add common initialization code like loading components.
         *
         * e.g. `$this->loadComponent('Security');`
         *
         * @return void
         */
        public function initialize()
        {
            parent::initialize();
            $this->loadComponent('Flash');
            $this->loadComponent('RequestHandler');
            $this->loadComponent('Csrf');
            $this->request->addDetector(
                'crawler',
                function ($request) {
                    /** @var Request $request */
                    return (
                        $request->hasHeader('User-Agent')
                        && preg_match('/bot|crawl|slurp|spider/i', $request->getHeaderLine('User-Agent'))
                    );
                }
            );

            $this->loadComponent('Auth', [
                'loginAction' => ['_name' => 'login'],
                'loginRedirect' => ['_name' => 'profile'],
                'logoutRedirect' => ['_name' => 'home'],
                'unauthorizedRedirect' => false,
                'authenticate' => [
                    AuthComponent::ALL => ['userModel' => 'Users'],
                    'Form' => [
                        'fields' => ['username' => 'email_address', 'password' => 'password'],
                        //'finder' => 'active'
                    ]
                ],
                'authError' => false,
                'authorize' => ['Controller'],

                'storage' => 'Session'
            ]);

            // Get Table instances
            $this->Users = TableRegistry::get('Users');
            $this->Config = TableRegistry::get('Config');


            // Setup Authentication
            $this->currentUser = null;
            if ($this->Auth->user('id') !== null) {
                $this->currentUser = $this->Users->get($this->Auth->user('id'));
            }

            $this->set('currentUser', $this->currentUser);
        }

        public function isAuthorized($user = null)
        {
            $acl = $this->getACL();
            $this->log('acl: ' . $acl, LogLevel::DEBUG);

            if ($this->currentUser != null) {
                return $this->currentUser->isAuthorised($acl);
            }

            if ($user == null) return false;

            $user = $this->Users->get($user['id']);
            return $user->isAuthorised($acl);
        }

        /**
         * Converts the current request into an ACL string
         * @return string acl string
         */
        public function getACL()
        {
            // Create Acl id ($prefix).$controller.$action
            $acl = $this->_convertControllerString($this->request->getParam('controller'));
            if ($this->request->getParam('prefix') != '') $acl = strtolower($this->request->getParam('prefix')) . '.' . $acl;
            if ($this->request->getParam('action') != '') $acl .= '.' . strtolower($this->request->getParam('action'));
            return $acl;
        }

        /**
         * Converts a controller string into dashed version.
         *
         * E.g.: MyController => my-controller
         *
         * @param $controller string Controller Name
         * @return string Dashed controller string
         */
        protected function _convertControllerString($controller)
        {
            // Break "MyController" into ['my', 'Controller']
            $controller = preg_split('/(?=[A-Z])/', lcfirst($this->request->getParam('controller')));

            // Convert all $controller bit to lowercase
            foreach ($controller as &$bit) $bit = strtolower($bit);

            // Stick the controller string back together
            return implode('-', $controller);
        }

        public function beforeFilter(Event $event)
        {
            parent::beforeFilter($event);
            // TODO: Enable cache in production
            $this->response->withDisabledCache();
            Cache::disable();


            if ($this->currentUser === null) {
                $this->Auth->setConfig('authError', false);
                return;
            }

            // Logout inactive users
            if (!$this->currentUser->isEnabled()) {
                $this->Flash->error("Your account has been disabled.");
                $this->Auth->logout();
            }

            // Logout users that are not active in any way
            if (!$this->currentUser->isActive()) {
                $this->Flash->error("Your account has been disabled.");
                $this->Auth->logout();
            }

            if (!$this->currentUser->isActivated()) {
                $this->Flash->error("Your account needs to be activated first.");
                $this->Auth->logout();
            }

            // Force user to password change if needs password change
            if ($this->currentUser->isChangePassword()) {
                if (Router::normalize($this->request->getUri()->getPath()) !== Router::url(['_name' => 'change_password'])) {
                    return $this->redirect(['_name' => 'change_password']);
                } else {
                    $this->Flash->set("You must change your password before continuing.", ['element' => 'warn']);
                }
            }
        }

        /**
         * Before render callback.
         *
         * @param \Cake\Event\Event $event The beforeRender event.
         * @return void
         */
        public function beforeRender(Event $event)
        {
            if (!array_key_exists('_serialize', $this->viewVars) &&
                in_array($this->response->type(), ['application/json', 'application/xml'])
            ) {
                $this->set('_serialize', true);
            }
            if ($this->request->getParam('prefix') == 'admin' || strtolower($this->request->getParam('controller')) == 'admin') {
                $this->viewBuilder()->setLayout('admin');
            }
        }
    }
}

namespace App\Controller {

    class AppController extends \SUSC\Controller\AppController
    {
    }
}