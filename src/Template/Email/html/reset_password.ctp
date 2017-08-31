<?php

use Cake\Routing\Router;

?>
<p>Hi <?= $user->first_name ?>,</p>

<p>You had trouble logging in and wanted to reset your password.<br/>
    If this was not you, you can <strong>safely ignore</strong> this email.</p>

<h3 class="h4">Your Details</h3>
<p><strong>Name:</strong> <?= $user->full_name ?><br/>
    <strong>Email:</strong> <?= $user->email_address ?><br/>
    <strong>Date Registered:</strong> <?= $user->created ?></p>

<p>Use the following link to reset your password: <br/>
    <?= $this->Html->link(Router::url(['_name' => 'reset_password',  'reset_code' => $reset_code], true), ['_name' => 'reset_password',  'reset_code' => $reset_code], ['fullBase' => true]) ?>
</p>

<p>If you don't use the link within 3 hours, it will expire. To get a new password reset link,
    visit <?= $this->Html->link(Router::url(['_name' => 'reset'], true), ['_name' => 'reset'], ['fullBase' => true]) ?>.</p>