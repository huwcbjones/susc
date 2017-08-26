<?php $this->start('basket') ?>
<?php if (!empty($basketData)):
    $total = 0;
    ?>
    <div>
        <?php foreach ($basketData as $id => $data):
            if (empty($data['kit'])) continue;
            $kit = $data['kit'];
            $size = $data['size'];
            if ($kit->price != null) $total += $kit->price;
            ?>
            <h3 class="h4"><?= $this->Html->link(h($kit->title), [
                    'controller' => 'kit',
                    'action' => 'view',
                    'slug' => $kit->slug
                ]) ?></h3>
            Size: <?= $size ?><br/>
            Price: <?= $kit->formattedPrice ?><br/>
            <?= $this->Form->postLink(
            'Remove',
            '',
            [
                'data' => [
                    'id' => $kit->id,
                    'isRemove' => 1
                ],
                'confirm' => 'Are you sure you want to remove ' . $kit->title . ' from your basket?'
            ]
        ) ?>
            <hr/>
        <?php endforeach; ?>
    </div>
    <div>
        Total: <?= sprintf("£%.2f", $total) ?>
    </div>
<?php else: ?>
    <p>Your basket is currently empty. To add kit, select an item, choose your size, then click &ldquo;Add to basket&rdquo;</p>
<?php endif; ?>
<?php $this->end() ?>