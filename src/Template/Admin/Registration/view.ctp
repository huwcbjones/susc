<?php

use SUSC\Model\Entity\RegistrationCode;
use SUSC\View\AppView;

/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 */

/**
 * @author huw
 * @since 15/01/2018 16:34
 *
 * @var AppView $this
 * @var RegistrationCode $code
 */

$this->assign('title', 'View: ' . $code->id);
?>
<form class="form-horizontal">
    <div class="form-group">
        <label for="id" class="col-sm-2 control-label">ID</label>
        <div class="col-sm-10">
            <input type="text" name="id" class="form-control" readonly="readonly" value="<?= h($code->id) ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label for="group" class="col-sm-2 control-label">Group</label>
        <div class="col-sm-10">
            <p class="form-control-static"><?php if($this->hasAccessTo('admin.groups.view')): ?>
                    <?= $this->Html->link($code->group->name, ['controller' => 'Groups', 'action' => 'view', $code->group_id]) ?>
                <?php else: ?>
                    <?= $code->group->name ?>
                <?php endif ?></p>
        </div>
    </div>
    <div class="form-group">
        <label for="valid_from" class="col-sm-2 control-label">Valid From</label>
        <div class="col-sm-10">
            <input type="text" name="valid_from" class="form-control" readonly="readonly"
                   value="<?= $this->Time->i18nFormat($code->valid_from, null, null, 'Europe/London') ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label for="valid_to" class="col-sm-2 control-label">Valid To</label>
        <div class="col-sm-10">
            <input type="text" name="valid_to" class="form-control" readonly="readonly"
                   value="<?= $this->Time->i18nFormat($code->valid_to, null, null, 'Europe/London') ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label for="is_active" class="col-sm-2 control-label">Is Active?</label>
        <div class="col-sm-10">
            <p class="form-control-static">
                <?php if ($code->isActive()): ?>
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
                <?php if ($code->enabled): ?>
                    <span class="text-success"><span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;&nbsp;Yes</span>
                <?php else: ?>
                    <span class="text-danger"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;&nbsp;No</span>
                <?php endif; ?>
            </p>
        </div>
    </div>
    <div class="form-group">
        <label for="created" class="col-sm-2 control-label">Created</label>
        <div class="col-sm-10">
            <input type="text" name="created" class="form-control" readonly="readonly"
                   value="<?= $this->Time->i18nFormat($code->created, null, null, 'Europe/London') ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label for="modified" class="col-sm-2 control-label">Last Modified</label>
        <div class="col-sm-10">
            <input type="text" name="modified" class="form-control" readonly="readonly"
                   value="<?= $this->Time->i18nFormat($code->modified, null, null, 'Europe/London') ?>"/>
        </div>
    </div>
</form>

<div class="row">
    <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-0 col-lg-4">
        <?= $this->Html->link('<span class="glyphicon glyphicon-chevron-left"></span> Back', ['action' => 'index'], ['class' => ['btn', 'btn-default', 'btn-block'], 'escape' => false]) ?>
    </div>
    <?php if ($this->hasAccessTo('admin.registration.edit') || $this->hasAccessTo('admin.registration.delete')): ?>
        <div class="col-xs-12 visible-xs-block"><br/></div>
        <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-2 col-lg-4 col-lg-offset-4">
            <?php if ($this->hasAccessTo('admin.registration.edit') && $this->hasAccessTo('admin.registration.delete')): ?>
                <div class="btn-group btn-block">
                    <?= $this->Html->link('Edit <span class="glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $code->id], ['class' => ['btn', 'btn-primary', 'col-sm-10', 'col-md-11'], 'escape' => false]) ?>
                    <a href="#" class="btn btn-primary col-sm-2 col-md-1 dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu btn-block">
                        <li><?= $this->Form->postLink('Delete&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-remove"></span>', ['action' => 'delete', $code->id], ['escape' => false, 'confirm' => __('Are you sure you want to delete {0}?', $code->id)]) ?></li>
                    </ul>
                </div>
            <?php elseif ($this->hasAccessTo('admin.registration.edit')): ?>
                <?= $this->Html->link('Edit <span class="glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $code->id], ['class' => ['btn', 'btn-primary', 'btn-block'], 'escape' => false]) ?>
            <?php else: ?>
                <?= $this->Form->postLink('Delete&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-remove"></span>', ['action' => 'delete', $code->id], ['escape' => false, 'class' => ['btn', 'btn-primary', 'btn-block'], 'confirm' => __('Are you sure you want to delete {0}?', $code->id)]) ?>
            <?php endif; ?>

        </div>
    <?php endif ?>
</div>
