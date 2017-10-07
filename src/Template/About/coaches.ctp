<?php
$this->assign('title', 'Our Coaches');
$this->assign('description', 'Find out who coaches for Southampton University Swimming Club.');

$this->start('css');
echo $this->fetch('css'); ?>
<style>
    .img-profile {
        width: 150px;
        height: 150px;
    }

    @media (max-width: 767px) {
        .img-profile {
            width: 100px;
            height: 100px;
        }
    }
</style>
<?php $this->end(); ?>

<div class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <?php $count = 0 ?>
        <?php foreach ($coaches as $coach): ?>
            <div class="media">
                <div class="media-left">
                    <img class="media-object img-rounded img-profile" src="/images/<?= $coach->image ?>"
                         alt="<?= $coach->name ?>"/>
                </div>
                <div class="media-body">
                    <h3 class="media-heading"><?= $coach->name ?></h3>
                    <?php if (!is_null($coach->contact)): ?>
                        <h4><?= $this->Text->autolink(h($coach->contact), ['escape' => false]) ?></h4>
                    <?php endif ?>
                    <p>
                        <?= h($coach->bio) ?>
                    </p>
                </div>
            </div>
            <?php $count++ ?>
            <?php if ($count != $coaches->count()): ?>
                <hr style="margin: 20px;"/>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>