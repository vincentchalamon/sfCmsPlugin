<?php $url = preg_match('/\?/i', $url) ? "$url&" : "$url?" ?>
<div id="pagenavi">
  <a href="<?php echo url_for($url."page=1") ?>">&laquo;</a>
  <a href="<?php echo url_for($url."page=".$pager->getPreviousPage()) ?>">&lsaquo;</a>
  <?php foreach ($pager->getLinks() as $page): ?>
    <?php if ($page == $pager->getPage()): ?>
      <a href="<?php echo url_for($url."page=$page") ?>" class="current"><?php echo $page ?></a>
    <?php else: ?>
      <a href="<?php echo url_for($url."page=$page") ?>"><?php echo $page ?></a>
    <?php endif; ?>
  <?php endforeach; ?>
  <a href="<?php echo url_for($url."page=".$pager->getNextPage()) ?>">&rsaquo;</a>
  <a href="<?php echo url_for($url."page=".$pager->getLastPage()) ?>">&raquo;</a>
</div>
