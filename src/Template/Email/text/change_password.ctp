<?php

use Cake\I18n\Time;

?>

Hi <?= $user->full_name ?>,

This email is to let you know that your password for the SUSC website has been changed.
Your password was changed: <?= Time::now()->nice() ?>


If this was you, then you can safely ignore this email.
If this wasn't you, please contact a committee member as soon as possible.
