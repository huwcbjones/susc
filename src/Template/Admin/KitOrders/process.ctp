<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 *
 * @var AppView $this
 */

use SUSC\View\AppView;

$this->assign('title', 'Process Orders');
?>

<h3>About Order Processing</h3>
<p>To process orders, click the process orders button below. The website will then create an order batch based on the options below.</p>
<ul>
    <li>Orders that have <strong>not</strong> been paid for will <strong>not</strong> be included</li>
    <li>Orders that have previously been processed will <strong>not</strong> be included</li>
    <li>After processing, you can download the orders.</li>
</ul>


<h3>Process Order</h3>

<?= $this->Form->create() ?>
<h4>Options</h4>
<p>TODO: Add ability to select what items to process. If you're lucky you can have some templates so you can just select "Masuri Kit" and have the Masuri kit processed! :)</p>

<?= $this->Form->submit('Process Order', ['class' => ['btn-primary']]) ?>
<?= $this->Form->end() ?>
