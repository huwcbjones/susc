<?php
$this->assign('description', 'Southampton University Swimming Club (SUSC) attend a variety of fixtures throughout the academic year. This page details fixtures past and present.');

$this->start('css');
echo $this->fetch('css');
echo $this->Html->css('blog');
$this->end();
$fixturesCount = 0;
?>
<ol class="hidden" itemscope itemtype="http://schema.org/BreadcrumbList">
    <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
        <?= $this->Html->link('<span itemprop="name">Fixtures</span>', ['_name' => 'news'], ['itemscope', 'itemtype' => 'http://schema.org/Thing', 'itemprop' => 'item', 'escape' => false]) ?>
        <meta itemprop="position" content="1"/>
    </li>
    <?php if (isset($year)): ?>
        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
            <?= $this->Html->link('<span itemprop="name">' . $year . '</span>', ['action' => 'index', $year], ['itemscope', 'itemtype' => 'http://schema.org/Thing', 'itemprop' => 'item', 'escape' => false]) ?>
            <meta itemprop="position" content="2"/>
        </li>
        <?php if (isset($month)): ?>
            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <?= $this->Html->link('<span itemprop="name">' . $month . '</span>', ['action' => 'index', $year, $month], ['itemscope', 'itemtype' => 'http://schema.org/Thing', 'itemprop' => 'item', 'escape' => false]) ?>
                <meta itemprop="position" content="3"/>
            </li>
            <?php if (isset($day)): ?>
                <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <?= $this->Html->link('<span itemprop="name">' . $day . '</span>', ['action' => 'index', $year, $month, $day], ['itemscope', 'itemtype' => 'http://schema.org/Thing', 'itemprop' => 'item', 'escape' => false]) ?>
                    <meta itemprop="position" content="4"/>
                </li>
            <?php endif ?>
        <?php endif ?>
    <?php endif ?>
</ol>
<div class="row">
    <div class="col-xs-12">
        <?php if ($fixtures->count() != 0): ?>
            <div class="row">
                <div class="col-xs-12">
                    <?php
                    $articlesCount = 0;
                    foreach ($fixtures as $fixture) {
                        echo $this->element(
                            'Articles/medium',
                            [
                                'article' => $fixture,
                                'link' => [
                                    'controller' => 'fixtures',
                                    'action' => 'view',
                                    'year' => $fixture->created->format('Y'),
                                    'slug' => $fixture->slug
                                ]
                            ]);
                        $articlesCount++;
                        if ($articlesCount != $fixtures->count()) {
                            echo "<hr />\n";
                        }
                    } ?>
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <?= $this->Paginator->numbers() ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <h2>Cannot find any fixtures.</h2>
        <?php endif; ?>
    </div>
</div>
