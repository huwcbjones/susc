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
            <?= $this->Paginator->numbers(['before' => null, 'after' => null]) ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>