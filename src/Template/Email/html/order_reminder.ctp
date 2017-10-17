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
use SUSC\View\AppView;

/**
 * Author: Huw
 * Since: 09/10/2017
 *
 * @var User $user
 * @var AppView $this
 * @var Order $order
 */

?>

<p>Hi <?= $user->first_name ?>,</p>

<p>You have placed your kit order, but have yet to pay.
    You currently owe: <?= $order->formattedTotal ?></p>

<p>Your selected payment method is: <?= $order->paymentMethod ?>.
    Please note your order will not be ordered until payment is received.</p>

<p>You can find out how to pay at <?= $this->Html->link($this->Url->build(['_name' => 'faq'], ['fullBase' => true])) ?>.</p>

<p>Please ensure your order is paid for before the deadline.</p>