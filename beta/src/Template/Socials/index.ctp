<?php
$this->start('css');
echo $this->fetch('css');
echo $this->Html->css('blog');
$this->end();

$this->element('articles_sidebar', ['controller' => 'Socials'])
?>
<div class="row">
    <div class="col-sm-8">
        <?php if ($socials->count() != 0): ?>
            <div class="row">
                <div class="col-xs-12">
                    <?php $articlesCount = 0; ?>
                    <?php foreach ($socials as $article): ?>
                        <div class="blog-post">
                            <h2 class="blog-post-title"><?= $this->Html->link(
                                    h($article->title),
                                    ['controller' => 'socials',
                                        'action' => 'viewSocial',
                                        'slug' => $article->slug
                                    ]
                                ) ?></h2>
                            <p class="blog-post-meta"><?=
                                $article->created->format('F j<\s\u\p>S</\s\u\p> Y') ?>,
                                by <?= h($article->user->fullname) ?></p>
                            <?= $this->Text->autolink($article->content, ['escape' => false]) ?>
                        </div>
                        <?php $articlesCount++; ?>
                        <?php if ($articlesCount != $socials->count()): ?>
                            <hr/>
                        <?php endif ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 text-center">
                    <?= $this->Paginator->numbers() ?>
                </div>
            </div>
        <?php else: ?>
            <h2>Cannot find any socials.</h2>
        <?php endif ?>
    </div>
    <?= $this->fetch('sidebar') ?>
</div>

