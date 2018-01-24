<?php

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= use Cake\Core\Configure;

        $this->fetch('title') ?></title>
    <?= $this->Html->css('bootstrap.min.css', ['fullBase' => true]) ?>
    <?= $this->Html->css('styling.css', ['fullBase' => true]) ?>
</head>
<body>
<header class="main-masthead">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-center vertical-center"><h1>Southampton University Swimming Club</h1></div>
        </div>

    </div>
</header>
<div class="container" id="email-content">
    <div class="row">
        <div class="col-xs-12">
            <?php if (Configure::read('App.devel')): ?>
                <p class="text-danger"><span class="glyphicon glyphicon-alert"></span> This email is from the SUSC development website. If you were not
                    expecting to see this email, please disregard it!</p>
            <?php endif; ?>
            <?= $this->fetch('content') ?>

            <p>Many thanks,<br/>
                Southampton University Swimming Club</p>
            <footer>
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <hr/>
                        <p class="text-center">
                            <?= $this->Html->link('Website', 'https://www.susc.org.uk', ['target' => '_blank']) ?>
                            &middot;
                            <?= $this->Html->link('Facebook', 'https://www.facebook.com/sotonswimteam/', ['target' => '_blank']) ?>
                            &middot;
                            <?= $this->Html->link('Facebook Group', 'https://www.facebook.com/groups/114314605328729/', ['target' => '_blank']) ?>
                            &middot;
                            <?= $this->Html->link('Instagram', 'https://www.instagram.com/swimsusc/', ['target' => '_blank']) ?>
                            &middot;
                            <?= $this->Html->link('Twitter', 'https://twitter.com/swimsusc', ['target' => '_blank']) ?>
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</div>
</body>
</html>
