<?php

use Cake\Core\Configure;
$this->start('css');
echo $this->fetch('css');
echo $this->Html->css('carousel');
$this->end();

$this->layout('clean');
$this->assign('title', 'Home');
?>

<?php
$this->start('precontent');
?>
<div id="mainCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#mainCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#mainCarousel" data-slide-to="1"></li>
        <li data-target="#mainCarousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <div class="image" style="background-image:url(/images/gallery/berchie_fly.jpg)">
                <img src="/images/gallery/berchie_fly.jpg" alt="SUSC Qualify for BUCS Team Finals">
            </div>
            <div class="container">
                <div class="carousel-caption">
                    <h1 class="h4">SUSC Qualify for BUCS Team Finals</h1>
                    <p>Something short and brief.</p>
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
                    <p><a class="btn btn-md btn-primary" href="gallery" role="button">View Gallery</a></p>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="image" style="background-image:url(/images/gallery/tudds_backstroke.jpg)">
                <img src="/images/gallery/tudds_backstroke.jpg"></div>
            <div class="container">
                <div class="carousel-caption carouselPane">
                    <h1 class="h4">SUSC Finish Top 10 @ BUSC Team</h1>
                    <p>Something something something</p>
                </div>
            </div>
        </div>
    </div>
    <a class="left carousel-control" href="#mainCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#mainCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
<?php
$this->end();
?>

<div class="col-md-4">
    <h2>News</h2>
    <hr/>
    <div class="blog-post">
        <h2 class="h4">Latest news post</h2>
        <p class="blog-post-meta">April 28<sup>th</sup> 2016, by John Smith</p>
        <article class="blog-post">
            Some news content! Woop, short summary of post with link to full article.
        </article>
        <p><a href="news/itemID" class="btn btn-default  btn-sm">Read more &raquo;</a></p>
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

