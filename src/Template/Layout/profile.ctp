<?php
$this->extend('clean')
?>
<div class="col-xs-12 col-md-3">
    <div class="row">
        <h1 class="h2">Tasks</h1><br />
        <div class="btn-group-vertical btn-block" role="group">
            <?= $this->Html->link('My Details', ['_name' => 'profile'], ['class' => ['btn', 'btn-lg', 'btn-default', 'btn-block']]) ?>
            <?= $this->Html->link('Change Password', ['_name' => 'change_password'], ['class' => ['btn', 'btn-lg', 'btn-default', 'btn-block']]) ?>
            <?= $this->Html->link('Change Email', ['_name' => 'change_email'], ['class' => ['btn', 'btn-lg', 'btn-default', 'btn-block']]) ?>
        </div>
    </div>
</div>
<div class="col-xs-12 col-md-8">
    <div class="row">
        <h1 class="h2"><?= h($this->fetch('title')) ?></h1><br />
        <?= $this->fetch('content') ?>
    </div>
</div>