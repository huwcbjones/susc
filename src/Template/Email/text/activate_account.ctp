Hi <?= $user->first_name ?>,

Your account for the Southampton University Swimming Club website has been created!
But, before you can log in you need to activate your account.

Use the following link to activate your account:
<?= $this->Url->build(['_name' => 'activate', 'activation_code' => $activation_code], true) ?>


Your activation code is:
<?= $activation_code ?>


If you have any queries, please don't hesitate to ask a committee member.