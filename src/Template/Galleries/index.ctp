<?php
/**
 * @var AppView $this
 * @var Gallery[] $galleries
 */

use SUSC\Model\Entity\Gallery;
use SUSC\View\AppView;

$this->start('css');
echo $this->fetch('css');
echo $this->Html->css(['jquery.fancybox', 'helpers/jquery.fancybox-buttons']);
$this->end();

$this->start('postscript');
echo $this->fetch('postscript');
echo $this->Html->script(['jquery.fancybox.pack', 'helpers/jquery.fancybox-buttons']);
?>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".fancybox").fancybox({
                closeBtn: false,
                helpers: {
                    buttons: {}
                }
            });
        });
    </script>
<?php
$this->end();
$this->assign('title', 'Galleries');

// TODO: Fix the layout
$galleryCount = 0;
if (count($galleries) == 0): ?>
    <h2>Cannot find any galleries</h2>
<?php else: ?>
    <?php foreach ($galleries as $gallery): ?>
        <?php if ($galleryCount == 0): ?>
            <div class="row">
        <?php endif; ?>
        <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php $imageCount = 0; ?>
                    <?php foreach ($gallery->images as $image): ?>
                <?php if ($imageCount == 0): ?>
                    <a class="fancybox" rel="<?= $gallery->id ?>" href="<?= $image->path ?>"
                       title="<?= $image->title ?>">
                        <img class="img-responsive img-rounded"
                             src="<?= $this->Url->build(['_name' => 'thumbnail', 'thumbid' => $gallery->thumbnail_image->id, '_ext' => 'jpg']) ?>"/>
                    </a>
                    <div class="hidden">
                        <?php else: ?>
                            <a class="fancybox" rel="<?= $gallery->id ?>" href="<?= $image->path ?>"
                               title="<?= $image->title ?>">
                                <img src="<?= $image->path ?>" alt="<?= $image->title ?>"/></a>
                        <?php endif; ?>
                        <?php $imageCount++ ?>
                        <?php endforeach; ?>
                        <?php if ($imageCount != 0) : ?>
                    </div>
                <?php endif; ?>
                </div>
                <div class="panel-footer">
                    <h2 class="h4"><?= $gallery->title ?></h2>
                </div>
            </div>
        </div>
        <?php if ($galleryCount != 0 && $galleryCount % 3 == 0): ?>
            </div>
        <?php endif;
        $galleryCount++;
        if ($galleryCount > 4) $galleryCount = 0;
        ?>
    <?php endforeach; ?>
<?php endif; ?>