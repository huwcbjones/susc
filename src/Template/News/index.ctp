<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

use SUSC\Model\Entity\Article;
use SUSC\View\AppView;

/**
 * Author: Huw
 * Since: 16/02/2017
 *
 * @var AppView $this
 * @var Article[] $news
 */

$this->assign('description', 'Find out the latest news from Southampton University Swimming Club (SUSC).');

$this->start('css');
echo $this->fetch('css');
echo $this->Html->css('blog');
$this->end();

$this->element('Articles/sidebar', ['controller' => 'News'])
?>
<ol class="hidden" itemscope itemtype="http://schema.org/BreadcrumbList">
    <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
        <?= $this->Html->link('<span itemprop="name">News</span>', ['_name' => 'news'], ['itemscope', 'itemtype' => 'http://schema.org/Thing', 'itemprop' => 'item', 'escape' => false]) ?>
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
        <?php if ($news->count() != 0): ?>
            <div class="row">
                <div class="col-xs-12">
                    <?php
                    $articlesCount = 0;
                    foreach ($news as $article) {
                        echo $this->element(
                            'Articles/medium',
                            [
                                'article' => $article,
                                'link' => [
                                    'controller' => 'news',
                                    'action' => 'view',
                                    'year' => $article->created->format('Y'),
                                    'month' => $article->created->format('m'),
                                    'day' => $article->created->format('d'),
                                    'slug' => $article->slug
                                ]
                            ]);
                        $articlesCount++;
                        if ($articlesCount != $news->count()) {
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
            <h2>Cannot find any news.</h2>
        <?php endif; ?>
    </div>
    <?= $this->fetch('sidebar', $archives) ?>
</div>
