<?php
$this->assign('title', 'Our Committee');
$this->assign('description', 'Southampton University Swimming Club (SUSC) is run by its members for its members. Find out who is on the SUSC committee.');

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
<ol class="hidden" itemscope itemtype="http://schema.org/BreadcrumbList">
    <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
        <?= $this->Html->link('<span itemprop="name">About Us</span>', ['_name' => 'about'], ['itemscope', 'itemtype' => 'http://schema.org/Thing', 'itemprop' => 'item', 'escape' => false]) ?>
        <meta itemprop="position" content="1"/>
    </li>
    <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
        <?= $this->Html->link('<span itemprop="name">' . $this->fetch('title'). '</span>', ['_name' => 'committee'], ['itemscope', 'itemtype' => 'http://schema.org/Thing', 'itemprop' => 'item', 'escape' => false]) ?>
        <meta itemprop="position" content="2"/>
    </li>
</ol>
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