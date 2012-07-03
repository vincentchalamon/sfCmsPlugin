<script type="text/javascript">
  $(document).ready(function(){
    $(".contentbox fieldset").each(function(){
      $('.jqTransformInputWrapper', $(this)).width('100%');
      if(!$(".sf_admin_form_row", $(this)).length) {
        $('a[href=#' + $(this).attr('id') + ']').parent().remove();
      }
    });
    $(".sf_admin_form fieldset").each(function(){
      if(!$(".sf_admin_form_row", $(this)).length) {
        $(this).remove();
      }
    });
  });
</script>
<?php use_helper('I18N', 'Date') ?>
<?php $sf_response->addMeta('title', 'Administration | '.__('Arborescence', array(), 'messages').' | '.($form->isNew() ? __('Nouveau menu', array(), 'messages') : __('Edition du menu "%%name%%"', array('%%name%%' => $menu->getName()), 'messages'))) ?>
<?php slot('breadcrumb', array(array('url' => '@menu', 'label' => __('Arborescence', array(), 'messages')), $form->isNew() ? array('url' => '@menu_add?id='.$sf_request->getParameter('id'), 'label' => __('Nouveau menu enfant', array(), 'messages')) : array('url' => '@menu_edit?id='.$sf_request->getParameter('id'), 'label' => __('Edition du menu "%%name%%"', array('%%name%%' => $menu->getName()), 'messages')))) ?>
<?php include_partial('menu/assets') ?>
<?php include_partial('menu/flashes') ?>

<div class="contentcontainer">
  <div class="headings">
    <h2><?php echo $form->isNew() ? __('Nouveau menu', array(), 'messages') : __('Edition du menu "%%name%%"', array('%%name%%' => $menu->getName()), 'messages') ?></h2>
  </div>

  <?php include_partial('menu/form_header', array('menu' => $menu, 'form' => $form, 'configuration' => $configuration)) ?>

  <div class="contentbox sf_admin_form">
    <?php echo form_tag_for($form, '@menu') ?>
      <?php include_partial('menu/form_header', array('menu' => $menu, 'form' => $form, 'configuration' => $configuration)) ?>
      <?php echo $form->renderHiddenFields(false) ?>
      <div class="left">
        <?php include_partial('menu/form', array('menu' => $menu, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
      </div>
      <div class="right">
        <?php foreach ($configuration->getFormFields($form, 'metas') as $fieldset => $fields): ?>
          <?php foreach ($fields as $name => $field): ?>
            <?php if ((isset($form[$name]) && $form[$name]->isHidden()) || (!isset($form[$name]) && $field->isReal())) continue ?>
            <li>
              <?php include_partial('menu/form_field', array(
                'name'       => $name,
                'attributes' => $field->getConfig('attributes', array()),
                'label'      => $field->getConfig('label'),
                'help'       => $field->getConfig('help'),
                'form'       => $form,
                'field'      => $field,
                'class'      => 'sf_admin_form_row sf_admin_'.strtolower($field->getType()).' sf_admin_form_field_'.$name,
              )) ?>
            </li>
          <?php endforeach; ?>
        <?php endforeach; ?>
      </div>
      <div class="clear"></div>
      <?php include_partial('menu/form_footer', array('menu' => $menu, 'form' => $form, 'configuration' => $configuration)) ?>
    </form>
  </div>
</div>