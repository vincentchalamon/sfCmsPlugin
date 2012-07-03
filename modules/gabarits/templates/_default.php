<?php use_javascript("/sfCmsPlugin/js/share.js") ?>
<?php use_stylesheet("/sfCmsPlugin/css/share.css") ?>

<!-- Start main section -->
<section class="span-800">
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
  <div id="page_content"><?php echo $sf_data->getRaw('page')->getContents() ?></div>
</section>
<!-- End main section -->

<!-- Start left column -->
<section class="span-200"<?php /* style="background: url('<?php echo getColumnImage() ?>') no-repeat 0 30px;"*/ ?>>
  <!-- Navigation intra rubriques -->
  <?php if($sf_data->getRaw('menu') && $sf_data->getRaw('menu')->hasChildren()): ?>
    <h3 id="and_title">Egalement...</h3>
    <ul>
      <?php foreach($sf_data->getRaw('menu')->getChildren() as $children): ?>
        <?php if($children->hasToRender($sf_user->getRawValue())): ?>
          <li><?php echo link_to($children, $children->getRoute(), array('title' => $children)) ?></li>
        <?php endif ?>
      <?php endforeach ?>
    </ul>
    <hr />
  <?php endif ?>

  <!-- Tags -->
  <div class="tag_cloud">
    <?php echo getTagCloud($sf_data->getRaw('page')) ?>
  </div>
</section>
<!-- End left column -->

<div class="clear"></div>