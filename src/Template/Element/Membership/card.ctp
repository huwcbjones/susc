<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 */

use SUSC\Model\Entity\MembershipType;
use SUSC\View\AppView;

/**
 * @author huw
 * @since 15/01/2018 15:30
 *
 * @var AppView $this
 * @var MembershipType $item
 * @var bool $disableLink
 */

if(!isset($disableLink)) $disableLink = false;

$url = ['controller' => 'Membership', 'action' => 'details', 'type' => $item->slug];
if($disableLink) $url = '#';

?>

<div class="panel panel-primary">
    <div class="panel-heading"><h2><?= h($item->title) ?>
            <span class="pull-right"><?= $item->formatted_price ?></span>
        </h2></div>
    <div class="panel-body">
        <?= $item->rendered_description ?>
    </div>
    <div class="panel-footer text-right">
        <?= $this->Html->link('Select ' . $item->title . ' »', $url, [ 'class' => ['btn', 'btn-dark', 'btn-lg']]) ?>
    </div>
</div>
