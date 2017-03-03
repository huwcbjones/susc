<?php

$this->layout('clean');
$this->assign('title', h($fixture->title));

$this->start('css');
echo $this->fetch('css');
echo $this->Html->css('blog');
$this->end();
?>
<div itemscope itemtype="http://schema.org/BlogPosting">
    <div class="page-header"><h1><span itemprop="name headline"><?= h($fixture->title) ?></span></h1></div>
    <div class="row">
        <div class="col-xs-12">
            <?= $this->element('Articles/long', ['article' => $fixture]) ?>
        </div>
    </div>
</div>

