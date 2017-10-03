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
?>
    <style>
        .image{
            position:relative;
            overflow:hidden;
            padding-bottom:45%;
        }
        .image img{
            position: absolute;
           max-width: 100%;
            max-height: 100%;
            top: 50%;
            left: 50%;
            transform: translateX(-50%) translateY(-50%);
        }
    </style>
<?php
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
    <div class="row">
        <?php foreach ($galleries as $gallery): ?>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <?php $imageCount = 0; ?>
                        <?php foreach ($gallery->images as $image): ?>
                    <?php if ($imageCount == 0): ?>
                        <div class="image">
                        <a class="fancybox" rel="<?= $gallery->id ?>" href="<?= $image->path ?>"
                           title="<?= $image->title ?>">
                            <img class="img-responsive img-rounded img-center"
                                 src="<?= $this->Url->build(['_name' => 'thumbnail', 'thumbid' => $gallery->thumbnail_image->id, '_ext' => 'jpg']) ?>"/>
                        </a>
                        </div>
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
            <?php $count++ ?>
            <?php if ($count % 6 == 0 && $count != 0): ?>
                <div class="clearfix visible-xs-block visible-sm-block visible-md-block visible-lg-block"></div>
            <?php elseif ($count % 4 == 0 && $count != 0): ?>
                <div class="clearfix visible-xs-block visible-md-block visible-lg-block"></div>
            <?php elseif ($count % 3 == 0 && $count != 0): ?>
                <div class="clearfix visible-xs-block visible-md-block visible-lg-block"></div>
            <?php elseif ($count % 2 == 0 && $count != 0): ?>
                <div class="clearfix visible-xs-block visible-sm-block"></div>
            <?php endif ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>