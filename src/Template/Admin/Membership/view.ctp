<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

use SUSC\View\AppView;

/**
 * Author: Huw
 * Since: 07/10/2017
 * @var AppView $this
 * @var \SUSC\Model\Entity\MembershipType $item
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
                <?php if ($item->status): ?>
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
