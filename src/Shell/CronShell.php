<?php
/**
 * @author huw
 * @since 22/01/2018 17:20
 */

namespace SUSC\Shell;

use Cake\Console\Shell;
use Cake\Utility\Inflector;

class CronShell extends Shell
{

    /**
     * Tasks to load
     *
     * @var array
     */
    public $tasks = [
        'CleanExpiredSessions'
    ];

    /**
     * Gets the option parser instance and configures it.
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser()
    {
        $parser = parent::getOptionParser();

        $parser->setDescription('Cron Shell perform various tasks related to Cron jobs.')
            ->addSubcommand('all', [
                'help' => 'Run all Cron jobs.',
            ]);

        foreach ($this->_taskMap as $task => $config) {
            $taskParser = $this->{$task}->getOptionParser();
            $parser->addSubcommand(Inflector::underscore($task), [
                'help' => $taskParser->getDescription(),
                'parser' => $taskParser
            ]);
        }

        return $parser;
    }

    public function all()
    {
        foreach ($this->_taskMap as $task => $config) {
            $this->{$task}->main();
        }
    }
}