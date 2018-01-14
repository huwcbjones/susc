<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

use SUSC\Model\Entity\Order;
use SUSC\Model\Entity\User;
use SUSC\View\AppView;

/**
 * Author: Huw
 * Since: 08/09/2017
 * @var Order $order
 * @var User $currentUser
 * @var AppView $this
 */

$this->assign('title', 'Edit Order #' . $order->id);

echo $this->Form->create($order);
?>

<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div>
                    <h3 style="display:inline">Order #<?= $order->id ?></h3>
                </div>
            </div>
            <div class="panel-body">
                <p><strong>Name:</strong> <?= $order->user->full_name ?></p>
                <p><strong>Ordered:</strong> <?= $order->placed_date ?></p>
                <p><strong>Payment Method:</strong> <?= $order->paymentMethod ?></p>

                <p><strong>Payment:</strong> <?= $order->paid_date ?></p>

                <p><strong>Status:</strong> <?= $order->status ?></p>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Item</th>
                        <th>Batch</th>
                        <th class="text-center">Size</th>
                        <th class="text-center">Colour</th>
                        <th class="text-center">Info</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Subtotal</th>
                        <?php if ($this->hasAccessTo('admin.kit-orders.status')) : ?>
                            <th scope="col">
                                <attr title="Collected">C?</attr>
                            </th>
                        <?php endif ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($order->items as $item): ?>
                        <tr>
                            <th data-th="Item"><?= $this->Html->link(h($item->item->title), [
                                    '_name' => 'kit_item',
                                    'action' => 'view',
                                    'slug' => $item->item->slug,
                                    'crc' => $item->item->crc
                                ]) ?></th>
                            <td><?= $item->processed_order_id !== null ? $this->Html->link($item->processed_order_id, ['action' => 'processedOrders', $item->processed_order_id, 'highlight' => $item->id]) : '-' ?></td>
                            <td data-th="Size"
                                class="text-center"><?= $item->item->hasSize ? $this->Form->select('items_orders.' . $item->id . '.size', $item->item->sizeList, ['value' => $item->size, 'class' => 'input-sm']) : '-' ?></td>
                            <td data-th="Colour"
                                class="text-center"><?= $item->item->hasColour ? $this->Form->select('items_orders.' . $item->id . '.colour', $item->item->colourList, ['value' => $item->colour, 'class' => 'input-sm']) : '-' ?></td>
                            <td data-th="Additional Info"
                                class="text-center"><?= $item->item->additional_info ? $this->Form->text('items_orders.' . $item->id . '.additional_info', ['value' => $item->additional_info, 'class' => 'input-sm']) : '-' ?></td>
                            <td data-th="Price" class="text-center" id="<?= $item->id ?>-price"
                                data-price="<?= $item->price ?>"><?= $item->formattedPrice ?></td>
                            <td data-th="Quantity"
                                class="text-center"><?= $this->Form->select('items_orders.' . $item->id . '.quantity', $item->item->quantityList, ['value' => $item->quantity, 'class' => 'input-sm', 'id' => $item->id . '-quantity']) ?></td>
                            <td data-th="Subtotal" class="text-right subtotal" id="<?= $item->id ?>-subtotal" data-subtotal="<?= $item->subtotal?>"><?= $item->formattedSubtotal ?></td>
                            <?php if ($this->hasAccessTo('admin.kit-orders.status')) : ?>
                                <td><?= $item->getCollectedStatusIcon() ?></td>
                            <?php endif ?>
                        </tr>
                    <?php
                    $this->start('postscript');
                    echo $this->fetch('postscript');
                    ?>
                        <script type="text/javascript">
                            $(function () {
                                $("#<?= $item->id?>-quantity").change(function () {
                                    var price = $("#<?= $item->id?>-price").data("price");
                                    price = (price * $(this).val());
                                    $("#<?= $item->id?>-subtotal").data('subtotal', price).html("£" + price.toFixed(2));
                                    calculateTotal();
                                });
                            });
                        </script>
                        <?php $this->end(); ?>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="6"></td>
                        <td class="text-center"><h3 class="h4">Total:</h3></td>
                        <td class="text-right" style="vertical-align: middle" id="totalCost" data-total="<?= $order->total ?>"><?= $order->formattedTotal ?> </td>
                        <?php if ($this->hasAccessTo('admin.kit-orders.status')) : ?>
                            <th style="vertical-align: middle"><?= $order->collected_left ?></th>
                        <?php endif ?>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-0 col-lg-4">
        <?= $this->Html->link('<span class="glyphicon glyphicon-chevron-left"></span> Cancel', ['action' => 'view', $order->id], ['class' => ['btn', 'btn-default', 'btn-block'], 'escape' => false]) ?>
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
?>
<script type="text/javascript">
    var totalCost = $("#totalCost");
    function calculateTotal()
    {
        var total = 0;
        $(".subtotal").each(function () {
            total += $(this).data('subtotal');
        });
        console.log(total);
        totalCost.html("£" + total.toFixed(2));
    }
</script>
<?php $this->end(); ?>
