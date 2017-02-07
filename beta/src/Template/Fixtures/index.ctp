<?php
$this->start('css');
echo $this->fetch('css');
echo $this->Html->css('blog');
$this->end();
$fixturesCount= 0;
?>
<div class="row">
    <div class="col-xs-12">
        <?php if($fixtures->count() != 0): ?>
        <?php foreach ($fixtures as $fixture): ?>
            <div class="blog-post">
                <h2 class="blog-post-title"><?= $this->Html->link(
                        h($fixture->title),
                        ['controller' => 'fixtures',
                            'action' => 'view',
                            $fixture->slug
                        ]
                    ) ?></h2>
                <p class="blog-post-meta"><?=
                    $fixture->created->format('F j<\s\u\p>S</\s\u\p> Y') ?>, by <?= h($fixture->user->fullname) ?></p>
                <?= $this->Text->autolink($fixture->content, ['escape'=>false]) ?>
                <?php $fixturesCount++; ?>
                <?php if ($fixturesCount != $fixtures->count()): ?>
                    <hr/>
                <?php endif ?>
            </div>
        <?php endforeach; ?>
        <?php else: ?>
            <h2>There are currently no fixtures.</h2>
        <?php endif ?>
    </div>
</div>

