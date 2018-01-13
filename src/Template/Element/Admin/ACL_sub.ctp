<?php

/**
 * @var \Cake\View\View $this
 */

use SUSC\Model\Entity\Acl;

if (!isset($Form)) $Form = $this->Form;

if (!function_exists('print_acl')) {
    function print_acl($item, $key, $data)
    {
        if ($item instanceof Acl) {
            ?>
            <tr>
                <td><?= $data['Form']->checkbox('acls._ids[]', ['hiddenField' => true, 'value' => $item->id, 'checked' => (Acl::hasAcl($data['test'], $item)), 'disabled' => $data['disabled'], 'class' => 'checkbox-' . $data['group']]) ?></td>
                <td><code><?= h($item->id) ?></code></td>
                <td><?= h($item->name) ?></td>
                <td><?= h($item->description) ?></td>
            </tr>
            <?php
        }
    }
}
?>
<div class="panel-group" id="accordion-<?= $groupID ?>" role="tablist" aria-multiselectable="true">
    <?php foreach ($acls as $tier1 => $t1_acls): ?>
        <?php
        $id = $tier1 . md5(microtime(true));
        $title_array = explode('-', $tier1);
        foreach ($title_array as &$bit) $bit = ucfirst($bit);
        $title = implode(' ', $title_array);
        ?>
        <div class="panel panel-primary">
            <div class="panel-heading" role="tab" id="h-<?= $id ?>">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion-<?= $groupID ?>" href="#c-<?= $id ?>"
                       aria-expanded="true" aria-controls="c-<?= $id ?>">
                        <?= $title ?>
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
                    <?php array_walk_recursive($t1_acls, 'print_acl', ['test' => $test, 'Form' => $Form, 'disabled' => $disabled, 'group' => $groupID . '-' . $tier1]) ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th><?= $this->Form->checkbox('select_all-' . $groupID . '-' . $tier1, ['id' => 'select_all-' . $groupID . '-' . $tier1]) ?></th>
                        <th colspan="3">Select All</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    <?php
    $this->start('postscript');
    echo $this->fetch('postscript');
    ?>
        <script type="text/javascript">
            $(function () {
                var checkboxes = $(".checkbox-<?=$groupID?>-<?=$tier1?>");
                var selectAll = $("#select_all-<?=$groupID?>-<?=$tier1?>");
                selectAll.change(function () {
                    checkboxes.prop('checked', $(this).is(':checked'));
                });
                checkboxes.change(function () {
                    selectAll.prop("checked", (checkboxes.filter(":checked").length === checkboxes.length));
                });
                selectAll.prop("checked", (checkboxes.filter(":checked").length === checkboxes.length));
            });
        </script>
        <?php
        $this->end();
        ?>
    <?php endforeach; ?>
</div>