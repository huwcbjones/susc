<?php
/**
 * @author huw
 * @since 22/01/2018 17:16
 */

namespace SUSC\Shell\Task;


use Bake\Shell\Task\TaskTask;
use Cake\Console\Shell;
use SUSC\Model\Table\SessionsTable;

/**
 * Class CleanExpiredSessionsTask
 * @package SUSC\Shell\Task
 *
 * @property SessionsTable $Sessions
 */
class CleanExpiredSessionsTask extends TaskTask
{
    public function getOptionParser()
    {
        return parent::getOptionParser()->setDescription(
            'Removes expired sessions from the database.'
        );
    }


    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Sessions');
    }

    public function main($name = null)
    {
        $now = new \DateTime();

        $before = $this->Sessions->find()->where([
            'expires <=' => $now
        ])->count();

        $this->Sessions->deleteAll([
            'expires <=' => $now
        ]);

        $after = $this->Sessions->find()->where([
            'expires <=' => $now
        ])->count();

        $this->out(sprintf('Removed %d sessions.', ($before - $after)), 1, Shell::NORMAL);
    }
}