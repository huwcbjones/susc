<?php

use SUSC\Model\Entity\KitOrder;

/** @var KitOrder[] $orders */

$this->assign('title', 'My Orders');
$this->layout('profile');
?>

<div class="users index large-9 medium-8 columns content">
    <div class="table-responsive">
        <table class="table table-hover table-striped table-condensed">
            <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id', 'Order #') ?></th>
                <th scope="col"><?= $this->Paginator->sort('date_ordered', 'Order Date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total') ?></th>
                <th scope="col"><?= $this->Paginator->sort('payment', 'Payment Method') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_paid', 'Paid For?') ?></th>
                <th scope="col"><?= $this->Paginator->sort('date_paid', 'Date Paid') ?></th>
                <th scope="col" class="actions"></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= h($order->id) ?></td>
                    <td><?= $this->Time->format($order->date_ordered, null, null, 'Europe/London') ?></td>
                    <td><?= h($order->formattedTotal) ?></td>
                    <td><?= h($order->paymentMethod) ?></td>
                    <td>
                        <span class="text-<?= ($order->is_paid) ? 'success' : 'danger' ?> glyphicon glyphicon-<?= ($order->is_enable) ? 'ok' : 'remove' ?>-sign"></span>
                    </td>
                    <td><?= ($order->paid != null) ? $this->Time->format($order->paid_date, null, null, 'Europe/London') : 'Not Paid' ?></td>
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