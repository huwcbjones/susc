<?php
/**
 * Author: Huw
 * Since: 07/06/2016
 */

namespace SUSC\Controller;

use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;

/**
 * News Controller
 *
 * @property \SUSC\Model\Table\ArticlesTable $News
 */
class NewsController extends AppController
{

    public $paginate = [
        'limit' => 10,
        'order' => [
            'Articles.created' => 'desc'
        ]
    ];

    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);
    }

    public function initialize()
    {
        parent::initialize();
        //$this->Auth->allow();
        $this->News = TableRegistry::get('Articles');
        $this->set('archives',
            $this->News->findNews('published')
                ->select([
                    'year' => 'YEAR(`Articles`.`created`)',
                    'month' => 'MONTH(`Articles`.`created`)'
                ])
                ->order(['year' => 'DESC', 'month' => 'DESC'])
                ->group(['year', 'month'])
                ->toArray());
    }

    public function index($year = null, $month = null, $day = null)
    {
        $options = array();
        if($year != null) $options['year'] = $year;
        if($month != null) $options['month'] = $month;
        if($day != null) $options['day'] = $day;
        $this->set('news', $this->paginate($this->News->findNews('published')->find('date', $options)));
    }

    public function view($year = null, $month = null, $day = null, $slug = null)
    {
        $options = ['year' => $year, 'month' => $month, 'day' => $day, 'slug' => $slug];
        $article = $this->News
            ->findNews('published')
            ->find('article', $options)
            ->first();
        if (empty($article)) {
            throw new NotFoundException(__('Article not found'));
        }
        $this->set('article', $article);
    }
}