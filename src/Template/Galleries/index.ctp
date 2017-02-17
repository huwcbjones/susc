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

<?php
$this->end();
$this->assign('title', 'Galleries');

$galleryCount = 0;
foreach ($galleries as $gallery):
    if ($galleryCount == 0):
?>
    <div class="row">
    <?php endif; ?>
        <div class="col-xs-12 col-sm-6 col-md-3">
            <a class="fancybox" rel="<?= $gallery->id ?>" href="<?= $gallery->thumbnail ?>" >
            <?php foreach ($gallery->images as $image): ?>
                <img src="<?= $image->path ?>" />
            <?php endforeach; ?>
            </a>
        </div>
    <?php if ($galleryCount == 0): ?>
    </div>
    <?php endif;
        $galleryCount++;
        if($galleryCount > 4) $galleryCount = 0;
    ?>
<?php endforeach; ?>
