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

This email is to confirm your SUSC kit order #<?= $order->id ?>.
You can view your order on the SUSC website at: <?= $this->Url->build(['controller' => 'Kit', 'action' => 'vieworder', $order->id], ['fullBase' => true]) ?>


Your selected payment method is: <?= $order->paymentMethod ?>.
* Please note your order will not be accepted until payment is received. *

You can find out how to pay at <?= $this->Url->build('faq', ['fullBase' => true]) ?>

<?= str_repeat('=', 60) ?>

=<?= str_pad('Your Order', 58, ' ', STR_PAD_BOTH) ?>=
<?= str_repeat('=', 60) ?>

=<?= str_repeat(' ', 58) ?>=
<?php foreach ($order->items as $item) {
    $line = ' ' . str_pad($item->quantity, 2, ' ', STR_PAD_LEFT) . ' x ';

    $itemLine = '';
    if ($item->item->hasColour) {
        $itemLine .= $item->colour . ' ';
    }

    $itemLine .= $item->item->title;
    $itemLine = substr($itemLine, 0, 31 - (strlen($item->size) + 3));

    if ($item->item->hasSize) {
        $itemLine .= ' (' . $item->size . ')';
    }

    $line .= str_pad($itemLine, 31, ' ');

    $line .= ' @ ' . str_pad($item->formattedPrice, 8, ' ', STR_PAD_LEFT) . '  ' . str_pad($item->formattedSubtotal, 9, ' ', STR_PAD_LEFT);
    echo '=' . str_pad($line, 60, ' ') . "=\r\n";

    if ($item->item->additional_info) {
        echo str_pad('=      Additional Info: ' . substr($item->additional_info, 0, 35), 59, ' ') . "=\r\n";
    }

}
?>
=<?= str_repeat(' ', 58) ?>=
<?= str_repeat('=', 60) ?>

= Total to Pay: <?= str_pad($order->formattedTotal, 43, ' ', STR_PAD_LEFT) ?> =
<?= str_repeat('=', 60) ?>
