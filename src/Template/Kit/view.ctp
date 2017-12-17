<?php

use SUSC\Form\KitBagForm;
use SUSC\Model\Entity\Item;
use SUSC\View\AppView;

/**
 * @var AppView $this
 * @var Item $kit
 */
$this->layout('kit');
$this->assign('title', h($kit->title));
$this->assign('description', $kit->description);

$this->element('Kit/basket');
$kitBagForm = new KitBagForm();

?>
<?php if (!$kit->instock): ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="alert alert-danger">
                This item is <strong>not</strong> currently available to order!
            </div>
        </div>
    </div>
<?php endif; ?>
    <div class="row">
        <div class="col-sm-7">
            <div class="row">
                <div class="col-xs-12">
                    <h3 class="h4">Description</h3>
                    <?= $kit->renderedDescription ?>
                    <hr />
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <h3 class="h4">Price</h3>
                    <?= $kit->formattedPrice ?>
                    <hr />
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <h3 class="h4">Options</h3>
                    <?php if (!$kit->instock): ?>
                        <?php if ($kit->additional_info): ?>
                            <div class="form-group">
                                <label for="additionalInfo">Additional Information</label>
                                <p class="help-block"><?= $kit->additional_info_description ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if ($kit->sizeList !== null): ?>
                            <div class="form-group">
                                <label class="control-label" for="sizeCombo">Sizes</label>
                                <p class="form-control-static"><?= implode(', ', $kit->sizeList) ?></p>
                            </div>
                        <?php endif ?>
                    <?php else: ?>
                        <?= $this->Form->create($kitBagForm) ?>
                        <?= $this->Form->hidden('id', ['value' => $kit->id]) ?>
                        <?= $this->Form->hidden('isRemove', ['value' => 0]) ?>
                        <?php if ($kit->additional_info): ?>
                            <div class="form-group">
                                <label for="additionalInfo">Additional Information</label>
                                <?= $this->Form->text('additional_info') ?>
                                <p class="help-block"><?= $kit->additional_info_description ?></p>
                            </div>
                        <?php endif; ?>
                        <div class="form-group<?php if ($kit->sizeList == null): ?> hidden<?php endif; ?>">
                            <label for="sizeCombo">Size</label>
                            <?= $this->Form->select('size', $kit->sizeList, ['empty' => 'Select Size']) ?>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <select name="quantity" id="quantity" class="form-control">
                                <?php for ($i = 1; $i < 10; $i++) : ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <?php if ($kit->additional_info): ?>
                            <button type="button" class="btn btn-primary btn-block" onclick="onSubmit()">Add to basket <span
                                        class="glyphicon glyphicon-shopping-cart"></span></button>
                        <?php else: ?>
                            <button type="submit" class="btn btn-primary btn-block">Add to basket <span class="glyphicon glyphicon-shopping-cart"></span>
                            </button>
                        <?php endif ?>
                        <?= $this->Form->end() ?>
                    <?php endif; ?>
                    <br class="visible-xs"/>
                </div>
            </div>
        </div>
        <div class="col-sm-5">
            <img src="<?= $kit->imagePath ?>" alt="<?= h($kit->title) ?>" class="img-responsive center-block"/>
        </div>
    </div>

<?php if ($kit->additional_info): ?>
    <?php $this->start('postscript'); ?>
    <?= $this->get('postscript') ?>
    <script type="text/javascript">
        additional_info = $("[name=additional_info]");
        form = $("form")[0];

        function onSubmit(e) {
            if (additional_info.val().length === 0 && !confirm("Are you sure you wish to add this item to your basket without personalising it?")) {
                e.preventDefault()
            } else {
                form.submit()
            }
        }
    </script>
    <?php $this->end() ?>
<?php endif; ?>