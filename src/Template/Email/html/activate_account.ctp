<p>Hi <?= $user->first_name ?>,</p>

<p>Your account for the Southampton University Swimming Club website has been created!
    But, before you can log in you need to activate your account.
</p>

<p>Use the following link to activate your account: <br/>
    <?= $this->Html->link($this->Url->build(['_name' => 'activate', 'activation_code' => $activation_code], ['fullBase' => true]), ['_name' => 'activate', 'activation_code' => $activation_code, '_full' => true]) ?>
</p>

<p>Your activation code is:<br/><kbd><?= $activation_code ?></kbd></p>

<p>If you have any queries, please don't hesitate to ask a committee member.</p>