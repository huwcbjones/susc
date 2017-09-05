<?php

use Cake\I18n\Time;

?>

    <p>Hi <?= $user->full_name ?>,</p>

    <p>This email is to let you know that your password for the SUSC website has been changed.
        Your password was changed: <code><?= Time::now()->nice() ?></code></p>

    <P>If this was you, then you can safely ignore this email.
        If this wasn't you, please contact a committee member as soon as possible.</P>