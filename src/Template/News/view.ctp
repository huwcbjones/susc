<?php

$this->layout('clean');
$this->assign('title', h($article->title));

$this->start('css');
echo $this->fetch('css');
echo $this->Html->css('blog');
$this->end();

$this->element('Articles/sidebar', ['controller' => 'News'])
?>
<div itemscope itemtype="http://schema.org/Article">
    <div class="page-header"><h1><span itemprop="name"><?= h($article->title) ?></span></h1></div>
    <div class="row">
        <div class="col-sm-8 col-md-9">
            <?= $this->element('Articles/long', ['article' => $article]) ?>
        </div>
        <?= $this->fetch('sidebar', $archives, 'socials') ?>
    </div>
</div>