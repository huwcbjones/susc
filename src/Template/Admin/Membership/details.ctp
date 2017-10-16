<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

use SUSC\Model\Entity\Membership;
use SUSC\View\AppView;

/**
 * Author: Huw
 * Since: 09/10/2017
 *
 * @var Membership $membership
 * @var AppView $this
 */
$this->assign('title', $membership->full_name . ' - Membership');
?>

<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 style="display:inline"><?= $membership->full_name ?> - Membership: <?= $membership->membership_type->title ?></h3>
                <?php if(!$membership->is_cancelled): ?>
                <div style="display:inline" class="pull-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">Options <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <?php if(!$membership->is_paid): ?><li><a href="#" onclick="$('#paidConfirmation').modal()">Mark Paid</a></li><?php endif ?>
                            <li><?= $this->Html->link('Edit Membership', ['action' => 'edit_membership', $membership->id]) ?></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#" onclick="$('#cancelConfirmation').modal()">Cancel Membership</a></li>
                        </ul>
                    </div>
                </div>
                <?php endif ?>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <h2 class="h3">Their Details</h2>
                        <p><strong>First Name:</strong> <?= $membership->first_name ?></p>
                        <p><strong>Last Name:</strong> <?= $membership->last_name ?></p>
                        <p><strong>Student ID:</strong> <?= $membership->student_id ?></p>
                        <p><strong>Southampton ID:</strong> <?= $membership->soton_id ?></p>
                        <p><strong>Date of Birth:</strong> <?= $membership->date_of_birth ?></p>

                        <h2 class="h3">Membership Details</h2>
                        <p><strong>Membership Type:</strong> <?= $membership->membership_type->title ?></p>
                        <p><strong>Membership Cost:</strong> <?= $membership->membership_type->formatted_price ?></p>
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

            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-0 col-lg-4">
                        <?= $this->Html->link('<span class="glyphicon glyphicon-chevron-left"></span> Back', ['action' => 'members'], ['class' => ['btn', 'btn-default', 'btn-block'], 'escape' => false]) ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php if(!$membership->is_cancelled): ?>
<div class="modal fade" id="cancelConfirmation" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?= $this->Form->create(null, ['id' => 'cancelForm', 'url' => ['action' => 'cancel']]) ?>
            <?= $this->Form->hidden('id', ['value' => $membership->id]); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Are you sure you want to cancel this membership?</h4>
            </div>
            <div class="modal-body">
                <?php if($membership->is_paid): ?>
                    As the user has paid for this membership, the money may need to be reimbursed.<br/>
                <?php endif ?>
                This action cannot be reversed.

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Abort</button>
                <?= $this->Form->button('Cancel Membership', ['class' => ['btn', 'btn-danger']]) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<?php endif ?>
<?php if(!$membership->is_paid): ?>
<div class="modal fade" id="paidConfirmation" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?= $this->Form->create(null, ['id' => 'paidForm', 'url' => ['action' => 'paid']]) ?>
            <?= $this->Form->hidden('id', ['value' => $membership->id]); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Are you sure you want to mark this membership as paid?</h4>
            </div>
            <div class="modal-body">
                The user will receive an email confirming the membership has been paid.<br/>
                This action cannot be reversed.

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <?= $this->Form->button('Mark as Paid', ['class' => ['btn', 'btn-primary']]) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<?php endif ?>