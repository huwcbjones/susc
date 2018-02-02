<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 */

use Cake\Datasource\QueryInterface;
use SUSC\Model\Entity\Membership;
use SUSC\View\AppView;

/**
 * Author: Huw
 * Since: 09/10/2017
 * @var AppView $this
 * @var Membership[]|QueryInterface $memberships
 * @var bool $includeCancelledOrders
 * @var bool $includeUnpaidOrders
 */

$this->assign('title', 'Memberships');


?>
<div class="row">
    <div class="col-xs-12">
        <?= $this->Form->create(null, ['id'=>'filters', 'type' => 'GET']) ?>
        <div class="checkbox">
            <label>
                <?= $this->Form->checkbox('cancelled', ['checked' => $includeCancelledOrders, 'hiddenField' => false]) ?>
                Include cancelled memberships
            </label>
        </div>
        <div class="checkbox">
            <label>
                <?= $this->Form->checkbox('unpaid', ['checked' => $includeUnpaidOrders, 'hiddenField' => false]) ?>
                Exclude unpaid memberships
            </label>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="table-responsive">
            <table class="table table-hover table-striped table-condensed">
                <thead>
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('Memberships.first_name', 'First Name') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('Memberships.last_name', 'Last Name') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('membership_type_id', 'Type') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('created', 'Registered') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('payment_method', 'Payment') ?></th>
                    <th scope="col"><abbr title="Status">S?</abbr></th>
                    <th scope="col"><abbr title="Active">A?</abbr></th>
                    <th scope="col"><abbr title="Valid">V?</abbr></th>
                    <th scope="col"><?= $this->Paginator->sort('paid', '<abbr title="Paid">P?</abbr>', ['escape' => false]) ?></th>
                    <th scope="col" class="actions"></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($memberships as $membership): ?>
                    <tr>
                        <td><?= $this->hasAccessTo('admin.users.view') ? $this->Html->link($membership->first_name, ['controller' => 'Users', 'action' => 'view', $membership->user->id]) : h($membership->first_name) ?></td>
                        <td><?= $this->hasAccessTo('admin.users.view') ? $this->Html->link($membership->last_name, ['controller' => 'Users', 'action' => 'view', $membership->user->id]) : h($membership->last_name) ?></td>
                        <td><?= h($membership->membership_type->title) ?></td>
                        <td><?= $membership->created ?></td>
                        <td><?= $membership->is_cancelled ? '-' : h($membership->payment) ?></td>
                        <?php if ($membership->is_cancelled): ?>
                            <td colspan="4" class="text-center"><span class="text-muted glyphicon glyphicon-ban-circle"></span></td>
                        <?php else: ?>
                            <td><?= $membership->getStatusIcon() ?></td>
                            <td><?= $membership->getActiveStatusIcon() ?></td>
                            <td><?= $membership->getValidStatusIcon() ?></td>
                            <td><?= $membership->getPaidStatusIcon() ?></td>
                        <?php endif ?>
                        <td><?= $this->Html->link('View', ['action' => 'details', $membership->id]) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <?= $this->element('paginator') ?>
    </div>
</div>
<?php
$this->start('postscript');
echo $this->fetch('postscript');
?>
<script type="text/javascript">
    $(function(){
        var filterForm = $("#filters");
        filterForm.find(":input").not(':hidden').change(function(){
            filterForm.submit();
        })
    })
</script>
<?php $this->end() ?>
