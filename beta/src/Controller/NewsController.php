<?php
/**
 * Author: Huw
 * Since: 07/06/2016
 */

namespace SUSC\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

/**
 * News Controller
 *
 * @property \SUSC\Model\Table\NewsTable $News
 */
class NewsController extends AppController
{



    public $paginate = [
        'limit' => 10,
        'order' => [
            'News.created' => 'desc'
        ],
        'finder' => 'published'
    ];

    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);
        $this->viewBuilder()->helpers(['BBCode.BBCode']);
    }

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        //$this->helpers[] = 'BBCode.BBCode';
        $this->Auth->allow();
        $this->News = TableRegistry::get('News');
    }

    public function index()
    {
         $this->set('news', $this->paginate());
    }

    public function view($fixtureID)
    {
    }
}