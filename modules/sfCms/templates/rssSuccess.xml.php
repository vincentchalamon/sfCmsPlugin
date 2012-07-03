<rss version="2.0">
  <channel>
    <title><?php echo sfConfig::get('app_sf_cms_plugin_sitename') ?></title>
    <description><?php echo sfConfig::get('app_sf_cms_plugin_sitename') ?></description>
    <lastBuildDate><?php echo date('r', strtotime($articles[0]['started_at'])) ?></lastBuildDate>
    <link><?php url_for2('homepage', array(), true) ?></link>
    <?php foreach($articles as $article): ?>
      <item>
        <title><?php echo $article['title'] ?></title>
        <description><?php echo $article['description'] ?></description>
        <pubDate><?php echo date('r', strtotime($article['started_at'])) ?></pubDate>
        <link><?php echo $article->getRoute(true) ?></link>
      </item>
    <?php endforeach ?>
  </channel>
</rss>