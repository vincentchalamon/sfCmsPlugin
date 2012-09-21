<?php use_javascripts_for_form($form) ?>
<?php use_stylesheets_for_form($form) ?>

<?php echo getPartial('login') ?>

<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
  <?php echo $form->renderHiddenFields() ?>
  <?php if($form->hasGlobalErrors()): ?>
    <?php echo $form->renderGlobalErrors() ?>
  <?php endif ?>
  <p><?php echo $form['username']->renderLabel() ?></p>
  <?php echo $form['username']->render() ?>
  <?php if($form['username']->hasError()): ?>
    <?php echo $form['username']->renderError() ?>
  <?php endif ?>
  <p><?php echo $form['password']->renderLabel() ?></p>
  <?php echo $form['password']->render() ?>
  <input type="submit" value="<?php echo __('Sign in', array(), 'sf_cms') ?>" />
  <?php $routes = $sf_context->getRouting()->getRoutes() ?>
  <?php if (isset($routes['sf_guard_forgot_password'])): ?>
    <br /><p><a href="<?php echo url_for('@sf_guard_forgot_password') ?>" title="<?php echo __('Forgot password ?', array(), 'sf_cms') ?>"><?php echo __('Forgot password ?', array(), 'sf_cms') ?></a></p>
  <?php endif; ?>
</form>