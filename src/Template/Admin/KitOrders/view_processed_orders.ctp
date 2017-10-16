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
            <div class="panel-heading"><h3 style="display:inline">Batch #<?= $order->id ?></h3>
                <?php if ($this->hasAccessTo('admin.kit-orders.process') && !$order->is_arrived): ?>
                    <div style="display:inline" class="pull-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">Options <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <?php if (!$order->is_arrived): ?>
                                    <?php if (!$order->is_ordered): ?>
                                        <li><?= $this->Form->postLink(__('Mark as Ordered'), ['action' => 'ordered', $order->id]) ?></li>
                                    <?php else: ?>
                                        <li><?= $this->Form->postLink(__('Mark as not Ordered'), ['action' => 'ordered', $order->id]) ?></li>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if ($order->is_ordered && !$order->is_arrived) : ?>
                                    <li><a href="#" onclick="$('#arriveConfirmation').modal()">Mark as Arrived</a></li>
                                <?php endif ?>
                            </ul>
                        </div>
                    </div>
                <?php endif ?></div>
            <div class="panel-body">
                <p><strong>Ordered:</strong> <?= $order->order_date ?></p>

                <p><strong>Status:</strong> <?= $order->status ?></p>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Name</th>
                        <th>Item</th>
                        <th class="text-center">Additional Info</th>
                        <th class="text-center">Size</th>
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
                    <?php foreach ($order->items_orders as $item): ?>
                        <tr>
                            <th><?= $this->Html->link($item->order->id, ['action' => 'view', $item->order->id]) ?></th>
                            <td><?= $item->order->user->full_name ?></td>
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
                            <?php if ($this->hasAccessTo('admin.kit-orders.status')) : ?>
                                <td><?= $order->getOrderedStatusIcon() ?></td>
                                <td><?= $order->getArrivedStatusIcon() ?></td>
                                <td><?= $item->getCollectedStatusIcon() ?>
                                    <?php if (!$item->collected && $order->is_arrived): ?>&nbsp;&nbsp;&nbsp;
                                        <a href="#" onclick="$('#collectedID').val('<?= $item->id ?>');$('#collectedConfirmation').modal()">Collected</a>
                                    <?php endif; ?>
                                </td>
                            <?php endif ?>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="4"></td>
                        <th class="text-center" colspan="2"><h3 class="h4">Total:</h3></th>
                        <th class="text-center" style="vertical-align: middle"><?= $order->item_count ?></th>
                        <th class="text-center" style="vertical-align: middle"><?= $order->formatted_total ?></th>
                        <?php if ($this->hasAccessTo('admin.kit-orders.status')) : ?>
                            <th colspan="3"></th>
                        <?php endif ?>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="arriveConfirmation" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?= $this->Form->create(null, ['id' => 'arriveForm', 'url' => ['action' => 'arrived']]) ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Are you sure you want to mark Batch <?= $order->id ?> as arrived?</h4>
            </div>
            <div class="modal-body">
                If you mark Batch <?= $order->id ?> as arrived, users with items in this batch will be notified via email that their items are available for
                collection.<br/>
                In addition, after setting a batch as arrived, you cannot revert the status.

                <?= $this->Form->hidden('id', ['value' => $order->id]); ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <?= $this->Form->button('Confirm', ['class' => ['btn', 'btn-primary']]) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<div class="modal fade" id="collectedConfirmation" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?= $this->Form->create(null, ['id' => 'collectedForm', 'url' => ['action' => 'collected']]) ?>
            <?= $this->Form->hidden('id', ['id' => 'collectedID']); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Are you sure you want to mark this item as collected?</h4>
            </div>
            <div class="modal-body">
                The person who ordered this item will be sent an email confirming their item has been collected.<br/>
                This action cannot be reversed.

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <?= $this->Form->button('Mark as Arrived', ['class' => ['btn', 'btn-primary']]) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>