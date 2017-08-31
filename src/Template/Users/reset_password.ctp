<?php


use Cake\Core\Configure;

$this->layout('empty');

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
    <h2 class="form-login-heading">Reset Password</h2>
    <?= $this->Form->input('new_password', ['type' => 'password', 'value' => '', 'class' => ['form-control'], 'placeholder' => 'New Password', 'autofocus', 'required', 'id' => 'new_password']) ?>

    <?= $this->Form->input('conf_password', ['type' => 'password', 'value' => '', 'class' => ['form-control'], 'placeholder' => 'Confirm Password', 'id' => 'conf_password']) ?>
    <br/>

    <?= $this->Flash->render() ?>
    <?= $this->Form->button('Reset Password', ['class' => ['btn', 'btn-lg', 'btn-primary', 'btn-block', 'g-recaptcha'], 'data-sitekey' => Configure::read('Recaptcha.sitekey'), 'data-callback' => 'submitForm']); ?>
    <div class="row">
        <div class="col-xs-6">
            <p class="text-left"><?= $this->Html->link('Register', ['_name' => 'register'], ['class' => ['btn', 'btn-md', 'btn-default', 'btn-block']]) ?></p>
        </div>
        <div class="col-xs-6">
            <p class="text-right"><?= $this->Html->link('Login', ['_name' => 'login'], ['class' => ['btn', 'btn-md', 'btn-default', 'btn-block']]) ?></p>
        </div>
    </div>
</div>
<script>
    function submitForm() {
        document.getElementById("reset-form").submit();
    }
</script>
<?= $this->Form->end() ?>
