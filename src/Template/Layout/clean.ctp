<?php
$this->extend('/Layout/empty');
?>
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

<?php
$this->start('postscript');
echo $this->fetch('postscript');
?>
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
<?php $this->end() ?>
