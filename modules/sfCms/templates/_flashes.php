<!-- Start notice -->
<?php if($sf_user->hasFlash('success')): ?>
  <div class="notify success"><span>Succès !</span><?php echo __($sf_user->getFlash('success'), null, 'sf_admin') ?></div>
<?php endif ?>
<?php if($sf_user->hasFlash('notice')): ?>
  <div class="notify success"><span>Succès !</span><?php echo __($sf_user->getFlash('notice'), null, 'sf_admin') ?></div>
<?php endif ?>
<?php if($sf_user->hasFlash('error')): ?>
  <div class="notify error"><span>Erreur !</span><?php echo __($sf_user->getFlash('error'), null, 'sf_admin') ?></div>
<?php endif ?>
<?php if($sf_user->hasFlash('info')): ?>
  <div class="notify info"><span>Information !</span><?php echo __($sf_user->getFlash('error'), null, 'sf_admin') ?></div>
<?php endif ?>
<!-- End notice -->