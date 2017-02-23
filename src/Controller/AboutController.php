<?php
/**
 * Author: Huw
 * Since: 07/06/2016
 */

namespace SUSC\Controller;


use Cake\ORM\TableRegistry;
use huwcbjones\markdown\GithubMarkdownExtended;

class AboutController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        require_once(ROOT .DS. "vendor" . DS  . "huwcbjones" . DS . "markdown" . DS . "GithubMarkdownExtended.php");
        $this->Committee = TableRegistry::get('committee');
        $this->Coaches = TableRegistry::get('coaches');
        $this->Static = TableRegistry::get('scontent');
    }

    public function contact()
    {
        $parser = new GithubMarkdownExtended();
        $this->set('content', $parser->parse($this->Static->find('contact')->first()->value));
    }

    public function club()
    {
        $parser = new GithubMarkdownExtended();
        $this->set('content', $parser->parse($this->Static->find('club')->first()->value));
    }

    public function committee(){
        $this->set('committee', $this->Committee->find('published')->order(['display_order' => 'ASC']));
    }

    public function coaches(){
        $this->set('coaches', $this->Coaches->find('published')->order(['display_order' => 'ASC']));
    }
}