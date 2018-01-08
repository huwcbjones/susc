<?php
$this->extend('clean')
?>
<div class="row">
    <div class="col-xs-12 col-sm-4 col-md-3">
        <span class="hidden-xs"><h1 class="h2">&nbsp;</h1><br/></span>
        <div class="btn-group-vertical btn-block" role="group">
            <?= $this->Html->link('My Details', ['_name' => 'profile'], ['class' => ['btn', 'btn-lg', 'btn-default', 'btn-block']]) ?>
            <?php if($this->hasAccessTo('kit.*')): ?>
            <?= $this->Html->link('My Orders', ['_name' => 'order'], ['class' => ['btn', 'btn-lg', 'btn-default', 'btn-block']]) ?>
            <?php endif; ?>
            <?php if($this->hasAccessTo('membership.*')): ?>
                <?= $this->Html->link('My Membership', ['_name' => 'memberships'], ['class' => ['btn', 'btn-lg', 'btn-default', 'btn-block']]) ?>
            <?php endif; ?>
            <?php if($this->hasAccessTo('users.changepassword')): ?>
            <?= $this->Html->link('Change Password', ['_name' => 'change_password'], ['class' => ['btn', 'btn-lg', 'btn-default', 'btn-block']]) ?>
            <?php endif; ?>
            <?php if($this->hasAccessTo('users.changeemail')): ?>
            <?= $this->Html->link('Change Email', ['_name' => 'change_email'], ['class' => ['btn', 'btn-lg', 'btn-default', 'btn-block']]) ?>
            <?php endif; ?>
            <?= $this->Html->link('Logout', ['_name' => 'logout'], ['class' => ['btn', 'btn-lg', 'btn-default', 'btn-block']]) ?>
        </div>
    </div>
    <div class="col-xs-12 col-sm-8 col-md-9">
        <h1 class="h2"><?= h($this->fetch('title')) ?></h1><br/>
        <?= $this->fetch('content') ?>
    </div>
</div>