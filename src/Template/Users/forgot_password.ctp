<?php


use Cake\Core\Configure;
use SUSC\Form\ResetForm;

$this->layout('empty');
$resetForm = new ResetForm();

$this->start('css');
echo $this->fetch('css');
echo $this->Html->css('login');
$this->end();

$this->start('script');
echo $this->fetch('script');
echo '<script src=\'https://www.google.com/recaptcha/api.js\'></script>';
$this->end();

$this->assign('title', 'Reset Password');
?>

<?= $this->Form->create($resetForm, ['class' => ['form-login'], 'id' => 'reset-form']) ?>
<div class="form-login-container">
    <h2 class="form-login-heading">Forgotten Password</h2>
    <label for="activation_code" class="sr-only">Email Address</label>
    <?= $this->Form->email('email_address', ['class' => ['form-control'], 'placeholder' => 'Email Address', 'autofocus', 'required', 'id' => 'activation_code']) ?><br />

    <?= $this->Flash->render() ?>
    <?= $this->Form->button('Reset Password', ['class' => ['btn', 'btn-lg', 'btn-primary', 'btn-block', 'g-recaptcha'], 'data-sitekey' => Configure::read('Recaptcha.sitekey'), 'data-callback' => 'submitForm']); ?>
    <div class="row">
        <div class="col-xs-6">
            <p class="text-left"><?= $this->Html->link('Register', ['_name'=>'register'], ['class' => ['btn', 'btn-md', 'btn-default', 'btn-block']]) ?></p>
        </div>
        <div class="col-xs-6">
            <p class="text-right"><?= $this->Html->link('Login', ['_name'=>'login'], ['class' => ['btn', 'btn-md', 'btn-default', 'btn-block']]) ?></p>
        </div>
    </div>
    <?= $this->element('form_footer') ?>
</div>
<script>
    function submitForm() {
        document.getElementById("reset-form").submit();
    }
</script>
<?= $this->Form->end() ?>
