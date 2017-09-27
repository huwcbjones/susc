<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

use SUSC\Model\Entity\Order;
use SUSC\Model\Entity\User;
use SUSC\View\AppView;

/**
 * Author: Huw
 * Since: 08/09/2017
 * @var Order $order
 * @var User $currentUser
 * @var AppView $this
 */

$this->assign('title', 'View Order #' . $order->id);
?>

<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading"> Order #<?= $order->id ?></div>
            <div class="panel-body">
                <p><strong>Name:</strong> <?= $order->user->full_name ?></p>
                <p><strong>Ordered:</strong> <?= $this->Time->i18nFormat($order->placed, null, null, 'Europe/London') ?></p>
                <p><strong>Payment Method:</strong> <?= $order->paymentMethod ?></p>

                <p><strong>Payment:</strong> <?= ($order->is_paid) ? $this->Time->i18nFormat($order->paid, null, null, 'Europe/London') : 'Outstanding' ?></p>

                <p><strong>Status:</strong> <?= $order->status ?></p>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Item</th>
                        <th class="text-center">Additional Info</th>
                        <th class="text-center">Size</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Subtotal</th>
                        <?php if ($currentUser->isAuthorised('admin.kit-orders.status')) : ?>
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
                    <?php foreach ($order->items as $item): ?>
                        <tr>
                            <th data-th="Item"><?= $this->Html->link(h($item->item->title), [
                                    'controller' => 'kit',
                                    'action' => 'view',
                                    'slug' => $item->item->slug
                                ]) ?></th>
                            <td data-th="Additional Info"
                                class="text-center"><?= h($item->item->displayAdditionalInformation($item->additional_info)) ?></td>
                            <td data-th="Size" class="text-center"><?= $item->size ?></td>
                            <td data-th="Price" class="text-center"><?= $item->formattedPrice ?></td>
                            <td data-th="Quantity" class="text-center"><?= $item->quantity ?></td>
                            <td data-th="Quantity" class="text-center"><?= $item->formattedSubtotal ?></td>
                            <?php if ($currentUser->isAuthorised('admin.kit-orders.status')) : ?>
                                <td><?= $item->getOrderedStatusIcon() ?></td>
                                <td><?= $item->getArrivedStatusIcon() ?></td>
                                <td><?= $item->getCollectedStatusIcon() ?>
                                &nbsp;&nbsp;&nbsp;
                                <?php if (!$item->collected && $item->is_arrived): ?>
                                    <?= ($item->is_arrived) ? $this->Form->postLink(__('Collected'), ['action' => 'collected', $item->id], ['confirm' => 'Mark item as collected?\nYou cannot revert this status!']) : 'Collected' ?></td>
                                <?php endif; ?>
                            <?php endif ?>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="4"></td>
                        <td class="text-center"><h3 class="h4">Total:</h3></td>
                        <td class="text-center" style="vertical-align: middle"><?= $order->formattedTotal ?> </td>
                        <?php if ($currentUser->isAuthorised('admin.kit-orders.status')) : ?>
                            <th colspan="3"></th>
                        <?php endif ?>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
