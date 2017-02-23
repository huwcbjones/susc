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
namespace SUSC\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\View\Exception\MissingTemplateException;
use huwcbjones\markdown\GithubMarkdownExtended;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{

    public function initialize()
    {
        require_once(ROOT .DS. "vendor" . DS  . "huwcbjones" . DS . "markdown" . DS . "GithubMarkdownExtended.php");
        parent::initialize();
        $this->Static = TableRegistry::get('scontent');
        if ($this->Auth !== false) {
            // Allow access to all pages
            $this->Auth->allow();
        }
    }

    public function home()
    {
        $this->set('gallery', TableRegistry::get('Galleries')->find('home')->first());

        $this->set('news', TableRegistry::get('Articles')->findNews('published', [
            'order' => ['`Articles`.`created`' => 'DESC'],
            'limit' => 3,
        ]));

        $this->set('fixtures', TableRegistry::get('Articles')->findFixtures('published', [
            'order' => ['`Articles`.`created`' => 'DESC'],
            'limit' => 3,
        ]));

        $this->set('socials', TableRegistry::get('Articles')->findSocials('published', [
            'order' => ['`Articles`.`created`' => 'DESC'],
            'limit' => 3,
        ]));
    }

    public function training()
    {
        $path = func_get_args();
        if(count($path) == 0) throw new NotFoundException();

        try {
            $parser = new GithubMarkdownExtended();
            $this->set($path[0], $parser->parse($this->Static->find('training', ['section' => $path[0]])->first()->value));
            $this->render('training_' . $path[0]);

        } catch (MissingTemplateException $e) {
            if (Configure::read('debug')) {
                throw $e;
            }
            throw new NotFoundException();
        }
    }
}
