<?php

use SUSC\Model\Entity\Order;

/** @var Order[] $orders */

$this->assign('title', 'My Orders');
$this->layout('profile');
?>

<div class="users index large-9 medium-8 columns content">
    <div class="table-responsive">
        <table class="table table-hover table-striped table-condensed">
            <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id', 'Order #') ?></th>
                <th scope="col"><?= $this->Paginator->sort('placed', 'Order Date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total') ?></th>
                <th scope="col"><?= $this->Paginator->sort('payment', 'Payment Method') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_paid', '<attr title="Paid">P?</attr>', ['escape' => false]) ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_ordered', '<attr title="Ordered">O?</attr>', ['escape' => false]) ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_arrived', '<attr title="Arrived">A?</attr>', ['escape' => false]) ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_collected', '<attr title="Collected">C?</attr>', ['escape' => false]) ?></th>
                <th scope="col" class="actions"></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= h($order->id) ?></td>
                    <td><?= $this->Time->format($order->placed, null, null, 'Europe/London') ?></td>
                    <td><?= h($order->formattedTotal) ?></td>
                    <td><?= h($order->paymentMethod) ?></td>
                    <td><?= h($order->status) ?></td>
                    <td>
                        <?= $order->getPaidStatusIcon() ?>
                    </td>
                    <td>
                        <?= $order->getOrderedStatusIcon() ?>
                    </td>
                    <td>
                        <?= $order->getArrivedStatusIcon() ?>
                    </td>
                    <td>
                        <?= $order->getCollectedStatusIcon() ?>
                    </td>
                    <td><?= $this->Html->link('View', ['controller' => 'Kit', 'action' => 'vieworder', 'orderid' => $order->id]) ?></td>
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