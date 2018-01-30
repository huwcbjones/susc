<?php
/**
 * @var AppView $this
 * @var Item[] $kit
 */

use SUSC\Form\KitBagForm;
use SUSC\Model\Entity\Item;
use SUSC\View\AppView;

$this->assign('description', 'Southampton University Swimming Club (SUSC) offers a variety of branded kit available for purchase.');
$this->layout('kit');

$count = 0;
$rowClosed = true;
$kitBagForm = new KitBagForm();

$this->start('css');
echo $this->fetch('css');
?>
<style>
    .image {
        position: relative;
        overflow: hidden;
        padding-bottom: 100%;
    }

    .image img {
        position: absolute;
        max-width: 100%;
        max-height: 100%;
        top: 50%;
        left: 50%;
        transform: translateX(-50%) translateY(-50%);
    }
</style>
<?php
$this->end();
?>
<ol class="hidden" itemscope itemtype="http://schema.org/BreadcrumbList">
    <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
        <?= $this->Html->link('<span itemprop="name">Shop</span>', '#', ['itemscope', 'itemtype' => 'http://schema.org/Thing', 'itemprop' => 'item', 'escape' => false]) ?>
        <meta itemprop="position" content="1"/>
    </li>
    <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
        <?= $this->Html->link('<span itemprop="name">Kit</span>', ['_name' => 'kit'], ['itemscope', 'itemtype' => 'http://schema.org/Thing', 'itemprop' => 'item', 'fullBase' => true, 'escape' => false]) ?>
        <meta itemprop="position" content="2"/>
    </li>
</ol>
<div class="row">
    <?php foreach ($kit as $item): ?>
        <div class="col-xs-6 col-sm-4 col-md-3">
            <div class="image"><?= $this->Html->link(
                    $this->Html->image(
                        $item->imagePath,
                        [
                            'alt' => $item->title,
                            'class' => ['img-responsive', 'center-block', $item->isAvailableToOrder ? '' : 'kit-out-of-stock-img']
                        ]
                    ),
                    [
                        'controller' => 'kit',
                        'action' => 'view',
                        'crc' => $item->crc,
                        'slug' => $item->slug
                    ],
                    ['escape' => false]
                ) ?></div>
            <br/>
            <?= $this->Html->link(sprintf("£%.2f", $item->price),
                [
                    'controller' => 'kit',
                    'action' => 'view',
                    'crc' => $item->crc,
                    'slug' => $item->slug
                ],
                [
                    'class' => [
                        'btn',
                        $item->isAvailableToOrder ? 'btn-primary' : 'btn-default', 'btn-block'
                    ]
                ]) ?>
            <h3 class="h4 text-center<?= $item->isAvailableToOrder ? '' : ' kit-out-of-stock' ?>"><?= $this->Html->link(
                    $item->title,
                    [
                        'controller' => 'kit',
                        'action' => 'view',
                        'crc' => $item->crc,
                        'slug' => $item->slug
                    ]) ?></h3><br/>

        </div>
        <?php $count++ ?>
        <?php if ($count % 12 == 0 && $count != 0): ?>
            <div class="clearfix visible-xs-block visible-sm-block visible-md-block visible-lg-block"></div>
        <?php elseif ($count % 4 == 0 && $count != 0): ?>
            <div class="clearfix visible-xs-block visible-md-block visible-lg-block"></div>
        <?php elseif ($count % 3 == 0 && $count != 0): ?>
            <div class="clearfix visible-sm-block"></div>
        <?php elseif ($count % 2 == 0 && $count != 0): ?>
            <div class="clearfix visible-xs-block"></div>
        <?php endif ?>
    <?php endforeach; ?>
</div>