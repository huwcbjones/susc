<?php
$this->start('css');
echo $this->fetch('css');
echo $this->Html->css('blog');
$this->end();

$this->element('Articles/sidebar', ['controller' => 'Socials'])
?>
<ol class="hidden" itemscope itemtype="http://schema.org/BreadcrumbList">
    <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
        <?= $this->Html->link('<span itemprop="name">Socials</span>', ['_name' => 'news'], ['itemscope', 'itemtype' => 'http://schema.org/Thing', 'itemprop' => 'item', 'escape' => false]) ?>
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
    <div class="col-sm-8">
        <?php if ($socials->count() != 0): ?>
            <div class="row">
                <div class="col-xs-12">
                    <?php
                    $articlesCount = 0;
                    foreach ($socials as $social) {
                        echo $this->element(
                            'Articles/medium',
                            [
                                'article' => $social,
                                'link' => [
                                    'controller' => 'socials',
                                    'action' => 'view',
                                    'year' => $social->created->format('Y'),
                                    'month' => $social->created->format('m'),
                                    'day' => $social->created->format('d'),
                                    'slug' => $social->slug
                                ]
                            ]);
                        $articlesCount++;
                        if ($articlesCount != $socials->count()) {
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
            <h2>Cannot find any socials.</h2>
        <?php endif; ?>
    </div>
    <?= $this->fetch('sidebar', $archives) ?>
</div>

