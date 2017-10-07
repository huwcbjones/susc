<?php

use SUSC\Model\Entity\MembershipType;
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
 * Since: 07/10/2017
 *
 * @var AppView $this
 * @var MembershipType[] $membershipTypes
 */

$this->assign('title', 'Membership Types');
?>

<div class="users index large-9 medium-8 columns content">
    <div class="table-responsive">
        <table class="table table-hover table-striped table-condensed">
            <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id', 'ID') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col"><?= $this->Paginator->sort('price') ?></th>
                <th scope="col"><?= $this->Paginator->sort('valid_from') ?></th>
                <th scope="col"><?= $this->Paginator->sort('valid_to') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_enable', 'Enabled') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions" colspan="3"><?= __('Actions') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($membershipTypes as $membership): ?>
                <tr>
                    <td><?= h($membership->slug) ?></td>
                    <td><?= h($membership->title) ?></td>
                    <td><?= h($membership->formatted_price) ?></td>
                    <td><?= h($membership->valid_from_string) ?></td>
                    <td><?= h($membership->valid_to_string) ?></td>

                    <td>
                        <span class="text-<?= ($membership->is_enable) ? 'success' : 'danger' ?> glyphicon glyphicon-<?= ($membership->is_enable) ? 'ok' : 'remove' ?>-sign"></span>
                    </td>
                    <td><?= $this->Time->format($membership->created, null, null, 'Europe/London') ?></td>
                    <td><?= $this->Time->format($membership->modified, null, null, 'Europe/London') ?></td>
                    <?php if ($currentUser->isAuthorised('admin.membership.view')): ?>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $membership->id]) ?>
                        </td>
                    <?php endif; ?>
                    <?php if ($currentUser->isAuthorised('admin.membership.edit')): ?>
                        <td class="actions">
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $membership->id]) ?>
                        </td>
                    <?php endif; ?>
                    <?php if ($currentUser->isAuthorised('admin.membership.delete')): ?>
                        <td class="actions">
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $membership->id], ['confirm' => __('Are you sure you want to delete {0}?', $membership->title)]) ?>
                        </td>
                    <?php endif ?>
                    </td>
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
