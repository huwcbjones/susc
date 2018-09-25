<?php
/**
 * @var \SUSC\View\AppView $this
 * @var \SUSC\Model\Entity\Bunfight $bunfight
 */

$this->assign('title', 'Edit Bunfight: ' . $bunfight->id);
?>

<?= $this->Form->create($bunfight, ['class' => ['form-horizontal']]) ?>
<div class="form-group">
    <label for="id" class="col-sm-2 control-label">ID</label>
    <div class="col-sm-10">
        <input type="text" name="id" class="form-control" disabled="disabled" value="<?= h($bunfight->id) ?>"/>
    </div>
</div>
<div class="form-group">
    <label for="id" class="col-sm-2 control-label">Name</label>
    <div class="col-sm-10">
        <input type="text" name="name" class="form-control" value="<?= h($bunfight->name) ?>"/>
    </div>
</div>
<div class="form-group">
    <label for="description" class="col-sm-2 control-label">Description</label>
    <div class="col-sm-10">
        <?= $this->Form->textarea('description') ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-0 col-lg-4">
        <?= $this->Html->link('<span class="glyphicon glyphicon-chevron-left"></span> Cancel', ['action' => 'view', $bunfight->id], ['class' => ['btn', 'btn-default', 'btn-block'], 'escape' => false]) ?>
    </div>
    <div class="col-xs-12 visible-xs-block"><br/></div>
    <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-2 col-lg-4 col-lg-offset-4">
        <?= $this->Form->button('Save <span class="glyphicon glyphicon-floppy-disk"></span>', ['type' => 'submit', 'class' => ['btn', 'btn-primary', 'btn-block'], 'escape' => false]); ?>
    </div>
</div>

<?= $this->Form->end() ?>
