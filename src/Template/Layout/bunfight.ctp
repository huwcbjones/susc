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
 * @var AppView $this
 */

$this->extend('empty');

$this->append('css', $this->Html->css('bunfight'));
?>

<div class="overlay"></div>
<header class="main-masthead">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-center vertical-center"><h1>Southampton University Swimming Club</h1></div>
        </div>

    </div>
</header>
<div class="container content menu-padding bunfight-container" id="content">
    <?= $this->fetch('precontent') ?>
    <div class="row">
        <div class="col-xs-12">
            <?= $this->Flash->render() ?>
            <div class="page-header"><h1><?= $this->fetch('title') ?></h1></div>

            <?= $this->fetch('content') ?>

        </div>
    </div>

    <hr>
    <?php if (false && (!isset($sponsors) || $sponsors)): ?>
        <div class="row">
            <div class="col-md-6 col-xs-12 text-center">
                <div class="row">
                    <div class="col-xs-12">
                        <h4>Funded by</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <?= $this->Html->link('<h5>Southampton University Students\' Union</h5>' .
                            $this->Html->image('susu_logo.svg', ['alt' => 'Southampton University Students\' Union', 'class' => 'img-responsive footer-logo center-block']),
                            'https://www.susu.org',
                            ['target' => '_blank', 'escape' => false])
                        ?>
                    </div>
                    <div class="col-xs-6">
                        <?= $this->Html->link('<h5>Team Southampton</h5>' .
                            $this->Html->image('team_southampton.png', ['alt' => 'Team Southampton', 'class' => 'img-responsive footer-logo center-block']),
                            'https://www.susu.org/groups/',
                            ['target' => '_blank', 'escape' => false])
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xs-12 text-center">
                <div class="row">
                    <div class="col-xs-12">
                        <h4>Proudly sponsored by</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <?= $this->Html->link('<h5>Kelly&rsquo;s Bar</h5>' .
                            $this->Html->image('kellys.png', ['alt' => 'Kelly\'s Bar', 'class' => 'img-responsive footer-logo center-block']),
                            'https://www.facebook.com/kellysbarsoton/',
                            ['target' => '_blank', 'escape' => false])
                        ?>
                    </div>
                    <div class="clearfix visible-xs-block"></div>
                    <div class="col-sm-6 col-xs-12">
                        <?= $this->Html->link('<h5>Tariq Manzils</h5>' .
                            $this->Html->image('manzils.png', ['alt' => 'Manzils', 'class' => 'img-responsive footer-logo center-block']),
                            'http://tariqmanzils.com/',
                            ['target' => '_blank', 'escape' => false])
                        ?>
                    </div>
                    <div class="clearfix visible-xs-block"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <hr/>
            </div>
        </div>

    <?php endif ?>

    <div class="row">
        <div class="col-xs-12">
            <p class="pull-left">&copy; <?= date("Y") ?> Southampton University Swimming Club.</p>
        </div>
    </div>

</div>
<div class="container">
    <div class="row">
        <div class="col-xs-12">

        </div>
    </div>
</div>