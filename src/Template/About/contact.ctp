<?php
$this->assign('title', 'Contact Us');
$this->assign('description', 'Finding the right person to contact can sometimes be tricky. Find out who to contact at Southampton University Swimming Club (SUSC).');
?>

<?= $this->Text->autolink($content, ['escape' =>false]) ?>
