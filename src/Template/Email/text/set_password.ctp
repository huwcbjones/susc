Hi <?= $user->first_name ?>,

An account for the Southampton University Swimming Club website has been created!
But, before you can log in you need to set your password.


Use the following link to set your password:

<?= $this->Url->build(['_name' => 'reset_password', 'reset_code' => $reset_code], ['fullBase' => true]) ?>


If you don't use the link within 3 hours, it will expire. To get a new link to set your password, visit

<?= $this->Url->build(['_name' => 'reset'], ['fullBase' => true]) ?>


If you have any queries, please don't hesitate to ask a committee member.