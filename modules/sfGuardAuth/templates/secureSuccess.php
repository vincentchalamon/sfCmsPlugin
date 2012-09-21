<?php echo getPartial('secure') ?>
<p>
  <a href="javascript:history.back();"><?php echo __('Back', array(), 'sf_cms') ?></a>
  <?php echo link_to(__('Sign out', array(), 'sf_cms'), "@sf_guard_signout") ?>
</p>