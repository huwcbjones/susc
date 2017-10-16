<?php
/**
 * @var \SUSC\View\AppView $this
 * @var \SUSC\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
$this->assign('title', 'Users');
?>
<div class="users index large-9 medium-8 columns content">
    <div class="table-responsive">
        <table class="table table-hover table-striped table-condensed">
            <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('first_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('last_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email_address') ?></th>
                <th scope="col"><?= $this->Paginator->sort('group_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_enable', 'Enabled') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_active', 'Activated') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('activation_date', 'Activated') ?></th>

                <th scope="col" class="actions" colspan="3"><?= __('Actions') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= h($user->first_name) ?></td>
                    <td><?= h($user->last_name) ?></td>
                    <td><?= h($user->email_address) ?></td>
                    <td><?= $user->has('group') ? $this->Html->link($user->group->name, ['controller' => 'Groups', 'action' => 'view', $user->group->id]) : '' ?></td>

                    <td>
                        <span class="text-<?= ($user->isEnabled()) ? 'success' : 'danger' ?> glyphicon glyphicon-<?= ($user->isEnabled()) ? 'ok' : 'remove' ?>-sign"></span>
                    </td>
                    <td>
                        <span class="text-<?= ($user->isActivated()) ? 'success' : 'danger' ?> glyphicon glyphicon-<?= ($user->isActivated()) ? 'ok' : 'remove' ?>-sign"></span>
                    </td>
                    <td><?= $this->Time->format($user->created, null, null, 'Europe/London') ?></td>
                    <td><?= $this->Time->format($user->modified, null, null, 'Europe/London') ?></td>
                    <td><?= $this->Time->format($user->activation_date, null, null, 'Europe/London') ?></td>
                    <?php if ($this->hasAccessTo('admin.users.view')): ?>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $user->id]) ?>
                        </td>
                    <?php endif; ?>
                    <?php if ($this->hasAccessTo('admin.users.edit')): ?>
                        <td class="actions">
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
                        </td>
                    <?php endif; ?>
                    <?php if ($this->hasAccessTo('admin.users.delete') && $user->id != $currentUser->id): ?>
                        <td class="actions">
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete {0}?', $user->full_name)]) ?>
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
            <?= $this->Paginator->numbers(['before' => null, 'after' => null]) ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
