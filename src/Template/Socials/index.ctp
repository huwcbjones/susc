<?php
$this->start('css');
echo $this->fetch('css');
echo $this->Html->css('blog');
$this->end();

$this->element('Articles/sidebar', ['controller' => 'Socials'])
?>
<div class="row">
    <div class="col-sm-8">
        <?php if ($socials->count() != 0): ?>
            <div class="row">
                <div class="col-xs-12">
                    <?php
                    $articlesCount = 0;
                    foreach ($socials as $social) {
                        echo $this->element(
                            'Articles/medium',
                            [
                                'article' => $social,
                                'link' => [
                                    'controller' => 'socials',
                                    'action' => 'viewSocial',
                                    'year' => $social->created->format('Y'),
                                    'month' => $social->created->format('m'),
                                    'day' => $social->created->format('d'),
                                    'slug' => $social->slug
                                ]
                            ]);
                        $articlesCount++;
                        if ($articlesCount != $socials->count()) {
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
            <h2>Cannot find any socials.</h2>
        <?php endif; ?>
    </div>
    <?= $this->fetch('sidebar', $archives) ?>
</div>

