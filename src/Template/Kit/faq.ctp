<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

use SUSC\View\AppView;

/**
 * Author: Huw
 * Since: 03/10/2017
 *
 * @var AppView $this
 * @var string $content
 */

$this->assign('title', 'Kit FAQs');
$this->assign('description', $content);

echo $content;
