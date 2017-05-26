<?php

use SUSC\Form\KitBagForm;

$this->element('Kit/bag');

$count = 0;
$rowClosed = true;
$kitBagForm = new KitBagForm();
?>
<div class="row">
    <div class="col-sm-8">
        <?php foreach ($kit as $item): ?>
            <?php if ($count % 3 == 0): $rowClosed = false; ?>
                <div class="row">
            <?php endif ?>
            <div class="col-xs-6 col-sm-4">
                <h3><?= $this->Html->link(h($item->title), [
                        'controller' => 'kit',
                        'action' => 'view',
                        'slug' => $item->slug
                    ]) ?></h3><br/>
                <?= $this->Html->link(
                    $this->Html->image(
                        $item->imagePath,
                        [
                            'alt' => h($item->title),
                            'class' => ['img-responsive', 'center-block']
                        ]
                    ),
                    [
                        'controller' => 'kit',
                        'action' => 'view',
                        'slug' => $item->slug
                    ],
                    ['escape' => false]
                ) ?>
                <br/>
                <?= $this->Html->link(sprintf("£%.2f", $item->price), [
                    'controller' => 'kit',
                    'action' => 'view',
                    'slug' => $item->slug
                ], ['class' => ['btn', 'btn-primary', 'btn-block']]) ?>
            </div>
            <?php $count++ ?>
            <?php if ($count % 3 == 0 || ($count > count($kit) && !$rowClosed)): ?>
                </div>
            <?php endif ?>
        <?php endforeach; ?>
    </div>
    <?= $this->fetch('bag', $kitBagData) ?>
</div>