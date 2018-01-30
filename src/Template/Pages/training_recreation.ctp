<?php

$this->assign('title', 'Recreational Squad');
$this->assign('description', $recreation);
?>
    <ol class="hidden" itemscope itemtype="http://schema.org/BreadcrumbList">
        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
            <?= $this->Html->link('<span itemprop="name">Training</span>', ['_name' => 'training'], ['itemscope', 'itemtype' => 'http://schema.org/Thing', 'itemprop' => 'item', 'escape' => false]) ?>
            <meta itemprop="position" content="1"/>
        </li>
        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
            <?= $this->Html->link('<span itemprop="name">' . $this->fetch('title') . '</span>', ['_name' => 'training_rec'], ['itemscope', 'itemtype' => 'http://schema.org/Thing', 'itemprop' => 'item', 'escape' => false]) ?>
            <meta itemprop="position" content="2"/>
        </li>
    </ol>
<?= $this->Text->autolink($recreation, ['escape' =>false]) ?>