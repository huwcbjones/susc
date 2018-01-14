<?php
/**
 * @var \SUSC\View\AppView $this
 * @var \SUSC\Model\Entity\Group[]|\Cake\Collection\CollectionInterface $groups
 */
$this->assign('title', 'Groups');
?>
<div class="users index large-9 medium-8 columns content">
    <div class="table-responsive">
        <table class="table table-hover table-striped table-condensed">
            <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('description') ?></th>
                <th scope="col"><?= $this->Paginator->sort('parent') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_enable', '<attr title="Enabled">E?</attr>', ['escape' => false]) ?></th>
                <th scope="col"># of Users</th>
                <?php if ($this->hasAccessTo('admin.groups.view')): ?>
                    <th scope="col" class="actions"></th>
                <?php endif ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($groups as $group): ?>
                <tr>
                    <td><?= h($group->name) ?></td>
                    <td><?= h($group->description) ?></td>
                    <td>
                        <?php if ($this->hasAccessTo('admin.groups.view')): ?>
                            <?= $group->has('parent') ? $this->Html->link($group->parent->name, ['controller' => 'Groups', 'action' => 'view', $group->parent->id]) : '-' ?>
                        <?php else: ?>
                            <?= $group->has('parent') ? $group->parent->name : '-' ?>
                        <?php endif; ?>
                    </td>
                    <td><?= $group->getEnabledIcon() ?></td>
                    <td><?= count($group->users) ?></td>
                    <?php if ($this->hasAccessTo('admin.groups.view')): ?>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $group->id]) ?>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?= $this->element('paginator') ?>
</div>
