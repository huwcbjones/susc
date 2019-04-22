<?php


use Cake\Core\Configure;
use SUSC\View\AppView;

/**
 * @var AppView $this
 */

?>
<nav class="<?= Configure::read('App.devel') ? 'navbar-devel ' : '' ?>navbar navbar-inverse <?php if (!isset($fixedTop) || !$fixedTop): ?>container fix-menu-margin <?php endif ?><?php if (isset($fixedTop) && $fixedTop): ?>navbar-fixed-top <?php endif ?>"
     id="nav">
    <div class="container<?php if (isset($fixedTop) && $fixedTop): ?>-fluid<?php endif; ?> nav-container" id="nav-container">
        <div class="navbar-header" id="nav-header">
            <?php if (!$this->fetch('navbar.top')): ?>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="true" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            <?php endif; ?>
            <?= $this->Html->link(Configure::read('App.name'), '/', ['class' => 'navbar-brand']); ?>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-right text-center" id="logo-nav">
                <?=
                $this->Menu
                    ->startMenu('<span class="header-image"></span>', '/', null, ['class' => 'navbar-brand'], ['escape' => false])
                    ->end(['class' => 'nav navbar-right text-center', 'id' => 'logo-nav'])
                ?>
            </ul>
            <ul class="nav navbar-nav navbar-left">
                <?=
                $this->Menu
                    ->startMenuMap('News & Events', [
                        'news.*' => ['_name' => 'news'],
                        'fixtures.*' => ['_name' => 'fixtures'],
                        'socials.*' => ['_name' => 'socials']
                    ])
                    ->item('News', ['_name' => 'news'], 'news.*')
                    ->separator('news.*')
                    ->item('Socials', ['_name' => 'socials'], 'socials.*')
                    ->separator(['socials.*', 'fixtures.*'])
                    ->item('Fixtures', ['_name' => 'fixtures'], 'fixtures.*')
                    ->item('Fixtures Calendar', ['_name' => 'fixture_calendar'], 'fixtures.calendar')
                    ->end();
                ?>
                <?=
                $this->Menu
                    ->startMenu('Training', ['_name' => 'training'], 'training.*')
                    ->item('Competition Squad', ['_name' => 'training_comp'], 'training.competition')
                    ->item('Recreational Squad', ['_name' => 'training_rec'], 'training.recreational')
                    ->separator(['training.facilities'])
                    ->item('Facilities', ['_name' => 'training_facilities'], 'training.facilities')
                    ->end();
                ?>
                <?=
                $this->Menu
                    ->startMenuMap('Shop', [
                        'kit.*' => ['_name' => 'kit'],
                        'membership.*' => ['_name' => 'membership']
                    ])
                    ->item('Kit', ['_name' => 'kit'], 'kit.*')
                    ->separator(['kit.*'])
                    ->item('Membership', ['_name' => 'membership'], 'membership.*')
                    ->separator(['membership.*'])
                    ->item('FAQs', ['_name' => 'faq'])
                    ->end();
                ?>
                <?=
                $this->Menu
                    ->startMenu('Gallery', ['_name' => 'gallery'], 'gallery.*')
                    ->end();
                ?>
                <?=
                $this->Menu
                    ->startMenu('About Us', ['_name' => 'about'], null, [], ['fuzzy' => true])
                    ->item('Our Club', ['_name' => 'about'])
                    ->item('Club Records', "https://docs.google.com/spreadsheets/d/1DC3bJHdW8ujtneftwrqbEZRSriWwinH5gItkd7mUQ1Q/edit?usp=sharing", null, [], ["target" => "_blank"])  
                    ->item('Our Coaches', ['_name' => 'coaches'])
                    ->item('Our Committee', ['_name' => 'committee'])
                    ->separator()
                    ->item('Contact Us', ['_name' => 'contact'])
                    ->end();
                ?>
                <?php if (strpos($this->request->getUri()->getPath(), $this->Url->build(['_name' => 'admin'])) !== false): ?>
                    <?= $this->Menu
                        ->startMenu('Admin', '#', 'admin.*', [], ['onclick' =>'openMenu()'])
                        ->end()
                    ?>
                <?php else: ?>
                    <?=
                    $this->Menu
                        ->startMenu('Admin', ['_name' => 'admin'], 'admin.*')
                        ->item('Site Administration', ['_name' => 'admin'], 'admin.*')
                        ->item('Users', ['prefix' => 'admin', 'controller' => 'Users', 'action' => 'index'], 'admin.users.*')
                        ->item('Groups', ['prefix' => 'admin', 'controller' => 'Groups', 'action' => 'index'], 'admin.groups.*')
                        ->item('Signups', ['prefix' => 'admin', 'controller' => 'Registration', 'action' => 'index'], 'admin.registration.*')
                        ->item('Kit Items', ['prefix' => 'admin', 'controller' => 'KitItems', 'action' => 'index'], 'admin.kit-items.*')
                        ->item('Kit Orders', ['prefix' => 'admin', 'controller' => 'KitOrders', 'action' => 'index'], 'admin.kit-orders.*')
                        ->item('Membership', ['prefix' => 'admin', 'controller' => 'Membership', 'action' => 'index'], 'admin.membership.*')
                        ->item('News', ['prefix' => 'admin', 'controller' => 'News', 'action' => 'index'], 'admin.news.*')
                        ->item('Fixtures', ['prefix' => 'admin', 'controller' => 'Fixtures', 'action' => 'index'], 'admin.fixtures.*')
                        ->item('Socials', ['prefix' => 'admin', 'controller' => 'Socials', 'action' => 'index'], 'admin.socials.*')
                        ->item('Coaches', ['prefix' => 'admin', 'controller' => 'Coaches', 'action' => 'index'], 'admin.coaches.*')
                        ->item('Committee', ['prefix' => 'admin', 'controller' => 'Committee', 'action' => 'index'], 'admin.committee.*')
                        ->item('Training', ['prefix' => 'admin', 'controller' => 'Training', 'action' => 'index'], 'admin.training.*')
                        ->end();
                    ?>
                <?php endif ?>

                <?php if ($currentUser !== null): ?>
                    <li class="visible-xs"><?= $this->Html->link('My Profile', ['_name' => 'profile'], ['class' => ['navbar-link']]) ?></li>
                    <li class="visible-xs"><?= $this->Html->link('Logout', ['_name' => 'logout'], ['class' => ['navbar-link']]) ?></li>
                <?php else: ?>
                    <li class="visible-xs"><?= $this->Html->link('Register', ['_name' => 'register'], ['class' => ['navbar-link']]) ?></li>
                    <li class="visible-xs"><?= $this->Html->link('Log in', ['_name' => 'login'], ['class' => ['navbar-link']]) ?></li>
                <?php endif; ?>
            </ul>
            <p class="navbar-text navbar-right text-center navbar-user hidden-xs">
                <?php if ($currentUser !== null): ?>
                    Hi <?= h($currentUser->first_name) ?>!
                    <br/><?= $this->Html->link('My Profile', ['_name' => 'profile'], ['class' => ['navbar-link']]) ?>
                    | <?= $this->Html->link('Logout', ['_name' => 'logout'], ['class' => ['navbar-link']]) ?>
                <?php else: ?>
                    &nbsp;
                    <br/><?= $this->Html->link('Register', ['_name' => 'register'], ['class' => ['navbar-link']]) ?>
                    | <?= $this->Html->link('Log in', ['_name' => 'login'], ['class' => ['navbar-link']]) ?>
                <?php endif; ?>
            </p>
        </div>
    </div>
</nav>
<?php $this->start('postscript');
echo $this->fetch('postscript');
?>
<script>
    var mainMenu = $("#navbar");

    function clickMainMenu(e) {
        if (!$(e.target).closest("#navbar").length) {
            $(".overlay").css({
                "background-color": "rgba(0, 0, 0, 0)",
                "pointer-events": ""
            });
            mainMenu.collapse("hide");
            document.removeEventListener("click", clickMainMenu);
        }
    }

    $(function () {
        mainMenu
            .on('show.bs.collapse', function () {
                $(".overlay").css({
                    "background-color": "rgba(0, 0, 0, 0.5)",
                    "pointer-events": "auto"
                });
            })
            .on("shown.bs.collapse", function () {
                document.addEventListener("click", clickMainMenu);
            });

    });
</script>
<?php $this->end() ?>
