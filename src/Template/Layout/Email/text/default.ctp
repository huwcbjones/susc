<?php

use Cake\Core\Configure;
use Cake\Routing\Router;

?>
<?php if (Configure::read('App.devel')): ?>
===============================================================================
=              This email is from the SUSC development website.               =
=      If you were not expecting to see this email, please disregard it!      =
===============================================================================
<?php endif; ?>
<?= $this->fetch('content') ?>


Many thanks,
Southampton University Swimming Club

Website <?= Router::url('/', true) ?>

Facebook https://fb.me/sotonswimteam/
Instagram https://www.instagram.com/swimsusc/
Twitter https://twitter.com/swimsusc