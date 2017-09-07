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
                <th scope="col"><?= $this->Paginator->sort('is_collected', '<attr title="Collected">C?</attr>', ['escape' => false]) ?></th>
                <th scope="col" class="actions" colspan="3"></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= h($order->id) ?></td>
                    <td><?= ($currentUser->isAuthorised('admin.users.view')) ? $this->Html->link(h($order->user->full_name), ['controller' => 'Users', 'action' => 'view', $order->user_id]) : h($order->user->full_name) ?></td>
                    <td><?= $this->Time->format($order->placed, null, null, 'Europe/London') ?></td>
                    <td><?= h($order->formattedTotal) ?></td>
                    <td><?= h($order->paymentMethod) ?></td>
                    <td><?= h($order->status) ?></td>
                    <td>
                        <span class="text-<?= ($order->is_paid) ? 'success' : 'danger' ?> glyphicon glyphicon-<?= ($order->is_paid) ? 'ok' : 'remove' ?>-sign"></span>
                    </td>
                    <td>
                        <span class="text-<?= ($order->is_ordered) ? 'success' : 'danger' ?> glyphicon glyphicon-<?= ($order->is_ordered) ? 'ok' : 'remove' ?>-sign"></span>
                    </td>
                    <td>
                        <span class="text-<?= ($order->is_collected) ? 'success' : 'danger' ?> glyphicon glyphicon-<?= ($order->is_collected) ? 'ok' : 'remove' ?>-sign"></span>
                    </td>
                    <td><?= $this->Html->link('View', ['controller' => 'Kit', 'action' => 'view', $order->id]) ?></td>
                    <td><?= $this->Form->postLink(__('Paid'), ['action' => 'paid', $order->id]) ?></td>
                    <td<?php if(!$order->is_paid):?> class="text-muted"<?php endif?>><?= ($order->is_paid) ? $this->Form->postLink(__('Ordered'), ['action' => 'ordered', $order->id]) : 'Ordered' ?></td>
                    <td<?php if(!$order->is_ordered):?> class="text-muted"<?php endif?>><?= ($order->is_ordered) ? $this->Form->postLink(__('Collected'), ['action' => 'collected', $order->id]) : 'Collected' ?></td>
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
