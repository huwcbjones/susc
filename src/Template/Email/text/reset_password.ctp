<?php

use Cake\Routing\Router;

?>
Hi <?= $user->first_name ?>,

You had trouble logging in and wanted to reset your password.
If this was not you, you can safely ignore this email.

Your Details
Name: <?= $user->full_name ?>

Email:  <?= $user->email_address ?>

Date Registered: <?= $user->created ?>


Use the following link to reset your password:

<?= Router::url(['_name' => 'reset_password', 'reset_code' => $reset_code], true) ?>


If you don't use the link within 3 hours, it will expire. To get a new password reset link, visit <?= Router::url(['_name' => 'reset'], true) ?>