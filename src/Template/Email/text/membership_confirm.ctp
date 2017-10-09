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

This email is to confirm your SUSC membership. Your membership is as follows:

** <?= $membership->name ?> - Memberrhip **
Name: <?= $membership->name ?>

Student ID: <?= $membership->student_id ?>

Southampton ID: <?= $membership->soton_id ?>

Date of Birth: <?= $membership->date_of_birth ?>

Membership: <?= $membership->membership_type->title ?>

Membership Cost: <?= $membership->membership_type->formatted_price ?>

Your selected payment method is: <?= $membership->payment ?>

Please note your membership will not be valid until payment is received.
You can find out how to pay at <?= $this->Url->build(['_name' => 'faq'], ['fullBase' => true]) ?>.
