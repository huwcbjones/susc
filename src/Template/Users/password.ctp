<?php

use SUSC\Model\Entity\User;
use SUSC\Form\ChangePasswordForm;

/** @var User $user */

$passwordForm = new ChangePasswordForm();
$this->assign('title', 'Change Password');
$this->layout('profile');
?>

<?= $this->Form->create($user) ?>
<?= $this->Form->control('old_password', ['type' => 'password', 'placeholder' => 'Old Password']) ?>
<?= $this->Form->control('new_password', ['type' => 'password', 'placeholder' => 'New Password']) ?>
<?= $this->Form->control('conf_password', ['type' => 'password', 'label' => 'Confirm Password', 'placeholder' => 'Confirm Password']) ?>
<?= $this->Form->button('Change Password', ['class' => 'btn-primary']) ?>
<?= $this->Form->end() ?>
<br/>