<?php
/**
 * Author: Huw
 * Since: 07/06/2016
 */

namespace SUSC\Controller;

use App\Model\Entity\Article;
use Cake\Controller\Component\AuthComponent;

use Cake\Network\Exception\NotFoundException;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use SUSC\Model\Table\ArticlesTable;

/**
 * News Controller
 *
 * @property ArticlesTable $News
 * @property Session $Session
 * @property AuthComponent $Auth
 */
class NewsController extends AppController
{

    public $paginate = [
        'limit' => 10,
        'order' => [
            'Articles.created' => 'desc'
        ]
    ];

    public function initialize()
    {
        parent::initialize();

        // Set session
        $this->Session = $this->request->session();

        // Get table instances
        $this->News = TableRegistry::get('Articles');
        $this->set('archives',
            $this->News->find('news')->find('published')
                ->select([
                    'year' => 'YEAR(`Articles`.`created`)',
                    'month' => 'MONTH(`Articles`.`created`)'
                ])
                ->order(['year' => 'DESC', 'month' => 'DESC'])
                ->group(['year', 'month'])
                ->toArray());

        // Set auth
        $this->Auth->allow();
    }

    public function index($year = null, $month = null, $day = null)
    {
        $options = array();
        if ($year != null) $options['year'] = $year;
        if ($month != null) $options['month'] = $month;
        if ($day != null) $options['day'] = $day;
        $this->set(
            'news',
            $this->paginate(
                $this->News
                    ->find('news')
                    ->find('published')
                    ->find('date', $options)
            )
        );
    }

    public function view($year = null, $month = null, $day = null, $slug = null)
    {
        $options = ['year' => $year, 'month' => $month, 'day' => $day, 'slug' => $slug];
        /** @var Article $article */
        $article = $this->News
            ->find('news')
            ->find('published')
            ->find('article', $options)
            ->first();
        if (empty($article)) {
            throw new NotFoundException(__('Article not found'));
        }
        if (
            !$this->request->is('crawler')
            && $this->Session->read('read_article_' . $article->slug) != true
        ) {
            $article->hits++;
            $this->News->save($article);
        }
        $this->set('article', $article);
    }
}