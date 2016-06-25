<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$this->extend('/Layout/clean');
?>
<div class="jumbotron">
    <div class="container">
        <h1><?= $this->fetch('title') ?></h1>
        <?= $this->fetch('content') ?>
        <p><a class="btn btn-primary btn-lg" href="javascript:history.back()" role="button">&laquo; Back</a></p>
    </div>
</div>