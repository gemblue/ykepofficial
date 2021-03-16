<?= '<?xml version="1.0" encoding="UTF-8" ?>' ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?= base_url();?></loc> 
        <priority>1.0</priority>
    </url>

    <?php foreach ($pages as $page): ?>
    <url>
        <loc><?= base_url().$page; ?></loc>
        <priority>0.5</priority>
    </url>
    <?php endforeach; ?>

    <?php while ($row = $posts->unbuffered_row()): ?>
    <url>
        <loc><?= base_url().$row->slug; ?></loc>
        <priority>0.5</priority>
    </url>
    <?php endwhile; ?>

</urlset>