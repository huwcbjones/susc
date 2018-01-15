<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 */

use Cake\Collection\CollectionInterface;
use SUSC\Model\Entity\Config;
use SUSC\Model\Entity\Group;

/**
 * @var \SUSC\View\AppView $this
 * @var Config $registrationRequiresCode
 * @var Group[]|CollectionInterface $groups
 * @var Config $defaultGroup
 */

$this->assign('title', 'Configure Signups');
?>


<?= $this->Form->create(null, ['class' => 'form-horizontal']) ?>
<div class="form-group">
    <label for="registrationRequiresCode" class="col-sm-3 control-label">Signup Requires Code</label>
    <div class="col-sm-9">
        <div class="checkbox">
            <?= $this->Form->checkbox('registrationRequiresCode', ['checked' => $registrationRequiresCode->value]) ?>
        </div>
    </div>
</div>
<div class="form-group">
    <label for="defaultGroup" class="col-sm-3 control-label">Default Group</label>
    <div class="col-sm-9">
        <?= $this->Form->select('defaultGroup', $groups, ['val' => $defaultGroup->value]) ?>
    </div>
</div>
<div class="row">
    <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-0 col-lg-4">
    </div>
    <div class="col-xs-12 visible-xs-block"><br/></div>
    <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-2 col-lg-4 col-lg-offset-4">
        <?= $this->Form->button('Save Changes&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-floppy-disk"></span>', ['type' => 'submit', 'class' => ['btn', 'btn-primary', 'btn-block'], 'escape' => false]); ?>
    </div>
</div>
<?= $this->Form->end() ?>
