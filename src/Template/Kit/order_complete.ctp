<?php
$this->layout('clean');
$this->assign('title', 'Order placed!');
?>

<div class="jumbotron">
    <h2><?= $this->fetch('title') ?></h2>
    <p>Your order number is <code><?= $orderNumber ?></code></p>

    <p>An email confirming your order will be sent to you shortly.
        Details on how to pay can be found in the <?= $this->Html->link('Kit FAQs', ['_name'=>'faq']) ?>.
        Please pay as soon as possible - delays in payment may result in your items not being ordered.</p>

</div>
