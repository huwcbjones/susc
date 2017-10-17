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

<p>You have registered your membership, but have yet to pay.
    You currently owe: <?= $membership->membership_type->formatted_price ?></p>

<p>Your selected payment method is: <?= $membership->payment ?>.
    Please note your membership will not be valid until payment is received.</p>

<p>You can find out how to pay at <?= $this->Html->link($this->Url->build(['_name' => 'faq'], ['fullBase' => true])) ?>.</p>

<p>Please ensure your membership is paid for before the deadline.</p>