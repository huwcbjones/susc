<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

use SUSC\Model\Entity\Membership;
use SUSC\Model\Entity\User;
use SUSC\View\AppView;

/**
 * Author: Huw
 * Since: 09/10/2017
 * @var AppView $this
 * @var Membership $membership
 * @var User $currentUser
 */

$this->assign('title', 'Membership');
$this->layout('profile');
?>

<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading"><?= $membership->name ?> - Membership: <?= $membership->membership_type->title ?></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <h2 class="h3">Your Details</h2>
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
                        <?= $this->Html->link('<span class="glyphicon glyphicon-chevron-left"></span> Back', ['_name' => 'memberships'], ['class' => ['btn', 'btn-default', 'btn-block'], 'escape' => false]) ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>