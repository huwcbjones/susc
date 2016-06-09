<?php
use Cake\Core\Configure;

?>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <?php if ($this->fetch('navbar.top')): ?>
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
                    <div class="text-center logo"><a href="/"><?= $this->Html->image('logo_min.png', ['alt' => 'SUSC']) ?></a></div>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-left">
                <li><?= $this->Html->link(Configure::read('App.name'), '/', ['class' => 'navbar-brand']); ?></li>
                <li><?= $this->Html->link('News', ['controller' => 'News'])  ?></li>
                <li class="dropdown">
                    <a href="training" class="dropdown-toggle" title="SUSC Training" data-toggle="dropdown"
                       role="button" aria-haspopup="true"
                       aria-expanded="false">Training <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="comp" title="Find out about our Comp Squad">Competition Squad</a></li>
                        <li><a href="rec" title="Find out about our Rec Squad">Recreational Squad</a></li>
                        <li><a href="times" title="Find out when we train">Training Times</a></li>
                    </ul>
                </li>
                <li><? /*= $this->Html->link('Fixtures', ['controller' => 'Fixtures']) */ ?></li>
                <li><? /*= $this->Html->link('Socials', ['controller' => 'Socials']) */ ?></li>
                <li class="dropdown">
                    <? /*= $this->Html->link('About Us  <span class="caret"></span>', ['controller' => 'About', 'class'=>'dropdown-toggle']) */ ?>

                    <ul class="dropdown-menu">
                        <li><a href="club">Our Club</a></li>
                        <li><a href="coaches">Our Coaches</a></li>
                        <li><a href="committee">Our Committee</a></li>
                    </ul>
                </li>
                <li><a href="contact">Contact Us</a></li>
            </ul>
        </div>-->
    </div>
</nav>

