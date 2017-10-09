<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

use Cake\Datasource\QueryInterface;
use SUSC\View\AppView;

/**
 * Author: Huw
 * Since: 09/10/2017
 * @var AppView $this
 * @var Membership[]|QueryInterface $memberships
 */

$this->assign('title', 'Memberships');

?>

<div class="users index large-9 medium-8 columns content">
    <div class="table-responsive">
        <table class="table table-hover table-striped table-condensed">
            <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('membership_type', 'Type') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created', 'Date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('payment', 'Payment') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col"><abbr title="Active">A?</abbr></th>
                <th scope="col"><?= $this->Paginator->sort('is_valid', '<abbr title="Valid">V?</abbr>', ['escape' => false]) ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_paid', '<abbr title="Paid">P?</abbr>', ['escape' => false]) ?></th>
                <th scope="col" class="actions"></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($memberships as $membership): ?>
                <tr>
                    <td><?= $this->hasAccessTo('admin.users.view') ? $this->Html->link($membership->name, ['controller' => 'Users', 'action' => 'view', $membership->user->id]) : h($membership->name) ?></td>
                    <td><?= h($membership->membership_type->title) ?></td>
                    <td><?= $this->Time->format($membership->created, null, null, 'Europe/London') ?></td>
                    <td><?= $membership->is_cancelled ? '-' : h($membership->payment) ?></td>
                    <td><?= $membership->status ?></td>
                    <?php if ($membership->is_cancelled): ?>
                        <td colspan="3" class="text-center"><span class="text-muted glyphicon glyphicon-ban-circle"></span></td>
                    <?php else: ?>
                        <td><?= $membership->getStatusIcon() ?></td>
                        <td><?= $membership->getValidStatusIcon() ?></td>
                        <td><?= $membership->getPaidStatusIcon() ?></td>
                    <?php endif ?>
                    <td><?= $this->Html->link('View', ['action' => 'details', $membership->id]) ?></td>
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
