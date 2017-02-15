<div class="blog-post">
    <h2 class="h4"><?= $this->Html->link(
            h($article->title),
            $link
        ) ?></h2>
    <p class="blog-post-meta">Added <?=
        $article->created->format('F j<\s\u\p>S</\s\u\p> Y') ?>,
        by <?= h($article->authorName) ?></p>
    <article>
        <?= $this->Text->truncate($article->content, 200, ['exact' => false,]) ?>
        <p><?= $this->Html->link($button, $link, ['class' => 'btn btn-default btn-sm', 'escape' => false]) ?></p>
    </article>
</div>