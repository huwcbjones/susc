<?php

use SUSC\Form\LoginForm;

$this->layout('empty');
$login = new LoginForm();

$this->start('css');
echo $this->fetch('css');
echo $this->Html->css('form');
$this->end();

$this->assign('title', 'Log In');
?>

<?= $this->Form->create($login, ['class' => ['form-layout']]) ?>
<div class="form-layout-container">
    <h2 class="form-layout-heading">Log In</h2>
    <label for="email_address" class="sr-only">Email Address</label>
    <?= $this->Form->email('email_address', ['class' => ['form-control', 'top'], 'placeholder' => 'Email Address', 'autofocus', 'required', 'id' => 'email_address']) ?>

    <label for="password" class="sr-only">Password</label>
    <?= $this->Form->password('password', ['class' => ['form-control', 'bottom'], 'placeholder' => 'Password', 'required', 'id' => 'password', 'value' => '']) ?>

    <div class="checkbox">
        <label><?= $this->Form->checkbox('remember') ?> Remember me</label>
    </div>
    <?= $this->Flash->render() ?>
    <?= $this->Form->button('Log In', ['class' => ['btn', 'btn-lg', 'btn-primary', 'btn-block']]); ?>
    <div class="row">
        <div class="col-xs-6">
            <p><?= $this->Html->link('Forgot Password', ['_name'=>'reset'], ['class' => ['btn', 'btn-md', 'btn-default', 'btn-block']]) ?></p>
        </div>
        <div class="col-xs-6">
            <p><?= $this->Html->link('Register', ['_name'=>'register'], ['class' => ['btn', 'btn-md', 'btn-default', 'btn-block']]) ?></p>
        </div>
    </div>
    <?= $this->element('form_footer') ?>
</div>
<?= $this->Form->end() ?>
