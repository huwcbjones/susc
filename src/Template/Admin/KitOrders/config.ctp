<?php
/**
 * @var \SUSC\View\AppView $this
 * @var Config[] $config
 * @var string[] $items
 */

use SUSC\Model\Entity\Config;

$this->assign('title', 'Configure Kit Orders');
?>


<?= $this->Form->create($config, ['class' => 'form-horizontal']) ?>
<?php foreach ($config as $name => $item): ?>
    <div class="form-group">
        <label for="id" class="col-sm-2 control-label"><?= implode(' ', array_map('ucfirst', explode('-', $name))) ?></label>
        <div class="col-sm-10">
            <?= $this->Form->select($item->key, $items, ['val' => $item->value, 'empty' => 'Select Item']) ?>
        </div>
    </div>
<?php endforeach; ?>
<?= $this->Form->submit() ?>
<?= $this->Form->end() ?>
