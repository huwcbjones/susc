<?php

use Cake\I18n\FrozenTime;
use SUSC\View\AppView;

/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

/**
 * Author: Huw
 * Since: 11/10/2017
 *
 * @var AppView $this
 *
 */
$now = new FrozenTime();
$now_string = $now->format('d F Y');
$now = $now->i18nformat('yyyy-MM-dd HH:mm:ss');
$this->Form->unlockField('as_of');

$this->assign('title', 'Membership List');
$this->start('css');
echo $this->fetch('css');
echo $this->Html->css('bootstrap-datetimepicker');
$this->end();
?>
<?= $this->Form->create(null, ['class' => ['form-horizontal']]) ?>
<div class="form-group">
    <label for="date" class="col-sm-3 control-label">Membership as of</label>
    <div class="col-sm-9">
        <div class="input-group date form_as_of" data-date="<?= $now ?>">
            <?= $this->Form->text('date', ['value' => $now_string, 'readonly' => true]) ?>
            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
        </div>
        <input name="as_of" id="as_of" type="hidden"/>
    </div>
</div>
<div class="row">
    <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-0 col-lg-4"></div>
    <div class="col-xs-12 visible-xs-block"><br/></div>
    <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-2 col-lg-4 col-lg-offset-4">
        <?= $this->Form->button('Download&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-download-alt"></span>', ['type' => 'submit', 'class' => ['btn', 'btn-primary', 'btn-block'], 'escape' => false]); ?>
    </div>
</div>
<?= $this->Form->end() ?>

<?php
$this->start('postscript');
echo $this->fetch('postscript');
echo $this->Html->script('bootstrap-datetimepicker');
?>
<script type="text/javascript">
    $(".form_as_of").datetimepicker({
        format: "dd MM yyyy",
        minView: 2,
        linkField: 'as_of',
        linkFormat: 'yyyy-mm-dd'
    });
</script>
<?php $this->end() ?>
