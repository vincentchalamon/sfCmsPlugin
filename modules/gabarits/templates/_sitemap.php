<?php use_stylesheet(public_path('/sfCmsPlugin/css/slickmap.css')) ?>

<?php if($sf_data->getRaw('menu')): ?>
  <ul id="breadcrumb">
    <li><?php echo __('You are here', array(), 'sf_cms') ?> :</li>
    <?php foreach(getBreadcrumb($sf_data->getRaw('menu')) as $element): ?>
      <li><?php echo link_to($element, $element->getRoute(), array('title' => $element)) ?> &gt;</li>
    <?php endforeach ?>
    <li><?php echo $sf_data->getRaw('menu') ?></li>
  </ul>
<?php endif ?>

<h1><?php echo $sf_data->getRaw('page')->getTitle() ?></h1>
<?php echo $sf_data->getRaw('page')->getContents() ?>

<div class="sitemap">
  <?php if($front = getMenu('front', $sf_user) && $front->hasToRender($sf_user->getRawValue())): ?>
    <ul id="primaryNav" class="col<?php echo count($front['__children']) ?>">
      <li id="home"><?php echo link_to($front, $front->getRoute(), array('title' => $front)) ?></li>
      <?php foreach($front['__children'] as $key => $subMenu): ?>
        <?php include_partial("sfCms/sitemapMenu", array('menu' => $subMenu)) ?>
      <?php endforeach ?>
    </ul>
  <?php endif ?>
</div>