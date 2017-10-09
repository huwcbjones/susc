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

<p>This email is to let you know that your SUSC membership has been cancelled.</p>

<div class="panel panel-default">
    <div class="panel-heading"><?= $membership->name ?> - Membership: <?= $membership->membership_type->title ?></div>
    <div class="panel-body">
        <h2 class="h3">Your Details</h2>
        <p><strong>Name:</strong> <?= $membership->name ?></p>

        <h2 class="h3">Membership Details</h2>
        <p><strong>Registered:</strong> <?= $membership->created ?></p>
        <p><strong>Membership Type:</strong> <?= $membership->membership_type->title ?></p>
        <p><strong>Membership Cost:</strong> <?= $membership->membership_type->formatted_price ?></p>
    </div>
</div>


<p>If you were not expecting your membership to be cancelled please contact a member of committee ASAP.</p>