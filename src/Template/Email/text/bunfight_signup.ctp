<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

use SUSC\Model\Entity\BunfightSignup;
use SUSC\View\AppView;

/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

/**
 * Author: Huw
 * Since: 29/09/2017
 *
 * @var BunfightSignup $signup
 * @var AppView $this
 * @var string $plain_content
 */

?>

Hi <?= $signup->first_name ?>,

<?= $plain_content ?>

If you want to unsubscribe from these emails, please visit <?= $signup->unsubscribeUri ?>.
If you want to request all the data we have on you, please email pres@susc.org.uk, you'll need your unique ID '<?= $signup->id ?>'.
