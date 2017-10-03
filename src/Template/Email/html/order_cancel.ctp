<?php

use SUSC\Model\Entity\User;

/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

/**
 * Author: Huw
 * Since: 02/10/2017
 *
 * @var User $user
 * @var int $orderNumber
 */
?>
<p>Hi <?= $user->first_name ?>,</p>

<p>This email is to let you know that your kit order #<?= $orderNumber ?> has been cancelled.</p>

<p>If you requested this, then there is nothing to do. <br/>
    If you think this was made in error, please contact a member of committee.</p>