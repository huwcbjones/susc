<?php
/**
 * Author: Huw
 * Since: 24/06/2016
 */

namespace SUSC\Controller;


use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;

/**
 * Socials Controller
 *
 * @property \SUSC\Model\Table\ArticlesTable $Socials
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
        //$this->Auth->allow();
        $this->Socials = TableRegistry::get('Articles');
        $this->set('archives',
            $this->Socials->findSocials('published')
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
        $this->set('socials', $this->paginate($this->Socials->findSocials('published')->find('date', $options)));
    }

    public function view( $year = null, $month = null, $day = null, $slug = null)
    {
        $options = ['year' => $year, 'month' => $month, 'day' => $day, 'slug' => $slug];
        $article = $this->Socials
            ->findSocials('published')
            ->find('article', $options)
            ->first();
        if (empty($article)) {
            throw new NotFoundException(__('Social not found'));
        }
        $this->set('social', $article);
    }
}