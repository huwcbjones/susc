<?php

use Cake\View\View;

/** @var View $this */

?>
<p>Hi <?= $user->first_name ?>,</p>

<p>You requested to change your email.
    Before we can complete the request, we need you to verify this email address.</p>

<p>If this email means nothing to you, please contact Southampton University Swimming Club using the following
    link:<br/>

    <?= $this->Html->link($this->Url->build(['_name' => 'contact'], ['fullBase' => true])) ?></p>


<p>To verify your email address, use the following link: <br/>

    <?= $this->Html->link($this->Url->build(['_name' => 'verify_email', 'email_code' => $code], ['fullBase' => true])) ?></p>

<p>
    If you don't use the link within 3 hours, it will expire. If the link expires, you will have to change your email
    address again by
    visiting <?= $this->Html->link($this->Url->build(['_name' => 'change_email'], ['fullBase' => true])) ?></p>


