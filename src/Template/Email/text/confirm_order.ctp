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

Hi <?= $user->first_name ?>,

This email is to confirm your SUSC kit order.
Your order is as follows:

<?php foreach($order->items as $item): ?>
 - <?= $item->quantity?> x <?= $item->item->title ?><?php if($item->item->additional_info): ?>, <?= $item->additional_info ?><?php endif ?><?php if($item->size !=null):?>, <?= $item->size ?><?php endif; ?> @ <?= $item->item->formattedPrice ?> = <?= $item->formattedSubtotal ?>
<?php endforeach; ?>

Total: <?= $order->formattedTotal ?>


Your selected payment method is: <?= $order->paymentMethod ?>.
Please note your order will not be accepted until payment is received.

You can find out how to pay at <?= $this->Url->build('faq', ['fullBase' => true]); ?>.
