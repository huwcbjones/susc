<?php

use SUSC\Form\KitBagForm;

$this->assign('title', 'My Basket');
$this->layout('clean');
$this->element('Kit/basket');

$count = 0;
$rowClosed = true;
$kitBagForm = new KitBagForm();
?>

<?= $this->element('Kit/breadcrumb') ?>
<div class="page-header"><h1><?= $this->fetch('title') ?></h1></div>

<div class="row">
    <div class="col-xs-12">
        <table class="table .table-bordered">
            <thead>
            <th>Item</th>
            <th>Size</th>
            <th>Price</th>
            <th></th>
            </thead>
            <tbody>
            <?php foreach ($basketData as $id => $data):
                $kit = $data['kit'];
                $size = $data['size'];

                ?>
                <row>
                    <td><h3 class="h4"><?= $this->Html->link(h($kit->title), [
                                'controller' => 'kit',
                                'action' => 'view',
                                'slug' => $kit->slug
                            ]) ?></h3></td>
                    <td><?= $size ?></td>
                    <td><?= $kit->price ?></td>
                </row>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?= $this->fetch('basket', $basketData) ?>
    </div>
</div>