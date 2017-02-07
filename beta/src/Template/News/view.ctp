<?php
use Cake\Utility\Text;

$this->layout('clean');
$this->assign('title', h($article->title));

$this->start('css');
echo $this->fetch('css');
echo $this->Html->css('blog');
$this->end();

$this->element('articles_sidebar')
?>
<div class="page-header"><h1><?= h($article->title) ?></h1></div>
<div class="row">
    <div class="col-sm-8">
        <div class="blog-post">
            <p class="blog-post-meta"><?= $article->created->format('F j<\s\u\p>S</\s\u\p> Y') ?>, by <?= h($article->user->fullname) ?></p>
            <?= $article->content ?>

        </div>
    </div>
    <?= $this->fetch('sidebar', $archives) ?>
</div>

