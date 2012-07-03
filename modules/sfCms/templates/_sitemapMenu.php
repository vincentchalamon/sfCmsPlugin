<?php if($menu->hasToRender($sf_user->getRawValue())): ?>
  <li>
    <?php echo link_to($menu, $menu->getRoute(), array('title' => $menu)) ?>
    <?php if($menu->hasChildren()): ?>
      <ul>
        <?php foreach($menu['__children'] as $children): ?>
          <?php include_partial("sfCms/sitemapMenu", array('menu' => $children)) ?>
        <?php endforeach ?>
      </ul>
    <?php endif ?>
  </li>
<?php endif ?>