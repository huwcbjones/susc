<?php
/**
 * @var \SUSC\View\AppView $this
 * @var \SUSC\Model\Entity\Item $item
 */

$this->assign('title', 'Add Item');
$this->start('css');
echo $this->fetch('css');
echo $this->Html->css('bootstrap-datetimepicker');
?>
    <style>
        .panel {
            margin-bottom: 0;
        }
    </style>
<?php
$this->end();
$this->Form->unlockField('instock');
$this->Form->unlockField('additional_info');
?>
<?= $this->Form->create($item, ['class' => ['form-horizontal'], 'type' => 'file']) ?>
    <div class="form-group">
        <label for="title" class="col-sm-2 control-label">Title</label>
        <div class="col-sm-10">
            <?= $this->Form->text('title') ?>
        </div>
    </div>
    <div class="form-group">
        <label for="price" class="col-sm-2 control-label">Price</label>
        <div class="col-sm-10">
            <div class="input-group">
                <span class="input-group-addon">&pound;</span>
                <?= $this->Form->number('price', ['step' => '0.01']); ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="size" class="col-sm-2 control-label">Colours</label>
        <div class="col-sm-10">
            <?= $this->Form->text('colours'); ?>
        </div>
    </div>
    <div class="form-group">
        <label for="size" class="col-sm-2 control-label">Sizes</label>
        <div class="col-sm-10">
            <?= $this->Form->text('sizes'); ?>
        </div>
    </div>
    <div class="form-group">
        <label for="description" class="col-sm-2 control-label">Description</label>
        <div class="col-sm-10">
            <?= $this->Form->textarea('description') ?>
        </div>
    </div>
    <div class="form-group">
        <label for="status" class="col-sm-2 control-label">Requires Additional Info?</label>
        <div class="col-sm-10">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-<?php if ($item->additional_info): ?>success active<?php else: ?>default<?php endif ?>" id="btn-additional_infoY">
                    <input type="radio" name="additional_info" id="additional_infoY" value="1"<?php if ($item->additional_info): ?> checked="checked"<?php endif ?> /> Yes
                </label>
                <label class="btn btn-<?php if (!$item->additional_info): ?>danger active<?php else: ?>default<?php endif ?>" id="btn-additional_infoN">
                    <input type="radio" name="additional_info" id="additional_infoN" value="0"<?php if (!$item->additional_info): ?> checked="checked"<?php endif ?> /> No
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="description" class="col-sm-2 control-label">Additional Information</label>
        <div class="col-sm-10">
            <?= $this->Form->text('additional_info_description') ?>
        </div>
    </div>
    <div class="form-group">
        <label for="image" class="col-sm-2 control-label">Image</label>
        <div class="col-sm-10">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= $this->Html->image($item->imagePath, ['class' => 'img-responsive', 'alt' => $item->title]) ?>
                </div>
                <div class="panel-footer">Image: <?= $this->Form->file('image') ?></div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="is_enabled" class="col-sm-2 control-label">Is Available to Order?</label>
        <div class="col-sm-10">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-<?php if ($item->instock): ?>success active<?php else: ?>default<?php endif ?>" id="btn-isInStockY">
                    <input type="radio" name="instock" id="isInStockY" value="1"<?php if ($item->instock): ?> checked="checked"<?php endif ?> /> Yes
                </label>
                <label class="btn btn-<?php if (!$item->instock): ?>danger active<?php else: ?>default<?php endif ?>" id="btn-isInStockN">
                    <input type="radio" name="instock" id="isInStockN" value="0"<?php if (!$item->instock): ?> checked="checked"<?php endif ?> /> No
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="status" class="col-sm-2 control-label">Available From</label>
        <div class="col-sm-10">
            <div class="input-group date form_from_date"
                 data-date="<?= $item->from == null ? '' : $item->from->i18nformat('yyyy-MM-dd HH:mm:ss') ?>">
                <?= $this->Form->text('from_string', ['value' => $item->from == null ? '' : $item->from->i18nformat('dd/MM/yyyy HH:mm'), 'readonly' => true]) ?>
                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
            </div>
            <?= $this->Form->hidden('from', [
                'id' => 'from',
                'value' => $item->from == null ? '' : $item->from->i18nformat('yyyy-MM-dd HH:mm:ss')
            ]) ?>
        </div>
    </div>
    <div class="form-group">
        <label for="status" class="col-sm-2 control-label">Available Until</label>
        <div class="col-sm-10">
            <div class="input-group date form_until_date"
                 data-date="<?= $item->until == null ? '' : $item->until->i18nformat('yyyy-MM-dd HH:mm:ss') ?>">
                <?= $this->Form->text('until_string', ['value' => $item->until == null ? '' : $item->until->i18nformat('dd/MM/yyyy HH:mm'), 'readonly' => true]) ?>
                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
            </div>
            <?= $this->Form->hidden('until', [
                'id' => 'until',
                'value' => $item->until == null ? '' : $item->until->i18nformat('yyyy-MM-dd HH:mm:ss')
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-0 col-lg-4">
            <?= $this->Html->link('<span class="glyphicon glyphicon-chevron-left"></span> Cancel', ['action' => 'index'], ['class' => ['btn', 'btn-default', 'btn-block'], 'escape' => false]) ?>
        </div>
        <div class="col-xs-12 visible-xs-block"><br/></div>
        <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-2 col-lg-4 col-lg-offset-4">
            <?= $this->Form->button('Save <span class="glyphicon glyphicon-floppy-disk"></span>', ['type' => 'submit', 'class' => ['btn', 'btn-primary', 'btn-block'], 'escape' => false]); ?>
        </div>
    </div>
<?= $this->Form->end() ?>

<?php
$this->start('postscript');
echo $this->fetch('postscript');
echo $this->Html->script('bootstrap-datetimepicker');
?>
    <script type="text/javascript">
        $("#btn-additional_infoY").click(function () {
            $("#btn-additional_infoY").addClass("btn-success").removeClass("btn-default");
            $("#btn-additional_infoN").addClass("btn-default").removeClass("btn-danger");
        });
        $("#btn-additional_infoN").click(function () {
            $("#btn-additional_infoY").addClass("btn-default").removeClass("btn-success");
            $("#btn-additional_infoN").addClass("btn-danger").removeClass("btn-default");
        });
        $("#btn-isInStockY").click(function () {
            $("#btn-isInStockY").addClass("btn-success").removeClass("btn-default");
            $("#btn-isInStockN").addClass("btn-default").removeClass("btn-danger");
        });
        $("#btn-isInStockN").click(function () {
            $("#btn-isInStockY").addClass("btn-default").removeClass("btn-success");
            $("#btn-isInStockN").addClass("btn-danger").removeClass("btn-default");
        });
        $(".form_from_date").datetimepicker({
            format: "dd/mm/yyyy hh:ii",
            minView: 0,
            linkField: 'from',
            linkFormat: 'yyyy-mm-dd hh:ii'
        });
        $(".form_until_date").datetimepicker({
            format: "dd/mm/yyyy hh:ii",
            minView: 0,
            linkField: 'until',
            linkFormat: 'yyyy-mm-dd hh:ii'
        });
    </script>
<?php $this->end() ?>