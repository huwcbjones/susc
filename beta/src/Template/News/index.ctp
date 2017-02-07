<?php
use Cake\Utility\Text;

$this->start('css');
echo $this->fetch('css');
echo $this->Html->css('blog');
$this->end();

$this->element('articles_sidebar', ['controller' => 'News'])
?>
<div class="row">
    <div class="col-sm-8">
        <?php if ($news->count() != 0): ?>
            <?php $articlesCount = 0; ?>
            <?php foreach ($news as $article): ?>
                <div class="blog-post">
                    <h2 class="blog-post-title"><?= $this->Html->link(
                            h($article->title),
                            ['controller' => 'news',
                                'action' => 'view',
                                'year' => $article->created->format('Y'),
                                'month' => $article->created->format('m'),
                                'day' => $article->created->format('d'),
                                'slug' => $article->slug
                            ]
                        ) ?></h2>
                    <p class="blog-post-meta"><?=
                        $article->created->format('F j<\s\u\p>S</\s\u\p> Y') ?>,
                        by <?= h($article->user->fullname) ?></p>
                    <?= $this->Text->autolink($article->content, ['escape' => false]) ?>
                </div>
                <?php $articlesCount++; ?>
                <?php if ($articlesCount != $news->count()): ?>
                    <hr/>
                <?php endif ?>
            <?php endforeach; ?>
        <?php else: ?>
            <h2>Cannot find any articles.</h2>
        <?php endif ?>
    </div>
    <?= $this->fetch('sidebar', $archives) ?>
</div>

