<?php

$this->assign('title', 'Fixture Calendar');
$this->assign('description', 'Southampton University Swimming Club (SUSC) attend a variety of fixtures throughout the academic year. This page details the programme of events.');
?>
    <ol class="hidden" itemscope itemtype="http://schema.org/BreadcrumbList">
        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
            <?= $this->Html->link('<span itemprop="name">Fixtures</span>', ['_name' => 'fixtures'], ['itemscope', 'itemtype' => 'http://schema.org/Thing', 'itemprop' => 'item', 'escape' => false]) ?>
            <meta itemprop="position" content="1"/>
        </li>
        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
            <?= $this->Html->link('<span itemprop="name">' . $this->fetch('title') . '</span>', ['_name' => 'fixture_calendar'], ['itemscope', 'itemtype' => 'http://schema.org/Thing', 'itemprop' => 'item', 'escape' => false]) ?>
            <meta itemprop="position" content="2"/>
        </li>
    </ol>
<?= $this->Text->autolink($calendar, ['escape' =>false]) ?>