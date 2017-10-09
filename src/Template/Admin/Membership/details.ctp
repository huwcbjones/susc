<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

use SUSC\Model\Entity\Membership;
use SUSC\View\AppView;

/**
 * Author: Huw
 * Since: 09/10/2017
 *
 * @var Membership $membership
 * @var AppView $this
 */
$this->assign('title', $membership->name . ' - Membership');
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3><?= $membership->name ?> - Membership</h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal">
            <div class="form-group-lg">
                <label class="col-sm-3 control-label">Name</label>
                <div class="col-sm-9">
                    <p class="form-control-static"><?= $membership->name ?></p>
                </div>
            </div>
            <div class="form-group-lg">
                <label class="col-sm-3 control-label">Student ID</label>
                <div class="col-sm-9">
                    <p class="form-control-static"><?= $membership->student_id ?></p>
                </div>
            </div>
            <div class="form-group-lg">
                <label class="col-sm-3 control-label">Southampton ID</label>
                <div class="col-sm-9">
                    <p class="form-control-static"><?= $membership->soton_id ?></p>
                </div>
            </div>
            <div class="form-group-lg">
                <label class="col-sm-3 control-label">Date of Birth</label>
                <div class="col-sm-9">
                    <p class="form-control-static"><?= $membership->date_of_birth ?></p>
                </div>
            </div>
            <div class="form-group-lg">
                <label class="col-sm-3 control-label">Membership</label>
                <div class="col-sm-9">
                    <p class="form-control-static"><?= $membership->membership_type->title ?></p>
                </div>
            </div>
            <div class="form-group-lg">
                <label class="col-sm-3 control-label">Membership Cost</label>
                <div class="col-sm-9">
                    <p class="form-control-static"><?= $membership->membership_type->formatted_price ?></p>
                </div>
            </div>
        </form>
    </div>
    <div class="panel-footer">
        <div class="row">
            <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-0 col-lg-4">
                <?= $this->Html->link('<span class="glyphicon glyphicon-chevron-left"></span> Back', ['action' => 'members'], ['class' => ['btn', 'btn-default', 'btn-block'], 'escape' => false]) ?>
            </div>
            <div class="col-xs-12 visible-xs-block"><br/></div>
            <div class="col-xs-8 col-xs-offset-2 col-sm-5 col-sm-offset-2 col-lg-4 col-lg-offset-4">
                <?= $this->Html->link('Edit <span class="glyphicon glyphicon-edit"></span>', ['action' => 'edit', $membership->id], ['escape' => false, 'class' => ['btn', 'btn-primary', 'btn-block', 'pull-right']]) ?>
            </div>
        </div>

    </div>
</div>
