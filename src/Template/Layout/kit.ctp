<?php
/**
 * Copyright (c) Southampton University Swimming Club (SUSC)
 *
 *
 * @copyright     Copyright (c) Southampton University Swimming Club (SUSC)
 */

$this->extend('/Layout/clean');
$this->element('Kit/basket');

?>
<?= $this->element('Kit/breadcrumb') ?>
<div class="page-header"><h1><?= $this->fetch('title') ?></h1></div>

<div class="row">
    <div class="col-sm-8">
        <?= $this->fetch('content') ?>
    </div>
    <div class="col-sm-4">
        <h2 class="h3"><?= $this->Html->link('My Basket', ['_name' => 'basket']) ?></h2>
        <hr/>
        <?= $this->fetch('basket', $basketData) ?>
    </div>
</div>

