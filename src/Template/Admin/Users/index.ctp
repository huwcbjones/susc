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
                <th scope="col"><?= $this->Paginator->sort('is_enable', '<attr title="Enabled">E?</attr>', ['escape' => false]) ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_active', '<attr title="Activated">A?</attr>', ['escape' => false]) ?></th>
                <th scope="col"><?= $this->Paginator->sort('activation_date', 'Activated') ?></th>
                <?php if ($this->hasAccessTo('admin.users.view')): ?>
                    <th scope="col" class="actions"></th>
                <?php endif ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= h($user->first_name) ?></td>
                    <td><?= h($user->last_name) ?></td>
                    <td><?= h($user->email_address) ?></td>
                    <td><?= $user->has('group') ? $this->Html->link($user->group->name, ['controller' => 'Groups', 'action' => 'view', $user->group->id]) : '' ?></td>
                    <td><?= $user->getEnabledIcon() ?></td>
                    <td><?= $user->getActivatedIcon() ?></td>
                    <td><?= $this->Time->format($user->activation_date, null, null, 'Europe/London') ?></td>
                    <?php if ($this->hasAccessTo('admin.users.view')): ?>
                        <td class="actions"><?= $this->Html->link(__('View'), ['action' => 'view', $user->id]) ?></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?= $this->element('paginator') ?>
</div>
