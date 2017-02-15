<?php

$this->assign('title', 'Recreational Squad');
?>

<?= $this->Text->autolink($recreation, ['escape' =>false]) ?>