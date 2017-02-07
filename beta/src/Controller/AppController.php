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
    use Cake\Controller\Controller as BaseController;
    use Cake\Event\Event;
    use Cake\ORM\TableRegistry;

    /**
     * Application Controller
     *
     * Add your application-wide methods in the class below, your controllers
     * will inherit them.
     *
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
            //TableRegistry::config('Articles', ['table' => 'News']);
        }

        public function isAuthorized($user = null)
        {
            // Any registered user can access public functions
            if (empty($this->request->params['prefix'])) {
                return true;
            }

            // Only admins can access admin functions
            if ($this->request->params['prefix'] === 'admin') {
                return (bool)($user['role'] === 'admin');
            }

            // Default deny
            return false;
        }

        public function beforeFilter(Event $event)
        {
            parent::beforeFilter($event);
            // TODO: Enable cache in production
            $this->response->disableCache();
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

    class AppController extends \SUSC\Controller\AppController {
    }
}