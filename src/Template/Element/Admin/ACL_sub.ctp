<?php

/**
 * @var \Cake\View\View $this
 */

use SUSC\Model\Entity\Acl;

if (!isset($Form)) $Form = $this->Form;

$group_id = md5(microtime(true));
if (!function_exists('print_acl')) {
    function print_acl($item, $key, $data)
    {
        if ($item instanceof Acl) {
            ?>
            <tr>
                <td><?= $data['Form']->checkbox('acls._ids[]', ['hiddenField' => true, 'value' => $item->id, 'checked' => (Acl::hasAcl($data['test'], $item)), 'disabled' => $data['disabled']]) ?></td>
                <td><code><?= h($item->id) ?></code></td>
                <td><?= h($item->name) ?></td>
                <td><?= h($item->description) ?></td>
            </tr>
            <?php
        }
    }
}
?>
<div class="panel-group" id="accordion-<?= $group_id ?>" role="tablist" aria-multiselectable="true">
    <?php foreach ($acls as $tier1 => $t1_acls): ?>
        <?php
        $id = $tier1 . md5(microtime(true))
        ?>
        <div class="panel panel-primary">
            <div class="panel-heading" role="tab" id="h-<?= $id ?>">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#c-<?= $id ?>"
                       aria-expanded="true" aria-controls="c-<?= $id ?>">
                        <?= ucfirst($tier1) ?>
                    </a>
                </h4>
            </div>
            <div id="c-<?= $id ?>" class="panel-collapse collapse"
                 role="tabpanel" aria-labelledby="h-<?= $id ?>">
                <div class="panel-body">

                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Granted</th>
                        <th>ACO ID</th>
                        <th>Name</th>
                        <th>Description</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php array_walk_recursive($t1_acls, 'print_acl', ['test' => $test, 'Form' => $Form, 'disabled' => $disabled]) ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endforeach; ?>
</div>