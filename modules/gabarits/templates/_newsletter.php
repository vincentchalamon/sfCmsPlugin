<?php $form = new RecipientForm() ?>
<?php use_javascripts_for_form($form) ?>
<?php use_stylesheets_for_form($form) ?>
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
  <?php echo $sf_data->getRaw('page')->getContents() ?>
  <div id="newsletterform">
    <form id="newsletter" action="<?php echo url_for("@newsletter_form") ?>" method="post" class="ajaxForm">
      <fieldset>
        <?php echo $form->renderHiddenFields() ?>
        <?php if ($form->hasGlobalErrors()): ?>
          <?php echo $form->renderGlobalErrors() ?>
        <?php endif; ?>
        <?php echo $form["mail"]->renderLabel() ?>
        <?php echo $form["mail"]->render() ?>
        <input type="submit" name="submit" class="button" id="submit_btn" value="S'inscrire" />
        <?php echo image_tag(public_path("/images/ajax-loader.gif"), array('title' => "Envoi en cours...", "alt" => "Envoi en cours...", "class" => "ajax-loading")) ?>
      </fieldset>
    </form>
    <?php $infos = getPartial("newsletter_infos", $sf_user) ?>
    <?php if($infos): ?>
      <div class="newsletterInfos">
        <h3><?php echo $infos['title'] ?></h3>
        <?php echo $infos['contents'] ?>
      </div>
    <?php endif ?>
    <div class="clear"></div>
  </div>
</section>
<!-- End main section -->

<!-- Start left column -->
<section class="span-200">
  <!-- Navigation intra rubriques -->
  <?php if($sf_data->getRaw('menu')->hasParent()): ?>
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