<?php
$this->assign('title', 'Our Committee');

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
        <?php $count = 0; ?>
        <?php foreach ($committee as $member): ?>
            <div class="media">
                <div class="media-left">
                    <img class="media-object img-rounded img-profile" src="/images/<?= $member->image ?>" alt="<?= $member->name ?>"/>
                </div>
                <div class="media-body">
                    <h3 class="media-heading"><?= $member->name ?>
                        <small><?= $member->role ?></small>
                    </h3>
                    <?php if (!is_null($member->contact)): ?>
                        <h4><?= $this->Text->autolink(h($member->contact), ['escape' => false]) ?></h4>
                    <?php endif ?>
                </div>
            </div>
            <?php $count++ ?>
            <?php if ($count != $committee->count()): ?>
                <hr style="margin: 20px;"/>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>