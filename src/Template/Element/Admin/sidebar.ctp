<?php
/**
 * SUSC Website
 * Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 *
 * @copyright Copyright (c) Southampton University Swimming Club. (https://susc.org.uk)
 * @link      http://susc.org.uk SUSC Website
 */

use SUSC\Model\Entity\User;

/**
 * Author: Huw
 * Since: 09/10/2017
 *
 * @var \SUSC\View\AppView $this
 * @var User $currentUser
 */

?>
<?=
$this->AdminMenu
    ->startMenu('Site Administration', ['_name' => 'admin'], 'admin.*', [], ['fuzzy' => false])
    ->end(['class' => 'nav-sidebar']);
?>
<?=
$this->AdminMenu
    ->startMenuMap('Users & Groups', [
        'admin.users.*' => ['prefix' => 'admin', 'controller' => 'Users', 'action' => 'index'],
        'admin.groups.*' => ['prefix' => 'admin', 'controller' => 'Groups', 'action' => 'index'],
        'admin.registration.*' => ['prefix' => 'admin', 'controller' => 'Registration', 'action' => 'index']
    ])
    ->item('Users', ['prefix' => 'admin', 'controller' => 'Users', 'action' => 'index'], 'admin.users.*', [], ['fuzzy' => true])
    ->item('Add User', ['prefix' => 'admin', 'controller' => 'Users', 'action' => 'add'], 'admin.users.add')
    ->item('Groups', ['prefix' => 'admin', 'controller' => 'Groups', 'action' => 'index'], 'admin.groups.*', [], ['fuzzy' => true])
    ->item('Add Group', ['prefix' => 'admin', 'controller' => 'Groups', 'action' => 'add'], 'admin.groups.add')
    ->item('Signup Codes', ['prefix' => 'admin', 'controller' => 'Registration', 'action' => 'index'], 'admin.registration.*', [], ['fuzzy' => true])
    ->item('Add Signup Code', ['prefix' => 'admin', 'controller' => 'Registration', 'action' => 'add'], 'admin.registration.add')
    ->item('Configure Signups', ['prefix' => 'admin', 'controller' => 'Registration', 'action' => 'configure'], 'admin.registration.configure')
    ->end(['class' => 'nav-sidebar']);
?>
<?=
$this->AdminMenu
    ->startMenuMap('News & Fixtures', [
        'admin.news.*' => ['prefix' => 'admin', 'controller' => 'News', 'action' => 'index'],
        'admin.fixtures.*' => ['prefix' => 'admin', 'controller' => 'Fixtures', 'action' => 'index'],
        'admin.socials.*' => ['prefix' => 'admin', 'controller' => 'Socials', 'action' => 'index']
    ])
    ->item('News', ['prefix' => 'admin', 'controller' => 'News', 'action' => 'index'], 'admin.news.*', [], ['fuzzy' => true])
    ->item('Add Article', ['prefix' => 'admin', 'controller' => 'News', 'action' => 'add'], 'admin.news.add')
    ->item('Fixtures', ['prefix' => 'admin', 'controller' => 'Fixtures', 'action' => 'index'], 'admin.fixtures.*', [], ['fuzzy' => true])
    ->item('Add Fixture', ['prefix' => 'admin', 'controller' => 'Fixtures', 'action' => 'add'], 'admin.fixtures.add')
    ->item('Socials', ['prefix' => 'admin', 'controller' => 'Socials', 'action' => 'index'], 'admin.socials.*', [], ['fuzzy' => true])
    ->item('Add Social', ['prefix' => 'admin', 'controller' => 'Socials', 'action' => 'add'], 'admin.socials.add')
    ->end(['class' => 'nav-sidebar']);
?>
<?=
$this->AdminMenu
    ->startMenuMap('Kit', [
        'admin.kit-items.*' => ['prefix' => 'admin', 'controller' => 'KitItems', 'action' => 'index'],
        'admin.kit-order.*' => ['prefix' => 'admin', 'controller' => 'KitOrders', 'action' => 'index']
    ])
    ->item('Items', ['prefix' => 'admin', 'controller' => 'KitItems', 'action' => 'index'], 'admin.kit-items.*', [], ['fuzzy' => true])
    ->item('Add Item', ['prefix' => 'admin', 'controller' => 'KitItems', 'action' => 'add'], 'admin.kit-items.add')
    ->item('Orders', ['prefix' => 'admin', 'controller' => 'KitOrders', 'action' => 'index'], 'admin.kit-orders.*', [], ['fuzzy' => true])
    ->item('Collections', ['prefix' => 'admin', 'controller' => 'KitOrders', 'action' => 'collections'], 'admin.kit-orders.collections')
    ->item('Batches', ['prefix' => 'admin', 'controller' => 'KitOrders', 'action' => 'batches'], 'admin.kit-orders.process', [], ['fuzzy' => true])
    ->item('Process Batch', ['prefix' => 'admin', 'controller' => 'KitOrders', 'action' => 'process'], 'admin.kit-orders.process')
    ->item('Send Reminders', ['prefix' => 'admin', 'controller' => 'KitOrders', 'action' => 'sendReminderEmails'], 'admin.kit-orders.remind')
    ->item('Configure', ['prefix' => 'admin', 'controller' => 'KitOrders', 'action' => 'config'], 'admin.kit-orders.config')
    ->end(['class' => 'nav-sidebar']);
?>
<?=
$this->AdminMenu
    ->startMenu('Membership', ['prefix' => 'admin', 'controller' => 'Membership', 'action' => 'index'], 'admin.membership.*', [], ['fuzzy' => true])
    ->item('Add Membership', ['prefix' => 'admin', 'controller' => 'Membership', 'action' => 'add'], 'admin.membership.add')
    ->item('Membership Types', ['prefix' => 'admin', 'controller' => 'Membership', 'action' => 'index'], 'admin.membership.*')
    ->item('Members', ['prefix' => 'admin', 'controller' => 'Membership', 'action' => 'members'], 'admin.membership.members')
    ->item('Membership List', ['prefix' => 'admin', 'controller' => 'Membership', 'action' => 'list'], 'admin.membership.list')
    ->item('Send Reminders', ['prefix' => 'admin', 'controller' => 'Membership', 'action' => 'sendReminderEmails'], 'admin.membership.remind')
    ->item('Configure', ['prefix' => 'admin', 'controller' => 'Membership', 'action' => 'config'], 'admin.membership.config')
    ->end(['class' => 'nav-sidebar']);
?>
