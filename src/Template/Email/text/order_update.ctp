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

Your SUSC kit order #<?= $order->id ?> has been updated.
You can view your order on the SUSC website at: <?= $this->Url->build(['controller' => 'Kit', 'action' => 'vieworder', $order->id], ['fullBase' => true]) ?>

<?php if($toPay != 0): ?>
<?php if($toPay > 0): ?>
You now owe SUSC <?= sprintf("£%.2f", $toPay) ?>.
This needs to be paid before your order is accepted!
<?php else: ?>
SUSC now owes you <?= sprintf("£%.2f", abs($toPay))?>.
Please contact the treasurer to arrange your reimbursement.
<?php endif ?>
<?php endif ?>

<?php if(!$order->is_paid): ?>
Your selected payment method is: <?= $order->paymentMethod ?>.
* Please note your order will not be accepted until payment is received. *

You can find out how to pay at <?= $this->Url->build('faq', ['fullBase' => true]) ?>
<?php endif ?>

<?= str_repeat('=', 60) ?>

=<?= mb_str_pad('Your Order', 58, ' ', STR_PAD_BOTH) ?>=
<?= str_repeat('=', 60) ?>

=<?= str_repeat(' ', 58) ?>=
<?php foreach ($order->items as $item) {
    $line = ' ' . mb_str_pad($item->quantity, 2, ' ', STR_PAD_LEFT) . ' x '; // 7

    $itemLine = '';
    if ($item->item->hasColour) {
        $itemLine .= $item->colour . ' ';
    }

    $itemLine .= $item->item->title;
    $itemLine = substr($itemLine, 0, 30 - (strlen($item->size) + 3)); // 60 - 2 - 7 - 22 = 29

    if ($item->item->hasSize) {
        $itemLine .= ' (' . $item->size . ')';
    }

    $line .= mb_str_pad($itemLine, 29, ' '); // 29

    $line .= ' @ ' . mb_str_pad($item->formattedPrice, 9, ' ', STR_PAD_LEFT) . ' ' . mb_str_pad($item->formattedSubtotal, 9, ' ', STR_PAD_LEFT); // 22
    echo '=' . mb_str_pad($line, 58, ' ') . "=\r\n"; // 2 + 29 + 22

    if ($item->item->additional_info) {
        echo mb_str_pad('=      Additional Info: ' . substr($item->additional_info, 0, 35), 59, ' ', STR_PAD_RIGHT) . "=\r\n";
    }

}
?>
=<?= str_repeat(' ', 58) ?>=
<?= str_repeat('=', 60) ?>

= Total to Pay: <?= str_pad($order->formattedTotal, 43, ' ', STR_PAD_LEFT) ?> =
<?= str_repeat('=', 60) ?>
