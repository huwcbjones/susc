<?php
/**
 * Author: Huw
 * Since: 07/06/2016
 */

namespace SUSC\Controller;


use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use huwcbjones\markdown\GithubMarkdownExtended;

class FixturesController extends AppController
{
    public $paginate = [
        'limit' => 10,
        'order' => [
            'Articles.created' => 'desc'
        ],
        'finder' => 'published'
    ];

    public function initialize()
    {
        parent::initialize();
        require_once(ROOT .DS. "vendor" . DS  . "huwcbjones" . DS . "markdown" . DS . "GithubMarkdownExtended.php");
        //$this->Auth->allow();
        $this->Articles = TableRegistry::get('Articles');
        $this->Static = TableRegistry::get('scontent');
    }

    public function calendar(){
        $parser = new GithubMarkdownExtended();
        $this->set('calendar', $parser->parse($this->Static->find('fixtures')->first()->value));
    }

    public function index()
    {
        $this->set('fixtures', $this->paginate($this->Articles->findFixtures('published')));
    }

    public function view($slug = null)
    {
        $options = ['slug' => $slug];
        $fixture = $this->Articles
            ->findFixtures('published')
            ->find('slug', $options)
            ->first();
        if (empty($fixture)) {
            throw new NotFoundException(__('Fixture not found'));
        }
        $this->set('fixture', $fixture);
    }
}