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
<p>Hi <?= $user->first_name ?>,</p>

<p>This email is to let you know that some of the items you ordered are ready for collection.<br/>
    These items are:</p>
<table class="table">
    <thead>
    <tr>
        <th>Item</th>
        <th>Additional Info</th>
        <th>Size</th>
        <th>Quantity</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($order->items as $item): ?>
        <tr>
            <th><?= $this->Html->link($item->item->title, ['_name' => 'kit_item', 'slug' => $item->item->slug], ['fullBase' => true]) ?></th>
            <td><?= $item->additional_info ?></td>
            <td><?= $item->size ?></td>
            <td><?= $item->quantity ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>