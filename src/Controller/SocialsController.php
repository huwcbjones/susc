<?php
/**
 * Author: Huw
 * Since: 24/06/2016
 */

namespace SUSC\Controller;


use Cake\Network\Exception\NotFoundException;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use SUSC\Model\Entity\Article;
use SUSC\Model\Table\ArticlesTable;

/**
 * Socials Controller
 *
 * @property ArticlesTable $Socials
 * @property Session $Session
 */
class SocialsController extends AppController
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
        $this->Session = $this->request->session();
        $this->Socials = TableRegistry::get('Articles');
        $this->set('archives',
            $this->Socials
                ->find('socials')
                ->find('published')
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
        if ($year != null) $options['year'] = $year;
        if ($month != null) $options['month'] = $month;
        if ($day != null) $options['day'] = $day;
        $this->set(
            'socials',
            $this->paginate(
                $this->Socials
                    ->find('socials')
                    ->find('published')
                    ->find('date', $options)
            )
        );
    }

    public function view($year = null, $month = null, $day = null, $slug = null)
    {
        $options = ['year' => $year, 'month' => $month, 'day' => $day, 'slug' => $slug];
        /** @var Article $article */
        $article = $this->Socials
            ->find('socials')
            ->find('published')
            ->find('article', $options)
            ->first();
        if (empty($article)) {
            throw new NotFoundException(__('Social not found'));
        }
        if (
            !$this->request->is('crawler')
            && $this->Session->read('read_social_' . $article->slug) != true
        ) {
            $article->hits++;
            $this->Socials->save($article);
            $this->Session->write('read_social_' . $article->slug, true);
        }
        $this->set('social', $article);
    }
}