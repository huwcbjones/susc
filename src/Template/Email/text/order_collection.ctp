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

<?= str_repeat('=', 60) ?>

=<?= str_pad('Your Items', 58, ' ', STR_PAD_BOTH) ?>=
<?= str_repeat('=', 60) ?>

=<?= str_repeat(' ', 58) ?>=
<?php foreach ($order->items as $item) {
    $line = ' ' . str_pad($item->quantity, 2, ' ', STR_PAD_LEFT) . ' x ';

    $itemLine = '';
    if ($item->item->hasColour) {
        $itemLine .= $item->colour . ' ';
    }

    $itemLine .= $item->item->title;
    $itemLine = substr($itemLine, 0, 52 - (strlen($item->size) + 3));

    if ($item->item->hasSize) {
        $itemLine .= ' (' . $item->size . ')';
    }

    $line .= str_pad($itemLine, 52, ' ');

    echo '=' . str_pad($line, 58, ' ') . "=\r\n";

    if ($item->item->additional_info) {
        echo str_pad('=      Additional Info: ' . substr($item->additional_info, 0, 35), 59, ' ') . "=\r\n";
    }

}
?>
=<?= str_repeat(' ', 58) ?>=
<?= str_repeat('=', 60) ?>

