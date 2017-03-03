<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php foreach($data as $entity): ?>
        <url>
            <loc><?= $data->url ?></loc>
            <lastmod><?= $data->modified ?></lastmod>
            <priority><?= $data->priority ?></priority>
        </url>
    <?php endforeach;?>
</urlset>