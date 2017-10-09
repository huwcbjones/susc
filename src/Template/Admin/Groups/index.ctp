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
                <th scope="col"><?= $this->Paginator->sort('id', 'Group ID') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('description') ?></th>
                <th scope="col"><?= $this->Paginator->sort('parent') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_enable', 'Enabled') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions" colspan="3"><?= __('Actions') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($groups as $group): ?>
                <tr>
                    <td><?= h($group->id) ?></td>
                    <td><?= h($group->name) ?></td>
                    <td><?= h($group->description) ?></td>
                    <td>
                        <?php if ($this->hasAccessTo('admin.groups.view')): ?>
                            <?= $group->has('parent') ? $this->Html->link($group->parent->name, ['controller' => 'Groups', 'action' => 'view', $group->parent->id]) : '' ?>
                        <?php else: ?>
                            <?= $group->has('parent') ? $group->parent->name : '' ?>
                        <?php endif; ?>
                    </td>

                    <td>
                        <span class="text-<?= ($group->is_enable) ? 'success' : 'danger' ?> glyphicon glyphicon-<?= ($group->is_enable) ? 'ok' : 'remove' ?>-sign"></span>
                    </td>
                    <td><?= $this->Time->format($group->created, null, null, 'Europe/London') ?></td>
                    <td><?= $this->Time->format($group->modified, null, null, 'Europe/London') ?></td>
                    <?php if ($this->hasAccessTo('admin.groups.view')): ?>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $group->id]) ?>
                        </td>
                    <?php endif; ?>
                    <?php if ($this->hasAccessTo('admin.groups.edit')): ?>
                        <td class="actions">
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $group->id]) ?>
                        </td>
                    <?php endif; ?>
                    <?php if ($this->hasAccessTo('admin.groups.delete')): ?>
                        <td class="actions">
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $group->id], ['confirm' => __('Are you sure you want to delete {0}?', $group->name)]) ?>
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
