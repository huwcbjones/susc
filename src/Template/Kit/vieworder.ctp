<?php

use SUSC\Model\Entity\Order;
use SUSC\View\AppView;

/** @var Order $order
 * @var AppView $this
 */

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
                        <th scope="col"><attr title="Ordered">O?</attr></th>
                        <th scope="col"><attr title="Arrived">A?</attr></th>
                        <th scope="col"><attr title="Collected">C?</attr></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($order->items as $item): ?>
                        <tr>
                            <th data-th="Item"><?= $this->Html->link($item->item->title, [
                                    'controller' => 'kit',
                                    'action' => 'view',
                                    'slug' => $item->item->slug,
                                    'crc' => $item->item->crc
                                ]) ?></th>
                            <td data-th="Additional Info" class="text-center"><?= $item->item->displayAdditionalInformation($item->additional_info) ?></td>
                            <td data-th="Size" class="text-center"><?= $item->size ?></td>
                            <td data-th="Price" class="text-center"><?= $item->formattedPrice ?></td>
                            <td data-th="Quantity" class="text-center"><?= $item->quantity ?></td>
                            <td data-th="Quantity" class="text-center"><?= $item->formattedSubtotal ?></td>
                            <td><span class="text-<?= ($item->is_ordered ? 'success' : 'danger') ?> glyphicon glyphicon-<?= ($item->is_ordered ? 'ok' : 'remove') ?>-sign"></span></td>
                            <td><span class="text-<?= ($item->is_arrived ? 'success' : 'danger') ?> glyphicon glyphicon-<?= ($item->is_arrived ? 'ok' : 'remove') ?>-sign"></span></td>
                            <td><span class="text-<?= ($item->is_collected ? 'success' : 'danger') ?> glyphicon glyphicon-<?= ($item->is_collected ? 'ok' : 'remove') ?>-sign"></span></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="4"></td>
                        <td class="text-center"><h3 class="h4">Total:</h3></td>
                        <td class="text-center" style="vertical-align: middle"><?= $order->formattedTotal ?> </td>
                        <td colspan="3"></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
