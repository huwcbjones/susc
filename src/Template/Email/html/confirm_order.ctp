<?php

use SUSC\Model\Entity\Order;
use SUSC\Model\Entity\User;
use SUSC\View\AppView;

/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

/**
 * Author: Huw
 * Since: 29/09/2017
 *
 * @var User $user
 * @var AppView $this
 * @var Order $order
 */

?>

<p>Hi <?= $user->first_name ?>,</p>

<p>This email is to confirm your SUSC kit order.
    Your order is as follows:</p>

<table class="table">
    <thead>
    <tr>
        <th>Item</th>
        <th>Additional Info</th>
        <th>Size</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Subtotal</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($order->items as $item): ?>
        <tr>
            <th><?= $this->Html->link($item->item->title, ['_name' => 'kit_item', 'slug' => $item->item->slug], ['fullBase' => true]) ?></th>
            <td><?= $item->additional_info ?></td>
            <td><?= $item->size ?></td>
            <td><?= $item->quantity ?></td>
            <td><?= $item->item->formatted_price ?></td>
            <td><?= $item->formattedSubtotal ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="4"></td>
        <th>Total</th>
        <th><?= $order->formattedTotal ?></th>
    </tr>
    </tfoot>
</table>


<p>Your selected payment method is: <?= $order->paymentMethod ?>.
    Please note your order will not be accepted until payment is received.</p>

<p>You can find out how to pay at <?= $this->Html->link($this->Url->build(['_name' => 'faq'], ['fullBase' => true])) ?>.</p>