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
    <div class="panel-heading"><?= $membership->name ?> - Membership: <?= $membership->membership_type->title ?></div>
    <div class="panel-body">
        <h2 class="h3">Your Details</h2>
        <p><strong>Name:</strong> <?= $membership->name ?></p>
        <p><strong>Student ID:</strong> <?= $membership->student_id ?></p>
        <p><strong>Southampton ID:</strong> <?= $membership->soton_id ?></p>
        <p><strong>Date of Birth:</strong> <?= $membership->date_of_birth ?></p>

        <h2 class="h3">Membership Details</h2>
        <p><strong>Membership Type:</strong> <?= $membership->membership_type->title ?></p>
        <p><strong>Membership Cost:</strong> <?= $membership->membership_type->formatted_price ?></p>
    </div>
</div>


<p>Your selected payment method is: <?= $membership->payment ?>.
    Please note your membership will not be valid until payment is received.</p>

<p>You can find out how to pay at <?= $this->Html->link($this->Url->build(['_name' => 'faq'], ['fullBase' => true])) ?>.</p>
