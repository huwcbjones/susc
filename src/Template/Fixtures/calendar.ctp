<?php

$this->assign('title', 'Fixture Calendar');
$this->assign('description', 'Southampton University Swimming Club (SUSC) attend a variety of fixtures throughout the academic year. This page details the programme of events.');
?>

<?= $this->Text->autolink($calendar, ['escape' =>false]) ?>