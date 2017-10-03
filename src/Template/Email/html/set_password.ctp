<p>Hi <?= $user->first_name ?>,</p>

<p>An account for the Southampton University Swimming Club website has been created!
    But, before you can log in you need to set your password.
</p>

<p>Use the following link to set your password: <br/>
    <?= $this->Html->link($this->Url->build(['_name' => 'reset_password', 'reset_code' => $reset_code], ['fullBase' => true])) ?>
</p>

<p>If you don't use the link within 3 hours, it will expire. To get a new link to set your password,
    visit <?= $this->Html->link($this->Url->build(['_name' => 'reset'], ['fullBase' => true])) ?>
    .</p>

<p>If you have any queries, please don't hesitate to ask a committee member.</p>