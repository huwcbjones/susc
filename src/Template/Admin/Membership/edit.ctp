<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

use Cake\I18n\FrozenTime;
use SUSC\Model\Entity\MembershipType;
use SUSC\View\AppView;

/**
 * Author: Huw
 * Since: 07/10/2017
 * @var AppView $this
 * @var MembershipType $item
 */

$this->assign('title', 'Edit Membership: ' . $item->title);
$this->start('css');
echo $this->Html->css('bootstrap-datetimepicker');
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
<?= $this->Form->create($item, ['class' => ['form-horizontal']]) ?>
<div class="form-group">
    <label for="id" class="col-sm-2 control-label">ID</label>
    <div class="col-sm-10">
        <input type="text" name="id" class="form-control" disabled="disabled" value="<?= h($item->id) ?>"/>
    </div>
</div>
<div class="form-group">
    <label for="slug" class="col-sm-2 control-label">Slug</label>
    <div class="col-sm-10">
        <input type="text" name="slug" class="form-control" disabled="disabled" value="<?= h($item->slug) ?>"/>
    </div>
</div>
<div class="form-group<?= !$this->Form->isFieldError('title') ? '' : ' has-error' ?>">
    <label for="title" class="col-sm-2 control-label">Title</label>
    <div class="col-sm-10">
        <?= $this->Form->text('title') ?>
        <?php if ($this->Form->isFieldError('title')) : ?>
            <span id="helpBlock" class="help-block"><?= $this->Form->error('title') ?></span>
        <?php endif; ?>
    </div>
</div>
<div class="form-group<?= !$this->Form->isFieldError('price') ? '' : ' has-error' ?>">
    <label for="price" class="col-sm-2 control-label">Price</label>
    <div class="col-sm-10">
        <div class="input-group">
            <span class="input-group-addon">&pound;</span>
            <?= $this->Form->number('price', ['step' => '0.01']); ?>
        </div>
        <?php if ($this->Form->isFieldError('price')) : ?>
            <span id="helpBlock" class="help-block"><?= $this->Form->error('price') ?></span>
        <?php endif ?>
    </div>
</div>
<div class="form-group<?= !$this->Form->isFieldError('valid_from') ? '' : ' has-error' ?>">
    <label for="valid_from" class="col-sm-2 control-label">Valid From</label>
    <div class="col-sm-10">
        <div class="input-group date form_valid_from"
             data-date="<?= ($item->valid_from == null ? new FrozenTime() : $item->valid_from)->i18nFormat('yyyy-MM-dd HH:mm:ss') ?>">
            <?= $this->Form->text('valid_from', ['value' => $item->valid_from_string, 'readonly' => true]) ?>
            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
        </div>
        <?= $this->Form->hidden('valid_from', ['value' => ($item->valid_from == null ? new FrozenTime() : $item->valid_from)->i18nFormat('yyyy-MM-dd HH:mm:ss'), 'id' => 'valid_from']) ?>
        <?php if ($this->Form->isFieldError('valid_from')) : ?>
            <span id="helpBlock" class="help-block"><?= $this->Form->error('valid_from') ?></span>
        <?php endif ?>
    </div>
</div>
<div class="form-group<?= !$this->Form->isFieldError('valid_to') ? '' : ' has-error' ?>">
    <label for="status" class="col-sm-2 control-label">Valid To</label>
    <div class="col-sm-10">
        <div class="input-group date form_valid_to"
             data-date="<?= ($item->valid_to == null ? new FrozenTime() : $item->valid_to)->i18nformat('yyyy-MM-dd HH:mm:ss') ?>">
            <?= $this->Form->text('valid_to', ['value' => $item->valid_to_string, 'readonly' => true]) ?>
            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
        </div>
        <?= $this->Form->hidden('valid_to', ['value' => ($item->valid_to == null ? new FrozenTime() : $item->valid_to)->i18nformat('yyyy-MM-dd HH:mm:ss'), 'id' => 'valid_to']) ?>
        <?php if ($this->Form->isFieldError('valid_to')) : ?>
            <span id="helpBlock" class="help-block"><?= $this->Form->error('valid_to') ?></span>
        <?php endif ?>
    </div>
</div>
<div class="form-group<?= !$this->Form->isFieldError('description') ? '' : ' has-error' ?>">
    <label for="description" class="col-sm-2 control-label">Description</label>
    <div class="col-sm-10">
        <?= $this->Form->textarea('description') ?>
        <?php if ($this->Form->isFieldError('description')) : ?>
            <span id="helpBlock" class="help-block"><?= $this->Form->error('description') ?></span>
        <?php endif ?>
    </div>
</div>
<div class="form-group<?= !$this->Form->isFieldError('is_enable') ? '' : ' has-error' ?>">
    <label for="status" class="col-sm-2 control-label">Is Enabled?</label>
    <div class="col-sm-10">
        <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-<?php if ($item->is_enable): ?>success active<?php else: ?>default<?php endif ?>" id="btn-is_enableY">
                <input type="radio" name="is_enable" id="is_enableY" value="1"<?php if ($item->is_enable): ?> checked="checked"<?php endif ?> /> Yes
            </label>
            <label class="btn btn-<?php if (!$item->is_enable): ?>danger active<?php else: ?>default<?php endif ?>" id="btn-is_enableN">
                <input type="radio" name="is_enable" id="is_enableN" value="0"<?php if (!$item->is_enable): ?> checked="checked"<?php endif ?> /> No
            </label>
        </div>
        <?php if ($this->Form->isFieldError('is_enable')) : ?>
            <span id="helpBlock" class="help-block"><?= $this->Form->error('is_enable') ?></span>
        <?php endif ?>
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

<?= $this->Form->submit(); ?>
<?= $this->Form->end() ?>

<?php
$this->start('postscript');
echo $this->fetch('postscript');
echo $this->Html->script('bootstrap-datetimepicker');
?>
<script type="text/javascript">
    $("#btn-is_enableY").click(function () {
        $("#btn-is_enableY").addClass("btn-success").removeClass("btn-default");
        $("#btn-is_enableN").addClass("btn-default").removeClass("btn-danger");
    });
    $("#btn-is_enableN").click(function () {
        $("#btn-is_enableY").addClass("btn-default").removeClass("btn-success");
        $("#btn-is_enableN").addClass("btn-danger").removeClass("btn-default");
    });
</script>
<script type="text/javascript">
    $(".form_valid_from").datetimepicker({
        format: "dd MM yyyy",
        minView: 2,
        linkField: 'valid_from',
        linkFormat: 'yyyy-mm-dd'
    });
    $(".form_valid_to").datetimepicker({
        format: "dd MM yyyy",
        minView: 2,
        linkField: 'valid_to',
        linkFormat: 'yyyy-mm-dd'
    });
</script>
<?php $this->end() ?>
