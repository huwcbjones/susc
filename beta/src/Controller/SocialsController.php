<?php
/**
 * Author: Huw
 * Since: 24/06/2016
 */

namespace SUSC\Controller;


use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;

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

    public function index()
    {
        $this->set('socials', $this->paginate($this->Socials->findSocials('published')));
    }

    public function viewYear($year)
    {
        $options = ['year' => $year];
        $articles = $this->News
            ->findSocials('published')
            ->find('year', $options);
        $this->set('socials', $this->paginate($articles));
        $this->render('index');
    }

    public function viewMonth($year, $month)
    {
        $options = ['year' => $year, 'month' => $month];
        $articles = $this->Socials
            ->findSocials('published')
            ->find('year', $options)
            ->find('month', $options);
        $this->set('socials', $this->paginate($articles));
        $this->render('index');
    }

    public function viewSocial($slug = null)
    {
        $options = ['slug' => $slug];
        $article = $this->Socials
            ->findSocials('published')
            ->find('slug', $options)
            ->first();
        if (empty($article)) {
            throw new NotFoundException(__('Social not found'));
        }
        $this->set('social', $article);
        $this->render('view');
    }
}