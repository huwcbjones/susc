<?php

use Cake\View\View;

/** @var View $this */

?>
Hi <?= $user->first_name ?>!

You've successfully created an account for the SUSC website.

Before you can login to the website, you'll need to activate your account.
To do so visit <?= $this->Url->build(['_name' => 'activate'], ['fullBase' => true]) ?> and paste the following code into the activation code box.

Activation Code: <?= $activationCode ?>
