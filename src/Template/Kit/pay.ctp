<?php
$this->assign('title', 'Select Payment');
$this->Form->unlockField('payment');
?>

<div class="row">
    <div class="col-xs-12">
        <h2 class="h4">Terms and Conditions</h2>
        <?= $terms ?>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <h2 class="h4">Payment Method</h2>
        <p>SUSC will <strong>not</strong> accept any payments online through the website.
            Payment must either be made via Bank Account Transfer, or by Cash.</p>
        <p>After selecting your payment method, and confirming your order, you will receive an email confirming your order.
            This will include instructions on how to make your payment.
            Your order and payment instructions will also appear in your account under <?= $this->Html->link('My Profile', ['_name' => 'profile']) ?>.</p>

        <?= $this->Form->create() ?>
        <p>Please select below how you wish to pay for your order of: <strong><?= sprintf("£%.2f", $basketTotal) ?></strong></p>
        <div class="radio">
            <label>
                <input type="radio" name="payment" id="payment-cash" value="cash">
                Cash
            </label>
        </div>
        <div class="radio">
            <label>
                <input type="radio" name="payment" id="payment-bat" value="bat">
                Bank Account Transfer
            </label>
        </div>
        <div class="row">
            <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-0 col-lg-4">
                <?= $this->Html->link('<span class="glyphicon glyphicon-chevron-left"></span> Basket', ['_name' => 'basket'], ['class' => ['btn', 'btn-warning', 'btn-lg', 'btn-block'], 'escape' => false]) ?>
            </div>
            <div class="col-xs-12 visible-xs-block"><br /></div>
            <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-2 col-lg-4 col-lg-offset-4">
                <?= $this->Form->button('Confirm Order <span class="glyphicon glyphicon-ok"></span>', ['class' => ['btn', 'btn-success', 'btn-lg', 'btn-block']]) ?>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>

