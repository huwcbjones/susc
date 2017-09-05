<?php

use Cake\I18n\Time;

?>

<p>Hi <?= $user->full_name ?>,</p>

<p>This email is to let you know that your email address for the SUSC website has been changed successfully!
    This means you cannot log in with your old address.<br/>
    Your email address was changed: <?= Time::now()->nice() ?></p>
