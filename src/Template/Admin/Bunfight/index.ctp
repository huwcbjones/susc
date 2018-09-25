<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 */

use Cake\Collection\CollectionInterface;
use SUSC\Model\Entity\Bunfight;

/**
 * @author huw
 * @since 25/09/2018 12:30
 *
 * @var Bunfight[]|CollectionInterface $bunfights
 */
$this->assign('title', 'Bunfights');
?>
<div class="users index large-9 medium-8 columns content">
    <div class="table-responsive">
        <table class="table table-hover table-striped table-condensed">
            <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><attr title="Current">C?</attr></th>
                <th scope="col"># Taster Sessions</th>
                <th scope="col"># Signups</th>
                <?php if ($this->hasAccessTo('admin.groups.view')): ?>
                    <th scope="col" class="actions"></th>
                <?php endif ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($bunfights as $bunfight): ?>
                <tr>
                    <td><?= h($bunfight->id) ?></td>
                    <td><?= h($bunfight->name) ?></td>
                    <td><?php
                        if ($bunfight->id == $current_bunfight_id) {
                            echo '<span class="text-success glyphicon glyphicon-ok-sign"></span>';
                        } else {
                            echo '<span class="text-danger glyphicon glyphicon-remove-sign"></span>';
                        }
                    ?></td>
                    <td><?= count($bunfight->bunfight_sessions) ?></td>
                    <td><?= count($bunfight->bunfight_signups) ?></td>
                    <?php if ($this->hasAccessTo('admin.bunfight.view')): ?>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $bunfight->id]) ?>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?= $this->element('paginator') ?>
</div>

