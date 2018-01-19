<?php

$this->extend('empty');

$this->start('css');
echo $this->fetch('css');
echo $this->Html->css('admin');
$this->end();


?>

<?= $this->element('header', ['fixedTop' => true]) ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <?= $this->element('Admin/sidebar') ?>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <div class="overlay"></div>
            <h1 class="page-header"><?= h($this->fetch('title')) ?></h1>
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>

            <?= $this->element('footer', ['sponsors' => false]) ?>
        </div>
    </div>
</div>

<?php $this->start('postscript');
echo $this->fetch('postscript');
?>
<script>
    function clickCloseMenu(e) {
        if (!$(e.target).closest(".sidebar").length) {
            closeMenu();
        }
    }

    function clickMainMenu(e) {
        if (!$(e.target).closest("#navbar").length && !$(e.target).closest(".sidebar").length) {
            $(".overlay").css({
                "background-color": "rgba(0, 0, 0, 0)"
            });
            mainMenu.collapse("hide");
            document.removeEventListener("click", clickMainMenu);
        }
    }

    function openMenu() {
        $(".sidebar").css("left", 0);
        $(".overlay").css({
            "background-color": "rgba(0, 0, 0, 0.5)",
            "pointer-events": ""
        });
        $("#navbar").collapse('toggle');
        setTimeout(function () {
            document.addEventListener("click", clickCloseMenu)
        }, 0.5);
    }

    function closeMenu() {
        $(".sidebar").css("left", "");
        $(".overlay").css({
            "background-color": "rgba(0, 0, 0, 0)",
            "pointer-events": "none"
        });
        document.removeEventListener("click", clickCloseMenu);
    }

    function toggleMenu(menuKey) {
        $("#" + menuKey).toggleClass("expanded");
        $("." + menuKey).toggleClass("item-hidden");
        $(".admin-menu-item").not("." + menuKey).addClass("item-hidden");
        $(".expanded").not("#" + menuKey).removeClass("expanded");
    }
</script>
<?php $this->end() ?>
