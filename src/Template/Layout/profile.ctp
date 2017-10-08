<?php
$this->extend('clean')
?>
<div class="row">
    <div class="col-xs-12 col-md-3">
        <h1 class="h2">&nbsp;</h1><br/>
        <div class="btn-group-vertical btn-block" role="group">
            <?= $this->Html->link('My Details', ['_name' => 'profile'], ['class' => ['btn', 'btn-lg', 'btn-default', 'btn-block']]) ?>
            <?php if($currentUser->isAuthorised('kit.*')): ?>
            <?= $this->Html->link('My Orders', ['_name' => 'order'], ['class' => ['btn', 'btn-lg', 'btn-default', 'btn-block']]) ?>
            <?php endif; ?>
            <?php if($currentUser->isAuthorised('membership.*')): ?>
                <?= $this->Html->link('My Membership', ['_name' => 'memberships'], ['class' => ['btn', 'btn-lg', 'btn-default', 'btn-block']]) ?>
            <?php endif; ?>
            <?php if($currentUser->isAuthorised('users.changepassword')): ?>
            <?= $this->Html->link('Change Password', ['_name' => 'change_password'], ['class' => ['btn', 'btn-lg', 'btn-default', 'btn-block']]) ?>
            <?php endif; ?>
            <?php if($currentUser->isAuthorised('users.changeemail')): ?>
            <?= $this->Html->link('Change Email', ['_name' => 'change_email'], ['class' => ['btn', 'btn-lg', 'btn-default', 'btn-block']]) ?>
            <?php endif; ?>
            <?= $this->Html->link('Logout', ['_name' => 'logout'], ['class' => ['btn', 'btn-lg', 'btn-default', 'btn-block']]) ?>
        </div>
    </div>
    <div class="col-xs-12 col-md-9">
        <h1 class="h2"><?= h($this->fetch('title')) ?></h1><br/>
        <?= $this->fetch('content') ?>
    </div>
</div>