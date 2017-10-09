<?php

$this->assign('title', 'Competition Squad');
$this->assign('description', $competition);
?>
<?= $this->Text->autolink($competition, ['escape' =>false]) ?>