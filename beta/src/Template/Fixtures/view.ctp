<?php

$this->layout('clean');
$this->assign('title', h($fixture->title));

$this->start('css');
echo $this->fetch('css');
echo $this->Html->css('blog');
$this->end();
?>
<div class="page-header"><h1><?= h($fixture->title) ?></h1></div>
<div class="row">
    <div class="col-xs-12">
        <div class="blog-post">
            <p class="blog-post-meta">Added <?= $fixture->created->format('F j<\s\u\p>S</\s\u\p> Y') ?>, by <?= h($fixture->user->fullname) ?></p>
            <?= $fixture->content ?>

        </div>
    </div>
    <?= $this->fetch('sidebar') ?>
</div>

