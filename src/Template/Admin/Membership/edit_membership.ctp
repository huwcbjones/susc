<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

use SUSC\Model\Entity\Membership;
use SUSC\Model\Entity\MembershipType;
use SUSC\View\AppView;

/**
 * Author: Huw
 * Since: 09/10/2017
 *
 * @var Membership $membership
 * @var MembershipType[] $membership_types
 * @var AppView $this
 */
$this->assign('title', 'Edit Membership: ' . $membership->full_name);
?>

<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 style="display:inline"><?= $membership->full_name ?> - Membership: <?= $membership->membership_type->title ?></h3>
            </div>
            <div class="panel-body">
                <?= $this->Form->create($membership, ['id' => 'editForm']) ?>
                <div class="row">
                    <div class="col-sm-6">
                        <h2 class="h3">Their Details</h2>
                        <p><strong>First Name:</strong> <?= $this->Form->text('first_name', ['value' => $membership->first_name]) ?></p>
                        <p><strong>Last Name:</strong> <?= $this->Form->text('last_name', ['value' => $membership->last_name]) ?></p>
                        <p><strong>Student ID:</strong> <?= $this->Form->text('student_id', ['value' => $membership->student_id]) ?></p>
                        <p><strong>Southampton ID:</strong> <?= $this->Form->text('soton_id', ['value' => $membership->soton_id]) ?></p>
                        <p><strong>Date of Birth:</strong> <?= $membership->date_of_birth ?></p>

                        <h2 class="h3">Membership Details</h2>
                        <label for="membership_type_id">Membership Type</label>
                        <?= $this->Form->select('membership_type_id', $membership_types, ['val' => $membership->membership_type_id]) ?>
                    </div>
                    <div class="col-sm-6">
                        <h2 class="h3">Order Details</h2>
                        <p><strong>Ordered:</strong> <?= $this->Time->i18nFormat($membership->created, null, null, 'Europe/London') ?></p>
                        <p><strong>Payment Method:</strong> <?= $membership->payment ?></p>
                        <p>
                            <strong>Payment:</strong> <?= ($membership->is_paid) ? $this->Time->i18nFormat($membership->paid, null, null, 'Europe/London') : 'Outstanding' ?>
                        </p>
                        <p><strong>Status:</strong> <?= $membership->status ?></p>
                    </div>
                </div>
                <?= $this->Form->end() ?>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-0 col-lg-4">
                        <?= $this->Html->link('<span class="glyphicon glyphicon-remove"></span> Cancel', ['action' => 'details', $membership->id], ['class' => ['btn', 'btn-default', 'btn-block'], 'escape' => false]) ?>
                    </div>
                    <div class="col-xs-12 visible-xs-block"><br/></div>
                    <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-2 col-lg-4 col-lg-offset-4">
                        <?= $this->Html->link('Save Changes <span class="glyphicon glyphicon-floppy-disk"></span>', '#', ['escape' => false, 'onclick' => '$(\'#saveConfirmation\').modal()', 'class' => ['btn', 'btn-primary', 'btn-block']]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="saveConfirmation" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Are you sure you want to edit  <?= $membership->name?>'s membership?</h4>
            </div>
            <div class="modal-body">
                <?= $membership->user->first_name?> will receive an email confirming the update to their membership.

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <?= $this->Html->link('Save Changes', '#', ['onclick' => '$(\'#editForm\').submit()', 'class' => ['btn', 'btn-primary']]) ?>
            </div>
        </div>
    </div>
</div>
