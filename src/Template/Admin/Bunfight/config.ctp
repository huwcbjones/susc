<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 */

/**
 * @author huw
 * @since 25/09/2018 12:31
 */
$this->assign('title', 'Configure Bunfight');
?>

<?= $this->Form->create($config, ['class' => 'form-horizontal']) ?>
<div class="form-group">
    <label for="id" class="col-sm-2 control-label">Current Bunfight</label>
    <div class="col-sm-10">
        <?= $this->Form->select($config["current"]->key, $bunfights, ['val' => $config["current"]->value, 'empty' => 'Select Bunfight']) ?>
    </div>
</div>
<div class="form-group">
    <label for="description" class="col-sm-2 control-label">Non Swimmer Email</label>
    <div class="col-sm-10">
        <?= $this->Form->textarea($config["non_swim"]->key, ['value' => $config["non_swim"]->value, 'rows'=> 10]) ?>
    </div>
</div>
<div class="form-group">
    <label for="description" class="col-sm-2 control-label">Email Template (HTML)</label>
    <div class="col-sm-10">
        <?= $this->Form->textarea($config["email_template_html"]->key, ['value' => $config["email_template_html"]->value, 'rows'=> 20]) ?>
    </div>
</div>
<div class="form-group">
    <label for="description" class="col-sm-2 control-label">Email Template (Plain)</label>
    <div class="col-sm-10">
        <?= $this->Form->textarea($config["email_template_plain"]->key, ['value' => $config["email_template_plain"]->value, 'rows'=> 20]) ?>
    </div>
</div>
<div class="form-group">
    <label for="description" class="col-sm-2 control-label">Privacy Policy</label>
    <div class="col-sm-10">
        <?= $this->Form->textarea($config["data_disclaimer"]->key, ['value' => $config["data_disclaimer"]->value, 'rows'=> 20]) ?>
    </div>
</div>
<div class="form-group">
    <label for="description" class="col-sm-2 control-label">Signup Confirmation Message</label>
    <div class="col-sm-10">
        <?= $this->Form->textarea($config["confirmation_message"]->key, ['value' => $config["confirmation_message"]->value]) ?>
    </div>
</div>


<?= $this->Form->submit() ?>
<?= $this->Form->end() ?>
