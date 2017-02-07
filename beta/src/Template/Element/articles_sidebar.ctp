<?php $this->start('sidebar') ?>
<div class="col-sm-3 col-sm-offset-1 blog-sidebar">
    <div class="sidebar-module">
        <h4>Archive</h4>
        <ol class="list-unstyled">
            <?php foreach($archives as $archive): ?>
            <li><?= $this->Html->Link(date('F', mktime(0, 0, 0, $archive->month, 15)) . ' ' . $archive->year,
                    [
                        'controller' => 'News',
                        'action' => 'viewMonth',
                        'year' => $archive->year,
                        'month' => sprintf('%02d', $archive->month),
                    ]) ?></li>
            <?php endforeach ?>
        </ol>
    </div>
</div>
<?php $this->end() ?>