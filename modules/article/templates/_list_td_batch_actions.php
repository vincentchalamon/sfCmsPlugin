<td>
  <?php if($article->isSystem()): ?>
    <span class="system"><?php echo image_tag(public_path('/sfDoctrinePlugin/images/error.png'), array('title' => "Article système", "alt" => "Article système")) ?></span>
  <?php else: ?>
    <input type="checkbox" name="ids[]" value="<?php echo $article->getPrimaryKey() ?>" class="sf_admin_batch_checkbox" />
  <?php endif ?>
</td>