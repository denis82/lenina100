<?php header('Content-Type: text/xml'); ?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>

<urlset
        xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
                http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<?php foreach($list as $models): ?>
    <?php foreach($models as $row): ?>
        <url>
            <loc><?php echo CHtml::encode($row['url']); ?></loc>
            <changefreq>daily</changefreq>
            <priority><?php echo $row['priority'];?></priority>
        </url>
    <?php endforeach; ?>    
<?php endforeach; ?>

</urlset>
