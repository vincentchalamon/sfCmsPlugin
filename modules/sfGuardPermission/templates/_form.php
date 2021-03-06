<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php if ($form->hasGlobalErrors()): ?>
  <?php echo $form->renderGlobalErrors() ?>
<?php endif; ?>

<?php foreach ($configuration->getFormFields($form, 'main') as $fieldset => $fields): ?>
  <?php include_partial('sfGuardPermission/form_fieldset', array('article' => $sf_guard_permission, 'form' => $form, 'fields' => $fields, 'fieldset' => $fieldset)) ?>
<?php endforeach; ?>

<?php include_partial('sfGuardPermission/form_actions', array('article' => $sf_guard_permission, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
