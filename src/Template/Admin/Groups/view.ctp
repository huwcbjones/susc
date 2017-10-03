<?php
/**
 * @var \SUSC\View\AppView $this
 * @var \SUSC\Model\Entity\Group $group
 */

$this->assign('title', 'View Group: ' . $group->name);
?>
<h2><?= __('Details') ?></h2>
<form class="form-horizontal">
    <div class="form-group">
        <label for="id" class="col-sm-2 control-label">ID</label>
        <div class="col-sm-10">
            <input type="text" name="id" class="form-control" readonly="readonly" value="<?= h($group->id) ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Name</label>
        <div class="col-sm-10">
            <input type="text" name="name" class="form-control" readonly="readonly" value="<?= h($group->name) ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label for="description" class="col-sm-2 control-label">Parent Group</label>
        <div class="col-sm-10">
            <p class="form-control-static"> <?php if ($currentUser->isAuthorised('admin.groups.view')): ?>
                    <?= $group->has('parent') ? $this->Html->link($group->parent->name, ['controller' => 'Groups', 'action' => 'view', $group->parent->id]) : '&mdash;' ?>
                <?php else: ?>
                    <?= $group->has('parent') ? $group->parent->name : '&mdash;' ?>
                <?php endif; ?></p>
        </div>
    </div>
    <div class="form-group">
        <label for="description" class="col-sm-2 control-label">Description</label>
        <div class="col-sm-10">
            <input type="text" name="description" class="form-control" value="<?= h($group->description) ?>" readonly="readonly"/>
        </div>
    </div>
    <div class="form-group">
        <label for="is_enabled" class="col-sm-2 control-label">Is Enabled?</label>
        <div class="col-sm-10">
            <p class="form-control-static">
                <?php if ($group->is_enable): ?>
                    <span class="text-success"><span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;&nbsp;Yes</span>
                <?php else: ?>
                    <span class="text-danger"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;&nbsp;No</span>
                <?php endif; ?>
            </p>
        </div>
    </div>

    <div class="form-group">
        <label for="created" class="col-sm-2 control-label">Group Created</label>
        <div class="col-sm-10">
            <input type="text" name="created" class="form-control" readonly="readonly"
                   value="<?= $this->Time->i18nFormat($group->created, null, null, 'Europe/London') ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label for="modified" class="col-sm-2 control-label">Group Last Modified</label>
        <div class="col-sm-10">
            <input type="text" name="modified" class="form-control" readonly="readonly"
                   value="<?= $this->Time->i18nFormat($group->modified, null, null, 'Europe/London') ?>"/>
        </div>
    </div>
    <div class="related">
        <h2><?= __('Access Control Objects') ?></h2>
        <?= $this->element('Admin/ACL', ['acls' => $group->acls, 'all_acls' => $all_acls, 'disabled' => true]) ?>
    </div>
</form>
