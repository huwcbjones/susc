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

Hi <?= $user->first_name ?>,

This email is to confirm your SUSC membership payment. Your membership is as follows:

** <?= $membership->name ?> - Membership: <?= $membership->membership_type->title ?> **
Membership: <?= $membership->membership_type->title ?>

Membership Cost: <?= $membership->membership_type->formatted_price ?>


If you have any questions, please contact a member of committee.