<?php

use SUSC\Form\KitBagForm;

$this->element('Kit/basket');

$count = 0;
$rowClosed = true;
$kitBagForm = new KitBagForm();
?>
<div class="row">
    <div class="col-sm-8">
        <div class="row">
            <?php foreach ($kit as $item): ?>
                <div class="col-xs-6 col-sm-4 col-md-3">

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
                    <h3 class="h4 text-center"><?= $this->Html->link(h($item->title), [
                            'controller' => 'kit',
                            'action' => 'view',
                            'slug' => $item->slug
                        ]) ?></h3><br/>
                </div>
                <?php $count++ ?>
                <?php if ($count % 12 == 0 && $count != 0): ?>
                    <div class="clearfix visible-xs-block visible-sm-block visible-md-block"></div>
                <?php elseif ($count % 4 == 0 && $count != 0): ?>
                    <div class="clearfix visible-xs-block visible-md-block"></div>
                <?php elseif ($count % 3 == 0 && $count != 0): ?>
                    <div class="clearfix visible-sm-block"></div>
                <?php elseif ($count % 2 == 0 && $count != 0): ?>
                    <div class="clearfix visible-xs-block"></div>
                <?php endif ?>
            <?php endforeach; ?>
        </div>
    </div>
    <?= $this->fetch('basket', $basketData) ?>
</div>