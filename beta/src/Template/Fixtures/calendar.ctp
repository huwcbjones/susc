<?php

$this->assign('title', 'Fixture Calendar');
?>

<?= $this->Text->autolink($calendar, ['escape' =>false]) ?>