<?php

use SUSC\Model\Entity\User;

/** @var User $user */

$this->assign('title', 'Change Email Address');
$this->layout('profile');
?>

<?= $this->Form->create($user, ['context' => ['validator' => 'changeEmail']]) ?>
<?= $this->Form->hidden('id', ['value' => $user->id]) ?>
<?= $this->Form->control('password', ['type' => 'password', 'placeholder' => 'Password', 'value'=> '']) ?>
<?= $this->Form->control('new_email', ['type' => 'email', 'placeholder' => 'New Email Address']) ?>
<?= $this->Form->control('conf_email', ['type' => 'email', 'label' => 'Confirm Email Address', 'placeholder' => 'Confirm Email Address']) ?>
<?= $this->Form->button('Change Email Address', ['class' => 'btn-primary']) ?>
<?= $this->Form->end() ?>

