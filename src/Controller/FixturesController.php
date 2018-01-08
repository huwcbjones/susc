<?php
/**
 * Author: Huw
 * Since: 07/06/2016
 */

namespace SUSC\Controller;


use Cake\Controller\Component\AuthComponent;
use Cake\Network\Exception\NotFoundException;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use huwcbjones\markdown\GithubMarkdownExtended;
use SUSC\Model\Entity\Article;
use SUSC\Model\Entity\StaticContent;
use SUSC\Model\Table\ArticlesTable;
use SUSC\Model\Table\StaticContentTable;

/**
 * Class FixturesController
 * @package SUSC\Controller
 * @property ArticlesTable $Articles
 * @property StaticContentTable $Static
 * @property Session $Session
 * @property AuthComponent $Auth
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

        // Get table instances
        $this->Articles = TableRegistry::get('Articles');
        $this->Static = TableRegistry::get('StaticContent');

        // Get session controller
        $this->Session = $this->request->session();

        // Set auth
        $this->Auth->allow();
    }

    public function calendar(){
        $parser = new GithubMarkdownExtended();

        /** @var StaticContent $content */
        $content = $this->Static->find('fixtures')->firstOrFail();
        $this->set('calendar', $parser->parse($content->value));
    }

    public function index($year = null)
    {
        $options = array();
        if($year != null) $options['year'] = $year;
        $this->set(
            'fixtures',
            $this->paginate(
                $this->Articles
                    ->find('fixtures')
                    ->find('published')
                    ->find('date', $options)
            )
        );
    }

    public function view($year = null, $slug = null)
    {
        $options = ['year' => $year, 'slug' => $slug];
        /** @var Article $fixture */
        $fixture = $this->Articles
            ->find('fixtures')
            ->find('published')
            ->find('article', $options)
            ->first();
        if (empty($fixture)) {
            throw new NotFoundException(__('Fixture not found'));
        }

        if (
            !$this->request->is('crawler')
            && $this->Session->read('read_fixture_' . $fixture->slug) != true
        ) {
            $fixture->incrementHits();
            $this->Articles->save($fixture);
            $this->Session->write('read_fixture_' . $fixture->slug, true);
        }
        $this->set('fixture', $fixture);
    }
}