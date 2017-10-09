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
 *
 * @var User $user
 * @var AppView $this
 * @var Membership $membership
 */

?>

<p>Hi <?= $user->first_name ?>,</p>

<p>This email is to confirm your SUSC membership.
    Your membership is as follows:</p>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3><?= $membership->name ?> - Membership</h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal">
            <div class="form-group-lg">
                <label class="col-xs-3 control-label">Name</label>
                <div class="col-xs-9">
                    <p class="form-control-static"><?= $membership->name ?></p>
                </div>
            </div>
            <div class="form-group-lg">
                <label class="col-xs-3 control-label">Student ID</label>
                <div class="col-xs-9">
                    <p class="form-control-static"><?= $membership->student_id ?></p>
                </div>
            </div>
            <div class="form-group-lg">
                <label class="col-xs-3 control-label">Southampton ID</label>
                <div class="col-xs-9">
                    <p class="form-control-static"><?= $membership->soton_id ?></p>
                </div>
            </div>
            <div class="form-group-lg">
                <label class="col-xs-3 control-label">Date of Birth</label>
                <div class="col-xs-9">
                    <p class="form-control-static"><?= $membership->date_of_birth ?></p>
                </div>
            </div>
            <div class="form-group-lg">
                <label class="col-xs-3 control-label">Membership</label>
                <div class="col-xs-9">
                    <p class="form-control-static"><?= $membership->membership_type->title ?></p>
                </div>
            </div>
            <div class="form-group-lg">
                <label class="col-xs-3 control-label">Membership Cost</label>
                <div class="col-xs-9">
                    <p class="form-control-static"><?= $membership->membership_type->formatted_price ?></p>
                </div>
            </div>
        </form>
    </div>
</div>


<p>Your selected payment method is: <?= $membership->payment ?>.
    Please note your membership will not be valid until payment is received.</p>

<p>You can find out how to pay at <?= $this->Html->link($this->Url->build(['_name' => 'faq'], ['fullBase' => true])) ?>.</p>
