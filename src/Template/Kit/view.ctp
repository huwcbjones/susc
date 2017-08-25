<?php

use SUSC\Form\KitBagForm;

$this->layout('kit');
$this->assign('title', h($kit->title));

$this->element('Kit/basket');
$kitBagForm = new KitBagForm();

?>

<div class="row">
    <div class="col-sm-7">
        <?= $kit->description ?>
        <?= $this->Form->create($kitBagForm) ?>
        <?= $this->Form->hidden('id', ['value' => $kit->id]) ?>
        <?= $this->Form->hidden('isRemove', ['value' => 0]) ?>
        <div class="form-group">
            <label for="priceText">Price</label>
            <p class="form-control-static"><?= sprintf("£%.2f", $kit->price) ?></p>
        </div>
        <div<?php if ($kit->sizeList == null) echo ' class="hidden"' ?>>
            <div class="form-group">
                <label for="sizeCombo">Size</label>
                <select name="size" id="sizeCombo" class="form-control">
                    <?php foreach ($kit->sizeList as $size): ?>
                        <option value="<?= $size ?>"><?= $size ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Add to basket <span
                    class="glyphicon glyphicon-shopping-cart"></span></button>
        <?= $this->Form->end() ?>
    </div>
    <div class="col-sm-5">
        <img src="<?= $kit->imagePath ?>" alt="<?= h($kit->title) ?>" class="img-responsive center-block"/>
    </div>
</div>
