<?php
/**
 * @var AppView $this
 * @var Article[] $archives
 * @var string $controller
 */

use SUSC\Model\Entity\Article;
use SUSC\View\AppView;

$this->start('sidebar');
?>
    <div class="blog-sidebar col-md-2 col-md-offset-1 col-sm-3 col-sm-offset-1">
        <div class="sidebar-module">
            <h4>Archive</h4>
            <ol class="list-unstyled">
                <?php
                foreach ($archives as $archive):
                    $link = date('F', mktime(0, 0, 0, $archive->month, 15)) . ' ' . $archive->year;
                    if (
                        $archive->month == $this->request->getParam('month')
                        && $archive->year == $this->request->getParam('year')
                    ) {
                        $link = '<strong>' . $link . '</strong>';
                    }
                    ?>
                    <li><?= $this->Html->link(
                            $link,
                            [
                                '_name' => $controller . "MonthIndex",
                                'year' => $archive->year,
                                'month' => sprintf('%02d', $archive->month)
                            ],
                            [
                                'escape' => false
                            ]) ?></li>
                <?php endforeach ?>
            </ol>
        </div>
    </div>
<?php $this->end() ?>