<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

/**
 * Author: Huw Jones
 * Date: 22/07/18
 * Time: 15:06
 */

namespace SUSC\Controller;


use Cake\Database\Exception;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\ORM\TableRegistry;
use huwcbjones\markdown\GithubMarkdownExtended;
use SUSC\Model\Entity\BunfightSignup;
use SUSC\Model\Table\BunfightSessionsTable;
use SUSC\Model\Table\BunfightSignupsTable;
use SUSC\Model\Table\BunfightsTable;
use SUSC\Model\Table\SquadsTable;

/**
 * Class BunfightController
 * @package SUSC\Controller
 *
 * @property BunfightsTable $Bunfights
 * @property BunfightSessionsTable $BunfightSessions
 * @property BunfightSignupsTable $BunfightSignups
 * @property SquadsTable $Squads;
 */
class BunfightController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Bunfights = TableRegistry::get('Bunfights');
        $this->BunfightSessions = TableRegistry::get('BunfightSessions');
        $this->BunfightSignups = TableRegistry::get('BunfightSignups');
        $this->Squads = TableRegistry::get('Squads');
    }

    public function getACL()
    {
        if ($this->request->getParam('action') == 'index') return 'bunfight.*';
        return parent::getACL();
    }

    public function index()
    {
        try {
            $bunfight_id = $this->Config->get('bunfight.current')['value'];
            if ($bunfight_id === null || trim($bunfight_id) == '') {
                return $this->redirect(['_name' => 'home']);
            }
            $bunfight = $this->Bunfights->get($bunfight_id);
        } catch (Exception $ex) {
            return $this->redirect(['_name' => 'home']);
        }


        $sessions = $this->BunfightSessions->find('bunfight', ['bunfight_id' => $bunfight_id]);
        $squads = $this->Squads->find();

        $signup = $this->BunfightSignups->newEntity();
        if ($this->request->is('POST')) {
            $this->BunfightSignups->patchEntity($signup, $this->request->getData(), ['associated' => ['Squads']]);

            if ($this->BunfightSignups->save($signup, ['associated' => ['Squads']])) {

                $signup = $this->BunfightSignups->find()
                    ->where(['BunfightSignups.id' => $signup->id])
                    ->contain([
                        'Squads' => [
                            'TrainingSessions' => [
                                'sort' => [
                                    'day',
                                    'start'
                                ]
                            ]
                        ],
                        'BunfightSessions'
                    ])->firstOrFail();
                $email = new Email();
                $email
                    ->setTo($signup->email_address, $signup->full_name)
                    ->setSubject('SUSC Taster Session')
                    ->setTemplate('bunfight_signup')
                    ->setViewVars([
                        'signup' => $signup,
                        'content' => $this->_renderHtmlEmail($signup),
                        'plain_content' => $this->_renderPlainEmail($signup),
                    ])
                    ->send();
                $this->Flash->success($this->Config->get('bunfight.confirmation_message')['value'], ['escape' => false]);
                //return $this->redirect($this->request->getUri()->getPath());
            } else {
                $this->Flash->error('There was an issue processing your signup. Please correct any errors and try again.');
            }
        }
        $this->set(compact('bunfight', 'sessions', 'squads', 'signup'));
    }

    protected function _getEmailVariables(BunfightSignup $signup)
    {
        return [
            'session_date' => $signup->bunfight_session->start->i18nFormat('EEEE d MMMM y h:mm a', null, 'Europe/London'),
            'squads_list' => join(', ', $signup->squad_names),
            'squads' => $this->_getSquads($signup)
        ];
    }

    protected function _renderEmail(BunfightSignup $signup, $template)
    {
        $template = $this->Config->get('bunfight.email_template_' . $template)['value'];
        $twig = new \Twig_Environment(new \Twig_Loader_String());
        $template = $twig->createTemplate($template);
        return $template->render($this->_getEmailVariables($signup));
    }

    protected function _renderHtmlEmail(BunfightSignup $signup)
    {
        $content = $this->_renderEmail($signup, 'html');
        $parser = new GithubMarkdownExtended();
        return $parser->parse($content);
    }

    protected function _renderPlainEmail(BunfightSignup $signup)
    {
        return $this->_renderEmail($signup, 'plain');
    }

    protected function _getSquads(BunfightSignup $signup)
    {
        $squads = [];
        foreach ($signup->squads as $s) {
            $sessions = [];
            foreach ($s->training_sessions as $session) {

                $sessions[] = [
                    'day' => $session->dayStr,
                    'start' => $session->start->format('H:i A'),
                    'finish' => $session->finish->format('H:i A'),
                    'location' => $session->location
                ];
            }
            $squads[] = [
                'name' => $s->name,
                'description' => $s->description,
                'sessions' => $sessions
            ];
        }
        return $squads;
    }
}