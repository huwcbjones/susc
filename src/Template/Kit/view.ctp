<?php

use SUSC\Form\KitBagForm;

$this->assign('title', h($kit->title));

$this->element('Kit/bag');
$kitBagForm = new KitBagForm();

?>

<div class="row">
    <div class="col-sm-8 media">
        <div class="media-body">
            <?= $kit->description ?>
            <div class="col-sm-6">
                <?= $this->Form->create($kitBagForm) ?>
                <?= $this->Form->hidden('id', ['value' => $kit->id]) ?>
                <?= $this->Form->hidden('isRemove', ['value' => 0]) ?>
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
                <button type="submit" class="btn btn-primary">Add to my bag</button>
                <?= $this->Form->end() ?>
            </div>
        </div>
        <div class="media-right">
            <img src="<?= $kit->imagePath ?>" alt="<?= h($kit->title) ?>"/>
        </div>
    </div>
    <?= $this->fetch('bag', $kitBagData) ?>
</div>