<?php

$this->assign('title', 'Training Facilities');
?>

<?= $this->Text->autolink($facilities, ['escape' =>false]) ?>
