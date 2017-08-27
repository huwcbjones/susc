<?php

use SUSC\Form\LoginForm;

$this->layout('empty');
$login = new LoginForm();

$this->start('css');
echo $this->fetch('css');
echo $this->Html->css('login');
$this->end();
?>

<?= $this->Form->create($login, ['class' => ['form-login']]) ?>
<div class="form-login-container">
    <h2 class="form-login-heading">Log In</h2>
    <label for="email" class="sr-only">Username/Email Address</label>
    <?= $this->Form->email('email_address', ['class' => ['form-control'], 'placeholder' => 'Email Address', 'autofocus', 'required', 'id' => 'inputEmail']) ?>
    <label for="inputPassword" class="sr-only">Password</label>
    <?= $this->Form->password('password', ['class' => ['form-control'], 'placeholder' => 'Password', 'required', 'id' => 'inputPassword', 'value' => '']) ?>

    <div class="checkbox">
        <label><?= $this->Form->checkbox('remember') ?> Remember me</label>
    </div>
    <?= $this->Flash->render('flash', ['element' => 'Flash/plain_error']) ?>
    <?= $this->Form->button('Log In', ['class' => ['btn', 'btn-lg', 'btn-primary', 'btn-block']]); ?>
</div>
<?= $this->Form->end() ?>
