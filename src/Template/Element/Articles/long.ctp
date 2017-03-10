<div class="blog-post">
    <div class="row">
        <div class="col-xs-12">
            <p class="blog-post-meta pull-left">Added by <span itemprop="author" itemscope
                                                               itemtype="http://schema.org/Person">
            <span itemprop="name"><?= h($article->authorName) ?></span></span>, <span itemprop="datePublished"
                                                                                      content="<?= $article->created->format("Y-m-d H:i:s") ?>"> at
                    <?= $article->created->format('g:iA \o\n F j<\s\u\p>S</\s\u\p> Y') ?></span></p>
            <?php if ($article->created != $article->modified) : ?>
                <p class="blog-post-meta pull-right"> (Last
                    updated at <span itemprop="dateModified"
                                  content="<?= $article->modified->format("Y-m-d H:i:s") ?>"><?= $article->modified->format('g:iA F j<\s\u\p>S</\s\u\p> Y') ?></span>
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
    <div class="hidden" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
        <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
            <?= $this->Html->Image('logo.png', ['fullBase' => true]) ?>
            <meta itemprop="url" content="<?= $this->Url->build('/img/logo.png', true) ?>">
        </div>
        <meta itemprop="name" content="SUSC">
    </div>
    <div class="hidden" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
        <img src="<?= $this->Url->build('/img/logo.png', true) ?>"/>
        <meta itemprop="url" content="<?= $this->Url->build('/img/logo.png', true) ?>"/>
        <meta itemprop="height width" content="1024"/>
    </div>
</div>