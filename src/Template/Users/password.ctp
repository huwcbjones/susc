<?php

use SUSC\Model\Entity\User;

/** @var User $user */

$this->assign('title', 'Change Password');
$this->layout('profile');
?>

<?= $this->Form->create($user) ?>
<?= $this->Form->hidden('id', ['value' => $user->id]) ?>
<?= $this->Form->control('old_password') ?>
<?= $this->Form->control('password') ?>
<?= $this->Form->control('confirm_password') ?>
<?= $this->Form->end() ?>
<br/>