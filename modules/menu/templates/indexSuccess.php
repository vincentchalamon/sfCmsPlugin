<?php use_stylesheet('/sfCmsPlugin/css/jquery.treeTable.css') ?>
<?php use_javascript('/sfCmsPlugin/js/jquery.treeTable.min.js') ?>
<script type="text/javascript">
  $(document).ready(function(){
    // Tree table
    $("#treeTable").treeTable({
      treeColumn: 1,
      initialState: 'expanded'
    });
    // Object actions
    $('.sf_admin_row_object_actions a.fancybox').fancybox({
      overlayColor: "#000",
      showCloseButton: false,
      padding: 0,
      margin: 0
    });
    $('.sf_admin_row td:not(.sf_admin_batch_actions)').live('click', function(){
      $(this).parent().next('.sf_admin_row_object_actions').find('a.fancybox').click();
    });
    // Batch actions
    if($('.contentbox tfoot select[name=batch_action] option').length <= 1) {
      $('.contentbox tfoot select[name=batch_action], .contentbox tfoot input:submit, .contentbox tfoot input:hidden').remove();
    }
  });
</script>
<?php use_helper('I18N', 'Date') ?>
<?php $sf_response->addMeta('title', 'Administration | '.__('Arborescence', array(), 'messages')) ?>
<?php slot('breadcrumb', array(array('url' => '@menu', 'label' => __('Arborescence', array(), 'messages')))) ?>
<?php include_partial('menu/assets') ?>
<?php include_partial('menu/flashes') ?>

<div class="contentcontainer sml right">
  <?php include_partial('menu/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
</div>
<div class="contentcontainer med left">
  <div class="headings">
    <h2><?php echo __('Arborescence', array(), 'messages') ?></h2>
  </div>

  <?php include_partial('menu/list_header', array('pager' => $pager)) ?>
  
  <div class="contentbox">
    <form action="<?php echo url_for('menu_collection', array('action' => 'batch')) ?>" method="post">
    <?php include_partial('menu/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
    </form>
  </div>

  <?php include_partial('menu/list_footer', array('pager' => $pager)) ?>
</div>
<div style="clear: both;"></div>
