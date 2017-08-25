<?php
/**
 * Copyright (c) Southampton University Swimming Club (SUSC)
 *
 *
 * @copyright     Copyright (c) Southampton University Swimming Club (SUSC)
 */

use Cake\Routing\Router;

$this->extend('/Layout/clean');

$currentUrl = Router::normalize($this->request->here);
$links = array();
$links['kit'] = $currentUrl === Router::url(['_name' => 'kit']);
$links['basket'] = $currentUrl === Router::url(['_name' => 'basket']);
$links['item'] = $currentUrl === Router::url(['_name' => 'kit_item', 'slug'=> $this->request->slug]);
?>
    <ol class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li<?= $links['kit'] ? ' class="active"' : '' ?>><?= $links['kit'] ? 'Kit' : $this->Html->link('Kit', ['_name' => 'kit']) ?></li>
        <?php if ($links['item']) : ?>
            <li class="active"><?= $this->fetch('title') ?></li>
        <?php endif ?>
    </ol>
    <div class="page-header"><h1><?= $this->fetch('title') ?></h1></div>

    <div class="row">
        <div class="col-sm-8">
            <?= $this->fetch('content') ?>
        </div>
        <?= $this->fetch('basket', $basketData) ?>
    </div>

