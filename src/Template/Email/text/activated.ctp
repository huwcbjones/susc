<?php

use Cake\Routing\Router;

?>

Hi <?= $user->first_name ?>,

Your account for the Southampton University Swimming Club website is now activate!
You can now view more information about the club, as well as registering as a member, or ordering kit.

Log in at <?= Router::url(['_name' => 'login'], true)?>

If you have any queries, please don't hesitate to ask a committee member.

