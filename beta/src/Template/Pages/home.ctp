<?php

use Cake\Core\Configure;

$this->start('css');
echo $this->fetch('css');
echo $this->Html->css('carousel');
$this->end();

$this->layout('clean');
$this->assign('title', 'Home');
?>

<?php $this->start('precontent') ?>
<div id="mainCarousel" class="carousel slide carousel-fade" data-ride="carousel">
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <div class="image" style="background-image:url(/images/gallery/berchie_fly.jpg)">
                <img src="/images/gallery/berchie_fly.jpg" alt="SUSC Qualify for BUCS Team Finals">
            </div>
            <div class="container">
                <div class="carousel-caption">
                    <h1 class="h4">SUSC Qualify for BUCS Team Finals</h1>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="image" style="background-image:url(/images/gallery/bucs_sc_2015.jpg)">
                <img src="/images/gallery/bucs_sc_2015.jpg" alt="SUSC @ BUCS Short Course">
            </div>
            <div class="container">
                <div class="carousel-caption">
                    <h1 class="h4">SUSC @ BUCS Short Course</h1>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="image" style="background-image:url(/images/gallery/tudds_backstroke.jpg)">
                <img src="/images/gallery/tudds_backstroke.jpg"></div>
            <div class="container">
                <div class="carousel-caption carouselPane">
                    <h1 class="h4">SUSC Finish Top 10 @ BUSC Team</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->end() ?>
<div class="col-md-4">
    <h2>News</h2>
    <hr/>
    <div class="blog-post">
        <?php $articlesCount = 0; ?>
        <?php if($news->count() != 0): ?>
        <?php foreach ($news as $article): ?>
            <h2 class="h4"><?= h($article->title) ?></h2>
            <p class="blog-post-meta"><?=
                $article->created->format('F j<\s\u\p>S</\s\u\p> Y') ?>, by <?= h($article->user->fullname) ?></p>
            <article class="blog-post">
                <?= $this->Text->truncate($article->content, 200, ['exact' => false,]) ?>
            </article>
            <p>
                <a href="<?= $this->Url->build(
                    ['controller' => 'news',
                        'action' => 'view',
                        'year' => $article->created->format('Y'),
                        'month' => $article->created->format('m'),
                        'day' => $article->created->format('d'),
                        'slug' => $article->slug
                    ]
                ) ?>" class="btn btn-default  btn-sm">Read more &raquo;</a></p>
            <?php $articlesCount++; ?>
            <?php if ($articlesCount != $news->count()): ?>
                <hr/>
            <?php endif ?>
        <?php endforeach; ?>
        <?php else: ?>
            <h3 class="h4">There is currently no news.</h3>
        <?php endif ?>
    </div>
</div>
<div class="col-md-4">
    <h2>Fixtures</h2>
    <hr/>
    <div class="blog-post">
        <?php $articlesCount = 0; ?>
        <?php if($fixtures->count() != 0): ?>
        <?php foreach ($fixtures as $fixture): ?>
            <h2 class="h4"><?= h($fixture->title) ?></h2>
            <p class="blog-post-meta">Added <?=
                $fixture->created->format('F j<\s\u\p>S</\s\u\p> Y') ?>, by <?= h($fixture->user->fullname) ?></p>
            <article class="blog-post">
                <?= $this->Text->truncate($fixture->content, 200, ['exact' => false,]) ?>
            </article>
            <p>
                <a href="<?= $this->Url->build(
                    ['controller' => 'fixtures',
                        'action' => 'view',
                        'slug' => $fixture->slug
                    ]
                ) ?>" class="btn btn-default  btn-sm">View more details &raquo;</a></p>
            <?php $articlesCount++; ?>
            <?php if ($articlesCount != $fixtures->count()): ?>
                <hr/>
            <?php endif ?>
        <?php endforeach; ?>
        <?php else: ?>
            <h3 class="h4">There are currently no fixtures.</h3>
        <?php endif ?>
    </div>
</div>
<div class="col-md-4">
    <h2>Socials</h2>
    <hr/>
    <div class="blog-post">
        <?php $articlesCount = 0; ?>
        <?php if($socials->count() != 0): ?>
        <?php foreach ($socials as $social): ?>
            <h2 class="h4"><?= h($social->title) ?></h2>
            <p class="blog-post-meta">Added <?=
                $fixture->created->format('F j<\s\u\p>S</\s\u\p> Y') ?>, by <?= h($social->user->fullname) ?></p>
            <article class="blog-post">
                <?= $this->Text->truncate($social->content, 200, ['exact' => false,]) ?>
            </article>
            <p>
                <a href="<?= $this->Url->build(
                    ['controller' => 'socials',
                        'action' => 'viewSocial',
                        'slug' => $social->slug
                    ]
                ) ?>" class="btn btn-default  btn-sm">More info &raquo;</a></p>
            <?php $articlesCount++; ?>
            <?php if ($articlesCount != $socials->count()): ?>
                <hr/>
            <?php endif ?>
        <?php endforeach; ?>
        <?php else: ?>
            <h3 class="h4">There are currently no socials.</h3>
        <?php endif ?>
    </div>
</div>
