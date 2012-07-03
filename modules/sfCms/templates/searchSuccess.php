<!-- Start main section -->
<section>
  <?php include_partial('sfCms/flashes') ?>
  <h2>Résultats de la recherche "<?php echo $sf_request->getParameter('query') ?>"</h2>
  <?php if($sf_data->getRaw('pager')->count()): ?>
    <?php foreach($sf_data->getRaw('pager')->getResults() as $article): ?>
      <div class="search_result">
        <h3><?php echo link_to($article['title'], $article->getRoute()) ?></h3>
        <p><?php echo preg_replace(sprintf('/(%s)/i', $sf_request->getParameter('query')), '<strong>$1</strong>', $article['description']) ?></p>
        <a href="<?php echo $article->getRoute() ?>" class="follow">lire la suite...</a>
      </div>
    <?php endforeach ?>
    <?php if($sf_data->getRaw('pager')->haveToPaginate()): ?>
      <div id="pagenavi">
        <a href="<?php echo url_for("@search?query=".$sf_request->getParameter('query')."&page=1") ?>" title="Première page">&laquo;</a>
        <?php foreach($sf_data->getRaw('pager')->getLinks() as $page): ?>
          <a href="<?php echo url_for("@search?query=".$sf_request->getParameter('query')."&page=$page") ?>"<?php echo $page == $sf_request->getParameter('page', 1) ? ' class="current"' : null ?> title="Page <?php echo $page ?>"><?php echo $page ?></a>
        <?php endforeach ?>
        <a href="<?php echo url_for("@search?query=".$sf_request->getParameter('query')."&page=".$sf_data->getRaw('pager')->getLastPage()) ?>" title="Dernière page">&raquo;</a>
      </div><!-- #pagenavi -->
    <?php endif ?>
  <?php else: ?>
    <div class="search_result">
      <?php $search = getPartial("search", $sf_user->hasCredential('editor')) ?>
      <p><?php echo $search ? $search['contents'] : "Aucun résultat" ?></p>
    </div>
  <?php endif ?>
</section>
<!-- End main section -->

<div class="clear"></div>