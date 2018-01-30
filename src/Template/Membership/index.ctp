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

$this->assign('description', 'View the membership options and register your membership for Southampton University Swimming Club (SUSC).');
$count = 0;
?>
<ol class="hidden" itemscope itemtype="http://schema.org/BreadcrumbList">
    <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
        <?= $this->Html->link('<span itemprop="name">Shop</span>', '#', ['itemscope', 'itemtype' => 'http://schema.org/Thing', 'itemprop' => 'item', 'escape' => false]) ?>
        <meta itemprop="position" content="1"/>
    </li>
    <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
        <?= $this->Html->link('<span itemprop="name">Membership</span>', ['_name' => 'membership'], ['itemscope', 'itemtype' => 'http://schema.org/Thing', 'itemprop' => 'item', 'fullBase' => true, 'escape' => false]) ?>
        <meta itemprop="position" content="2"/>
    </li>
</ol>
<?php foreach ($memberships as $membership){
    $count++;
    echo $this->element('Membership/card', ['item' => $membership]);
    if($count != $memberships->count()){
        echo '<hr/>';
    }
}
?>
