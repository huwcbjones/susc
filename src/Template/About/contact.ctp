<?php
$this->assign('title', 'Contact Us');
$this->assign('description', 'Finding the right person to contact can sometimes be tricky. Find out who to contact at Southampton University Swimming Club (SUSC).');
?>
<ol class="hidden" itemscope itemtype="http://schema.org/BreadcrumbList">
    <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
        <?= $this->Html->link('<span itemprop="name">About Us</span>', ['_name' => 'about'], ['itemscope', 'itemtype' => 'http://schema.org/Thing', 'itemprop' => 'item', 'escape' => false]) ?>
        <meta itemprop="position" content="1"/>
    </li>
    <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
        <?= $this->Html->link('<span itemprop="name">' . $this->fetch('title'). '</span>', ['_name' => 'contact'], ['itemscope', 'itemtype' => 'http://schema.org/Thing', 'itemprop' => 'item', 'escape' => false]) ?>
        <meta itemprop="position" content="2"/>
    </li>
</ol>
<?= $this->Text->autolink($content, ['escape' =>false]) ?>
