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
    use SUSC\Model\Entity\User;
    use SUSC\Model\Table\UsersTable;

    /**
     * Application Controller
     *
     * Add your application-wide methods in the class below, your controllers
     * will inherit them.
     *
     * @property Request $request
     * @property UsersTable $users
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
                        'fields' => ['username' => 'email_address', 'password' => 'password']
                    ]
                ],
                'authError' => 'You are not allowed to access that location.',
                'authorize' => ['Controller'],

                'storage' => 'Session'
            ]);

            $this->users = TableRegistry::get('Users');
        }

        public function isAuthorized($user = null)
        {
            if ($user == null) return false;

            /** @var User $user */
            $user = $this->users->get($user['id']);

            // Create Acl id ($prefix).$controller.$action
            $acl = strtolower($this->request->getParam('controller'));
            if ($this->request->getParam('prefix') != '') $acl = strtolower($this->request->getParam('prefix' != '')) . '.' . $acl;
            if ($this->request->getParam('action') != '') $acl .= '.' . strtolower($this->request->getParam('action'));

            return array_key_exists($acl, $user->acls);
        }

        public function beforeFilter(Event $event)
        {
            parent::beforeFilter($event);
            // TODO: Enable cache in production
            $this->response->withDisabledCache();
            Cache::disable();
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
        }
    }
}

namespace App\Controller {

    class AppController extends \SUSC\Controller\AppController
    {
    }
}