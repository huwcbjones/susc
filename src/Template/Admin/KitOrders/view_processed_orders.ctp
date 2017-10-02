<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

use SUSC\Model\Entity\ProcessedOrder;
use SUSC\View\AppView;

/**
 * Author: Huw
 * Since: 29/09/2017
 * @var AppView $this
 * @var ProcessedOrder $order
 */

$this->assign('title', 'View Batch # ' . $order->id);

?>
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading"> Batch #<?= $order->id ?></div>
            <div class="panel-body">
                <p><strong>Ordered:</strong> <?= $order->order_date ?></p>

                <p><strong>Status:</strong> <?= $order->status ?></p>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Item</th>
                        <th class="text-center">Additional Info</th>
                        <th class="text-center">Size</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Subtotal</th>
                        <?php if ($currentUser->isAuthorised('admin.kit-orders.status')) : ?>
                            <th scope="col">
                                <attr title="Ordered">O?</attr>
                            </th>
                            <th scope="col">
                                <attr title="Arrived">A?</attr>
                            </th>
                            <th scope="col"><?= ($order->is_all_collected || !$order->is_all_arrived ? '<attr title="Collected">C?</attr>' : 'Collected?') ?></th>
                        <?php endif ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($order->items_orders as $item): ?>
                        <tr>
                            <th><?= $item->order->user->full_name ?> </th>
                            <td data-th="Item"><?= $this->Html->link(h($item->item->title), [
                                    '_name' => 'kit_item',
                                    'action' => 'view',
                                    'slug' => $item->item->slug
                                ]) ?></td>
                            <td data-th="Additional Info"
                                class="text-center"><?= h($item->item->displayAdditionalInformation($item->additional_info)) ?></td>
                            <td data-th="Size" class="text-center"><?= $item->size ?></td>
                            <td data-th="Price" class="text-center"><?= $item->formattedPrice ?></td>
                            <td data-th="Quantity" class="text-center"><?= $item->quantity ?></td>
                            <td data-th="Quantity" class="text-center"><?= $item->formattedSubtotal ?></td>
                            <?php if ($currentUser->isAuthorised('admin.kit-orders.status')) : ?>
                                <td><?= $order->getOrderedStatusIcon() ?></td>
                                <td><?= $order->getArrivedStatusIcon() ?></td>
                                <td><?= $item->getCollectedStatusIcon() ?>&nbsp;&nbsp;&nbsp;
                                    <?php if (!$item->collected && $order->is_arrived): ?>
                                        <?= ($order->is_arrived) ? $this->Form->postLink(__('Collected'), ['action' => 'collected', $item->id], ['confirm' => 'Mark item as collected?\nYou cannot revert this status!']) : 'Collected' ?>
                                    <?php endif; ?>
                                </td>
                            <?php endif ?>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="3"></td>
                        <th class="text-center" colspan="2"><h3 class="h4">Total:</h3></th>
                        <th class="text-center" style="vertical-align: middle"><?= $order->item_count ?></th>
                        <th class="text-center" style="vertical-align: middle"><?= $order->formatted_total ?></th>
                        <?php if ($currentUser->isAuthorised('admin.kit-orders.status')) : ?>
                            <th colspan="3"></th>
                        <?php endif ?>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>