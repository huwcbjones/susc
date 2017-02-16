<?php $this->start('sidebar') ?>
<div class="blog-sidebar col-md-2 col-md-offset-1 col-sm-3 col-sm-offset-1">
    <div class="sidebar-module">
        <h4>Archive</h4>
        <ol class="list-unstyled">
            <?php foreach($archives as $archive): ?>
            <li><?= $this->Html->Link(date('F', mktime(0, 0, 0, $archive->month, 15)) . ' ' . $archive->year,
                    [
                        'controller' => $controller,
                        'action' => 'viewMonth',
                        'year' => $archive->year,
                        'month' => sprintf('%02d', $archive->month),
                    ]) ?></li>
            <?php endforeach ?>
        </ol>
    </div>
</div>
<?php $this->end() ?>