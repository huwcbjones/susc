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
                <th scope="col"><?= $this->Paginator->sort('user.full_name', 'Name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('placed', 'Order Date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total') ?></th>
                <th scope="col"><?= $this->Paginator->sort('payment', 'Payment Method') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_paid', '<attr title="Paid">P?</attr>', ['escape' => false]) ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_ordered', '<attr title="Ordered">O?</attr>', ['escape' => false]) ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_arrived', '<attr title="Arrived">A?</attr>', ['escape' => false]) ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_collected', '<attr title="Collected">C?</attr>', ['escape' => false]) ?></th>
                <?php if ($this->hasAccessTo('admin.kit-orders.view')): ?>
                    <th scope="col" class="actions"></th>
                <?php endif; ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= h($order->id) . ($order->is_cancelled ? '*' : '') ?></td>
                    <td><?= ($this->hasAccessTo('admin.users.view')) ? $this->Html->link(h($order->user->full_name), ['controller' => 'Users', 'action' => 'view', $order->user_id]) : h($order->user->full_name) ?></td>
                    <td><?= $this->Time->format($order->placed, null, null, 'Europe/London') ?></td>
                    <td><?= $order->is_cancelled ? '-' : $order->formattedTotal ?></td>
                    <td><?= $order->is_cancelled ? '-' : h($order->paymentMethod) ?></td>
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
    <div class="paginator">
        <nav>
            <ul class="pagination">
                <?= $this->Paginator->first('<< ' . __('first')) ?>
                <?= $this->Paginator->prev('< ' . __('previous')) ?>
                <?= $this->Paginator->numbers(['before' => null, 'after' => null]) ?>
                <?= $this->Paginator->next(__('next') . ' >') ?>
                <?= $this->Paginator->last(__('last') . ' >>') ?>
            </ul>
        </nav>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>