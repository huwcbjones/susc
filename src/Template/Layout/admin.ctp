<?php

use Cake\Routing\Router;
use SUSC\Model\Entity\User;

$this->extend('empty');

$this->start('css');
echo $this->fetch('css');
echo $this->Html->css('admin');
$this->end();

/** @var User $currentUser */

$currentUrl = Router::normalize($this->request->here);
$links = array();
$links['admin'] = $currentUrl === Router::url(['_name' => 'admin']);
$links['users'] = strpos($currentUrl, Router::url(['prefix' => 'admin', 'controller' => 'Users', 'action' => 'index'])) !== false;
$links['users_add'] = $currentUrl === Router::url(['prefix' => 'admin', 'controller' => 'Users', 'action' => 'add']);
$links['groups'] = strpos($currentUrl, Router::url(['prefix' => 'admin', 'controller' => 'Groups', 'action' => 'index'])) !== false;
$links['groups_add'] = $currentUrl === Router::url(['prefix' => 'admin', 'controller' => 'Groups', 'action' => 'add']);
$links['kit-items'] = strpos($currentUrl, Router::url(['prefix' => 'admin', 'controller' => 'KitItems', 'action' => 'index'])) !== false;
$links['kit-items_add'] = $currentUrl === Router::url(['prefix' => 'admin', 'controller' => 'KitItems', 'action' => 'add']);
$links['kit-orders'] = strpos($currentUrl, Router::url(['prefix' => 'admin', 'controller' => 'KitOrders', 'action' => 'index'])) !== false;
$links['kit-orders_view'] = $currentUrl === Router::url(['prefix' => 'admin', 'controller' => 'KitOrders', 'action' => 'index']);
$links['kit-orders_config'] = $currentUrl === Router::url(['prefix' => 'admin', 'controller' => 'KitOrders', 'action' => 'config']);
$links['kit-orders_process'] = $currentUrl === Router::url(['prefix' => 'admin', 'controller' => 'KitOrders', 'action' => 'process']);
$links['kit-orders_processed'] = $currentUrl === Router::url(['prefix' => 'admin', 'controller' => 'KitOrders', 'action' => 'processedOrders']);
?>

