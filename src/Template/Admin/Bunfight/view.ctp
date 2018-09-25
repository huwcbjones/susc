<?php
/**
 * @var \SUSC\View\AppView $this
 * @var \SUSC\Model\Entity\Bunfight $bunfight
 */

$this->assign('title', 'View Bunfight: ' . $bunfight->id);

$gender = [];
foreach (\SUSC\Model\Entity\BunfightSignup::$genders as $type => $value) {
    $gender[$type] = 0;
}
$abilities = [];
foreach (\SUSC\Model\Entity\BunfightSignup::$abilities as $type => $value) {
    $abilities[$type] = 0;
}
$years = [];

foreach ($bunfight->bunfight_signups as $signup) {
    $gender[$signup->gender]++;
    $abilities[$signup->ability]++;
    if (count($signup->squads) == 0) {
        $squads[""]["value"]++;
    } else {
        foreach ($signup->squads as $squad) {
            $squads[$squad->id]["value"]++;
        }
    }
    if (!key_exists($signup->graduation_year, $years)){
        $years[$signup->graduation_year] = 0;
    }
    $years[$signup->graduation_year]++;
}

ksort($years);
?>
<h2><?= __('Details') ?></h2>
<form class="form-horizontal">
    <div class="form-group">
        <label for="id" class="col-sm-2 control-label">ID</label>
        <div class="col-sm-10">
            <input type="text" name="id" class="form-control" readonly="readonly" value="<?= h($bunfight->id) ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label for="id" class="col-sm-2 control-label">Name</label>
        <div class="col-sm-10">
            <input type="text" name="name" class="form-control" readonly="readonly" value="<?= h($bunfight->name) ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label for="description" class="col-sm-2 control-label">Description</label>
        <div class="col-sm-10">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?= $bunfight->renderedDescription ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="is_enabled" class="col-sm-2 control-label">Is Current?</label>
        <div class="col-sm-10">
            <p class="form-control-static">
                <?php if ($bunfight->id === $current_bunfight_id): ?>
                    <span class="text-success"><span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;&nbsp;Yes</span>
                <?php else: ?>
                    <span class="text-danger"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;&nbsp;No</span>
                <?php endif; ?>
            </p>
        </div>
    </div>
    <div class="related">
        <h2><?= __('Sessions') ?></h2>
        <div class="table-responsive">
            <table class="table table-hover table-striped table-condensed">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Start</th>
                    <th scope="col">Finish</th>
                    <th scope="col">Base Capacity</th>
                    <th scope="col">Total Capacity</th>
                    <th scope="col">Oversubscription %</th>
                    <th scope="col"># Signups</th>
                    <th scope="col">Fill</th>
                    <?php if ($this->hasAccessTo('admin.bunfight.view')): ?>
                        <th scope="col" class="actions"></th>
                    <?php endif ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($bunfight->bunfight_sessions as $session): ?>
                    <tr>
                        <td><?= h($session->id) ?></td>
                        <td><?= h($session->start) ?></td>
                        <td><?= h($session->finish) ?></td>
                        <td><?= h($session->capacity) ?></td>
                        <td><?= h($session->totalCapacity) ?></td>
                        <td><?= h($session->oversubscribe_percentage) ?></td>
                        <td><?= h($session->signups_count) ?></td>
                        <td><?= h($session->progress) ?>%</td>

                        <?php if ($this->hasAccessTo('admin.bunfight.view')): ?>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['action' => 'view', $bunfight->id]) ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="related">
        <h2><?= __('Statistics') ?></h2>
        <div class="form-group">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-condensed">
                        <thead>
                        <tr>
                            <th scope="col">Gender</th>
                            <th scope="col">Total</th>
                            <th scope="col">Percentage</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($gender as $type => $value): ?>
                            <tr>
                                <td><?= h(\SUSC\Model\Entity\BunfightSignup::$genders[$type]) ?></td>
                                <td><?= $value ?></td>
                                <td><?= round(100 * $value / count($bunfight->bunfight_signups), 2) ?>%</td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-condensed">
                        <thead>
                        <tr>
                            <th scope="col">Swimming Ability</th>
                            <th scope="col">Total</th>
                            <th scope="col">Percentage</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($abilities as $type => $value): ?>
                            <tr>
                                <td><?= h(\SUSC\Model\Entity\BunfightSignup::$abilities[$type]) ?></td>
                                <td><?= $value ?></td>
                                <td><?= round(100 * $value / count($bunfight->bunfight_signups), 2) ?>%</td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-condensed">
                        <thead>
                        <tr>
                            <th scope="col">Squad</th>
                            <th scope="col">Total</th>
                            <th scope="col">Percentage</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($squads as $id => $data): ?>
                            <tr>
                                <td><?= h($data["name"]) ?></td>
                                <td><?= $data["value"] ?></td>
                                <td><?= round(100 * $data["value"] / count($bunfight->bunfight_signups), 2) ?>%</td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-condensed">
                        <thead>
                        <tr>
                            <th scope="col">Year of Graduation</th>
                            <th scope="col">Total</th>
                            <th scope="col">Percentage</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($years as $year => $value): ?>
                            <tr>
                                <td><?= h($year == "" ? "Prefer not to say" : $year) ?></td>
                                <td><?= $value ?></td>
                                <td><?= round(100 * $value / count($bunfight->bunfight_signups), 2) ?>%</td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</form>

<div class="row">
    <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-0 col-lg-4">
        <?= $this->Html->link('<span class="glyphicon glyphicon-chevron-left"></span> Back', ['action' => 'index'], ['class' => ['btn', 'btn-default', 'btn-block'], 'escape' => false]) ?>
    </div>
    <?php if ($this->hasAccessTo('admin.bunfight.edit') || $this->hasAccessTo('admin.bunfight.delete')): ?>
        <div class="col-xs-12 visible-xs-block"><br/></div>
        <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-2 col-lg-4 col-lg-offset-4">
            <?php if ($this->hasAccessTo('admin.bunfight.edit') && $this->hasAccessTo('admin.bunfight.delete')): ?>
                <div class="btn-group btn-block">
                    <?= $this->Html->link('Edit <span class="glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $bunfight->id], ['class' => ['btn', 'btn-primary', 'col-sm-10', 'col-md-11'], 'escape' => false]) ?>
                    <a href="#" class="btn btn-primary col-sm-2 col-md-1 dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu btn-block">
                        <li><?= $this->Form->postLink('Delete&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-remove"></span>', ['action' => 'delete', $bunfight->id], ['escape' => false, 'confirm' => __('Are you sure you want to delete {0}?', $bunfight->id)]) ?></li>
                    </ul>
                </div>
            <?php elseif ($this->hasAccessTo('admin.groups.edit')): ?>
                <?= $this->Html->link('Edit <span class="glyphicon glyphicon-pencil"></span>', ['action' => 'edit', $bunfight->id], ['class' => ['btn', 'btn-primary', 'btn-block'], 'escape' => false]) ?>
            <?php else: ?>
                <?= $this->Form->postLink('Delete&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-remove"></span>', ['action' => 'delete', $bunfight->id], ['escape' => false, 'class' => ['btn', 'btn-primary', 'btn-block'], 'confirm' => __('Are you sure you want to delete {0}?', $bunfight->id)]) ?>
            <?php endif; ?>

        </div>
    <?php endif ?>

</div>
