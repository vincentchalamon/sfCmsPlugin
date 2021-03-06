<?php

/**
 * PluginMenuTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PluginMenuTable extends Doctrine_Table
{

    /**
     * Returns an instance of this class.
     *
     * @return object PluginMenuTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('PluginMenu');
    }

    public function getCurrent(Menu $menu)
    {
        $parent = $this->createQuery("menu")
                ->where("menu.root_id = ?", $menu->getRootId())
                ->leftJoin("menu.Article article")
                ->leftJoin("menu.Permissions permission")
                ->andWhere("menu.level = 1")
                ->andWhere("menu.lft < ?", $menu->getLft())
                ->andWhere("menu.rgt > ?", $menu->getRgt())
                ->andWhere("menu.deleted_at IS NULL")
                ->orderBy("menu.lft ASC")
                ->fetchOne();
        return $menu->getLevel() <= 1 || !$parent ? $menu->getSlug() : $parent['slug'];
    }

    public function findMenus()
    {
        return $this->createQuery("menu")
                    ->leftJoin("menu.Article article")
                    ->leftJoin("menu.Permissions permission")
                    ->where("menu.deleted_at IS NULL")
                    ->orderBy("menu.root_id, menu.lft");
    }

    public function getMenu($slug, $showUnpublishedElements = false)
    {
        $menu = $this->findOneBySlug($slug);
        if (!$menu)
            throw new InvalidArgumentException("Menu $slug does not exist !", 500);
        $query = $this->createQuery("m")
                      ->leftJoin("m.Article a")
                      ->leftJoin("m.Permissions permission")
                      ->where("m.lft >= ?", $menu->getLft())
                      ->andWhere("m.rgt <= ?", $menu->getRgt())
                      ->andWhere("m.root_id = ?", $menu->getRootId())
                      ->andWhere("m.deleted_at IS NULL")
                      ->orderBy("m.lft ASC")
                      ->setHydrationMode(Doctrine_Core::HYDRATE_RECORD_HIERARCHY);
        $tree = $query->fetchOne();
        // Manage published elements
        return $tree && !$showUnpublishedElements ? $this->unsetUnpublished($tree) : $tree;
    }
    
    protected function unsetUnpublished($menu)
    {
        // Menu is not published : ignore it and its children
        if (!$menu->isPublished()) {
            return false;
        }
        // Check children publication
        if (isset($menu['__children']) && count($menu['__children'])) {
            foreach ($menu['__children'] as $key => $child) {
                if ($tree = $this->unsetUnpublished($child)) {
                    $menu['__children'][$key] = $tree;
                } else {
                    $menu['__children']->remove($key);
                }
            }
        }
        return $menu;
    }
}