<?php

use SUSC\Model\Entity\Order;

/** @var Order $order */

$this->assign('title', 'Order #' . $order->id);
$this->layout('profile');
?>

<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading"> Order #<?= $order->id ?></div>
            <div class="panel-body">
                <p><strong>Ordered:</strong> <?= $this->Time->i18nFormat($order->placed, null, null, 'Europe/London') ?></p>
                <p><strong>Payment Method:</strong> <?= $order->paymentMethod ?></p>

                <p><strong>Payment:</strong> <?= ($order->is_paid)? $this->Time->i18nFormat($order->paid, null, null, 'Europe/London') : 'Outstanding'?></p>

                <p><strong>Status:</strong> <?= $order->status ?></p>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Item</th>
                        <th class="text-center">Additional Info</th>
                        <th class="text-center">Size</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($order->items as $item): ?>
                        <tr>
                            <th data-th="Item"><?= $this->Html->link(h($item->title), [
                                    'controller' => 'kit',
                                    'action' => 'view',
                                    'slug' => $item->slug
                                ]) ?></th>
                            <td data-th="Additional Info" class="text-center"><?= h($item->_joinData->additional_info) ?></td>
                            <td data-th="Size" class="text-center"><?= $item->_joinData->size ?></td>
                            <td data-th="Price" class="text-center"><?= $item->_joinData->formattedPrice ?></td>
                            <td data-th="Quantity" class="text-center"><?= $item->_joinData->quantity ?></td>
                            <td data-th="Quantity" class="text-center"><?= $item->_joinData->formattedSubtotal ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="4"></td>
                        <td class="text-center"><h3 class="h4">Total:</h3></td>
                        <td class="text-center" style="vertical-align: middle"><?= $order->formattedTotal ?> </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
