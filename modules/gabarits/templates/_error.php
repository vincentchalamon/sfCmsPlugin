<!-- Start main section -->
<section>
  <?php include_partial('sfCms/flashes') ?>
  <div class="error">
    <h2 id="page_title"><?php echo $sf_data->getRaw('page')->getTitle() ?></h2>
    <?php echo $sf_data->getRaw('page')->getContents() ?>
  </div>
</section>
<!-- End main section -->
<div class="clear"></div>