<?php

use Cake\Core\Configure;
use Cake\Error\Debugger;

$this->layout = 'error';
/** @var ErrorException $error */
$this->assign('title', $message);
if (Configure::read('debug')):
    $this->layout = 'dev_error';


    $this->assign('templateName', 'error400.ctp');

    $this->start('file');
    ?>
    <?php if (!empty($error->queryString)) : ?>
    <p class="notice">
        <strong>SQL Query: </strong>
        <?= h($error->queryString) ?>
    </p>
<?php endif; ?>
    <?php if (!empty($error->params)) : ?>
    <strong>SQL Query Params: </strong>
    <?php Debugger::dump($error->params) ?>
<?php endif; ?>
    <?= $this->element('auto_table_warning') ?>
    <?php
    if (extension_loaded('xdebug')):
        xdebug_print_function_stack();
    endif;

    $this->end();
endif;
?>
<?php if ($error->getCode() == 404) : ?>
    <p class="error">
        <strong><?= __d('cake', 'Error') ?>: </strong>
        <?= sprintf(
            __d('cake', 'The requested address %s was not found on this server.'),
            "<strong>'{$url}'</strong>"
        ) ?>
    </p>
<?php endif ?>
