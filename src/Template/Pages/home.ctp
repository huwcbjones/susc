<?php

/**
 * @var \SUSC\View\AppView $this
 */
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
        <?php $imageCount = 0 ?>
        <?php foreach ($gallery->images as $image): ?>
            <div class="item<?= $imageCount == 0 ? ' active' : '' ?>">
                <div class="image" style="background-image:url(<?= $image->path ?>)">
                    <img src="<?= $image->path ?>" alt="<?= $image->title ?>">
                </div>
                <div class="container">
                    <div class="carousel-caption">
                        <h1 class="h4"><?= $image->title ?></h1>
                        <p>
                            <small><?= (strlen($image->copyright) != 0) ? $image->copyright : '&nbsp;' ?></small>
                        </p>
                    </div>
                </div>
            </div>
            <?php $imageCount++; ?>
        <?php endforeach; ?>
    </div>
</div>
<?php $this->end() ?>

<?php if ($this->hasAccessTo('socials.*')) : ?>
<div class="col-md-4">
    <?php else: ?>
    <div class="col-md-6">
        <?php endif; ?>
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
    <?php if ($this->hasAccessTo('socials.*')) : ?>
    <div class="col-md-4">
        <?php else: ?>
        <div class="col-md-6">
            <?php endif; ?>
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
                                'year' => $fixture->created->format('Y'),
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
        </div><?php if ($this->hasAccessTo('socials.*')) : ?>
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
                                    'action' => 'view',
                                    'year' => $social->created->format('Y'),
                                    'month' => $social->created->format('m'),
                                    'day' => $social->created->format('d'),
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
        <?php endif; ?>

