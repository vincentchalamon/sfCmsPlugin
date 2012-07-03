<urlset xmlns="http://www.google.com/schemas/sitemap/0.84">
  <?php foreach($articles as $article): ?>
    <url>
      <loc><?php echo $article->getRoute(true) ?></loc>
      <lastmod><?php echo date('Y-m-d', strtotime($article['updated_at'])) ?></lastmod>
      <changefreq>daily</changefreq>
    </url>
  <?php endforeach ?>
</urlset>