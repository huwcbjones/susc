<?php
/**
 * Copyright 2010 - 2015, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2015, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

use Cake\Core\Configure;

$this->assign('title', 'Login');
$this->start('css');
echo $this->fetch('css');
echo $this->Html->css('bootstrap-social');
$this->end();

?>
<?= $this->Flash->render('auth') ?>
<div class="row">
    <div class="col-sm-12 col-md-10 col-lg-8 col-lg-offset-2 col-md-offset-1">
        <div class="users form">
            <?= $this->Form->create() ?>
            <fieldset>
                <?= $this->Form->input('username', ['required' => true, 'placeholder' => 'Username']) ?>
                <?= $this->Form->input('password', ['required' => true, 'placeholder' => 'Password']) ?>
                <?php
                if (Configure::read('Users.reCaptcha.login')) {
                    echo $this->User->addReCaptcha();
                }
                if (Configure::check('Users.RememberMe.active')) {
                    echo $this->Form->input(Configure::read('Users.Key.Data.rememberMe'), [
                        'type' => 'checkbox',
                        'label' => __d('Users', 'Remember me'),
                        'checked' => 'checked'
                    ]);
                }
                ?>
                <div class="form-group">
                    <?= $this->Form->button(__d('Users', 'Login'), ['class' => ['btn', 'btn-primary', 'btn-block']]); ?>
                </div>
                <?php
                $registrationActive = Configure::read('Users.Registration.active');
                $resetActive = Configure::read('Users.Email.required');
                $enablePanel = $registrationActive || $resetActive;
                ?>
                <?php if ($enablePanel): ?>
                <div class="form-group">
                        <div class="row">
                        <?php if ($registrationActive && !$resetActive) { ?>
                            <div class="col-sm-12">
                        <?php } else { ?>
                            <div class="col-sm-6">
                        <?php } ?>
                            <?= $this->Html->Link(__d('users', 'Register'), ['action' => 'register'],['class' => ['btn', 'btn-default', 'btn-block']]); ?>
                            </div>

                        <?php if (!$registrationActive && $resetActive) { ?>
                            <div class="col-sm-12">
                        <?php } else { ?>
                            <div class="col-sm-6">
                        <?php } ?>
                            <?= $this->Html->Link(__d('users', 'Reset Password'), ['action' => 'requestResetPassword'], ['class' => ['btn', 'btn-default', 'btn-block']]); ?>
                            </div>
                        </div>
                </div>
                    <?php endif; ?>
                    <?= implode(' ', $this->User->socialLoginList()); ?>
            </fieldset>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
