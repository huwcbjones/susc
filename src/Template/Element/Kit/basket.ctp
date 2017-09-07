<?php $this->start('basket') ?>
<?php if (empty($basketData)): ?>
    <p>Your basket is currently empty. To add kit, select an item, choose your size, then click &ldquo;Add to basket&rdquo;</p>
<?php else: ?>
    <div class="row">
        <div class="col-xs-12">
            <?php foreach ($basketData as $hash => $data): ?>
                <div class="row">
                    <div class="col-xs-12">
                        <h3 class="h4"><?= $this->Html->link(h($data['item']->title), [
                                'controller' => 'kit',
                                'action' => 'view',
                                'slug' => $data['item']->slug
                            ]) ?></h3>
                        Size: <?= $data['size'] ?><br/>
                        Quantity: <?= $data['quantity'] ?><br/>
                        <?php if ($data['item']->additional_info): ?>
                            Additional Info: <?= h(($data['additional_info'] == '') ? '[None Provided]': $data['additional_info']) ?><br/>
                        <?php endif; ?>
                        Subtotal: <?= sprintf("£%.2f", $data['quantity'] * $data['item']->price) ?><br/>
                        <?= $this->Form->postLink(
                            'Remove',
                            '',
                            [
                                'data' => [
                                    'hash' => $hash,
                                    'isRemove' => 1
                                ],
                                'confirm' => 'Are you sure you want to remove ' . $data['item']->title . ' from your basket?'
                            ]
                        ) ?>
                        <hr/>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <h4>Total: <?= sprintf("£%.2f", $basketTotal) ?></h4>
            <hr />
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <?= $this->Html->link('View Basket', ['_name' => 'basket'], ['class' => ['btn', 'btn-primary', 'btn-md', 'btn-block']]) ?>
        </div>
    </div>
<?php endif; ?>
<?php $this->end() ?>