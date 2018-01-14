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
 * Since: 08/09/2017
 * @var Order $order
 * @var User $currentUser
 * @var AppView $this
 */

$this->assign('title', 'View Order #' . $order->id);
?>

<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div>
                    <h3 style="display:inline">Order #<?= $order->id ?></h3>
                    <?php if (((!$order->is_paid && !$order->is_cancelled || $order->ordered_left == count($order->items)) && $this->hasAccessTo('admin.kit-orders.status')) || $this->hasAccessTo('admin.kit-orders.edit')): ?>
                        <div style="display:inline" class="pull-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">Options <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <?php if ($this->hasAccessTo('admin.kit-orders.edit')): ?>
                                        <li><?= $this->Html->link('Edit Order', ['action' => 'edit', $order->id]) ?></li>
                                    <?php endif ?>
                                    <?php if (!$order->is_paid): ?>
                                        <li><a href="#" onclick="$('#paymentConfirmation').modal()">Mark Paid</a></li>
                                    <?php endif ?>
                                    <?php if ($order->ordered_left == count($order->items)): ?>
                                        <?php /* <li><?= $this->Html->link('Edit Order', ['action' => 'edit', $order->id]) ?></li>
                                        <li role="separator" class="divider"></li> */ ?>
                                        <li><a href="#" onclick="$('#cancelConfirmation').modal()">Cancel Order</a></li>
                                    <?php endif ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif ?>
                </div>
            </div>
            <div class="panel-body">
                <p><strong>Name:</strong> <?= $order->user->full_name ?></p>
                <p><strong>Ordered:</strong> <?= $order->placed_date ?></p>
                <p><strong>Payment Method:</strong> <?= $order->paymentMethod ?></p>

                <p><strong>Payment:</strong> <?= $order->paid_date ?></p>

                <p><strong>Status:</strong> <?= $order->status ?></p>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Item</th>
                        <th>Batch</th>
                        <th class="text-center">Size</th>
                        <th class="text-center">Colour</th>
                        <th class="text-center">Info</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Subtotal</th>
                        <?php if ($this->hasAccessTo('admin.kit-orders.status')) : ?>
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
                    <?php foreach ($order->items as $item): ?>
                        <tr<?= $this->request->getQuery('highlight') === $item->id ? ' class="info"' : '' ?>>
                            <th data-th="Item"><?= $this->Html->link(h($item->item->title), ['_name' => 'kit_item',
                                    'action' => 'view',
                                    'slug' => $item->item->slug,
                                    'crc' => $item->item->crc]) ?></th>
                            <td><?= $item->processed_order_id !== null ? $this->Html->link($item->processed_order_id, ['action' => 'processedOrders', $item->processed_order_id, 'highlight' => $item->id]) : '-' ?></td>
                            <td data-th="Size" class="text-center"><?= $item->item->displaySize($item->size) ?></td>
                            <td data-th="Colour" class="text-center"><?= $item->item->displayColour($item->colour) ?></td>
                            <td data-th="Additional Info"
                                class="text-center"><?= $item->item->displayAdditionalInformation($item->additional_info) ?></td>
                            <td data-th="Price" class="text-center"><?= $item->formattedPrice ?></td>
                            <td data-th="Quantity" class="text-center"><?= $item->quantity ?></td>
                            <td data-th="Quantity" class="text-center"><?= $item->formattedSubtotal ?></td>
                            <?php if ($this->hasAccessTo('admin.kit-orders.status')) : ?>
                                <td><?= $item->getOrderedStatusIcon() ?></td>
                                <td><?= $item->getArrivedStatusIcon() ?></td>
                                <td><?= $item->getCollectedStatusIcon() ?>
                                <?php if (!$item->collected && $item->is_arrived): ?>
                                    &nbsp;&nbsp;&nbsp;
                                    <?= ($item->is_arrived) ? '<a href="#" onclick="$(\'#collectedID\').val(\'' . $item->id . '\'); $(\'#collectedConfirmation\').modal()">Collected</a>' : 'Collected' ?></td>
                                <?php endif; ?>
                            <?php endif ?>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="6"></td>
                        <td class="text-center"><h3 class="h4">Total:</h3></td>
                        <td class="text-center" style="vertical-align: middle"><?= $order->formattedTotal ?> </td>
                        <?php if ($this->hasAccessTo('admin.kit-orders.status')) : ?>
                            <th colspan="2"></th>
                            <th style="vertical-align: middle"><?= $order->collected_left ?></th>
                        <?php endif ?>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="paymentConfirmation" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?= $this->Form->create(null, ['id' => 'paymentForm', 'url' => ['action' => 'paid']]) ?>
            <?php $this->Form->unlockField('id'); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Are you sure you want to mark Order #<?= $order->id ?> as paid?</h4>
            </div>
            <div class="modal-body">
                If you mark this order as paid, <?= $order->user->first_name ?> will receive an email letting them know that their payment has been
                received.<br/>
                This action cannot be reversed.

                <?= $this->Form->hidden('id', ['value' => $order->id]); ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <?= $this->Form->button('Confirm Payment', ['class' => ['btn', 'btn-primary']]) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<div class="modal fade" id="cancelConfirmation" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?= $this->Form->create(null, ['id' => 'cancelForm', 'url' => ['action' => 'cancel']]) ?>
            <?php $this->Form->unlockField('id'); ?>
            <?= $this->Form->hidden('id', ['value' => $order->id]); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Are you sure you want to cancel Order #<?= $order->id ?>?</h4>
            </div>
            <div class="modal-body">
                <?php if ($order->is_paid): ?>
                    As <?= $order->user->first_name ?> has paid for this order, their money will need to be returned.<br/>
                <?php endif ?>
                <?= $order->user->first_name ?> will receive an email letting them know that their order has been cancelled.<br/>
                This action cannot be reversed.

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Abort</button>
                <?= $this->Form->button('Cancel Order', ['class' => ['btn', 'btn-danger']]) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<div class="modal fade" id="collectedConfirmation" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?= $this->Form->create(null, ['id' => 'collectedForm', 'url' => ['action' => 'collected']]) ?>
            <?php $this->Form->unlockField('id'); ?>
            <?= $this->Form->hidden('id', ['id' => 'collectedID']); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Are you sure you want to mark this item as collected?</h4>
            </div>
            <div class="modal-body">
                <?= $order->user->first_name ?> will receive an email confirming that the item has been collected.<br/>
                This action cannot be reversed.

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <?= $this->Form->button('Mark as Collected', ['class' => ['btn', 'btn-primary']]) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>