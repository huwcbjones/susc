<?php
/**
 * @var \SUSC\View\AppView $this
 * @var \SUSC\Model\Entity\Group $group
 */

$this->assign('title', 'Edit Group: ' . $group->name);
?>
<?= $this->Form->create($group, ['class' => ['form-horizontal']]) ?>
    <h2><?= __('Details') ?></h2>
    <div class="form-group">
        <label for="id" class="col-sm-2 control-label">ID</label>
        <div class="col-sm-10">
            <input type="text" name="id" class="form-control" disabled="disabled" value="<?= h($group->id) ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Name</label>
        <div class="col-sm-10">
            <?= $this->Form->text('name') ?>
        </div>
    </div>
    <div class="form-group">
        <label for="description" class="col-sm-2 control-label">Description</label>
        <div class="col-sm-10">
            <?= $this->Form->text('description') ?>
        </div>
    </div>
    <div class="form-group">
        <label for="is_enabled" class="col-sm-2 control-label">Is Enabled?</label>
        <div class="col-sm-10">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-<?php if ($group->isEnabled()): ?>success active<?php else: ?>default<?php endif ?>" id="btn-isEnableY">
                    <input type="radio" name="is_enable" id="isEnabledY" value="1"<?php if ($group->isEnabled()): ?> checked="checked"<?php endif ?> /> Yes
                </label>
                <label class="btn btn-<?php if (!$group->isEnabled()): ?>danger active<?php else: ?>default<?php endif ?>" id="btn-isEnableN">
                    <input type="radio" name="is_enable" id="isEnabledN" value="0"<?php if (!$group->isEnabled()): ?> checked="checked"<?php endif ?> /> No
                </label>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="created" class="col-sm-2 control-label">Group Created</label>
        <div class="col-sm-10">
            <input type="text" name="created" class="form-control" disabled="disabled"
                   value="<?= $this->Time->i18nFormat($group->created, null, null, 'Europe/London') ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label for="modified" class="col-sm-2 control-label">Group Last Modified</label>
        <div class="col-sm-10">
            <input type="text" name="modified" class="form-control" disabled="disabled"
                   value="<?= $this->Time->i18nFormat($group->modified, null, null, 'Europe/London') ?>"/>
        </div>
    </div>

    <div class="related">
        <h2><?= __('Access Control Objects') ?></h2>
        <?= $this->element('Admin/ACL', ['acls' => $group->acls, 'all_acls' => $all_acls, 'Form' => $this->Form, 'disabled' => false]) ?>
    </div>
<?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>


<?php
$this->start('postscript');
echo $this->fetch('postscript');
?>
    <script type="text/javascript">
        $("#btn-isEnableY").click(function () {
            $("#btn-isEnableY").addClass("btn-success").removeClass("btn-default");
            $("#btn-isEnableN").addClass("btn-default").removeClass("btn-danger");
        });
        $("#btn-isEnableN").click(function () {
            $("#btn-isEnableY").addClass("btn-default").removeClass("btn-success");
            $("#btn-isEnableN").addClass("btn-danger").removeClass("btn-default");
        });
    </script>
<?php $this->end() ?>