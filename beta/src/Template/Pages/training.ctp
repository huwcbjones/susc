<?php

$this->assign('title', 'Training');
?>

<h2>Competition Squad<a name="comp"></a></h2>
<?= $this->Text->autolink($competition, ['escape' =>false]) ?>

<h2>Recreational Squad<a name="rec"></a></h2>
<?= $this->Text->autolink($recreation, ['escape' =>false]) ?>

<h2>Facilities<a name="facilities"></a></h2>
<?= $this->Text->autolink($facilities, ['escape' =>false]) ?>
