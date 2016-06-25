<?php
/**
 * Copyright (c) Southampton University Swimming Club (SUSC)
 *
 *
 * @copyright     Copyright (c) Southampton University Swimming Club (SUSC)
 */

$this->extend('/Layout/clean');
?>
    <div id="page-header"><h1><?= $this->fetch('title') ?></h1></div>
<?= $this->fetch('content') ?>