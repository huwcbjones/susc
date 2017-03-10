<?php
/**
 * Author: Huw
 * Since: 03/03/2017
 */

namespace SUSC\Controller;

use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

/**
 * Class SitemapsController
 * @package SUSC\Controller
 * @property $Articles \SUSC\Model\Table\ArticleTable
 */
class SitemapsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->Articles = TableRegistry::get('Articles');
    }

    public function index()
    {
        $data = array_merge($this->_getPages(), $this->_getArticles());
        usort($data, function ($a, $b) {
            if (key_exists('priority', $a) && key_exists('priority', $b)) {
                $diff = $b['priority'] - $a['priority'];
                if ($diff == 0) {
                    return strcmp($b['modified'], $a['modified']);
                } else {
                    return $diff > 0;
                }
            } elseif (key_exists('priority', $a)) {
                return -1;
            } elseif (key_exists('priority', $b)) {
                return 1;
            } else {
                return strcmp($a['modified'], $b['modified']);
            }
        });
        $this->set('data', $data);
        $this->set('_serialize', false);
    }

    private function _getPages()
    {
        return [
            [
                'url' => Router::url(['_name' => 'home', '_full' => true]),
                'modified' => date('c'),
                'priority' => 1.0
            ],
            [
                'url' => Router::url(['_name' => 'news', '_full' => true]),
                'modified' => $this->Articles->getLastModified('news')->format('c')
            ],
            [
                'url' => Router::url(['_name' => 'fixtures', '_full' => true]),
                'modified' => $this->Articles->getLastModified('fixtures')->format('c')
            ],
            [
                'url' => Router::url(['_name' => 'fixture_calendar', '_full' => true]),
                'modified' => $this->Articles->getLastModified('fixtures')->format('c')
            ],
            [
                'url' => Router::url(['_name' => 'socials', '_full' => true]),
                'modified' => $this->Articles->getLastModified('socials')->format('c')
            ],
            [
                'url' => Router::url(['_name' => 'training', '_full' => true]),
                'modified' => date('c')
            ],
            [
                'url' => Router::url(['_name' => 'training_comp', '_full' => true]),
                'modified' => date('c')
            ],
            [
                'url' => Router::url(['_name' => 'training_rec', '_full' => true]),
                'modified' => date('c')
            ],
            [
                'url' => Router::url(['_name' => 'training_facilities', '_full' => true]),
                'modified' => date('c')
            ],
            [
                'url' => Router::url(['_name' => 'gallery', '_full' => true]),
                'modified' => date('c')
            ],
            [
                'url' => Router::url(['_name' => 'about', '_full' => true]),
                'modified' => date('c')
            ],
            [
                'url' => Router::url(['_name' => 'contact', '_full' => true]),
                'modified' => date('c')
            ],
            [
                'url' => Router::url(['_name' => 'coaches', '_full' => true]),
                'modified' => date('c')
            ],
            [
                'url' => Router::url(['_name' => 'committee', '_full' => true]),
                'modified' => date('c')
            ],
        ];
    }

    private function _getArticles()
    {
        $articles = $this->Articles->getSitemap();

        $data = array();
        foreach ($articles as $article) {
            $data[] = [
                'url' => Router::url([
                    'controller' => 'news',
                    'action' => 'view',
                    'year' => $article->created->format('Y'),
                    'month' => $article->created->format('m'),
                    'day' => $article->created->format('d'),
                    'slug' => $article->slug,
                    '_full' => true
                ]),
                'modified' => $article->modified->format("c"),
                'priority' => floatval($article->rank)
            ];
        }

        return $data;
    }

    public function robots()
    {
        $this->set('_serialize', false);
        $this->viewBuilder()->setLayout('');
        $this->response->withType('txt');
        $this->render('robots');
    }
}