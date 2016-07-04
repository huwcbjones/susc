<?php
use Cake\Core\Configure;

?>
<?= $this->Html->charset() ?>

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="apple-mobile-web-app-title" content="SUSC">
<meta name="apple-mobile-web-app-capable" content="no"/>
<link rel="apple-touch-icon" sizes="57x57" href="/img/icon/apple-touch-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/img/icon/apple-touch-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/img/icon/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/img/icon/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/img/icon/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/img/icon/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/img/icon/apple-touch-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/img/icon/apple-touch-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/img/icon/apple-touch-icon-180x180.png">
<link rel="icon" type="image/png" href="/img/icon/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="/img/icon/favicon-194x194.png" sizes="194x194">
<link rel="icon" type="image/png" href="/img/icon/favicon-96x96.png" sizes="96x96">
<link rel="icon" type="image/png" href="/img/icon/android-chrome-192x192.png" sizes="192x192">
<link rel="icon" type="image/png" href="/img/icon/favicon-16x16.png" sizes="16x16">
<link rel="manifest" href="/img/icon/manifest.json">
<link rel="mask-icon" href="/img/icon/safari-pinned-tab.svg" color="#552b35">
<meta name="msapplication-TileColor" content="#2b554b">
<meta name="msapplication-TileImage" content="/mstile-144x144.png">
<meta name="theme-color" content="#552b35">
<meta name="COPYRIGHT"
      content="© 2016. All content, photos and text are the property of Southampton University Swimming Club. All Rights Reserved. Site conducted in accordance with the ASA &quot;Guidelines for Club Web Sites&quot;."/>
<meta http-equiv="Content-Language" content="en-gb"/>
<meta http-equiv="CONTENT-LANGUAGE" content="en-US,en-GB,en"/>
<meta name="msvalidate.01" content="0507DB2FA5C0529E705119BE61898740"/>
<meta name="ROBOTS" content="INDEX"/>
<?= $this->Html->meta([
    'description',
    h($this->fetch('description'))
]) ?>

<title><?= h($this->fetch('title')) ?> | <?= Configure::read('App.name') ?></title>

<?= $this->Html->css('bootstrap.min.css') ?>

<?= $this->Html->css('font-awesome.min.css') ?>

<?= $this->Html->css('styling.css') ?>

<?= $this->fetch('meta') ?>
<?= $this->fetch('css') ?>
<?= $this->fetch('script') ?>

<?= $this->Html->meta(
    'favicon.ico',
    '/favicon.ico',
    ['type' => 'icon']
) ?>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<?= $this->Html->script('html5shiv.min.js') ?>

<?= $this->Html->script('respond.min.js') ?>

<![endif]-->