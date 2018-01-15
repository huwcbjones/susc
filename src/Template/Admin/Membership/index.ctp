<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 */

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
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col"><?= $this->Paginator->sort('price') ?></th>
                <th scope="col"><?= $this->Paginator->sort('valid_from') ?></th>
                <th scope="col"><?= $this->Paginator->sort('valid_to') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_enable', '<attr title="Enabled">E?</attr>', ['escape' => false]) ?></th>
                <?php if ($this->hasAccessTo('admin.membership.view')): ?>
                    <th scope="col" class="actions"></th>
                <?php endif ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($membershipTypes as $membership): ?>
                <tr>
                    <td><?= h($membership->title) ?></td>
                    <td><?= h($membership->formatted_price) ?></td>
                    <td><?= h($membership->valid_from_string) ?></td>
                    <td><?= h($membership->valid_to_string) ?></td>
                    <td><?= $membership->getStatusIcon() ?></td>
                    <?php if ($this->hasAccessTo('admin.membership.view')): ?>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $membership->id]) ?>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?= $this->element('paginator') ?>
</div>

