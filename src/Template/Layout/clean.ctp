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
<script>
    window.fbAsyncInit = function () {
        FB.init({
            appId: '1103769579691459',
            xfbml: true,
            version: 'v2.8'
        });
        FB.AppEvents.logPageView();
    };

    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<header class="main-masthead">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-center vertical-center"><h1>Southampton University Swimming Club</h1></div>
        </div>

    </div>
</header>
<?= $this->element('header') ?>
<div class="container menu-padding" id="content">
    <?= $this->fetch('precontent') ?>
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

<?= $this->fetch('postscript') ?>
<script type="text/javascript">
    $(document).ready(function () {
        var menu = $('#nav');
        var menuContainer = $('#nav-container');
        var menuHeader = $('#nav-header');
        var content = $('#content');
        var offset = menu.offset().top;

        function calcOffset() {
            offset = menu.offset().top;
            scroll();
        }

        function scroll() {
            if ($(window).scrollTop() >= offset) {
                menu.addClass('navbar-fixed-top')
                    .removeClass('container')
                    .removeClass('fix-menu-margin');
                menuContainer
                    .addClass('fix-menu-padding');
                menuHeader
                    .removeClass('fix-menu-header');
                content.removeClass('menu-padding');
            } else {
                menu.removeClass('navbar-fixed-top')
                    .addClass('container')
                    .addClass('fix-menu-margin');
                menuContainer
                    .removeClass('fix-menu-padding');
                menuHeader
                    .addClass('fix-menu-header');
                content.addClass('menu-padding');
            }
        }

        document.onscroll = scroll;
        window.onresize = calcOffset;
    });
</script>
</body>
</html>