<style type="text/css">
  .batch {
    width: 20px;
  }
</style>
<?php if (!$pager->getNbResults()): ?>
  <p><?php echo __('No result', array(), 'sf_admin') ?></p>
  <?php include_partial('menu/list_actions', array('helper' => $helper)) ?>
<?php else: ?>
  <table width="100%" id="treeTable">
    <thead>
      <tr>
        <th id="sf_admin_list_batch_actions"><input id="sf_admin_list_batch_checkbox" type="checkbox" onclick="checkAll();" /></th>
        <?php include_partial('menu/list_th_tabular', array('sort' => $sort)) ?>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <td colspan="4">
          <?php include_partial('menu/list_batch_actions', array('helper' => $helper)) ?>
          <span>
            <?php echo format_number_choice('[0] no result|[1] 1 result|(1,+Inf] %1% results', array('%1%' => $pager->getNbResults()), $pager->getNbResults(), 'sf_admin') ?>
            <?php if ($pager->haveToPaginate()): ?>
              <?php echo __('(page %%page%%/%%nb_pages%%)', array('%%page%%' => $pager->getPage(), '%%nb_pages%%' => $pager->getLastPage()), 'sf_admin') ?>
            <?php endif; ?>
          </span>
          <span>
            <?php include_partial('menu/list_actions', array('helper' => $helper)) ?>
          </span>
          <?php if ($pager->haveToPaginate()): ?>
            <?php include_partial('menu/pagination', array('pager' => $pager)) ?>
          <?php endif; ?>
          <div style="clear: both;"></div>
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php $levels = array(); foreach ($pager->getResults() as $i => $menu): ?>
        <?php if($menu->hasChildren()) $levels[$menu->getLevel()] = $menu->getPrimaryKey() ?>
        <tr id="node-<?php echo $menu->getPrimaryKey() ?>" class="sf_admin_row <?php echo fmod(++$i, 2) ? 'odd' : 'even' ?><?php echo $menu->hasParent() ? " child-of-node-".$levels[$menu->getLevel()-1] : null ?>">
          <?php include_partial('menu/list_td_batch_actions', array('menu' => $menu, 'helper' => $helper)) ?>
          <?php include_partial('menu/list_td_tabular', array('menu' => $menu)) ?>
        </tr>
        <tr class="sf_admin_row_object_actions">
          <?php include_partial('menu/list_td_actions', array('menu' => $menu, 'helper' => $helper, 'i' => $i)) ?>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif ?>
<script type="text/javascript">
/* <![CDATA[ */
function checkAll()
{
  var boxes = document.getElementsByTagName('input'); for(var index = 0; index < boxes.length; index++) { box = boxes[index]; if (box.type == 'checkbox' && box.className == 'sf_admin_batch_checkbox') box.checked = document.getElementById('sf_admin_list_batch_checkbox').checked } return true;
}
/* ]]> */
</script>
