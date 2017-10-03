<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 *
 * @var AppView $this
 * @var Item[] $items
 */

use SUSC\Model\Entity\Item;
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
<div class="checkbox">
    <label>
        <input type="checkbox" id="selectAllItemsCheckbox" />
        Select All
    </label>
</div>
<div class="row">
    <div class="col-xs-6">
        <?php for ($i = 0; $i < count($items); $i += 2): ?>
            <div class="checkbox">
                <label>
                    <?= $this->Form->checkbox('items[]', ['hiddenField' => false, 'value' => $items[$i]->id, 'class' => ['itemCheckbox']]) ?>
                    <?= $items[$i]->title ?>
                </label>
            </div>
        <?php endfor ?>
    </div>
    <div class="col-xs-6">
        <?php for ($i = 1; $i < count($items); $i += 2): ?>
            <div class="checkbox">
                <label>
                    <?= $this->Form->checkbox('items[]', ['hiddenField' => false, 'value' => $items[$i]->id, 'class' => ['itemCheckbox']]) ?>
                    <?= $items[$i]->title ?>
                </label>
            </div>
        <?php endfor ?>
    </div>
</div>

<p>TODO: If you're lucky you can have some templates so you can just select "Masuri Kit" and have the Masuri kit processed! :)</p>

<?= $this->Form->submit('Process Order', ['class' => ['btn-primary']]) ?>
<?= $this->Form->end() ?>

<?php
$this->start('postscript');
echo $this->fetch('postscript');
?>
<script type="text/javascript">
    var checkboxes = $(".itemCheckbox");
    checkboxes.change(function(){
        $("#selectAllItemsCheckbox").prop('checked', checkboxes.length === $(".itemCheckbox:checked").length);
    });
    $("#selectAllItemsCheckbox").change(function() {
        checkboxes.prop('checked', $(this).is(':checked'));
    })
</script>
<?php $this->end() ?>