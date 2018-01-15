<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 */

use Cake\Collection\CollectionInterface;
use Cake\I18n\FrozenTime;
use SUSC\Model\Entity\Group;
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
 * @var Group[]|CollectionInterface $groups
 */

$this->assign('title', 'Edit: ' . $code->id);
$this->start('css');
echo $this->Html->css('bootstrap-datetimepicker');
echo $this->fetch('css');
$this->end();
$this->Form->unlockField('enabled');
$this->Form->unlockField('valid_from');
$this->Form->unlockField('valid_to');
?>
<?= $this->Form->create($code, ['class' => ['form-horizontal']]) ?>
    <div class="form-group">
        <label for="id" class="col-sm-2 control-label">ID</label>
        <div class="col-sm-10">
            <input type="text" name="id" class="form-control" disabled="disabled" value="<?= h($code->id) ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label for="group" class="col-sm-2 control-label">Group</label>
        <div class="col-sm-10">
            <?= $this->Form->select('group_id', $groups); ?>
        </div>
    </div>
    <div class="form-group<?= !$this->Form->isFieldError('valid_from') ? '' : ' has-error' ?>">
        <label for="valid_from" class="col-sm-2 control-label">Valid From</label>
        <div class="col-sm-10">
            <div class="input-group date form_valid_from"
                 data-date="<?= ($code->valid_from == null ? new FrozenTime() : $code->valid_from)->i18nFormat('yyyy-MM-dd HH:mm:ss') ?>">
                <?= $this->Form->text('valid_from_str', ['value' => $code->valid_from_string, 'readonly' => true]) ?>
                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
            </div>
            <?= $this->Form->hidden('valid_from', ['value' => $code->valid_from == null ? '' : ($code->valid_from)->i18nFormat('yyyy-MM-dd HH:mm:ss'), 'id' => 'valid_from']) ?>
            <?php if ($this->Form->isFieldError('valid_from')) : ?>
                <span id="helpBlock" class="help-block"><?= $this->Form->error('valid_from') ?></span>
            <?php endif ?>
        </div>
    </div>
    <div class="form-group<?= !$this->Form->isFieldError('valid_to') ? '' : ' has-error' ?>">
        <label for="status" class="col-sm-2 control-label">Valid To</label>
        <div class="col-sm-10">
            <div class="input-group date form_valid_to"
                 data-date="<?= ($code->valid_to == null ? new FrozenTime() : $code->valid_to)->i18nformat('yyyy-MM-dd HH:mm:ss') ?>">
                <?= $this->Form->text('valid_to_str', ['value' => $code->valid_to_string, 'readonly' => true]) ?>
                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
            </div>
            <?= $this->Form->hidden('valid_to', ['value' => $code->valid_to == null ? '' : ($code->valid_to)->i18nformat('yyyy-MM-dd HH:mm:ss'), 'id' => 'valid_to']) ?>
            <?php if ($this->Form->isFieldError('valid_to')) : ?>
                <span id="helpBlock" class="help-block"><?= $this->Form->error('valid_to') ?></span>
            <?php endif ?>
        </div>
    </div>
    <div class="form-group<?= !$this->Form->isFieldError('enabled') ? '' : ' has-error' ?>">
        <label for="status" class="col-sm-2 control-label">Is Enabled?</label>
        <div class="col-sm-10">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-<?php if ($code->enabled): ?>success active<?php else: ?>default<?php endif ?>" id="btn-enabledY">
                    <input type="radio" name="enabled" id="enabledY" value="1"<?php if ($code->enabled): ?> checked="checked"<?php endif ?> /> Yes
                </label>
                <label class="btn btn-<?php if (!$code->enabled): ?>danger active<?php else: ?>default<?php endif ?>" id="btn-enabledN">
                    <input type="radio" name="enabled" id="enabledN" value="0"<?php if (!$code->enabled): ?> checked="checked"<?php endif ?> /> No
                </label>
            </div>
            <?php if ($this->Form->isFieldError('enabled')) : ?>
                <span id="helpBlock" class="help-block"><?= $this->Form->error('enabled') ?></span>
            <?php endif ?>
        </div>
    </div>
    <div class="form-group">
        <label for="created" class="col-sm-2 control-label">Created</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" readonly="readonly"
                   value="<?= $this->Time->i18nFormat($code->created, null, null, 'Europe/London') ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label for="modified" class="col-sm-2 control-label">Last Modified</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" readonly="readonly"
                   value="<?= $this->Time->i18nFormat($code->modified, null, null, 'Europe/London') ?>"/>
        </div>
    </div>


    <div class="row">
        <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-0 col-lg-4">
            <?= $this->Html->link('<span class="glyphicon glyphicon-chevron-left"></span> Back', ['action' => 'view', $code->id], ['class' => ['btn', 'btn-default', 'btn-block'], 'escape' => false]) ?>
        </div>
        <div class="col-xs-12 visible-xs-block"><br/></div>
        <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-2 col-lg-4 col-lg-offset-4">
            <?= $this->Form->button('Save Changes&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-floppy-disk"></span>', ['type' => 'submit', 'class' => ['btn', 'btn-primary', 'btn-block'], 'escape' => false]); ?>
        </div>
    </div>
<?= $this->Form->end() ?>
<?php
$this->start('postscript');
echo $this->fetch('postscript');
echo $this->Html->script('bootstrap-datetimepicker');
?>
    <script type="text/javascript">
        $("#btn-enabledY").click(function () {
            $("#btn-enabledY").addClass("btn-success").removeClass("btn-default");
            $("#btn-enabledN").addClass("btn-default").removeClass("btn-danger");
        });
        $("#btn-enabledN").click(function () {
            $("#btn-enabledY").addClass("btn-default").removeClass("btn-success");
            $("#btn-enabledN").addClass("btn-danger").removeClass("btn-default");
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