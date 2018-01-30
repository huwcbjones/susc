<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

use SUSC\View\AppView;

/**
 * Author: Huw
 * Since: 03/10/2017
 *
 * @var AppView $this
 * @var string $content
 */

$this->assign('title', 'Kit/Membership FAQs');
$this->assign('description', $content);
?>
<ol class="hidden" itemscope itemtype="http://schema.org/BreadcrumbList">
    <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
        <?= $this->Html->link('<span itemprop="name">Shop</span>', '#', ['itemscope', 'itemtype' => 'http://schema.org/Thing', 'itemprop' => 'item', 'escape' => false]) ?>
        <meta itemprop="position" content="1"/>
    </li>
    <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
        <?= $this->Html->link('<span itemprop="name">'. $this->fetch('title') .'</span>', ['_name' => 'faq'], ['itemscope', 'itemtype' => 'http://schema.org/Thing', 'itemprop' => 'item', 'fullBase' => true, 'escape' => false]) ?>
        <meta itemprop="position" content="2"/>
    </li>
</ol>
<?= $content ?>
