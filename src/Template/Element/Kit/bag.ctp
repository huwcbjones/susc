<?php $this->start('bag') ?>
    <div class="col-sm-4">
        <h2 class="h3">My Kit Bag</h2>
        <hr/>
        <?php if (!empty($kitBagData)):
            $total = 0;
            ?>
            <div>
                <?php foreach ($kitBagData as $id => $data):
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
                    Price: <?= sprintf("£%.2f", $kit->price) ?><br/>
                    <?= $this->Form->postLink(
                    'Remove',
                    '',
                    [
                        'data' => [
                            'id' => $kit->id,
                            'isRemove' => 1
                        ],
                        'confirm' => 'Are you sure you want to remove ' . $kit->title . ' from your kit bag?'
                    ]
                ) ?>
                    <hr/>
                <?php endforeach; ?>
            </div>
            <div>
                Total: <?= sprintf("£%.2f", $total) ?>
            </div>
        <?php else: ?>
            <p>Your kit bag is currently empty. To add kit, select an item, choose your size, then click &ldquo;Add to my bag&rdquo;</p>
        <?php endif; ?>
    </div>
<?php $this->end() ?>