<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

use SUSC\Model\Entity\Article;
use SUSC\View\AppView;

/**
 * Author: Huw
 * Since: 16/02/2017
 *
 * @var AppView $this
 * @var Article $fixture
 */

$this->layout('clean');
$this->assign('title', h($fixture->title));
$this->assign('description', $fixture->content);

$this->start('css');
echo $this->fetch('css');
echo $this->Html->css('blog');
$this->end();
?>
<div itemscope itemtype="http://schema.org/BlogPosting">
    <div class="page-header"><h1><span itemprop="name headline"><?= h($fixture->title) ?></span></h1></div>
    <div class="row">
        <div class="col-xs-12">
            <?= $this->element('Articles/long', ['article' => $fixture]) ?>
        </div>
    </div>
</div>

