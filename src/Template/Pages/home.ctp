<?php

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
                    <p>
                        <small>Photo by Oli Crump</small>
                    </p>
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
                    <p>
                        <small>&nbsp;</small>
                    </p>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="image" style="background-image:url(/images/gallery/tudds_backstroke.jpg)">
                <img src="/images/gallery/tudds_backstroke.jpg"></div>
            <div class="container">
                <div class="carousel-caption carouselPane">
                    <h1 class="h4">SUSC Finish Top 10 @ BUSC Team</h1>
                    <p>
                        <small>&nbsp;</small>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->end() ?>

<div class="col-md-4">
    <h2>News</h2>
    <hr/>
    <?php
    $articlesCount = 0;
    if ($news->count() != 0):
        foreach ($news as $article) {
            echo $this->element(
                'Articles/short',
                [
                    'article' => $article,
                    'link' => [
                        'controller' => 'news',
                        'action' => 'view',
                        'year' => $article->created->format('Y'),
                        'month' => $article->created->format('m'),
                        'day' => $article->created->format('d'),
                        'slug' => $article->slug
                    ],
                    'button' => 'Read more &raquo;'
                ]);
            $articlesCount++;
            if ($articlesCount != $news->count() && $articlesCount < 3) {
                echo "<hr />\n";
            }
        }
    else: ?>
        <h3 class="h4">There is currently no news.</h3>
    <?php endif ?>
</div>
<div class="col-md-4">
    <h2>Fixtures</h2>
    <hr/>
    <?php
    $articlesCount = 0;
    if ($fixtures->count() != 0):
        foreach ($fixtures as $fixture) {
            echo $this->element(
                'Articles/short',
                [
                    'article' => $fixture,
                    'link' => [
                        'controller' => 'fixtures',
                        'action' => 'view',
                        'slug' => $fixture->slug
                    ],
                    'button' => 'View more details &raquo;'
                ]);
            $articlesCount++;
            if ($articlesCount != $fixtures->count() && $articlesCount < 3) {
                echo "<hr />\n";
            }
        }
    else: ?>
        <h3 class="h4">There are currently no fixtures.</h3>
    <?php endif ?>
</div>
<div class="col-md-4">
    <h2>Socials</h2>
    <hr/>
    <?php
    $articlesCount = 0;
    if ($socials->count() != 0):
        foreach ($socials as $social) {
            echo $this->element(
                'Articles/short',
                [
                    'article' => $social,
                    'link' => [
                        'controller' => 'socials',
                        'action' => 'viewSocial',
                        'slug' => $social->slug
                    ],
                    'button' => 'More info &raquo;'
                ]);
            $articlesCount++;
            if ($articlesCount != $socials->count() && $articlesCount < 3) {
                echo "<hr />\n";
            }
        }
    else: ?>
        <h3 class="h4">There are currently no socials.</h3>
    <?php endif ?>
</div>
