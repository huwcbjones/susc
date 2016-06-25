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
<head>
<?= $this->element('head') ?>

</head>
<body>

<?= $this->element('header') ?>
<?= $this->fetch('precontent') ?>
<div class="container" id="content">

    <div class="row">
        <div class="col-xs-12">
        <?= $this->Flash->render() ?>

        <?= $this->fetch('content') ?>

        </div>
    </div>

    <hr>

    <?= $this->element('footer') ?>

</div>

<!--<script src="/js/ga.js" type="text/javascript"></script>-->
<!--[if lt IE 9]>
<?= $this->Html->script('jquery-1.12.3.min.js') ?>
<![endif]-->
<!--[if gte IE 9]><!-->
<?= $this->Html->script('jquery-2.2.3.js') ?>
<!--<![endif]-->
<!-- Include all compiled plugins (below), or include individual files as needed -->
<?= $this->Html->script('bootstrap.min.js') ?>
</body>
</html>