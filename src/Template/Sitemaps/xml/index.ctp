<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php foreach ($data as $entity): ?>
        <url>
            <loc><?= $entity['url'] ?></loc>
            <lastmod><?= $entity['modified'] ?></lastmod>
            <?php if (key_exists('priority', $entity)): ?>
                <priority><?= $entity['priority'] ?></priority>
            <?php endif; ?>
        </url>
    <?php endforeach; ?>
</urlset>