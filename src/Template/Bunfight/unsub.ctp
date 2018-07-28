<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

use SUSC\Form\EmailForm;
use SUSC\Model\Entity\Bunfight;
use SUSC\Model\Entity\BunfightSession;
use SUSC\Model\Entity\BunfightSignup;

/**
 * @var \SUSC\View\AppView $this
 * @var Bunfight $bunfight
 * @var BunfightSession[] $sessions
 * @var BunfightSignup $signup
 */

$this->layout('empty');
$this->assign('title', 'Unsubscribe');
$emailForm = new EmailForm();

$this->start('css');
echo $this->fetch('css');
echo $this->Html->css('form');
$this->end();
?>

<?= $this->Form->create($emailForm, ['class' => ['form-layout']]) ?>
<div class="form-layout-container">
    <h2 class="form-layout-heading">Unsubscribe</h2>
    <label for="email_address" class="sr-only">Email Address</label>
    <?= $this->Form->text('email_address', ['class' => ['form-control'], 'placeholder' => 'Email Address', 'autofocus', 'required', 'id' => 'email_address', 'value' => $email_address]) ?><br />

    <?= $this->Flash->render() ?>
    <?= $this->Form->button('Unsubscribe', ['class' => ['btn', 'btn-lg', 'btn-warning', 'btn-block']]); ?>
    <?= $this->element('form_footer') ?>
</div>
<?= $this->Form->end() ?>
