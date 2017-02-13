<?php
/**
 * Author: Huw
 * Since: 07/06/2016
 */

namespace SUSC\Controller;


use Cake\ORM\TableRegistry;
use cebe\markdown\GithubMarkdown;

class AboutController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->Committee = TableRegistry::get('committee');
        $this->Coaches = TableRegistry::get('coaches');
        $this->Static = TableRegistry::get('scontent');
    }

    public function club()
    {
        $parser = new GithubMarkdown();
        $this->set('content', $parser->parse($this->Static->find('club')->first()->value));
    }

    public function committee(){
        $this->set('committee', $this->Committee->find('published'));
    }

    public function coaches(){
        $this->set('coaches', $this->Coaches->find('published'));
    }
}