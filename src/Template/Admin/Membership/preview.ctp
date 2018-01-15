<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 */

use SUSC\Model\Entity\MembershipType;
use SUSC\View\AppView;

/**
 * @var AppView $this
 * @var MembershipType $item
 */

$this->setLayout('default');

$this->assign('title', 'Membership Preview');
?>
<p class="text-info">This page displays the membership as it would be shown to a user. This item is <?= $item->is_enable ? '<span class="text-danger"><strong>LIVE</strong></span>' : '<span class="text-warning"><strong>NOT LIVE</strong></span>.' ?></p>
<?= $this->element('Membership/card', [$item, 'disableLink' => true]) ?>
<div class="row">
    <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-0 col-lg-4">
        <?= $this->Html->link('<span class="glyphicon glyphicon-chevron-left"></span>&nbsp;&nbsp;&nbsp;Back', ['action' => 'view', $item->id], ['class' => ['btn', 'btn-default', 'btn-block'], 'escape' => false]) ?>
    </div>
</div>