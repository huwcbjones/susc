<?php

use SUSC\Model\Entity\User;

/** @var User $user */

$this->assign('title', 'Change Password');
$this->layout('profile');
?>

<?= $this->Form->create($user) ?>
<?= $this->Form->control('old_password', ['type' => 'password', 'placeholder' => 'Old Password', 'value' => '']) ?>
<?= $this->Form->control('new_password', ['type' => 'password', 'placeholder' => 'New Password', 'value' => '']) ?>
<?= $this->Form->control('conf_password', ['type' => 'password', 'label' => 'Confirm Password', 'placeholder' => 'Confirm Password', 'value' => '']) ?>
<?= $this->Form->button('Change Password', ['class' => 'btn-primary']) ?>
<?= $this->Form->end() ?>