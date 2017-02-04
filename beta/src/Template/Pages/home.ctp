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
        <?php foreach ($news as $article): ?>
            <h2 class="h4"><?= h($article->title) ?></h2>
            <p class="blog-post-meta"><?=
                $article->created->format('F j<\s\u\p>S</\s\u\p> Y') ?>, by <?= h($article->user_id) ?></p>
            <article class="blog-post">
                Some news content! Woop, short summary of post with link to full article.
            </article>
            <p>
                <a href="<?= $this->Url->build(
                    ['controller' => 'news',
                        'action' => 'view',
                        $article->created->format('Y'),
                        $article->created->format('m'),
                        $article->created->format('d'),
                        $article->slug
                    ]
                ) ?>" class="btn btn-default  btn-sm">Read more &raquo;</a></p>
        <?php endforeach; ?>
    </div>
</div>
<div class="col-md-4">
    <h2>Fixtures</h2>
    <hr/>
    <div class="blog-post">
        <h2 class="h4">Fixture title</h2>
        <p class="blog-post-meta">Added April 28<sup>th</sup> 2016, by John Smith</p>
        <article class="blog-post">
            Few short details&hellip; next fixture is such-and-such. Leaving for whenever, getting back
            whenever. Oh look, a button to find out
            more!
        </article>
        <p><a class="btn btn-default" href="programme" role="button">View more details &raquo;</a></p>
    </div>
</div>
<div class="col-md-4">
    <h2>Socials</h2>
    <hr/>
    <div class="blog-post">
        <h2 class="h4">Social title</h2>
        <p class="blog-post-meta">Added April 28<sup>th</sup> 2016, by John Smith</p>
        <article class="blog-post">
            Short details to warm an appetite&hellip; next social is blahblahblah. Booze booze booze. Wakae up
            in a hotel. Wow, I'd never have expected to see
            another button that I can click to get more info!
        </article>
        <p><a class="btn btn-default" href="downloads" role="button">Visit more info &raquo;</a></p>
    </div>
</div>
