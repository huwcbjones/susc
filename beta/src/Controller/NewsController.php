<?php
/**
 * Author: Huw
 * Since: 07/06/2016
 */

namespace SUSC\Controller;

use Cake\Datasource\ConnectionManager;
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
        $this->loadComponent('Paginator');
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

    public function index()
    {
        $this->set('news', $this->paginate($this->News->findNews('published')));
    }

    public function viewYear($year)
    {
        $options = ['year' => $year];
        $articles = $this->News
            ->findNews('published')
            ->find('year', $options);
        $this->set('news', $this->paginate($articles));
        $this->render('index');
    }

    public function viewMonth($year, $month)
    {
        $options = ['year' => $year, 'month' => $month];
        $articles = $this->News
            ->findNews('published')
            ->find('year', $options)
            ->find('month', $options);
        $this->set('news', $this->paginate($articles));
        $this->render('index');
    }

    public function viewDay($year, $month, $day)
    {
        $options = ['year' => $year, 'month' => $month, 'day' => $day];
        $articles = $this->News
            ->findNews('published')
            ->find('year', $options)
            ->find('month', $options)
            ->find('day', $options);
        $this->set('news', $this->paginate($articles));
        $this->render('index');
    }

    public function view($slug = null, $year = null, $month = null, $day = null)
    {
        $options = ['year' => $year, 'month' => $month, 'day' => $day, 'slug' => $slug];
        $article = $this->News
            ->findNews('published')
            ->find('slug', $options)
            ->first();
        if (empty($article)) {
            throw new NotFoundException(__('Article not found'));
        }
        $this->set('article', $article);
    }

    public function viewArticle($slug = null)
    {
        $options = ['slug' => $slug];
        $article = $this->News
            ->findNews('published')
            ->find('slug', $options)
            ->first();
        if (empty($article)) {
            throw new NotFoundException(__('Article not found'));
        }
        $this->set('article', $article);
    }
}