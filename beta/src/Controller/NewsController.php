<?php
/**
 * Author: Huw
 * Since: 07/06/2016
 */

namespace SUSC\Controller;
use Cake\ORM\TableRegistry;

/**
 * News Controller
 *
 * @property \SUSC\Model\Table\NewsTable $News
 */
class NewsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow();
        $this->News = TableRegistry::get('News');
    }

    public function index()
    {
        $this->paginate = [
            'contain' => ['news']
        ];
        $news = $this->paginate($this->News);

        $this->set(compact('news'));
        $this->set('_serialize', ['news']);
    }

    public function view($fixtureID)
    {
    }
}