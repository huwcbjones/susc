<?php
$this->start('css');
echo $this->fetch('css');
echo $this->Html->css('blog');
$this->end();
$fixturesCount = 0;
?>
<div class="row">
    <div class="col-xs-12">
        <?php if ($fixtures->count() != 0): ?>
            <div class="row">
                <div class="col-xs-12">
                    <?php
                    $articlesCount = 0;
                    foreach ($fixtures as $fixture) {
                        echo $this->element(
                            'Articles/medium',
                            [
                                'article' => $fixture,
                                'link' => [
                                    'controller' => 'fixtures',
                                    'action' => 'view',
                                    'year' => $fixture->created->format('Y'),
                                    'slug' => $fixture->slug
                                ]
                            ]);
                        $articlesCount++;
                        if ($articlesCount != $fixtures->count()) {
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
            <h2>Cannot find any fixtures.</h2>
        <?php endif; ?>
    </div>
</div>
