<?php
use Cake\Core\Configure;

?>
<?= $this->Html->charset() ?>

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="apple-mobile-web-app-title" content="SUSC">
<meta name="apple-mobile-web-app-capable" content="no"/>
<link rel="apple-touch-icon-precomposed" sizes="57x57" href="/img/icon/apple-icon-57x57.png">
<link rel="apple-touch-icon-precomposed" sizes="60x60" href="/img/icon/apple-icon-60x60.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/img/icon/apple-icon-72x72.png">
<link rel="apple-touch-icon-precomposed" sizes="76x76" href="/img/icon/apple-icon-76x76.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/img/icon/apple-icon-114x114.png">
<link rel="apple-touch-icon-precomposed" sizes="120x120" href="/img/icon/apple-icon-120x120.png">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/img/icon/apple-icon-144x144.png">
<link rel="apple-touch-icon-precomposed" sizes="152x152" href="/img/icon/apple-icon-152x152.png">
<link rel="apple-touch-icon-precomposed" sizes="180x180" href="/img/icon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="/img/icon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="/img/icon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="/img/icon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="/img/icon/favicon-16x16.png">
<link rel="manifest" href="/img/icon/manifest.json">
<meta name="application-name" content="SUSC"/>
<meta name="msapplication-TileColor" content="#552b35">
<meta name="msapplication-TileImage" content="/img/icon/ms-icon-144x144.png">
<meta name="theme-color" content="#552b35">
<meta name="msapplication-TileColor" content="#552b35">
<meta name="msapplication-TileImage" content="/img/icon/mstile-144x144.png" />
<meta name="msapplication-square70x70logo" content="/img/icon/mstile-70x70.png" />
<meta name="msapplication-square150x150logo" content="/img/icon/mstile-150x150.png" />
<meta name="msapplication-wide310x150logo" content="/img/icon/mstile-310x150.png" />
<meta name="msapplication-square310x310logo" content="/img/icon/mstile-310x310.png" />
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