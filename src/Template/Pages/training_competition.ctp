<?php

$this->assign('title', 'Competition Squad');
?>
<?= $this->Text->autolink($competition, ['escape' =>false]) ?>