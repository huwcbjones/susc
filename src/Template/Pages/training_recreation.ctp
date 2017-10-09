<?php

$this->assign('title', 'Recreational Squad');
$this->assign('description', $recreation);
?>

<?= $this->Text->autolink($recreation, ['escape' =>false]) ?>