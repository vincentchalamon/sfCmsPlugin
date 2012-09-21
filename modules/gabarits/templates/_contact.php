<?php use_javascripts_for_form($form) ?>
<?php use_stylesheets_for_form($form) ?>

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

<form action="<?php echo url_for("@contact_form") ?>" method="post">
  <fieldset>
    <?php echo $form->renderHiddenFields() ?>
    <?php if ($form->hasGlobalErrors()): ?>
      <?php echo $form->renderGlobalErrors() ?>
    <?php endif; ?>
    <?php echo $form["name"]->renderLabel() ?>
    <?php echo $form["name"]->render() ?>
    <?php echo $form["email"]->renderLabel() ?>
    <?php echo $form["email"]->render() ?>
    <?php echo $form["website"]->renderLabel() ?>
    <?php echo $form["website"]->render() ?>
    <?php echo $form["message"]->renderLabel() ?>
    <?php echo $form["message"]->render() ?>
    <input type="submit" name="submit" value="<?php echo __('Send', array(), 'sf_cms') ?>" />
  </fieldset>
</form>