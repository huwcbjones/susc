<?php

use SUSC\Model\Entity\Order;
use SUSC\Model\Entity\User;

/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

/**
 * Author: Huw
 * Since: 02/10/2017
 *
 * @var User $user
 * @var Order $order
 */
?>
Hi <?= $user->first_name ?>,

This email is to confirm your payment for your kit order #<?= $order->id ?> has been received.

You will receive another email when your item(s) are ready for collection.
