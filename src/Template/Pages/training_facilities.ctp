<?php

$this->assign('title', 'Training Facilities');
$this->assign('description', $facilities);
?>

<?= $this->Text->autolink($facilities, ['escape' =>false]) ?>
