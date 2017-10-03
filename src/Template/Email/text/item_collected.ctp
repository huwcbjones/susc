<?php

use SUSC\Model\Entity\ItemsOrder;
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
 * @var ItemsOrder $item
 */
?>
Hi <?= $user->first_name ?>,

This email is to confirm that you collected your <?= $item->item->title ?> on <?= $item->collected_date ?>.

Item: <?= $item->item->title ?>

Size: <?= $item->size ?>

Quantity: <?= $item->quantity ?>

Additional Information: <?= $item->additional_info ?>

