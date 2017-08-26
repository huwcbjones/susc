<?php

use SUSC\Model\Entity\User;

/** @var User $user */

$this->assign('title', 'Change Email Address');
$this->layout('profile');
?>

<?= $this->Form->create($user) ?>
<?= $this->Form->hidden('id', ['value' => $user->id]) ?>
<?= $this->Form->control('password') ?>
<?= $this->Form->control('new_email_address') ?>
<?= $this->Form->end() ?>

