<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

/**
 * Created by PhpStorm.
 * User: huw
 * Date: 28/07/18
 * Time: 14:59
 */

namespace SUSC\Mailer;


use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Mailer\Mailer;
use Cake\ORM\TableRegistry;
use huwcbjones\markdown\GithubMarkdownExtended;
use SUSC\Model\Entity\BunfightSignup;

class BunfightMailer extends Mailer implements EventListenerInterface
{
    public function implementedEvents()
    {
        return [
            'Model.afterSave' => 'onSignup'
        ];
    }

    public function onSignup(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        /** @var BunfightSignup $entity */
        if ($entity->consent_to_emails) {
            $this->send('signup', [$entity]);
        }
    }

    public function signup(BunfightSignup $signup)
    {
        $this
            ->setTo($signup->email_address, $signup->full_name)
            ->setSubject('SUSC Taster Session')
            ->setTemplate('bunfight_signup')
            ->setViewVars([
                'signup' => $signup,
                'content' => $this->_renderHtmlEmail($signup),
                'plain_content' => $this->_renderPlainEmail($signup),
            ]);
    }

    protected function _renderHtmlEmail(BunfightSignup $signup)
    {
        $content = $this->_renderEmail($signup, 'html');
        $parser = new GithubMarkdownExtended();
        return $parser->parse($content);
    }

    protected function _renderEmail(BunfightSignup $signup, $template)
    {
        $config = TableRegistry::getTableLocator()->get('Config');
        $template_name = 'bunfight.email_template_' . $template;
        $template = $config->get($template_name)['value'];
        $twig = new \Twig_Environment(new \Twig_Loader_Array([
            $template_name => $template
        ]));

        return $twig->render($template_name, $this->_getEmailVariables($signup));
    }

    protected function _getEmailVariables(BunfightSignup $signup)
    {
        $vars = [
            'session_date' => null,
            'squads_list' => join(', ', $signup->squad_names),
            'squads' => $this->_getSquads($signup)
        ];
        if ($signup->bunfight_session != null) {
            $vars['session_date'] = $signup->bunfight_session->start->i18nFormat('EEEE d MMMM y h:mm a', null, 'Europe/London');
        }
        return $vars;
    }

    protected function _getSquads(BunfightSignup $signup)
    {
        $squadsTable = TableRegistry::getTableLocator()->get("Squads");
        $squads = [];
        foreach ($signup->squads as $s) {
            $squadsTable->loadInto($s, ['TrainingSessions' => [
                'sort' => [
                    'day',
                    'start'
                ]
            ]]);
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

    protected function _renderPlainEmail(BunfightSignup $signup)
    {
        return $this->_renderEmail($signup, 'plain');
    }
}