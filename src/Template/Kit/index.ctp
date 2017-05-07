<?php

$this->element('Kit/bag');

?>
<form class="form-horizontal">
    <div class="row">
        <div class="col-sm-8 media">
            Kit shiz
        </div>
        <?= $this->fetch('bag') ?>
    </div>
</form>