<?php

$this->extend('empty');

$this->start('css');
echo $this->fetch('css');
echo $this->Html->css('admin');
$this->end();



?>

<?= $this->element('header', ['fixedTop' => true]) ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <?= $this->element('Admin/sidebar') ?>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header"><?= h($this->fetch('title')) ?></h1>
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>

            <?= $this->element('footer', ['sponsors' => false]) ?>
        </div>
    </div>
</div>