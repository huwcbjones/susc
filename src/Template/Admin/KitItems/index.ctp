<?php
/**
 * @var \SUSC\View\AppView $this
 * @var \SUSC\Model\Entity\KitItem[]|\Cake\Collection\CollectionInterface $items
 */
$this->assign('title', 'Kit Items');
?>
<div class="users index large-9 medium-8 columns content">
    <div class="table-responsive">
        <table class="table table-hover table-striped table-condensed">
            <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id', 'Item ID') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col"><?= $this->Paginator->sort('price') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sizes') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_enable', 'Enabled') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions" colspan="3"><?= __('Actions') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= h($item->slug) ?></td>
                    <td><?= h($item->title) ?></td>
                    <td><?= h($item->formatted_price) ?></td>
                    <td><?= h(implode(', ', explode(',',$item->sizes))) ?></td>

                    <td>
                        <span class="text-<?= ($item->status) ? 'success' : 'danger' ?> glyphicon glyphicon-<?= ($item->status) ? 'ok' : 'remove' ?>-sign"></span>
                    </td>
                    <td><?= $this->Time->format($item->created, null, null, 'Europe/London') ?></td>
                    <td><?= $this->Time->format($item->modified, null, null, 'Europe/London') ?></td>
                    <?php if ($currentUser->isAuthorised('admin.kit-items.view')): ?>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $item->id]) ?>
                        </td>
                    <?php endif; ?>
                    <?php if ($currentUser->isAuthorised('admin.kit-items.edit')): ?>
                        <td class="actions">
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $item->id]) ?>
                        </td>
                    <?php endif; ?>
                    <?php if ($currentUser->isAuthorised('admin.kit-items.delete')): ?>
                        <td class="actions">
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $item->id], ['confirm' => __('Are you sure you want to delete {0}?', $item->title)]) ?>
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