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
            <p class="form-control-static"> <?php if ($this->hasAccessTo('admin.groups.view')): ?>
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
    <?php if ($this->hasAccessTo('admin.users.*')): ?>
        <div class="users">
            <h2>Group Members</h2>
            <div class="panel-group" id="accordion-userList" role="tablist" aria-multiselectable="true">
                <div class="panel panel-primary">
                    <div class="panel-heading" role="tab" id="h-userList">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion-userList" href="#c-userList" aria-expanded="true"
                               aria-controls="c-userList">
                                Group Members
                            </a>
                        </h4>
                    </div>
                    <div id="c-userList" class="panel-collapse collapse"
                         role="tabpanel" aria-labelledby="h-userList">
                        <div class="panel-body">

                        </div>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Created</th>
                                <?php if ($this->hasAccessTo('admin.users.view')): ?>
                                    <th></th>
                                <?php endif ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($group->users as $user): ?>
                                <tr>
                                    <td><?= $user->first_name ?></td>
                                    <td><?= $user->last_name ?></td>
                                    <td><?= $user->created ?></td>
                                    <?php if ($this->hasAccessTo('admin.users.view')): ?>
                                        <td class="actions"><?= $this->Html->link(__('View'), ['controller' => 'Users', 'action' => 'view', $user->id]) ?></td>
                                    <?php endif ?>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php endif ?>
</form>

<div class="row">
    <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-0 col-lg-4">
        <?= $this->Html->link('<span class="glyphicon glyphicon-chevron-left"></span> Back', ['action' => 'index'], ['class' => ['btn', 'btn-default', 'btn-block'], 'escape' => false]) ?>
    </div>
    <?php if ($this->hasAccessTo('admin.groups.edit') || $this->hasAccessTo('admin.groups.delete')): ?>
        <div class="col-xs-12 visible-xs-block"><br/></div>
        <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-2 col-lg-4 col-lg-offset-4">
            <?php if ($this->hasAccessTo('admin.groups.edit') && $this->hasAccessTo('admin.groups.delete')): ?>
                <div class="btn-group btn-block">
                    <?= $this->Html->link('Edit <span class="glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $group->id], ['class' => ['btn', 'btn-primary', 'col-sm-10', 'col-md-11'], 'escape' => false]) ?>
                    <a href="#" class="btn btn-primary col-sm-2 col-md-1 dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu btn-block">
                        <li><?= $this->Form->postLink('Delete&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-remove"></span>', ['action' => 'delete', $group->id], ['escape' => false, 'confirm' => __('Are you sure you want to delete {0}?', $group->name)]) ?></li>
                    </ul>
                </div>
            <?php elseif ($this->hasAccessTo('admin.groups.edit')): ?>
                <?= $this->Html->link('Edit <span class="glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $group->id], ['class' => ['btn', 'btn-primary', 'btn-block'], 'escape' => false]) ?>
            <?php else: ?>
                <?= $this->Form->postLink('Delete&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-remove"></span>', ['action' => 'delete', $group->id], ['escape' => false, 'class' => ['btn', 'btn-primary', 'btn-block'], 'confirm' => __('Are you sure you want to delete {0}?', $group->name)]) ?>
            <?php endif; ?>

        </div>
    <?php endif ?>
</div>
