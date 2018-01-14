<?php
/**
 * @var AppView $this
 * @var Order[]|CollectionInterface $orders
 */

use Cake\Collection\CollectionInterface;
use SUSC\Model\Entity\Order;
use SUSC\View\AppView;

$this->assign('title', 'Kit Orders');
?>

<div class="users index large-9 medium-8 columns content">
    <div class="table-responsive">
        <table class="table table-hover table-striped table-condensed">
            <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id', 'Order #') ?></th>
                <th scope="col">Name</th>
                <th scope="col"><?= $this->Paginator->sort('placed', 'Order Date') ?></th>
                <th scope="col"># Items</th>
                <th scope="col"><?= $this->Paginator->sort('total') ?></th>
                <th scope="col"><?= $this->Paginator->sort('payment', 'Payment') ?></th>
                <th scope="col">Status</th>
                <th scope="col"><?= $this->Paginator->sort('paid', '<attr title="Paid">P?</attr>', ['escape' => false]) ?></th>
                <th scope="col"><attr title="Ordered">O?</attr></th>
                <th scope="col"><attr title="Arrived">A?</attr></th>
                <th scope="col"><attr title="Collected">C?</attr></th>
                <?php if ($this->hasAccessTo('admin.kit-orders.view')): ?>
                    <th scope="col" class="actions"></th>
                <?php endif; ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= h($order->id) . ($order->is_cancelled ? '*' : '') ?></td>
                    <td><?= $this->Html->link($order->user->full_name, ['controller' => 'KitOrders', 'action' => 'index', 'user_id' => $order->user_id]) ?></td>
                    <td><?= $this->Time->format($order->placed, null, null, 'Europe/London') ?></td>
                    <td><?= count($order->items) ?></td>
                    <td><?= $order->is_cancelled ? '-' : $order->formattedTotal ?></td>
                    <td><?= $order->is_cancelled ? '-' : $order->paymentMethod ?></td>
                    <td><?= h($order->status) ?></td>
                    <?php if ($order->is_cancelled) : ?>
                        <td colspan="4" class="text-center"><span class="text-muted glyphicon glyphicon-ban-circle"></span></td>
                    <?php else: ?>
                        <td><?= $order->getPaidStatusIcon() ?></td>
                        <td><?= $order->getOrderedStatusIcon() ?></td>
                        <td><?= $order->getArrivedStatusIcon() ?></td>
                        <td><?= $order->getCollectedStatusIcon() ?></td>
                    <?php endif; ?>
                    <?php if ($this->hasAccessTo('admin.kit-orders.view')): ?>
                        <td><?= $this->Html->link('View', ['action' => 'view', $order->id]) ?></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <p>
            <small>* Cancelled order</small>
        </p>
    </div>
    <?= $this->element('paginator') ?>
</div>