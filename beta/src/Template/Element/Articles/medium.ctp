<div class="blog-post">
    <h2 class="blog-post-title"><?= $this->Html->link(
            h($article->title),
            $link
        ) ?></h2>
    <p class="blog-post-meta"><?=
        $article->created->format('F j<\s\u\p>S</\s\u\p> Y') ?>,
        by <?= h($article->user->fullname) ?></p>
    <article>
        <?= $this->Text->truncate($article->content, 400, ['exact' => false,]) ?>
        <p><?= $this->Html->link('Read more &raquo;', $link, ['class' => 'btn btn-default', 'escape' => false]) ?></p>
    </article>
</div>