<?= $this->element('header', ['fixedTop' => true]) ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li<?= $links['admin'] ? ' class="active"' : '' ?>><?= $this->Html->link('Site Administration', ['_name' => 'admin']) ?></li>
            </ul>

            <?php if ($currentUser->isAuthorised('admin.users.*')): ?>
                <ul class="nav nav-sidebar">
                    <li<?= $links['users'] ? ' class="active"' : '' ?>><?= $this->Html->link('Users', ['prefix' => 'admin', 'controller' => 'Users', 'action' => 'index']) ?></li>
                    <?php if ($links['users']) : ?>
                        <?php if ($currentUser->isAuthorised('admin.users.add')): ?>
                            <li<?= $links['users_add'] ? ' class="active"' : '' ?>><?= $this->Html->link('Add User', ['prefix' => 'admin', 'controller' => 'Users', 'action' => 'add']) ?></li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
            <?php endif ?>
            <?php if ($currentUser->isAuthorised('admin.groups.*')): ?>
                <ul class="nav nav-sidebar">
                    <li<?= $links['groups'] ? ' class="active"' : '' ?>><?= $this->Html->link('Groups', ['prefix' => 'admin', 'controller' => 'Groups', 'action' => 'index']) ?></li>
                    <?php if ($links['groups']) : ?>
                        <?php if ($currentUser->isAuthorised('admin.groups.add')): ?>
                            <li<?= $links['groups_add'] ? ' class="active"' : '' ?>><?= $this->Html->link('Add Group', ['prefix' => 'admin', 'controller' => 'Groups', 'action' => 'add']) ?></li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>
            <?php if ($currentUser->isAuthorised('admin.news.*')): ?>
                <ul class="nav nav-sidebar">
                    <li><?= $this->Html->link('News', ['prefix' => 'admin', 'controller' => 'News', 'action' => 'index']) ?></li>
                    <?php if ($links['news']) : ?>
                        <?php if ($currentUser->isAuthorised('admin.news.add')): ?>
                            <li><?= $this->Html->link('Add Article', ['prefix' => 'admin', 'controller' => 'News', 'action' => 'add']) ?></li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
            <?php endif ?>
            <?php if ($currentUser->isAuthorised('admin.fixtures.*')): ?>
                <ul class="nav nav-sidebar">
                    <li><?= $this->Html->link('Fixtures', ['prefix' => 'admin', 'controller' => 'Fixtures', 'action' => 'index']) ?></li>
                </ul>
                <?php if ($currentUser->isAuthorised('admin.fixtures.add')): ?>
                    <li><?= $this->Html->link('Add Fixture', ['prefix' => 'admin', 'controller' => 'Fixtures', 'action' => 'add']) ?></li>
                <?php endif; ?>
                <?php if ($currentUser->isAuthorised('admin.fixtures.calendar')): ?>
                    <li><?= $this->Html->link('Edit Calendar', ['prefix' => 'admin', 'controller' => 'Fixtures', 'action' => 'calendar']) ?></li>
                <?php endif; ?>
            <?php endif ?>
            <?php if ($currentUser->isAuthorised('admin.socials.*')): ?>
                <ul class="nav nav-sidebar">
                    <li><?= $this->Html->link('Socials', ['prefix' => 'admin', 'controller' => 'Socials', 'action' => 'index']) ?></li>
                </ul>
                <?php if ($currentUser->isAuthorised('admin.socials.add')): ?>
                    <li><?= $this->Html->link('Add Social', ['prefix' => 'admin', 'controller' => 'Socials', 'action' => 'add']) ?></li>
                <?php endif; ?>
            <?php endif ?>
            <?php if ($currentUser->isAuthorised('admin.membership.*')): ?>
                <ul class="nav nav-sidebar">
                    <li><?= $this->Html->link('Membership', ['prefix' => 'admin', 'controller' => 'Membership', 'action' => 'index']) ?></li>
                </ul>
            <?php endif ?>
            <?php if ($currentUser->isAuthorised('admin.kit-items.*')): ?>
                <ul class="nav nav-sidebar">
                    <li<?= $links['kit-items'] ? ' class="active"' : '' ?>><?= $this->Html->link('Kit Items', ['prefix' => 'admin', 'controller' => 'KitItems', 'action' => 'index']) ?></li>
                    <?php if ($links['kit-items']) : ?>
                        <?php if ($currentUser->isAuthorised('admin.kit-items.add')): ?>
                            <li<?= $links['kit-items_add'] ? ' class="active"' : '' ?>><?= $this->Html->link('Add Item', ['prefix' => 'admin', 'controller' => 'KitItems', 'action' => 'add']) ?></li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
            <?php endif ?>
            <?php if ($currentUser->isAuthorised('admin.kit-orders.*')): ?>
                <ul class="nav nav-sidebar">
                    <li<?= $links['kit-orders'] ? ' class="active"' : '' ?>><?= $this->Html->link('Kit Orders', ['prefix' => 'admin', 'controller' => 'KitOrders', 'action' => 'index']) ?></li>
                    <?php if ($links['kit-orders']) : ?>
                        <?php if ($currentUser->isAuthorised('admin.kit-orders.view')): ?>
                            <li<?= $links['kit-orders_view'] ? ' class="active"' : '' ?>><?= $this->Html->link('View Orders', ['prefix' => 'admin', 'controller' => 'KitOrders', 'action' => 'index']) ?></li>
                        <?php endif; ?>
                        <?php if ($currentUser->isAuthorised('admin.kit-orders.process')): ?>
                            <li<?= $links['kit-orders_processed'] ? ' class="active"' : '' ?>><?= $this->Html->link('Processed Orders', ['prefix' => 'admin', 'controller' => 'KitOrders', 'action' => 'processedOrders']) ?></li>
                        <?php endif; ?>
                        <?php if ($currentUser->isAuthorised('admin.kit-orders.process')): ?>
                            <li<?= $links['kit-orders_process'] ? ' class="active"' : '' ?>><?= $this->Html->link('Process Orders', ['prefix' => 'admin', 'controller' => 'KitOrders', 'action' => 'process']) ?></li>
                        <?php endif; ?>
                        <?php if ($currentUser->isAuthorised('admin.kit-orders.config')): ?>
                            <li<?= $links['kit-orders_config'] ? ' class="active"' : '' ?>><?= $this->Html->link('Configure', ['prefix' => 'admin', 'controller' => 'KitOrders', 'action' => 'config']) ?></li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
            <?php endif ?>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header"><?= h($this->fetch('title')) ?></h1>
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>

            <?= $this->element('footer', ['sponsors' => false]) ?>
        </div>
    </div>
</div>