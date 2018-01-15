<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 */

use Cake\Collection\CollectionInterface;
use SUSC\Model\Entity\RegistrationCode;
use SUSC\View\AppView;

/**
 * @author huw
 * @since 15/01/2018 16:13
 *
 * @var AppView $this
 * @var RegistrationCode[]|CollectionInterface $codes
 */

$this->assign('title', 'Signup Codes');
?>
<div class="codes index large-9 medium-8 columns content">
    <div class="table-responsive">
        <table class="table table-hover table-striped table-condensed">
            <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id', 'Code') ?></th>
                <th scope="col"><?= $this->Paginator->sort('valid_from') ?></th>
                <th scope="col"><?= $this->Paginator->sort('valid_to') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Groups.name', 'Group') ?></th>
                <th scope="col"><?= $this->Paginator->sort('enabled', '<attr title="Enabled">E?</attr>', ['escape' => false]) ?></th>
                <th scope="col"><attr title="Activate">A?</attr></th>
                <?php if ($this->hasAccessTo('admin.registration.view')): ?>
                    <th scope="col" class="actions"></th>
                <?php endif ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($codes as $code): ?>
                <tr>
                    <td><?= h($code->id) ?></td>
                    <td><?= $this->Time->format($code->valid_from, null, null, 'Europe/London') ?></td>
                    <td><?= $this->Time->format($code->valid_to, null, null, 'Europe/London') ?></td>
                    <td>
                        <?php if($this->hasAccessTo('admin.groups.view')): ?>
                            <?= $this->Html->link($code->group->name, ['controller' => 'Groups', 'action' => 'view', $code->group_id]) ?>
                        <?php else: ?>
                            <?= $code->group->name ?>
                        <?php endif ?>
                    </td>
                    <td><?= $code->getEnabledIcon() ?></td>
                    <td><?= $code->getActivateIcon() ?></td>
                    <?php if ($this->hasAccessTo('admin.registration.view')): ?>
                        <td class="actions"><?= $this->Html->link(__('View'), ['action' => 'view', $code->id]) ?></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?= $this->element('paginator') ?>
</div>

