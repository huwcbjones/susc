<?php

use SUSC\Model\Entity\User;

/** @var User $user */

$this->assign('title', 'My Details');
$this->layout('profile');
?>

<?= $this->Form->create($currentUser); ?>
<?= $this->Form->control('first_name') ?>
<?= $this->Form->control('last_name') ?>
<?= $this->Form->control('email_address', ['disabled' => true]) ?>
<?= $this->Form->button('Update Profile', ['class' => 'btn-primary']) ?>
<?= $this->Form->end() ?>
