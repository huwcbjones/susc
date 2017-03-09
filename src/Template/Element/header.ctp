<?php
use Cake\Core\Configure;
use Cake\Routing\Router;

$currentUrl = Router::normalize($this->request->here);
$links = array();
$links['home'] = $currentUrl === Router::url(['_name' => 'home']);
$links['news'] = strpos($currentUrl, Router::url(['_name' => 'news'])) !== false;
$links['training'] = strpos($currentUrl, Router::url(['_name' => 'training'])) !== false;
$links['training_comp'] = $currentUrl === Router::url(['_name' => 'training_comp']);
$links['training_rec'] = $currentUrl === Router::url(['_name' => 'training_rec']);
$links['training_facilities'] = $currentUrl === Router::url(['_name' => 'training_facilities']);
$links['fixtures'] = strpos($currentUrl, Router::url(['_name' => 'fixtures'])) !== false;
$links['fixtures_feed'] = strpos($currentUrl, Router::url(['_name' => 'fixtures'])) !== false && strpos($currentUrl, Router::url(['_name' => 'fixture_calendar'])) === false;
$links['fixtures_calendar'] = $currentUrl === Router::url(['_name' => 'fixture_calendar']);
$links['gallery'] = strpos($currentUrl, Router::url(['_name' => 'gallery'])) !== false;
$links['socials'] = strpos($currentUrl, Router::url(['_name' => 'socials'])) !== false;
$links['about'] = strpos($currentUrl, 'about') !== false;
$links['about_contact'] = $currentUrl === Router::url(['_name' => 'contact']);
$links['about_club'] = $currentUrl === Router::url(['controller' => 'About', 'action' => 'club']);
$links['about_coaches'] = $currentUrl === Router::url(['controller' => 'About', 'action' => 'coaches']);
$links['about_committee'] = $currentUrl === Router::url(['controller' => 'About', 'action' => 'committee']);
?>
<nav class="navbar navbar-inverse container fix-menu-margin" id="nav">
    <div class="container" id="nav-container">
        <div class="navbar-header" id="nav-header">
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
            <ul class="nav navbar-nav navbar-right text-center">
                <li class="navbar-brand" id="logo">
                    <a class="header-image-container" href="/">
                        <span class="header-image"></span>
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-left">
                <li<?= $links['home'] ? ' class="active"' : '' ?>><?= $this->Html->link('Home', ['_name' => 'home']) ?></li>
                <li<?= $links['news'] ? ' class="active"' : '' ?>><?= $this->Html->link('News', ['_name' => 'news']) ?></li>
                <li class="dropdown<?= $links['fixtures'] ? ' active' : '' ?>">
                    <a href="<?= Router::url(['_name' => 'fixtures']) ?>" class="dropdown-toggle" data-toggle="dropdown"
                       role="button" aria-haspopup="true"
                       aria-expanded="false">Fixtures <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li<?= $links['fixtures_feed'] ? ' class="active"' : '' ?>><?= $this->Html->link('Fixtures', ['_name' => 'fixtures']) ?></li>
                        <li<?= $links['fixtures_calendar'] ? ' class="active"' : '' ?>><?= $this->Html->link('Fixture Calendar', ['_name' => 'fixture_calendar']) ?></li>
                    </ul>
                </li>
                <li<?= $links['socials'] ? ' class="active"' : '' ?>><?= $this->Html->link('Socials', ['_name' => 'socials']) ?></li>
                <li class="dropdown<?= $links['training'] ? ' active' : '' ?>">
                    <a href="#" class="dropdown-toggle" title="SUSC Training"
                       data-toggle="dropdown"
                       role="button" aria-haspopup="true"
                       aria-expanded="false">Training <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li<?= $links['training_comp'] ? ' class="active"' : '' ?>><?= $this->Html->link('Competition Squad', ['_name' => 'training_comp']) ?></li>
                        <li<?= $links['training_rec'] ? ' class="active"' : '' ?>><?= $this->Html->link('Recreational Squad', ['_name' => 'training_rec']) ?></li>
                        <li<?= $links['training_facilities'] ? ' class="active"' : '' ?>><?= $this->Html->link('Training Facilities', ['_name' => 'training_facilities']) ?></li>
                    </ul>
                </li>
                <li<?= $links['gallery'] ? ' class="active"' : '' ?>><?= $this->Html->link('Gallery', ['_name' => 'gallery']) ?></li>
                <li class="dropdown<?= $links['about'] ? ' active' : '' ?>">
                    <a href="<?= Router::url(['_name' => 'about']) ?>" class="dropdown-toggle" data-toggle="dropdown"
                       role="button" aria-haspopup="true"
                       aria-expanded="false">About Us <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li<?= $links['about_contact'] ? ' class="active"' : '' ?>><?= $this->Html->link('Contact Us', ['_name' => 'contact']) ?></li>
                        <li<?= $links['about_club'] ? ' class="active"' : '' ?>><?= $this->Html->link('Our Club', ['_name' => 'about']) ?></li>
                        <li<?= $links['about_coaches'] ? ' class="active"' : '' ?>><?= $this->Html->link('Our Coaches', ['controller' => 'About', 'action' => 'coaches']) ?></li>
                        <li<?= $links['about_committee'] ? ' class="active"' : '' ?>><?= $this->Html->link('Our Committee', ['controller' => 'About', 'action' => 'committee']) ?></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

