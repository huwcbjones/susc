<?php

use SUSC\Form\ActivateForm;

$this->layout('empty');
$activationForm = new ActivateForm();

$this->start('css');
echo $this->fetch('css');
echo $this->Html->css('login');
$this->end();

$this->assign('title', 'Activate Account');
?>

<?= $this->Form->create($activationForm, ['class' => ['form-login']]) ?>
<div class="form-login-container">
    <h2 class="form-login-heading">Activate Account</h2>
    <label for="activation_code" class="sr-only">Activation Code</label>
    <?= $this->Form->text('activation_code', ['class' => ['form-control'], 'placeholder' => 'Activation Code', 'autofocus', 'required', 'id' => 'activation_code', 'value' => $activationCode]) ?><br />

    <?= $this->Flash->render() ?>
    <?= $this->Form->button('Activate Account', ['class' => ['btn', 'btn-lg', 'btn-primary', 'btn-block']]); ?>
    <div class="row">
        <div class="col-xs-6">
            <p class="text-left"><?= $this->Html->link('Register', ['_name'=>'register'], ['class' => ['btn', 'btn-md', 'btn-default', 'btn-block']]) ?></p>
        </div>
        <div class="col-xs-6">
            <p class="text-right"><?= $this->Html->link('Login', ['_name'=>'login'], ['class' => ['btn', 'btn-md', 'btn-default', 'btn-block']]) ?></p>
        </div>
    </div>
</div>
<?= $this->Form->end() ?>
