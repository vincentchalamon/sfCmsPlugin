<td class="sf_admin_batch_actions">
  <input type="checkbox" name="ids[]" value="<?php echo $menu->getPrimaryKey() ?>" class="sf_admin_batch_checkbox" />
  <input type="hidden" id="select_node-<?php echo $menu->getPrimaryKey() ?>" name="newparent[<?php echo $menu->getPrimaryKey() ?>]" />
</td>