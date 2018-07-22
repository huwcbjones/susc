<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 */

/**
 * @author huw
 * @since 15/01/2018 22:21
 */

$this->extend('admin');

?>
<?php if (isset($requiresCode)): ?>
    <?php if ($requiresCode): ?>
        <p class="text-info">New users <span class="text-danger">REQUIRE</span> a code to signup.</p>
    <?php else: ?>
        <p class="text-warning"><span class="glyphicon glyphicon-warning-sign"></span>&nbsp;&nbsp;&nbsp;Any member of
            the public can create an account for the SUSC
            website.</p>
    <?php endif ?>
<?php endif ?>
<?= $this->fetch('content') ?>
