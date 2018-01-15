<?php
/**
 * @var \Cake\View\View $this
 */

use Cake\Core\Configure;
use SUSC\Form\RegisterForm;

$this->setLayout('empty');
$register = new RegisterForm();

$this->start('css');
echo $this->fetch('css');
echo $this->Html->css('form');
$this->end();

$this->start('script');
echo $this->fetch('script');
echo '<script src=\'https://www.google.com/recaptcha/api.js\'></script>';
$this->end();

$this->assign('title', 'Register');

$this->Form->unlockField('g-recaptcha-response');
?>

<?= $this->Form->create($register, ['class' => ['form-layout'], 'id' => 'registration-form']) ?>
<div class="form-layout-container">
    <h2 class="form-layout-heading">Register</h2>
    <?= $this->Form->control('first_name', ['class' => ['form-control'], 'placeholder' => 'First Name', 'autofocus', 'required', 'id' => 'first_name']) ?>

    <?= $this->Form->control('last_name', ['class' => ['form-control'], 'placeholder' => 'Surname', 'required', 'id' => 'last_name']) ?>

    <?= $this->Form->control('email_address', ['class' => ['form-control'], 'placeholder' => 'Email Address', 'required', 'id' => 'email_address']) ?>

    <?= $this->Form->control('password', ['class' => ['form-control', 'middle'], 'placeholder' => 'Password', 'required', 'id' => 'password', 'value' => '']) ?>
    <?php if ($requiresCode): ?>
        <?= $this->Form->control('registration_code', ['class' => ['form-control', 'bottom'], 'placeholder' => 'Registration Code', 'id' => 'registration_code', 'value' => $registrationCode]) ?>
    <?php endif; ?>

    <?= $this->Flash->render() ?>
    <?= $this->Form->button('Register', ['class' => ['btn', 'btn-lg', 'btn-primary', 'btn-block', 'g-recaptcha'], 'data-sitekey' => Configure::read('Recaptcha.sitekey'), 'data-callback' => 'submitForm']); ?>
    <div class="row">
        <div class="col-xs-6">
            <p><?= $this->Html->link('Forgot Password', ['_name' => 'reset'], ['class' => ['btn', 'btn-md', 'btn-default', 'btn-block']]) ?></p>
        </div>
        <div class="col-xs-6">
            <p><?= $this->Html->link('Log In', ['_name' => 'login'], ['class' => ['btn', 'btn-md', 'btn-default', 'btn-block']]) ?></p>
        </div>
    </div>
    <?= $this->element('form_footer') ?>
</div>
<script>
    function submitForm() {
        document.getElementById("registration-form").submit();
    }
</script>
<?= $this->Form->end() ?>
