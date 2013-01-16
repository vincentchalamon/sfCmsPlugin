<?php

function getTagCloud(Article $article)
{
    $tags = PluginTagTable::getAllTagNameWithCount(null, array('model' => 'Article', 'object_id' => $article->getPrimaryKey()));
    $cloud = "";
    foreach ($tags as $tag => $count) {
        $cloud.= link_to("$tag ", sprintf("@search?query=%s", $tag), array("class" => "size$count"));
    }
    return $cloud;
}

function getPartial($slug, $column = "contents")
{
    $partial = ArticleTable::getInstance()->findOneBySlugAndContentType($slug, ARTICLE::PARTIAL);
    return $partial ? $partial[$column] : false;
}

function getMenuLink($menu)
{
    return link_to($menu, $menu->getRoute(), array_merge(array('title' => $menu), $menu['new_window'] ? array('target' => '_blank') : array()));
}

function getMenu($slug, $showUnpublishedElements = false)
{
    return MenuTable::getInstance()->getMenu($slug, $showUnpublishedElements);
}

function renderMenu($slug, $showUnpublishedElements = false, $partial = 'sfCms/renderMenu')
{
    $menu = getMenu($slug, $showUnpublishedElements);
    return $menu ? get_partial($partial, array('menu' => $menu)) : null;
}

function getBreadcrumb(Menu $menu)
{
    return MenuTable::getInstance()->createQuery("menu")
                    ->where("menu.root_id = ?", $menu['root_id'])
                    ->andWhere("menu.level < ? AND menu.level > 0", $menu['level'])
                    ->andWhere("menu.lft < ?", $menu['lft'])
                    ->andWhere("menu.rgt > ?", $menu['rgt'])
                    ->orderBy("menu.lft ASC")
                    ->groupBy("menu.level")
                    ->execute();
}