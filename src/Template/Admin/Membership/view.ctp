<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 */

use SUSC\Model\Entity\MembershipType;
use SUSC\View\AppView;

/**
 * Author: Huw
 * Since: 07/10/2017
 * @var AppView $this
 * @var MembershipType $item
 */

$this->assign('title', 'View Membership: ' . $item->title);
$this->start('css');
echo $this->fetch('css');
?>
<style>
    .panel {
        margin-bottom: 0;
    }
</style>
<?php
$this->end();
?>
<form class="form-horizontal">
    <div class="form-group">
        <label for="id" class="col-sm-2 control-label">ID</label>
        <div class="col-sm-10">
            <input type="text" name="id" class="form-control" readonly="readonly" value="<?= h($item->id) ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label for="slug" class="col-sm-2 control-label">Slug</label>
        <div class="col-sm-10">
            <input type="text" name="slug" class="form-control" readonly="readonly" value="<?= h($item->slug) ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label for="title" class="col-sm-2 control-label">Title</label>
        <div class="col-sm-10">
            <input type="text" name="title" class="form-control" readonly="readonly" value="<?= h($item->title) ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label for="price" class="col-sm-2 control-label">Price</label>
        <div class="col-sm-10">
            <div class="input-group">
                <span class="input-group-addon">&pound;</span>
                <input type="number" step="0.01" name="price" class="form-control" readonly="readonly" value="<?= h($item->price) ?>"/>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="valid_from" class="col-sm-2 control-label">Valid From</label>
        <div class="col-sm-10">
            <input type="text" name="valid_from" class="form-control" readonly="readonly" value="<?= h($item->valid_from_string) ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label for="valid_from" class="col-sm-2 control-label">Valid To</label>
        <div class="col-sm-10">
            <input type="text" name="valid_to" class="form-control" readonly="readonly" value="<?= h($item->valid_to_string) ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label for="description" class="col-sm-2 control-label">Description</label>
        <div class="col-sm-10">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= $item->rendered_description ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="is_enabled" class="col-sm-2 control-label">Is Enabled?</label>
        <div class="col-sm-10">
            <p class="form-control-static">
                <?php if ($item->is_enable): ?>
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
                   value="<?= $this->Time->i18nFormat($item->created, null, null, 'Europe/London') ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label for="modified" class="col-sm-2 control-label">Last Modified</label>
        <div class="col-sm-10">
            <input type="text" name="modified" class="form-control" readonly="readonly"
                   value="<?= $this->Time->i18nFormat($item->modified, null, null, 'Europe/London') ?>"/>
        </div>
    </div>
</form>

<div class="row">
    <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-0 col-lg-4">
    </div>
    <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-2 col-lg-4 col-lg-offset-4">
        <?= $this->Html->link('Preview&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-eye-open"></span>', ['action' => 'preview', $item->id], ['class' => ['btn', 'btn-default', 'btn-block'], 'escape' => false]) ?>
    </div>
</div>
<br/>
<div class="row">
    <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-0 col-lg-4">
        <?= $this->Html->link('<span class="glyphicon glyphicon-chevron-left"></span>&nbsp;&nbsp;&nbsp;Back', ['action' => 'index'], ['class' => ['btn', 'btn-default', 'btn-block'], 'escape' => false]) ?>
    </div>
    <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-2 col-lg-4 col-lg-offset-4">
        <?php if ($this->hasAccessTo('admin.membership.edit') && $this->hasAccessTo('admin.membership.delete')): ?>
            <div class="btn-group btn-block">
                <?= $this->Html->link('Edit&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $item->id], ['class' => ['btn', 'btn-primary', 'col-sm-10', 'col-md-11'], 'escape' => false]) ?>
                <a href="#" class="btn btn-primary col-sm-2 col-md-1 dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu btn-block">
                    <li><?= $this->Form->postLink('Delete&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-remove"></span>', ['action' => 'delete', $item->id], ['escape' => false, 'confirm' => __('Are you sure you want to delete {0}?', $item->title)]) ?></li>
                </ul>
            </div>
        <?php elseif ($this->hasAccessTo('admin.membership.edit')): ?>
            <?= $this->Html->link('Edit <span class="glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $item->id], ['class' => ['btn', 'btn-primary', 'btn-block'], 'escape' => false]) ?>
        <?php else: ?>
            <?= $this->Form->postLink('Delete&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-remove"></span>', ['action' => 'delete', $item->id], ['escape' => false, 'class' => ['btn', 'btn-primary', 'btn-block'], 'confirm' => __('Are you sure you want to delete {0}?', $item->title)]) ?>
        <?php endif; ?>
    </div>
</div>
