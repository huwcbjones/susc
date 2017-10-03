<?php

use Cake\I18n\Time;

?>

Hi <?= $user->full_name ?>,

This email is to let you know that your email address for the SUSC website has been changed successfully!
This means you cannot log in with your old address.
Your email address was changed: <?= Time::now()->nice() ?>
