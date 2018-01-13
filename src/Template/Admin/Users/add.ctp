<?php
/**
 * @var \SUSC\View\AppView $this
 * @var User $user
 * @var Group[] $groups
 * @var Acl[] $acls
 */

use SUSC\Model\Entity\Acl;
use SUSC\Model\Entity\Group;
use SUSC\Model\Entity\User;

$this->assign('title', 'Add User');
?>
    <h2><?= __('Details') ?></h2>
<?= $this->Form->create($user, ['class' => ['form-horizontal']]) ?>
    <div class="form-group">
        <label for="email_address" class="col-sm-2 control-label">Email Address</label>
        <div class="col-sm-10">
            <?= $this->Form->email('email_address'); ?>
        </div>
    </div>
    <div class="form-group">
        <label for="first_name" class="col-sm-2 control-label">First Name</label>
        <div class="col-sm-10">
            <?= $this->Form->text('first_name'); ?>
        </div>
    </div>
    <div class="form-group">
        <label for="last_name" class="col-sm-2 control-label">Surname</label>
        <div class="col-sm-10">
            <?= $this->Form->text('last_name'); ?>
        </div>
    </div>
    <div class="form-group">
        <label for="group" class="col-sm-2 control-label">Group</label>
        <div class="col-sm-10">
            <?= $this->Form->select('group_id', $groups, ['empty'=> 'Select Group']); ?>
        </div>
    </div>
    <div class="form-group">
        <label for="is_enabled" class="col-sm-2 control-label">Is Enabled?</label>
        <div class="col-sm-10">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-success active" id="btn-isEnableY">
                    <input type="radio" name="is_enable" id="isEnabledY" value="1" checked="checked"/> Yes
                </label>
                <label class="btn btn-default" id="btn-isEnableN">
                    <input type="radio" name="is_enable" id="isEnabledN" value="0"/> No
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="is_change_password" class="col-sm-2 control-label">Must Change Password?</label>
        <div class="col-sm-10">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-default" id="btn-isChangePasswordY">
                    <input type="radio" name="is_change_password" id="isChangePasswordY" value="1"/> Yes
                </label>
                <label class="btn btn-danger active" id="btn-isChangePasswordN">
                    <input type="radio" name="is_change_password" id="isChangePasswordN" value="0" checked="checked"/> No
                </label>
            </div>
        </div>
    </div>

    <div class="related">
        <h2><?= __('Access Control Objects') ?></h2>
        <?= $this->element('Admin/ACL', ['acls' => $user->acls, 'all_acls' => $all_acls, 'Form' => $this->Form, 'disabled' => false]) ?>
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
?>
    <script type="text/javascript">
        $("#btn-isEnableY").click(function () {
            $("#btn-isEnableY").addClass("btn-success").removeClass("btn-default");
            $("#btn-isEnableN").addClass("btn-default").removeClass("btn-danger");
        });
        $("#btn-isEnableN").click(function () {
            $("#btn-isEnableY").addClass("btn-default").removeClass("btn-success");
            $("#btn-isEnableN").addClass("btn-danger").removeClass("btn-default");
        });
        $("#btn-isChangePasswordY").click(function () {
            $("#btn-isChangePasswordY").addClass("btn-success").removeClass("btn-default");
            $("#btn-isChangePasswordN").addClass("btn-default").removeClass("btn-danger");
        });
        $("#btn-isChangePasswordN").click(function () {
            $("#btn-isChangePasswordY").addClass("btn-default").removeClass("btn-success");
            $("#btn-isChangePasswordN").addClass("btn-danger").removeClass("btn-default");
        });
    </script>
<?php $this->end() ?>