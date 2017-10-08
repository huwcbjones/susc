<?php

use Cake\Datasource\QueryInterface;
use SUSC\Model\Entity\MembershipType;
use SUSC\Model\Entity\User;
use SUSC\View\AppView;

/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

/**
 * Author: Huw
 * Since: 08/10/2017
 *
 * @var AppView $this
 * @var User $currentUser
 * @var MembershipType[]|QueryInterface $memberships
 */

$count = 0;
?>
<?php foreach ($memberships as $membership): $count++; ?>
    <div class="panel panel-primary">
        <div class="panel-heading"><h2><?= h($membership->title) ?>
                <span class="pull-right"><?= $membership->formatted_price ?></span>
            </h2></div>
        <div class="panel-body">
            <?= $membership->rendered_description ?>
        </div>
        <div class="panel-footer text-right">
            <?= $this->Html->link('Select ' . $membership->title . ' »', ['controller' => 'Membership', 'action' => 'details', 'type' => $membership->slug], [ 'class' => ['btn', 'btn-dark', 'btn-lg']]) ?>
        </div>
    </div>



    <?php if ($count != $memberships->count()): ?>
        <hr/>
    <?php endif ?>
<?php endforeach; ?>
