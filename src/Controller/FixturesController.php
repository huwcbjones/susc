<?php
/**
 * Author: Huw
 * Since: 07/06/2016
 */

namespace SUSC\Controller;


use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use huwcbjones\markdown\GithubMarkdownExtended;

/**
 * Class FixturesController
 * @package SUSC\Controller
 * @property \SUSC\Model\Table\ArticlesTable $Articles
 * @property \Cake\Network\Session $Session
 */
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
        $this->Session = $this->request->session();
    }

    public function calendar(){
        $parser = new GithubMarkdownExtended();
        $this->set('calendar', $parser->parse($this->Static->find('fixtures')->first()->value));
    }

    public function index($year = null)
    {
        $options = array();
        if($year != null) $options['year'] = $year;
        $this->set('fixtures', $this->paginate($this->Articles->findFixtures('published')->find('date', $options)));
    }

    public function view($year = null, $slug = null)
    {
        $options = ['year' => $year, 'slug' => $slug];
        $fixture = $this->Articles
            ->findFixtures('published')
            ->find('date', $options)
            ->find('slug', $options)->first();
        if (
            !$this->request->is('crawler')
            && $this->Session->read('read_fixture_' . $fixture->slug) != true
        ) {
            $fixture->hits++;
            $this->Articles->save($fixture);
            $this->Session->write('read_fixture_' . $fixture->slug, true);
        }
        if (empty($fixture)) {
            throw new NotFoundException(__('Fixture not found'));
        }
        $this->set('fixture', $fixture);
    }
}