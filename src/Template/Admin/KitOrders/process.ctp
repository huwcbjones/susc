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
<p>To process orders, click the process orders button below.</p>
<ul>
    <li>Orders that have <strong>not</strong> been paid for will <strong>not</strong> be included</li>
    <li>Orders that have previously been processed will <strong>not</strong> be included</li>
    <li>The orders will then be converted into a format that can be imported into <code>Core-Order-Form.xlsm</code> and <code>Athletics-Order-Form.xlsm</code></li>
    <li>After conversion, you can download the orders.</li>
</ul>


<h3>Process Order</h3>

<?= $this->Form->create() ?>
<h4>Options</h4>

<?= $this->Form->submit('Process Order', ['class' => ['btn-primary']]) ?>
<?= $this->Form->end() ?>
