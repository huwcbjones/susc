<?php

use Cake\Routing\Router;

$currentUrl = Router::normalize($this->request->here);
$links = array();
$links['kit'] = $currentUrl === Router::url(['_name' => 'kit']);
$links['basket'] = $currentUrl === Router::url(['_name' => 'basket']);
$links['item'] = $currentUrl === Router::url(['_name' => 'kit_item', 'slug'=> $this->request->slug]);
?>

<ol class="breadcrumb">
    <li><a href="/">Home</a></li>
    <li<?= $links['kit'] ? ' class="active"' : '' ?>><?= $links['kit'] ? 'Kit' : $this->Html->link('Kit', ['_name' => 'kit']) ?></li>
    <?php if ($links['item']) : ?>
        <li class="active"><?= $this->fetch('title') ?></li>
    <?php elseif ($links['basket']):?>
        <li class="active"><?= $this->fetch('title') ?></li>
    <?php endif ?>
</ol>
