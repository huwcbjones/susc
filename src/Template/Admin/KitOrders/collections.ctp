<?php
/**
 * @var AppView $this
 * @var ItemsOrder[]|CollectionInterface $items
 */

use Cake\Collection\CollectionInterface;
use SUSC\Model\Entity\ItemsOrder;
use SUSC\View\AppView;

$this->assign('title', 'Item Collections');
?>

<div class="users index large-9 medium-8 columns content">
    <div class="table-responsive">
        <table class="table table-hover table-striped table-condensed">
            <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('order_id', 'Order #') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Users.last_name', 'Name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Items.title', 'Item') ?></th>
                <th scope="col"><?= $this->Paginator->sort('size', 'Size') ?></th>
                <th scope="col"><?= $this->Paginator->sort('colour', 'Colour') ?></th>
                <th scope="col"><?= $this->Paginator->sort('additional_info', 'Info') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Orders.paid', '<attr title="Paid">P?</attr>', ['escape' => false]) ?></th>
                <?php if ($this->hasAccessTo('admin.kit-orders.view')): ?>
                    <th scope="col" class="actions"></th>
                <?php endif; ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= $this->Html->link($item->order_id, ['action' => 'view', $item->order->id]) ?></td>
                    <td><?= $this->Html->link($item->order->user->full_name, ['controller' => 'KitOrders', 'user_id' => $item->order->user_id]) ?></td>
                    <td><?= $this->Html->link($item->item->title, ['_name' => 'kit_item', 'slug' => $item->item->slug, 'crc' => $item->item->crc]) ?></td>
                    <td><?= $item->item->displaySize($item->size) ?></td>
                    <td><?= $item->item->displayColour($item->colour) ?></td>
                    <td><?= $item->item->displayAdditionalInformation($item->additional_info) ?></td>
                    <td><?= $item->order->getPaidStatusIcon() ?></td>
                    <?php if ($this->hasAccessTo('admin.kit-orders.view')): ?>
                        <td><?= $this->Html->link('View', ['action' => 'view', $item->order->id, 'highlight' => $item->id]) ?></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?= $this->element('paginator') ?>
</div>