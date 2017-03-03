<div class="blog-post" itemscope itemtype="http://schema.org/BlogPosting">
    <h2 class="blog-post-title"><span itemprop="name headline"><?= $this->Html->link(
                h($article->title),
                $link
            ) ?></span></h2>
    <p class="blog-post-meta"><span itemprop="datePublished" content="<?= $article->created->format("Y-m-d") ?>"><?=
            $article->created->format('F j<\s\u\p>S</\s\u\p> Y') ?></span>,
        by <span itemprop="author" itemscope itemtype="http://schema.org/Person">
            <span itemprop="name"><?= h($article->authorName) ?></span></span></p>
    <article><span itemprop="articleBody">
        <?= $this->Text->truncate($article->content, 400, ['exact' => false,]) ?></span>
        <p><?= $this->Html->link('Read more &raquo;', $link, ['itemprop' => 'url', 'class' => 'btn btn-default', 'escape' => false]) ?></p>
    </article>
    <div class="hidden" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
        <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
            <?= $this->Html->Image('logo.png',  ['fullBase' => true]) ?>
            <meta itemprop="url" content="<?= $this->Url->build('/img/logo.png', true) ?>">
        </div>
        <meta itemprop="name" content="SUSC">
    </div>
    <div class="hidden" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
        <img src="<?= $this->Url->build('/img/logo.png', true) ?>"/>
        <meta itemprop="url" content="<?= $this->Url->build('/img/logo.png', true) ?>" />
        <meta itemprop="height width" content="1024" />
    </div>
</div>