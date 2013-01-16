<ul>
    <?php foreach ($menu['__children'] as $child): ?>
        <li><?php echo getMenuLink($child) ?></li>
    <?php endforeach ?>
</ul>