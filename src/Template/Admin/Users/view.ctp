<?php
/**
 * @var \SUSC\View\AppView $this
 * @var \SUSC\Model\Entity\User $user
 */

$this->assign('title', 'View User: ' . $user->full_name);
?>
<h2><?= __('Details') ?></h2>
<form class="form-horizontal">
    <div class="form-group">
        <label for="id" class="col-sm-2 control-label">ID</label>
        <div class="col-sm-10">
            <input type="text" name="id" class="form-control" readonly="readonly" value="<?= h($user->id) ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label for="email_address" class="col-sm-2 control-label">Email Address</label>
        <div class="col-sm-10">
            <input type="email" name="email_address" class="form-control" readonly="readonly"
                   value="<?= h($user->email_address) ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label for="first_name" class="col-sm-2 control-label">First Name</label>
        <div class="col-sm-10">
            <input type="text" name="first_name" class="form-control" readonly="readonly"
                   value="<?= h($user->first_name) ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label for="last_name" class="col-sm-2 control-label">Surname</label>
        <div class="col-sm-10">
            <input type="text" name="last_name" class="form-control" readonly="readonly"
                   value="<?= h($user->last_name) ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label for="group" class="col-sm-2 control-label">Group</label>
        <div class="col-sm-10">
            <p class="form-control-static"><?= $user->has('group') ? $this->Html->link($user->group->name, ['controller' => 'Groups', 'action' => 'view', $user->group->id]) : '' ?></p>
        </div>
    </div>
    <div class="form-group">
        <label for="is_active" class="col-sm-2 control-label">Is Activated?</label>
        <div class="col-sm-10">
            <p class="form-control-static">
                <?php if ($user->isActive()): ?>
                    <span class="text-success"><span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;&nbsp;Yes</span>
                <?php else: ?>
                    <span class="text-danger"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;&nbsp;No</span>
                <?php endif; ?>
            </p>
        </div>
    </div>
    <div class="form-group">
        <label for="is_enabled" class="col-sm-2 control-label">Is Enabled?</label>
        <div class="col-sm-10">
            <p class="form-control-static">
                <?php if ($user->isEnabled()): ?>
                    <span class="text-success"><span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;&nbsp;Yes</span>
                <?php else: ?>
                    <span class="text-danger"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;&nbsp;No</span>
                <?php endif; ?>
            </p>
        </div>
    </div>
    <div class="form-group">
        <label for="is_change_password" class="col-sm-2 control-label">Must Change Password?</label>
        <div class="col-sm-10">
            <p class="form-control-static">
                <?php if ($user->isChangePassword()): ?>
                    <span class="text-success"><span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;&nbsp;Yes</span>
                <?php else: ?>
                    <span class="text-danger"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;&nbsp;No</span>
                <?php endif; ?>
            </p>
        </div>
    </div>

    <div class="form-group">
        <label for="created" class="col-sm-2 control-label">Account Created</label>
        <div class="col-sm-10">
            <input type="text" name="created" class="form-control" readonly="readonly"
                   value="<?= $this->Time->i18nFormat($user->created, null, null, 'Europe/London') ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label for="modified" class="col-sm-2 control-label">Account Last Modified</label>
        <div class="col-sm-10">
            <input type="text" name="modified" class="form-control" readonly="readonly"
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
        <?= $this->element('Admin/ACL', ['acls' => $user->acls, 'all_acls' => $all_acls, 'disabled' => true]) ?>
    </div>

</form>

<div class="row">
    <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-0 col-lg-4">
        <?= $this->Html->link('<span class="glyphicon glyphicon-chevron-left"></span> Back', ['action' => 'index'], ['class' => ['btn', 'btn-default', 'btn-block'], 'escape' => false]) ?>
    </div>
    <?php if ($this->hasAccessTo('admin.users.edit') || $this->hasAccessTo('admin.users.delete')): ?>
        <div class="col-xs-12 visible-xs-block"><br/></div>
        <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-2 col-lg-4 col-lg-offset-4">
            <?php if ($this->hasAccessTo('admin.users.edit') && $this->hasAccessTo('admin.users.delete')): ?>
                <div class="btn-group btn-block">
                    <?= $this->Html->link('Edit <span class="glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $user->id], ['class' => ['btn', 'btn-primary', 'col-sm-10', 'col-md-11'], 'escape' => false]) ?>
                    <a href="#" class="btn btn-primary col-sm-2 col-md-1 dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu btn-block">
                        <li><?= $this->Form->postLink('Delete&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-remove"></span>', ['action' => 'delete', $user->id], ['escape' => false, 'confirm' => __('Are you sure you want to delete {0}?', $user->full_name)]) ?></li>
                    </ul>
                </div>
            <?php elseif ($this->hasAccessTo('admin.users.edit')): ?>
                <?= $this->Html->link('Edit <span class="glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $user->id], ['class' => ['btn', 'btn-primary', 'btn-block'], 'escape' => false]) ?>
            <?php else: ?>
                <?= $this->Form->postLink('Delete&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-remove"></span>', ['action' => 'delete', $user->id], ['escape' => false, 'class' => ['btn', 'btn-primary', 'btn-block'], 'confirm' => __('Are you sure you want to delete {0}?', $user->full_name)]) ?>
            <?php endif; ?>

        </div>
    <?php endif ?>
</div>
