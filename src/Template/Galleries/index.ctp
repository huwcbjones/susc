<?php
$this->start('css');
?>
<?= $this->fetch('css'); ?>
<?= $this->Html->css('jquery.fancybox'); ?>
<?= $this->Html->css('helpers/jquery.fancybox-thumbs'); ?>
<?= $this->Html->css('helpers/jquery.fancybox-buttons'); ?>

<?php
$this->end();
$this->start('postscript');
?>
<?= $this->fetch('postscript'); ?>
<?= $this->Html->script('jquery.fancybox.pack'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $(".fancybox").fancybox();
    });
</script>
<?php
$this->end();
$this->assign('title', 'Galleries');
// TODO: Fix the layout
$galleryCount = 0;
foreach ($galleries as $gallery): ?>
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
                <img class="img-responsive img-rounded" src="<?= $gallery->thumbnail_image->path ?>"/>
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
    <?php if ($galleryCount == 0): ?>
        </div>
    <?php endif;
    $galleryCount++;
    if ($galleryCount > 4) $galleryCount = 0;
    ?>
<?php endforeach; ?>
