<ul>
    <?php foreach ($menu['__children'] as $child): ?>
        <li><?php echo link_to($child, $child->getRoute(), array('title' => $child)) ?></li>
    <?php endforeach ?>
</ul>