<?php
/**
 * @var \SUSC\View\AppView $this
 * @var \SUSC\Model\Entity\User $user
 */

$this->assign('title', 'Edit User: ' . $user->full_name);
$this->Form->unlockField('is_enable');
$this->Form->unlockField('is_active');
$this->Form->unlockField('is_change_password');
?>
    <h2><?= __('Details') ?></h2>
<?= $this->Form->create($user, ['class' => ['form-horizontal']]) ?>
    <div class="form-group">
        <label for="id" class="col-sm-2 control-label">ID</label>
        <div class="col-sm-10">
            <input type="text" name="id" class="form-control" disabled="disabled" value="<?= h($user->id) ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label for="email_address" class="col-sm-2 control-label">Email Address</label>
        <div class="col-sm-10">
            <?= $this->Form->email('email_address'); ?>
        </div>
    </div>
    <div class="form-group">
        <label for="first_name" class="col-sm-2 control-label">First Name</label>
        <div class="col-sm-10">
            <?= $this->Form->text('first_name'); ?>
        </div>
    </div>
    <div class="form-group">
        <label for="last_name" class="col-sm-2 control-label">Surname</label>
        <div class="col-sm-10">
            <?= $this->Form->text('last_name'); ?>
        </div>
    </div>
    <div class="form-group">
        <label for="group" class="col-sm-2 control-label">Group</label>
        <div class="col-sm-10">
            <?= $this->Form->select('group_id', $groups); ?>
        </div>
    </div>
    <div class="form-group">
        <label for="is_enable" class="col-sm-2 control-label">Is Activated?</label>
        <div class="col-sm-10">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-<?php if ($user->isActivated()): ?>success active<?php else: ?>default<?php endif ?>" id="btn-isActiveY">
                    <input type="radio" name="is_active" id="isActivatedY" value="1"<?php if ($user->isActivated()): ?> checked="checked"<?php endif ?> /> Yes
                </label>
                <label class="btn btn-<?php if (!$user->isActivated()): ?>danger active<?php else: ?>default<?php endif ?>" id="btn-isActiveN">
                    <input type="radio" name="is_active" id="isActivatedN" value="0"<?php if (!$user->isActivated()): ?> checked="checked"<?php endif ?> /> No
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="is_enabled" class="col-sm-2 control-label">Is Enabled?</label>
        <div class="col-sm-10">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-<?php if ($user->isEnabled()): ?>success active<?php else: ?>default<?php endif ?>" id="btn-isEnableY">
                    <input type="radio" name="is_enable" id="isEnabledY" value="1"<?php if ($user->isEnabled()): ?> checked="checked"<?php endif ?> /> Yes
                </label>
                <label class="btn btn-<?php if (!$user->isEnabled()): ?>danger active<?php else: ?>default<?php endif ?>" id="btn-isEnableN">
                    <input type="radio" name="is_enable" id="isEnabledN" value="0"<?php if (!$user->isEnabled()): ?> checked="checked"<?php endif ?> /> No
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="is_change_password" class="col-sm-2 control-label">Must Change Password?</label>
        <div class="col-sm-10">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-<?php if ($user->isChangePassword()): ?>success active<?php else: ?>default<?php endif ?>" id="btn-isChangePasswordY">
                    <input type="radio" name="is_change_password" id="isChangePasswordY"
                           value="1"<?php if ($user->isChangePassword()): ?> checked="checked"<?php endif ?> /> Yes
                </label>
                <label class="btn btn-<?php if (!$user->isChangePassword()): ?>danger active<?php else: ?>default<?php endif ?>" id="btn-isChangePasswordN">
                    <input type="radio" name="is_change_password" id="isChangePasswordN"
                           value="0"<?php if (!$user->isChangePassword()): ?> checked="checked"<?php endif ?> /> No
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="created" class="col-sm-2 control-label">Account Created</label>
        <div class="col-sm-10">
            <input type="text" name="created" class="form-control" disabled="disabled"
                   value="<?= $this->Time->i18nFormat($user->created, null, null, 'Europe/London') ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label for="modified" class="col-sm-2 control-label">Account Last Modified</label>
        <div class="col-sm-10">
            <input type="text" name="modified" class="form-control" disabled="disabled"
                   value="<?= $this->Time->i18nFormat($user->modified, null, null, 'Europe/London') ?>"/>
        </div>
    </div>

    <div class="form-group">
        <label for="is_forgot_password" class="col-sm-2 control-label">Has Forgotten Password?</label>
        <div class="col-sm-10">
            <p class="form-control-static">
                <?php if ($user->isResettingPassword()): ?>
                    <span class="text-success"><span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;&nbsp;Yes</span>
                    <?php if (!$user->isResetPasswordValid()): ?>
                        &nbsp;&nbsp;&nbsp;&mdash;&nbsp;&nbsp;&nbsp;<span class="text-danger"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;&nbsp;Code has expired</span>
                    <?php endif; ?>
                <?php else: ?>
                    <span class="text-danger"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;&nbsp;No</span>
                <?php endif; ?>
            </p>
        </div>
    </div>
    <div class="form-group">
        <label for="is_forgot_password" class="col-sm-2 control-label">Is Changing Email?</label>
        <div class="col-sm-10">
            <p class="form-control-static">
                <?php if ($user->isChangingEmail()): ?>
                    <span class="text-success"><span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;&nbsp;Yes</span>
                    <?php if (!$user->isChangeEmailValid()): ?>
                        &nbsp;&nbsp;&nbsp;&mdash;&nbsp;&nbsp;&nbsp;<span class="text-danger"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;&nbsp;Code has expired</span>
                    <?php endif; ?>
                <?php else: ?>
                    <span class="text-danger"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;&nbsp;No</span>
                <?php endif; ?>
            </p>
        </div>
    </div>
    <div class="related">
        <h2><?= __('Access Control Objects') ?></h2>
        <?= $this->element('Admin/ACL', ['acls' => $user->acls, 'all_acls' => $all_acls, 'Form' => $this->Form, 'disabled' => false]) ?>
    </div>

    <div class="row">
        <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-0 col-lg-4">
            <?= $this->Html->link('<span class="glyphicon glyphicon-chevron-left"></span> Cancel', ['action' => 'view', $user->id], ['class' => ['btn', 'btn-default', 'btn-block'], 'escape' => false]) ?>
        </div>
        <div class="col-xs-12 visible-xs-block"><br/></div>
        <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-2 col-lg-4 col-lg-offset-4">
            <?= $this->Form->button('Save <span class="glyphicon glyphicon-floppy-disk"></span>', ['type' => 'submit', 'class' => ['btn', 'btn-primary', 'btn-block'], 'escape' => false]); ?>
        </div>
    </div>
