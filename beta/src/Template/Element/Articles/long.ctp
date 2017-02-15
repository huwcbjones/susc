<div class="blog-post">
    <div class="row">
        <div class="col-xs-12">
            <p class="blog-post-meta pull-left">Added <?= $article->created->format('F j<\s\u\p>S</\s\u\p> Y') ?>,
                by <?= h($article->authorName) ?></p>
            <?php if ($article->created != $article->modified) : ?>
                <p class="blog-post-meta pull-right"> (Last
                    updated <?= $article->modified->format('F j<\s\u\p>S</\s\u\p> Y') ?>
                    )</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <article class="">
                <?= $article->content ?>
            </article>
        </div>
    </div>
</div>