<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

use SUSC\Model\Entity\ItemsOrder;
use SUSC\Model\Entity\ProcessedOrder;
use SUSC\View\AppView;

/**
 * Author: Huw
 * Since: 29/09/2017
 * @var AppView $this
 * @var ProcessedOrder $order
 * @var ItemsOrder[] $items
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
                                        <li><?= $this->Form->postLink('Mark as <strong>not</strong> Ordered', ['action' => 'ordered', $order->id], ['escape' => false]) ?></li>
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
                <p><strong>Arrived:</strong> <?= $order->arrived_date ?></p>
                <p><strong>Status:</strong> <?= $order->status ?></p>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('order_id', 'Order #') ?></th>
                        <th><?= $this->Paginator->sort('Users.last_name', 'Name') ?></th>
                        <th><?= $this->Paginator->sort('item_id', 'Item') ?></th>
                        <th class="text-center"><?= $this->Paginator->sort('size') ?></th>
                        <th class="text-center"><?= $this->Paginator->sort('colour') ?></th>
                        <th class="text-center"><?= $this->Paginator->sort('additional_info', 'Info') ?></th>
                        <th class="text-center"><?= $this->Paginator->sort('quantity') ?></th>
                        <?php if ($this->hasAccessTo('admin.kit-orders.status')) : ?>
                            <th><?= $this->Paginator->sort('Orders.paid', '<attr title="Paid">P?</attr>', ['escape' => false]) ?></th>
                            <th scope="col">
                                <?php if (!$order->is_all_collected): ?>
                                    <?= $this->Paginator->sort('collected', '<attr title="Collected">C?</attr>', ['escape' => false]) ?>
                                <?php else: ?>
                                    <attr title="Collected">C?</attr>
                                <?php endif; ?>
                            </th>
                        <?php endif ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr<?= $this->request->getQuery('highlight') === $item->id
                        || $this->request->getQuery('user_id') === $item->order->user_id
                        || $this->request->getQuery('item_id') === $item->item_id ? ' class="info"' : '' ?>>
                            <th id="<?= $item->id ?>"><?= $this->Html->link($item->order->id, ['action' => 'view', $item->order->id]) ?></th>
                            <td><?= $this->Html->link($item->order->user->full_name, [$order->id, 'user_id' => $item->order->user->id]) ?></td>
                            <td data-th="Item"><?= $this->Html->link(h($item->item->title), [$order->id, 'item_id' => $item->item_id]) ?></td>
                            <td data-th="Size" class="text-center"><?= $item->item->displaySize($item->size) ?></td>
                            <td data-th="Colouor" class="text-center"><?= $item->item->displayColour($item->colour) ?></td>
                            <td data-th="Additional Info"
                                class="text-center"><?= h($item->item->displayAdditionalInformation($item->additional_info)) ?></td>

                            <td data-th="Quantity" class="text-center"><?= $item->quantity ?></td>
                            <?php if ($this->hasAccessTo('admin.kit-orders.status')) : ?>
                                <td><?= $item->order->getPaidStatusIcon() ?></td>
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
                        <?php if ($this->hasAccessTo('admin.kit-orders.status')) : ?>
                            <th colspan="2"></th>
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
                <?= $this->Form->button('Mark as Collected', ['class' => ['btn', 'btn-primary']]) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>