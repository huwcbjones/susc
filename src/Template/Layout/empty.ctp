<?php
/**
 * Copyright (c) Southampton University Swimming Club (SUSC)
 *
 *
 * @copyright     Copyright (c) Southampton University Swimming Club (SUSC)
 */

?>
<!DOCTYPE html>
<html lang="en">
<head itemscope itemtype="http://schema.org/WebSite">
    <?= $this->element('head') ?>

</head>
<body>
<?= $this->Html->script('ga') ?>
<?= $this->Html->script('fb') ?>

<?= $this->fetch('content') ?>

<!--<script src="/js/ga.js" type="text/javascript"></script>-->
<!--[if lt IE 9]>
<?= $this->Html->script('jquery-1.12.3.min.js') ?>
<![endif]-->
<!--[if gte IE 9]><!-->
<?= $this->Html->script('jquery-2.2.3.min.js') ?>
<!--<![endif]-->
<!-- Include all compiled plugins (below), or include individual files as needed -->
<?= $this->Html->script('bootstrap.min.js') ?>

<?= $this->fetch('postscript') ?>

</body>
</html>