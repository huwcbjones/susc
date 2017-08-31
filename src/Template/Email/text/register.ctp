<?php

use Cake\Routing\Router;

?>
Hi <?= $user->first_name ?>!

You've successfully created an account for the SUSC website.

Before you can login to the website, you'll need to activate your account.
To do so visit <?= Router::url(['_name' => 'activate']) ?> and paste the following code into the activation code box.

Activation Code: <?= $activationCode ?>
