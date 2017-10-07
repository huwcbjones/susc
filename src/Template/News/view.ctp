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
 * @var Article $article
 */
$this->layout('clean');
$this->assign('title', h($article->title));
$this->assign('description', $article->content);

$this->start('css');
echo $this->fetch('css');
echo $this->Html->css('blog');
$this->end();

$this->element('Articles/sidebar', ['controller' => 'News'])
?>
<div itemscope itemtype="http://schema.org/BlogPosting">
    <div class="page-header"><h1><span itemprop="name headline"><?= h($article->title) ?></span></h1></div>
    <div class="row">
        <div class="col-sm-8 col-md-9">
            <?= $this->element('Articles/long', ['article' => $article]) ?>
        </div>
        <?= $this->fetch('sidebar', $archives, 'socials') ?>
    </div>
</div>