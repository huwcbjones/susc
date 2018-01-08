<?php
/**
 * @var AppView $this
 */

use SUSC\View\AppView;

$this->assign('title', 'My Basket');
$this->layout('clean');
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
                    <tr>
                        <th>Item</th>
                        <th class="text-center">Additional Info</th>
                        <th class="text-center">Size</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Subtotal</th>
                        <th width="15%"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($basketData as $hash => $data):
                        $kit = $data['item'];
                        $size = $data['size'];
                        $quantity = $data['quantity'];
                        $additionalInfo = $data['additional_info'];
                        ?>
                        <tr>
                            <th data-th="Item"><h3 class="h4"><?= $this->Html->link(h($kit->title), [
                                        'controller' => 'kit',
                                        'action' => 'view',
                                        'slug' => $kit->slug,
                                        'crc' => $kit->crc
                                    ]) ?></h3></th>
                            <td data-th="Additional Info" class="text-center"><?= $data['item']->displayAdditionalInformation($data['additional_info']) ?></td>
                            <td data-th="Size" class="text-center"><?= $size ?></td>
                            <td data-th="Price" class="text-center"><?= $kit->formattedPrice ?></td>
                            <td data-th="Quantity" class="text-center"><?= $quantity ?></td>
                            <td data-th="Quantity" class="text-center"><?= sprintf("£%.2f", $quantity * $kit->price) ?></td>
                            <td class="text-right"><?= $this->Form->postLink(
                                    'Remove&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-trash"></span>',
                                    '',
                                    [
                                        'escape' => false,
                                        'data' => [
                                            'hash' => $hash,
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
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-3 col-sm-offset-9">
                    <h3>Total <strong class="pull-right"><?= sprintf("£%.2f", $basketTotal) ?></strong></h3></td>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-0 col-lg-4">
                    <?= $this->Html->link('<span class="glyphicon glyphicon-chevron-left"></span> Continue Shopping', ['_name' => 'kit'], ['class' => ['btn', 'btn-warning', 'btn-lg', 'btn-block'], 'escape' => false]) ?>
                </div>
                <div class="col-xs-12 visible-xs-block"><br/></div>
                <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-2 col-lg-4 col-lg-offset-4">
                    <?= $this->Html->link('Select Payment <span class="glyphicon glyphicon-shopping-cart"></span>', ['_name' => 'pay'], ['class' => ['btn', 'btn-success', 'btn-lg', 'btn-block'], 'escape' => false]) ?>
                </div>
            </div>
        <?php else: ?>
            <div><h2 class="h4">Your basket is currently empty. To add kit, select an item, choose your size, then click &ldquo;Add
                    to basket&rdquo;</h2>
                <?= $this->Html->link('View Kit', ['_name' => 'kit'], ['class' => ['btn', 'btn-lg', 'btn-primary']]) ?></div>

        <?php endif; ?>
    </div>
</div>