<?php
/**
 * Author: Huw
 * Since: 07/06/2016
 */

namespace SUSC\Controller;


use Cake\Controller\Component\AuthComponent;
use Cake\ORM\TableRegistry;
use huwcbjones\markdown\GithubMarkdownExtended;
use SUSC\Model\Entity\StaticContent;
use SUSC\Model\Table\CoachesTable;
use SUSC\Model\Table\CommitteeTable;
use SUSC\Model\Table\StaticContentTable;

/**
 * Class AboutController
 * @package SUSC\Controller
 *
 * @property StaticContentTable $Static
 * @property CommitteeTable $Committee
 * @property CoachesTable $Coaches
 * @property AuthComponent $Auth
 */
class AboutController extends AppController
{

    public function initialize()
    {
        parent::initialize();

        // Get table instances
        $this->Static = TableRegistry::get('StaticContent');
        $this->Committee = TableRegistry::get('committee');
        $this->Coaches = TableRegistry::get('coaches');

        // Set Auth
        $this->Auth->allow();
    }

    public function contact()
    {
        $parser = new GithubMarkdownExtended();

        /** @var StaticContent $content */
        $content = $this->Static->find('contact')->first();
        $this->set('content', $parser->parse($content->value));
    }

    public function club()
    {
        $parser = new GithubMarkdownExtended();

        /** @var StaticContent $content */
        $content = $this->Static->find('club')->first();
        $this->set('content', $parser->parse($content->value));
    }

    public function committee()
    {
        $this->set('committee', $this->Committee->find('published')->order(['display_order' => 'ASC']));
    }

    public function coaches()
    {
        $this->set('coaches', $this->Coaches->find('published')->order(['display_order' => 'ASC']));
    }
}