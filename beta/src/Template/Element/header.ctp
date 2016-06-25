<?php
use Cake\Core\Configure;
use Cake\Routing\Router;

$currentUrl = Router::normalize($this->request->here);
$links = array();

$links['home'] = $currentUrl === Router::url(['_name' => 'home']);
$links['news'] = $currentUrl === Router::url(['_name' => 'news']);
$links['training'] = $currentUrl === Router::url(['_name' => 'training']);
$links['training_comp'] = $currentUrl === Router::url(['controller' => 'Training', 'action' => 'comp']);
$links['training_rec'] = $currentUrl === Router::url(['controller' => 'Training', 'action' => 'rec']);
$links['training_times'] = $currentUrl === Router::url(['controller' => 'Training', 'action' => 'times']);
$links['fixtures'] = $currentUrl === Router::url(['_name' => 'fixtures']);
$links['socials'] = $currentUrl === Router::url(['_name' => 'socials']);
$links['about'] = $currentUrl === Router::url(['_name' => 'about']);
$links['about_club'] = $currentUrl === Router::url(['controller' => 'About', 'action' => 'club']);
$links['about_coaches'] = $currentUrl === Router::url(['controller' => 'About', 'action' => 'coaches']);
$links['about_committee'] = $currentUrl === Router::url(['controller' => 'About', 'action' => 'committee']);
$links['contact'] = $currentUrl === Router::url(['_name' => 'contact']);
?>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <?php if (!$this->fetch('navbar.top')): ?>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="true" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            <?php endif; ?>
            <?= $this->Html->link(Configure::read('App.name'), '/', ['class' => 'navbar-brand']); ?>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="navbar-text" id="logo">
                    <div class="text-center logo"><a
                            href="/"><?= $this->Html->image('logo_min.png', ['alt' => 'SUSC']) ?></a></div>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-left">
                <li<?= $links['home'] ? ' class="active"' : '' ?>><?= $this->Html->link('Home', ['_name' => 'home']) ?></li>
                <li<?= $links['news'] ? ' class="active"' : '' ?>><?= $this->Html->link('News', ['_name' => 'news']) ?></li>
                <li class="dropdown<?= $links['training'] ? ' active' : '' ?>">
                    <a href="training" class="dropdown-toggle" title="SUSC Training" data-toggle="dropdown"
                       role="button" aria-haspopup="true"
                       aria-expanded="false">Training <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li<?= $links['training_comp'] ? ' class="active"' : '' ?>><?= $this->Html->link('Competition Squad', ['controller' => 'Training', 'action' => 'comp']) ?></li>
                        <li<?= $links['training_rec'] ? ' class="active"' : '' ?>><?= $this->Html->link('Recreational Squad', ['controller' => 'Training', 'action' => 'rec']) ?></li>
                        <li<?= $links['training_times'] ? ' class="active"' : '' ?>><?= $this->Html->link('Training Times', ['controller' => 'Training', 'action' => 'times']) ?></li>
                    </ul>
                </li>
                <li<?= $links['fixtures'] ? ' class="active"' : '' ?>><?= $this->Html->link('Fixtures', ['_name' => 'fixtures']) ?></li>
                <li<?= $links['socials'] ? ' class="active"' : '' ?>><?= $this->Html->link('Socials', ['_name' => 'socials']) ?></li>
                <li class="dropdown<?= $links['about'] ? ' active' : '' ?>">
                    <a href="about" class="dropdown-toggle" data-toggle="dropdown"
                       role="button" aria-haspopup="true"
                       aria-expanded="false">About Us <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li<?= $links['about_club'] ? ' class="active"' : '' ?>><?= $this->Html->link('Our Club', ['_name' => 'about']) ?></li>
                        <li<?= $links['about_coaches'] ? ' class="active"' : '' ?>><?= $this->Html->link('Our Coaches', ['controller' => 'About', 'action' => 'coaches']) ?></li>
                        <li<?= $links['about_committee'] ? ' class="active"' : '' ?>><?= $this->Html->link('Our Committee', ['controller' => 'About', 'action' => 'committee']) ?></li>
                    </ul>
                </li>
                <li<?= $links['contact'] ? ' class="active"' : '' ?>><?= $this->Html->link('Contact Us', ['_name' => 'contact']) ?></li>
            </ul>
        </div>
    </div>
</nav>

