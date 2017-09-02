<?php

use Cake\View\View;

/** @var View $this */

?>
Hi <?= $user->first_name ?>,

You requested to change your email.
Before we can complete the request, we need you to verify this email address.

If this email means nothing to you, please contact Southampton University Swimming Club using the following link:

<?= $this->Url->build(['_name' => 'contact'], ['fullBase' => true]) ?>


To verify your email address, use the following link:

<?= $this->Url->build(['_name' => 'verify_email', 'email_code' => $code], ['fullBase' => true]) ?>


If you don't use the link within 3 hours, it will expire. If the link expires, you will have to change your email address again by visiting <?= $this->Url->build(['_name' => 'change_email'], ['fullBase' => true]) ?>


