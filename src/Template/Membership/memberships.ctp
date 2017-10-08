<?php

use Cake\Datasource\QueryInterface;
use SUSC\Model\Entity\Membership;
use SUSC\View\AppView;

/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

/**
 * Author: Huw
 * Since: 08/10/2017
 *
 * @var AppView $this
 * @var Membership[]|QueryInterface $memberships
 */

$this->assign('title', 'My Membership');
$this->layout('profile');

?>

<div class="users index large-9 medium-8 columns content">
    <div class="table-responsive">
        <table class="table table-hover table-striped table-condensed">
            <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('membership_type', 'Type') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created', 'Date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('valid_from', 'Valid From') ?></th>
                <th scope="col"><?= $this->Paginator->sort('valid_to', 'Valid To') ?></th>
                <th scope="col"><?= $this->Paginator->sort('payment', 'Payment') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_valid', 'Valid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_paid', 'Paid') ?></th>
                <th scope="col" class="actions"></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($memberships as $membership): ?>
                <tr>
                    <td><?= $this->Time->format($membership->created, null, null, 'Europe/London') ?></td>
                    <td><?= h($membership->membership_type->title) ?></td>
                    <td><?= h($membership->membership_type->valid_from_string) ?></td>
                    <td><?= h($membership->membership_type->valid_to_string) ?></td>
                    <td><?= h($membership->payment) ?></td>
                    <td><?= $membership->getStatusIcon() ?></td>
                    <td><?= $membership->getValidStatusIcon() ?></td>
                    <td><?= $membership->getPaidStatusIcon() ?></td>
                    <td><?= $this->Html->link('View', ['controller' => 'Kit', 'action' => 'vieworder', 'orderid' => $membership->id]) ?></td>
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
