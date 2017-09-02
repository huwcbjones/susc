<?php

?>

<p>Hi <?= $user->first_name ?>,</p>

<p>Your account for the Southampton University Swimming Club website is now activated!
    You can now view more information about the club, as well as registering as a member, or ordering kit.
</p>

<p><?= $this->Html->link('Log in', ['_name' => 'login'], ['class' => ['btn', 'btn-lg', 'btn-primary'], '_full' => true])?></p>

<p>If you have any queries, please don't hesitate to ask a committee member.</p>