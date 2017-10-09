<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace SUSC\View;

use BootstrapUI\View\UIViewTrait;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\ORM\TableRegistry;
use Cake\View\View;

/**
 * Application View
 *
 * Your application’s default view class
 *
 * @link http://book.cakephp.org/3.0/en/views.html#the-app-view
 */
class AppView extends View
{

    use UIViewTrait;

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading helpers.
     *
     * e.g. `$this->loadHelper('Html');`
     *
     * @return void
     */
    public function initialize()
    {
        $this->initializeUI(['layout' => false]);
        $this->loadHelper('Text');
        $this->loadHelper('Paginator');
    }

    public function hasAccessTo($acl){
        if(array_key_exists('currentUser', $this->viewVars) && $this->viewVars['currentUser'] !== null){
            return ($this->viewVars['currentUser'])->isAuthorised($acl);
        }
        try {
            if(substr($acl, -2) == '.*') $acl = substr($acl, 0, -2);
            $acl_entity = TableRegistry::get('Acls')->get($acl);
            return $acl_entity->is_public;
        } catch (RecordNotFoundException $ex) {

        }
        return false;
    }
}
