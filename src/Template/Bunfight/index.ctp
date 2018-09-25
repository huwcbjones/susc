<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

use SUSC\Model\Entity\Bunfight;
use SUSC\Model\Entity\BunfightSession;
use SUSC\Model\Entity\BunfightSignup;

/**
 * @var \SUSC\View\AppView $this
 * @var Bunfight $bunfight
 * @var BunfightSession[] $sessions
 * @var BunfightSignup $signup
 */

$this->assign('title', 'Interested in joining Southampton University Swimming Club?');
$this->assign('title_string', 'Interested in joining Southampton University Swimming Club?');
$this->append('css', $this->Html->css('bootstrap-datetimepicker'));

$years = [];
foreach (range(date('Y') + 1, date('Y') + 8) as $year) {
    $years[$year] = $year;
}

$this->Form->unlockField('bunfight_session_id');

$this->start('css');
echo $this->fetch('css');
?>
<style>
    .progress {
        margin-top: 5px;
        margin-bottom: 15px;
    }
</style>
<?php $this->end() ?>

<?= $bunfight->renderedDescription ?>

<?= $this->Form->create($signup, ['class' => ['form-horizontal'], 'autocomplete' => 'off']) ?>
<div class="form-group<?= !$this->Form->isFieldError('first_name') ? '' : ' has-error' ?>">
    <label for="title" class="col-sm-3 control-label">First Name <span class="required"></span></label>
    <div class="col-sm-9">
        <?= $this->Form->text('first_name', ['placeholder' => 'John', 'required' => true]) ?>
        <?php if ($this->Form->isFieldError('first_name')) : ?>
            <span id="helpBlock" class="help-block"><?= $this->Form->error('first_name') ?></span>
        <?php endif; ?>
    </div>
</div>
<div class="form-group<?= !$this->Form->isFieldError('last_name') ? '' : ' has-error' ?>">
    <label for="title" class="col-sm-3 control-label">Last Name <span class="required"></label>
    <div class="col-sm-9">
        <?= $this->Form->text('last_name', ['placeholder' => 'Doe', 'required' => true]) ?>
        <?php if ($this->Form->isFieldError('last_name')) : ?>
            <span id="helpBlock" class="help-block"><?= $this->Form->error('last_name') ?></span>
        <?php endif; ?>
    </div>
</div>
<div class="form-group<?= !$this->Form->isFieldError('email_address') ? '' : ' has-error' ?>">
    <label for="title" class="col-sm-3 control-label">Email Address <span class="required"></label>
    <div class="col-sm-9">
        <?= $this->Form->text('email_address', ['placeholder' => 'abcd1g15@soton.ac.uk', 'required' => true]) ?>
        <?php if ($this->Form->isFieldError('email_address')) : ?>
            <span id="helpBlock" class="help-block"><?= $this->Form->error('email_address') ?></span>
        <?php endif; ?>
    </div>
</div>
<div class="form-group<?= !$this->Form->isFieldError('gender') ? '' : ' has-error' ?>">
    <label for="status" class="col-sm-3 control-label">Gender</label>
    <div class="col-sm-9">
        <?= $this->Form->select('gender', BunfightSignup::$genders, ['empty' => 'Prefer not to say']) ?>
    </div>
</div>
<div class="form-group<?= !$this->Form->isFieldError('graduation_year') ? '' : ' has-error' ?>">
    <label for="status" class="col-sm-3 control-label">Expected Year of Graduation</label>
    <div class="col-sm-9">
        <?= $this->Form->select('graduation_year', $years, ['empty' => 'Prefer not to say']) ?>
    </div>
</div>
<div class="form-group<?= !$this->Form->isFieldError('ability') ? '' : ' has-error' ?>">
    <label for="status" class="col-sm-3 control-label">Swimming Ability</label>
    <div class="col-sm-9">
        <?= $this->Form->select('ability', BunfightSignup::$abilities, ['empty' => 'Prefer not to say']) ?>
    </div>
</div>

<div class="form-group<?= !$this->Form->isFieldError('squads') ? '' : ' has-error' ?>">
    <label for="title" class="col-sm-3 control-label">Interested Squad(s)</label>
    <div class="col-sm-9">
        <input name="squads[_ids][]" class="hidden" value="" />
        <?php foreach ($squads as $squad): ?>
            <div class="checkbox">
                <label>
                    <?= $this->Form->checkbox('squads._ids[]', ['value' => $squad->id, 'id' => 'squads-' . $squad->id, 'hiddenField' => false]) ?>
                    <?= $squad->name ?>
                </label>
            </div>
        <?php endforeach ?>
        <?php if ($this->Form->isFieldError('squads')) : ?>
            <span id="helpBlock" class="help-block"><?= $this->Form->error('squads') ?></span>
        <?php endif; ?>
    </div>
</div>
<div class="form-group<?= !$this->Form->isFieldError('bunfight_session_id') ? '' : ' has-error' ?>">
    <label for="title" class="col-sm-3 control-label">Taster Session</label>
    <div class="col-sm-9">
        <?php foreach ($sessions as $session): ?>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-lg-4">
                    <div class="radio">
                        <label>
                            <?php if(!$session->isFull): ?>
                                <input type="radio" name="bunfight_session_id" value="<?= $session->id ?>"
                                       id="session-<?= $session->id ?>"/>
                            <?php endif; ?>
                            <?= $session->start->i18nFormat('EEEE d MMMM y h:mm a', null, 'Europe/London') ?>
                        </label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-lg-8">
                    <div class="progress">
                        <div class="progress-bar progress-bar-<?= $session->progressStatus?>" role="progressbar" aria-valuenow="<?= $session->progress?>" aria-valuemin="0"
                             aria-valuemax="100" style="width: <?= $session->progress?>%;">
                            <?php if($session->isFull):?>
                                Sorry, this session is full.
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>

        <?php endforeach ?>
        <?php if ($this->Form->isFieldError('squads')) : ?>
            <span id="helpBlock" class="help-block"><?= $this->Form->error('squads') ?></span>
        <?php endif; ?>
    </div>
</div>
<div class="form-group<?= !$this->Form->isFieldError('consent_to_emails') ? '' : ' has-error' ?>">
    <label for="consent_to_emails" class="col-sm-3 control-label">Email Consent <span
                class="required"></span></label>
    <div class="col-sm-9">
        <div class="checkbox">
            <label>
                <?= $this->Form->checkbox('consent_to_emails', ['value' => true, 'id' => 'consent_to_emails', 'required' => true]) ?>
                I consent to receiving emails about the club.
            </label>
        </div>
        <?php if ($this->Form->isFieldError('consent_to_emails')) : ?>
            <span id="helpBlock" class="help-block"><?= $this->Form->error('consent_to_emails') ?></span>
        <?php endif; ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-lg-4 col-lg-offset-4">
        <?= $this->Form->button('Register Your Interest <span class="glyphicon glyphicon-send"></span>', ['type' => 'submit', 'class' => ['btn', 'btn-success', 'btn-block']]) ?>
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