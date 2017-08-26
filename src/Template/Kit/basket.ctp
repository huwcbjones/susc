<?php

use SUSC\Form\KitBagForm;

$this->assign('title', 'My Basket');
$this->layout('clean');
$this->element('Kit/basket');

$total = 0;
$kitBagForm = new KitBagForm();
?>
<?php $this->start('css') ?>
<style>
    .table > tbody > tr > td, .table > tfoot > tr > td {
        vertical-align: middle;
    }
</style>
<?php $this->end() ?>
<?= $this->element('Kit/breadcrumb') ?>
<div class="page-header"><h1><?= $this->fetch('title') ?></h1></div>

<div class="row">
    <div class="col-xs-12">
        <?php if (!empty($basketData)): ?>
            <div class="table-responsive">
                <table class="table .table-bordered">
                    <thead>
                    <th width="70%">Item</th>
                    <th class="text-center">Size</th>
                    <th class="text-center">Price</th>
                    <th width="10%"></th>
                    </thead>
                    <tbody>
                    <?php foreach ($basketData as $id => $data):
                        $kit = $data['kit'];
                        $size = $data['size'];

                        ?>
                        <tr>
                            <td data-th="Item"><h3 class="h4"><?= $this->Html->link(h($kit->title), [
                                        'controller' => 'kit',
                                        'action' => 'view',
                                        'slug' => $kit->slug
                                    ]) ?></h3></td>
                            <td data-th="Size" class="text-center"><?= $size ?></td>
                            <td data-th="Price" class="text-center"><?= $kit->formattedPrice ?></td>
                            <td><?= $this->Form->postLink(
                                    'Remove&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-trash"></span>',
                                    '',
                                    [
                                        'escape' => false,
                                        'data' => [
                                            'id' => $kit->id,
                                            'isRemove' => 1
                                        ],
                                        'class' => [
                                            'btn',
                                            'btn-danger',
                                            'btn-sm'
                                        ],
                                        'confirm' => 'Are you sure you want to remove ' . $kit->title . ' from your basket?'
                                    ]
                                ) ?></td>
                        </tr>
                        <?php $total += $kit->price ?>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="2">  </td>
                        <td><h3>Total</h3></td>
                        <td class="text-right"><h3><strong><?= sprintf("£%.2f", $total) ?></strong></h3></td>
                    </tr>
                    <tr>
                        <td><?= $this->Html->link('<span class="glyphicon glyphicon-chevron-left"></span> Continue Shopping', ['_name' => 'kit'], ['class' => ['btn', 'btn-warning', 'btn-lg'], 'escape' => false]) ?></td>
                        <td class="hidden-xs" colspan="2"></td>
                        <td><?= $this->Html->link('Complete Order <span class="glyphicon glyphicon-shopping-cart"></span>', ['_name'=>'order'], ['class' => ['btn', 'btn-success', 'btn-block', 'btn-lg'], 'escape' => false]) ?></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        <?php else: ?>
            <div><p>Your basket is currently empty. To add kit, select an item, choose your size, then click &ldquo;Add
                    to basket&rdquo;</p></div>
        <?php endif; ?>
    </div>
</div>