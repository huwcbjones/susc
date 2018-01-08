<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

use SUSC\Model\Entity\ItemsOrder;
use SUSC\Model\Entity\User;

/**
 * Author: Huw
 * Since: 02/10/2017
 *
 * @var User $user
 * @var ItemsOrder $item
 */
?>
<p>Hi <?= $user->first_name ?>,</p>

<p>This email is to confirm that you collected your <?= $item->item->title ?> on <?= $item->collected_date ?>.</p>

<table class="table table-bordered table-condensed">
    <tr>
        <th>Item</th>
        <td><?= $item->item->title ?></td>
    </tr>
    <tr>
        <th>Colour</th>
        <td><?= $item->item->displayColour($item->colour) ?></td>
    </tr>
    <tr>
        <th>Size</th>
        <td><?= $item->item->displaySize($item->size) ?></td>
    </tr>
    <tr>
        <th>Quantity</th>
        <td><?= $item->quantity ?></td>
    </tr>
    <tr>
        <th>Additional Information</th>
        <td><?= $item->item->displayAdditionalInformation($item->additional_info) ?></td>
    </tr>
</table>
