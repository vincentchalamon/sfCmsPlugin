<?php use_javascript("/sfCmsPlugin/js/share.js") ?>
<?php use_stylesheet("/sfCmsPlugin/css/share.css") ?>

<!-- Start main section -->
<section>
  <?php if($sf_data->getRaw('menu')): ?>
    <!-- Start breadcrumb -->
    <div id="breadcrumb">
      <span>Vous êtes ici :</span>
      <ul>
        <?php foreach(getBreadcrumb($sf_data->getRaw('menu')) as $element): ?>
          <li><?php echo link_to($element, $element->getRoute(), array('title' => $element)) ?></li>
          <li>/</li>
        <?php endforeach ?>
        <li><span><?php echo $sf_data->getRaw('menu') ?></span></li>
      </ul>
    </div>
    <!-- End breadcrumb -->
  <?php endif ?>

  <?php include_partial('sfCms/flashes') ?>

  <h2 id="page_title"><?php echo $sf_data->getRaw('page')->getTitle() ?></h2>
  <p class="chapo"><?php echo format_date(strtotime($sf_data->getRaw('page')->getUpdatedAt()), "EEEE dd MMMM yyyy", $sf_user->getCulture()) ?></p>
  <?php if(!$sf_data->getRaw('page')->getRequireAuth()): ?>
    <div id="share" rel="facebook-twitter"></div>
  <?php endif ?>
  <?php echo $sf_data->getRaw('page')->getContents() ?>
</section>
<!-- End main section -->

<div class="clear"></div>