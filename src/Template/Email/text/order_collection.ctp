<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

use SUSC\Model\Entity\Order;
use SUSC\Model\Entity\User;

/**
 * Author: Huw
 * Since: 02/10/2017
 *
 * @var Order $order
 * @var User $user
 */

?>
Hi <?= $user->first_name ?>,

This email is to let you know that some of the items you ordered are ready for collection.

These items are:

<?php foreach($order->items as $item): ?>
- <?= $item->quantity?> x <?= $item->item->title ?><?php if($item->size !=null):?> (<?= $item->size ?>)<?php endif; ?><?php if($item->item->additional_info): ?>, <?= $item->additional_info ?><?php endif ?>

<?php endforeach; ?>
