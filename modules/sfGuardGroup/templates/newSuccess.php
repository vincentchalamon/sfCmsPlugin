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
<?php $sf_response->addMeta('title', 'Administration | '.__('Groupes d\'utilisateurs', array(), 'messages').' | '.__('Nouveau groupe', array(), 'messages')) ?>
<?php slot('breadcrumb', array(array('url' => '@sf_guard_group', 'label' => __('Groupes d\'utilisateurs', array(), 'messages')), array('url' => '@sf_guard_group_new', 'label' => __('Nouveau groupe', array(), 'messages')))) ?>
<?php include_partial('sfGuardGroup/assets') ?>
<?php include_partial('sfGuardGroup/flashes') ?>

<div class="contentcontainer">
  <div class="headings">
    <h2><?php echo __('Nouveau groupe', array(), 'messages') ?></h2>
  </div>

  <?php include_partial('sfGuardGroup/form_header', array('sf_guard_group' => $sf_guard_group, 'form' => $form, 'configuration' => $configuration)) ?>

  <div class="contentbox sf_admin_form">
    <?php echo form_tag_for($form, '@sf_guard_group') ?>
      <?php include_partial('sfGuardGroup/form_header', array('sf_guard_group' => $sf_guard_group, 'form' => $form, 'configuration' => $configuration)) ?>
      <?php echo $form->renderHiddenFields(false) ?>
      <div class="left">
        <?php include_partial('sfGuardGroup/form', array('sf_guard_group' => $sf_guard_group, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
      </div>
      <div class="right">
        <?php foreach ($configuration->getFormFields($form, 'metas') as $fieldset => $fields): ?>
          <?php foreach ($fields as $name => $field): ?>
            <?php if ((isset($form[$name]) && $form[$name]->isHidden()) || (!isset($form[$name]) && $field->isReal())) continue ?>
            <li>
              <?php include_partial('sfGuardGroup/form_field', array(
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
      <?php include_partial('sfGuardGroup/form_footer', array('sf_guard_group' => $sf_guard_group, 'form' => $form, 'configuration' => $configuration)) ?>
    </form>
  </div>
</div>