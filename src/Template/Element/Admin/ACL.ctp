<?php

use SUSC\Model\Entity\Acl;

if (!isset($Form)) $Form = $this->Form;

$admin_acls = [];
if (isset($all_acls['admin'])) {
    $admin_acls = $all_acls['admin'];
}

$normal_acls = $all_acls;
unset($normal_acls['admin']);
$acls = Acl::splattify($acls);
?>

    <h3>Normal ACOs</h3>
<?= $this->element('Admin/ACL_sub', ['acls' => $normal_acls, 'test' => $acls, 'Form' => $Form, 'disabled' => $disabled,'groupID' => 'user']) ?>

    <h3>Admin ACOs</h3>
<?= $this->element('Admin/ACL_sub', ['acls' => $admin_acls, 'test' => $acls, 'Form' => $Form, 'disabled' => $disabled, 'groupID' => 'admin']) ?>