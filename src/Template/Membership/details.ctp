<?php

use Cake\I18n\FrozenTime;
use SUSC\Model\Entity\Membership;
use SUSC\Model\Entity\MembershipType;
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
 * Since: 08/10/2017
 *
 * @var AppView $this
 * @var Membership $membership
 * @var MembershipType[] $membership_types
 */

$this->assign('title', 'Member Details');
$this->start('css');
echo $this->fetch('css');
echo $this->Html->css('bootstrap-datetimepicker');
$this->end();
?>

<?= $this->Form->create($membership, ['class' => ['form-horizontal']]) ?>
    <div class="form-group<?= !$this->Form->isFieldError('first_name') ? '' : ' has-error' ?>">
        <label for="title" class="col-sm-2 control-label">First Name</label>
        <div class="col-sm-10">
            <?= $this->Form->text('first_name', ['placeholder' => 'John']) ?>
            <?php if ($this->Form->isFieldError('first_name')) : ?>
                <span id="helpBlock" class="help-block"><?= $this->Form->error('first_name') ?></span>
            <?php endif; ?>
        </div>
    </div>
    <div class="form-group<?= !$this->Form->isFieldError('last_name') ? '' : ' has-error' ?>">
        <label for="title" class="col-sm-2 control-label">Last Name</label>
        <div class="col-sm-10">
            <?= $this->Form->text('last_name', ['placeholder' => 'Doe']) ?>
            <?php if ($this->Form->isFieldError('last_name')) : ?>
                <span id="helpBlock" class="help-block"><?= $this->Form->error('last_name') ?></span>
            <?php endif; ?>
        </div>
    </div>
    <div class="form-group<?= !$this->Form->isFieldError('student_id') ? '' : ' has-error' ?>">
        <label for="title" class="col-sm-2 control-label">Student ID</label>
        <div class="col-sm-10">
            <?= $this->Form->text('student_id', ['placeholder' => '2xxxxxxx']) ?>
            <?php if ($this->Form->isFieldError('student_id')) : ?>
                <span id="helpBlock" class="help-block"><?= $this->Form->error('student_id') ?></span>
            <?php endif; ?>
        </div>
    </div>
    <div class="form-group<?= !$this->Form->isFieldError('soton_id') ? '' : ' has-error' ?>">
        <label for="title" class="col-sm-2 control-label">Southampton ID</label>
        <div class="col-sm-10">
            <?= $this->Form->text('soton_id', ['placeholder' => 'abcd1gxx']) ?>
            <?php if ($this->Form->isFieldError('soton_id')) : ?>
                <span id="helpBlock" class="help-block"><?= $this->Form->error('student_id') ?></span>
            <?php endif; ?>
        </div>
    </div>
    <div class="form-group<?= !$this->Form->isFieldError('date_of_birth') ? '' : ' has-error' ?>">
        <label for="status" class="col-sm-2 control-label">Date of Birth</label>
        <div class="col-sm-10">
            <div class="input-group date form_date_of_birth"
                 data-date="<?= ($membership->date_of_birth == null ? (new FrozenTime())->subYears(18) : $membership->date_of_birth)->i18nformat('yyyy-MM-dd HH:mm:ss') ?>">
                <?= $this->Form->text('date_of_birth', ['value' => ($membership->date_of_birth === null ? '' : $membership->date_of_birth->format('d F Y')), 'readonly' => true]) ?>
                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
            </div>
            <input name="date_of_birth" id="date_of_birth" type="hidden"
                   value="<?= ($membership->date_of_birth == null ? '' : $membership->date_of_birth->i18nformat('yyyy-MM-dd')) ?>"/>
            <?php if ($this->Form->isFieldError('date_of_birth')) : ?>
                <span id="helpBlock" class="help-block"><?= $this->Form->error('date_of_birth') ?></span>
            <?php endif ?>
        </div>
    </div>

    <div class="form-group<?= !$this->Form->isFieldError('membership_type_id') ? '' : ' has-error' ?>">
        <label for="title" class="col-sm-2 control-label">Membership Type</label>
        <div class="col-sm-10">
            <?= $this->Form->select('membership_type_id', $membership_types, ['empty' => 'Select Membership Type', 'val' => $membership->membership_type_id]) ?>
            <?php if ($this->Form->isFieldError('membership_type_id')) : ?>
                <span id="helpBlock" class="help-block"><?= $this->Form->error('membership_type_id') ?></span>
            <?php endif; ?>
        </div>
    </div>

    <div class="form-group<?= !$this->Form->isFieldError('payment_method') ? '' : ' has-error' ?>">
        <label for="payment_method" class="col-sm-2 control-label">Payment Method</label>
        <div class="col-sm-10">
            <div class="radio">
                <label>
                    <input type="radio" name="payment_method" id="payment-cash" value="cash"
                           <?php if ($membership->payment_method === 'cash'): ?>checked="checked"<?php endif; ?>>
                    Cash
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="payment_method" id="payment-bat" value="bat"
                           <?php if ($membership->payment_method === 'bat'): ?>checked="checked"<?php endif; ?>>
                    Bank Account Transfer
                </label>
            </div>
            <?php if ($this->Form->isFieldError('payment_method')) : ?>
                <span id="helpBlock" class="help-block"><?= $this->Form->error('payment_method') ?></span>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-0 col-lg-4">
            <?= $this->Html->link('<span class="glyphicon glyphicon-chevron-left"></span> Back', ['_name' => 'membership'], ['class' => ['btn', 'btn-warning', 'btn-lg', 'btn-block'], 'escape' => false]) ?>
        </div>
        <div class="col-xs-12 visible-xs-block"><br/></div>
        <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-2 col-lg-4 col-lg-offset-4">
            <?= $this->Form->button('Next <span class="glyphicon glyphicon-chevron-right"></span>', ['type' => 'submit', 'class' => ['btn', 'btn-success', 'btn-lg', 'btn-block']]) ?>
        </div>
    </div>

<?= $this->Form->end() ?>

<?php
$this->start('postscript');
echo $this->fetch('postscript');
echo $this->Html->script('bootstrap-datetimepicker');
?>
    <script type="text/javascript">
        $(".form_date_of_birth").datetimepicker({
            format: "dd MM yyyy",
            minView: 2,
            linkField: 'date_of_birth',
            linkFormat: 'yyyy-mm-dd'
        });
    </script>
<?php $this->end() ?>