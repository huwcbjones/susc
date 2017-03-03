<div class="blog-post">
    <div class="row">
        <div class="col-xs-12">
            <p class="blog-post-meta pull-left">Added <span itemprop="datePublished"
                                                            content="<?= $article->created->format("Y-m-d") ?>">
                    <?= $article->created->format('F j<\s\u\p>S</\s\u\p> Y') ?></span>,
                by <span itemprop="author" itemscope itemtype="http://schema.org/Person">
            <span itemprop="name"><?= h($article->authorName) ?></span></span></p>
            <?php if ($article->created != $article->modified) : ?>
                <p class="blog-post-meta pull-right"> (Last
                    updated <span itemprop="dateModified" content="<?= $article->created->format("Y-m-d") ?>"><?= $article->modified->format('F j<\s\u\p>S</\s\u\p> Y') ?></span>
                    )</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <article><span itemprop="articleBody">
                <?= $article->content ?>
                </span></article>
        </div>
    </div>
</div>