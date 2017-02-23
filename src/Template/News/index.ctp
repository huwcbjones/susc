<?php
$this->start('css');
echo $this->fetch('css');
echo $this->Html->css('blog');
$this->end();

$this->element('Articles/sidebar', ['controller' => 'News'])
?>
<div class="row">
    <div class="col-sm-8">
        <?php if ($news->count() != 0): ?>
            <div class="row">
                <div class="col-xs-12">
                    <?php
                    $articlesCount = 0;
                    foreach ($news as $article) {
                        echo $this->element(
                            'Articles/medium',
                            [
                                'article' => $article,
                                'link' => [
                                    'controller' => 'news',
                                    'action' => 'view',
                                    'year' => $article->created->format('Y'),
                                    'month' => $article->created->format('m'),
                                    'day' => $article->created->format('d'),
                                    'slug' => $article->slug
                                ]
                            ]);
                        $articlesCount++;
                        if ($articlesCount != $news->count()) {
                            echo "<hr />\n";
                        }
                    } ?>
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <?= $this->Paginator->numbers() ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <h2>Cannot find any news.</h2>
        <?php endif; ?>
    </div>
    <?= $this->fetch('sidebar', $archives) ?>
</div>