<?= $this->Form->end() ?>
<?php
$this->start('postscript');
echo $this->fetch('postscript');
?>
    <script type="text/javascript">
        $("#btn-isActiveY").click(function () {
            $("#btn-isActiveY").addClass("btn-success").removeClass("btn-default");
            $("#btn-isActiveN").addClass("btn-default").removeClass("btn-danger");
        });
        $("#btn-isActiveN").click(function () {
            $("#btn-isActiveY").addClass("btn-default").removeClass("btn-success");
            $("#btn-isActiveN").addClass("btn-danger").removeClass("btn-default");
        });
        $("#btn-isEnableY").click(function () {
            $("#btn-isEnableY").addClass("btn-success").removeClass("btn-default");
            $("#btn-isEnableN").addClass("btn-default").removeClass("btn-danger");
        });
        $("#btn-isEnableN").click(function () {
            $("#btn-isEnableY").addClass("btn-default").removeClass("btn-success");
            $("#btn-isEnableN").addClass("btn-danger").removeClass("btn-default");
        });
        $("#btn-isChangePasswordY").click(function () {
            $("#btn-isChangePasswordY").addClass("btn-success").removeClass("btn-default");
            $("#btn-isChangePasswordN").addClass("btn-default").removeClass("btn-danger");
        });
        $("#btn-isChangePasswordN").click(function () {
            $("#btn-isChangePasswordY").addClass("btn-default").removeClass("btn-success");
            $("#btn-isChangePasswordN").addClass("btn-danger").removeClass("btn-default");
        });
    </script>
<?php $this->end() ?>