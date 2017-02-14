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
        <?= $this->element('Articles/long', ['article' => $fixture]) ?>
    </div>
</div>

