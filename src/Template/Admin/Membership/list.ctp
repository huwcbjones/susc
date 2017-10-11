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
        <div class="input-group date form_valid_from" data-date="<?= $now ?>">
            <?= $this->Form->text('date', ['value' => $now_string, 'readonly' => true]) ?>
            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
        </div>
        <input name="valid_from" id="valid_from" type="hidden"/>
    </div>
</div>
<?= $this->Form->submit('Download'); ?>
<?= $this->Form->end() ?>

<?php
$this->start('postscript');
echo $this->fetch('postscript');
echo $this->Html->script('bootstrap-datetimepicker');
?>
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
