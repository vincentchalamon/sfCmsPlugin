<?php use_stylesheet(public_path('/sfCmsPlugin/css/slickmap.css')) ?>

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
  <?php echo $sf_data->getRaw('page')->getContents() ?>
  <div class="sitemap">
    <?php $front = getMenu('front', $sf_user) ?>
    <?php if($front && $front->hasToRender($sf_user->getRawValue())): ?>
      <ul id="primaryNav" class="col<?php echo count($front['__children']) ?>">
        <li id="home"><?php echo link_to($front, $front->getRoute(), array('title' => $front)) ?></li>
        <?php foreach($front['__children'] as $key => $subMenu): ?>
          <?php include_partial("sfCms/sitemapMenu", array('menu' => $subMenu)) ?>
        <?php endforeach ?>
      </ul>
    <?php endif ?>
  </div>
</section>
<!-- End main section -->

<!-- Start left column -->
<section class="span-200">
  <!-- Navigation intra rubriques -->
  <?php if($sf_data->getRaw('menu') && $sf_data->getRaw('menu')->hasParent()): ?>
    <?php $menu = getMenu($sf_data->getRaw('menu')->getParent()->getSlug(), $sf_user->hasCredential("editor")) ?>
    <h3 id="and_title"><?php echo $menu ?></h3>
    <?php if($menu->hasChildren()): ?>
      <ul>
        <?php foreach($menu['__children'] as $children): ?>
          <?php if($children->hasToRender($sf_user->getRawValue())): ?>
            <li><?php echo link_to($children, $children->getRoute(), array('title' => $children)) ?></li>
          <?php endif ?>
        <?php endforeach ?>
      </ul>
    <?php endif ?>
    <hr />
  <?php endif ?>

  <!-- Tags -->
  <div class="tag_cloud">
    <?php echo getTagCloud($sf_data->getRaw('page')) ?>
  </div>
</section>
<!-- End left column -->

<div class="clear"></div>