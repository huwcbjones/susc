<?php

use SUSC\Form\KitBagForm;

$this->layout('kit');
$this->assign('title', h($kit->title));

$this->element('Kit/basket');
$kitBagForm = new KitBagForm();

?>

<div class="row">
    <div class="col-sm-7">
        <div class="row">
            <div class="col-xs-12">
                <h3 class="h4">Description</h3>
                <?= $kit->renderedDescription ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <h3 class="h4">Price</h3>
                <?= $kit->formattedPrice ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <h3 class="h4">Options</h3>
                <?= $this->Form->create($kitBagForm) ?>
                <?= $this->Form->hidden('id', ['value' => $kit->id]) ?>
                <?= $this->Form->hidden('isRemove', ['value' => 0]) ?>
                <?php if($kit->additional_info): ?>
                    <div class="form-group">
                        <label for="additionalInfo">Additional Information</label>
                        <?= $this->Form->text('additional_info') ?>
                        <p class="help-block"><?= $kit->additional_info_description ?></p>
                    </div>
                <?php endif; ?>
                <div class="form-group<?php if ($kit->sizeList == null): ?> hidden<?php endif; ?>">
                    <label for="sizeCombo">Size</label>
                    <select name="size" id="sizeCombo" class="form-control">
                        <?php foreach ($kit->sizeList as $size): ?>
                            <option value="<?= $size ?>"><?= $size ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <select name="quantity" id="quantity" class="form-control">
                        <?php for ($i = 1; $i < 10; $i++) : ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Add to basket <span class="glyphicon glyphicon-shopping-cart"></span></button>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
    <div class="col-sm-5">
        <img src="<?= $kit->imagePath ?>" alt="<?= h($kit->title) ?>" class="img-responsive center-block"/>
    </div>
</div>