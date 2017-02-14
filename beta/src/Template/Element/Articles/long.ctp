<div class="blog-post">
    <p class="blog-post-meta">Added <?= $article->created->format('F j<\s\u\p>S</\s\u\p> Y') ?>,
        by <?= h($article->user->fullname) ?><?php if ($article->created != $article->modified) : ?>. (Last updated <?= $article->modified->format('F j<\s\u\p>S</\s\u\p> Y') ?>)<?php endif; ?></p>
    <article class="">
        <?= $article->content ?>
    </article>
</div>