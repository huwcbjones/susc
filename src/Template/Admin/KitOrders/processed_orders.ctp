<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

/**
 * Author: Huw
 * Since: 26/09/2017
 *
 * @var AppView $this
 * @var User $currentUser
 * @var ProcessedOrder[]|CollectionInterface $orders []
 */

use Cake\Collection\CollectionInterface;
use SUSC\Model\Entity\ProcessedOrder;
use SUSC\Model\Entity\User;
use SUSC\View\AppView;

$this->assign('title', 'Processed Orders');
?>

<div class="users index large-9 medium-8 columns content">
    <div class="table-responsive">
        <table class="table table-hover table-striped table-condensed">
            <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id', 'Batch #') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created', 'Order Date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('item_count', 'Items') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total', 'Total') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_ordered', '<attr title="Ordered">O?</attr>', ['escape' => false]) ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_arrived', '<attr title="Arrived">A?</attr>', ['escape' => false]) ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_collected', '<attr title="Collected">C?</attr>', ['escape' => false]) ?></th>
                <?php if ($this->hasAccessTo('admin.kit-orders.process')): ?>
                    <th scope="col" class="actions"></th>
                <?php endif; ?>
                <?php if ($this->hasAccessTo('admin.kit-orders.process')): ?>
                    <th scope="col" class="actions"></th>
                <?php endif ?>
                <?php if ($this->hasAccessTo('admin.kit-orders.view')): ?>
                    <th scope="col" class="actions" colspan="2"></th>
                <?php endif ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <th><?= h($order->id) ?></th>
                    <td><?= $order->order_date ?></td>
                    <td><?= h($order->item_count) ?></td>
                    <td><?= h($order->formattedTotal) ?></td>
                    <td>
                        <?= $order->getOrderedStatusIcon() ?>
                    </td>
                    <td>
                        <?= $order->getArrivedStatusIcon() ?>
                    </td>
                    <td>
                        <?= $order->getCollectedStatusIcon() ?>
                    </td>
                    <?php if ($this->hasAccessTo('admin.kit-orders.process')): ?>
                        <td>
                            <?php if (!$order->is_arrived): ?>
                                <?= $this->Form->postLink(__('Ordered'), ['action' => 'ordered', $order->id]) ?>
                            <?php endif ?>
                        </td>
                    <?php endif; ?>
                    <?php if ($this->hasAccessTo('admin.kit-orders.process')): ?>
                        <td>
                            <?php if (!$order->is_arrived): ?>
                                <?php if ($order->is_ordered) : ?>
                                    <a href="#" onclick="$('#arrivedID').val(<?= $order->id ?>); $('#arriveConfirmation').modal()">Arrived</a>
                                <?php else: ?>
                                    <span class="text-muted">Arrived</span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    <?php endif; ?>
                    <?php if ($this->hasAccessTo('admin.kit-orders.view')): ?>
                        <td><?= $this->Html->link('View', ['action' => 'processed-orders', $order->id]) ?></td>
                        <td><?= $this->Html->link('Download', ['action' => 'download', $order->id]) ?></td>
                    <?php endif ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>

<div class="modal fade" id="arriveConfirmation" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?= $this->Form->create(null, ['id' => 'arriveForm', 'url' => ['action' => 'arrived']]) ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Are you sure you want to mark this batch as arrived?</h4>
            </div>
            <div class="modal-body">
                If you mark this order as arrived, users with items in this batch will be notified via email that their items are available for collection.<br/>
                In addition, after setting a batch as arrived, you cannot revert the status.

                <?= $this->Form->hidden('id', ['id' => 'arrivedID']); ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <?= $this->Form->button('Confirm', ['class' => ['btn', 'btn-primary']]) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
