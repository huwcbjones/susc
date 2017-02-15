<?php

$this->layout('clean');
$this->assign('title', h($social->title));

$this->start('css');
echo $this->fetch('css');
echo $this->Html->css('blog');
$this->end();

$this->element('Articles/sidebar', ['controller' => 'Socials'])
?>
<div class="page-header"><h1><?= h($social->title) ?></h1></div>
<div class="row">
    <div class="col-sm-8 col-md-9">
        <?= $this->element('Articles/long', ['article' => $social]) ?>
    </div>
    <?= $this->fetch('sidebar', $archives, 'socials') ?>
</div>

