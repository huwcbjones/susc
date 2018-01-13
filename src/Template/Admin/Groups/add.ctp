<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

/**
 * @var \SUSC\View\AppView $this
 * @var \SUSC\Model\Entity\Group $group
 */

$this->assign('title', 'Add Group');
$this->Form->unlockField('is_enable');
?>
<?= $this->Form->create($group, ['class' => ['form-horizontal']]) ?>
    <h2><?= __('Details') ?></h2>
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Name</label>
        <div class="col-sm-10">
            <?= $this->Form->text('name') ?>
        </div>
    </div>
    <div class="form-group">
        <label for="description" class="col-sm-2 control-label">Parent Group</label>
        <div class="col-sm-10">
            <?= $this->Form->select('parent_id', $parent, ['empty' => '[None]']) ?>
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
                <label class="btn btn-default" id="btn-isEnableY">
                    <input type="radio" name="is_enable" id="isEnabledY" value="1" /> Yes
                </label>
                <label class="btn btn-danger active" id="btn-isEnableN">
                    <input type="radio" name="is_enable" id="isEnabledN" value="0" checked="checked" /> No
                </label>
            </div>
        </div>
    </div>

    <div class="related">
        <h2><?= __('Access Control Objects') ?></h2>
        <?= $this->element('Admin/ACL', ['acls' => $group->acls, 'all_acls' => $all_acls, 'Form' => $this->Form, 'disabled' => false]) ?>
    </div>
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-0 col-lg-4">
            <?= $this->Html->link('<span class="glyphicon glyphicon-chevron-left"></span> Cancel', ['action' => 'index'], ['class' => ['btn', 'btn-default', 'btn-block'], 'escape' => false]) ?>
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