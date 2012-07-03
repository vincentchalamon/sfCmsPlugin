<?php

function getTagCloud(Article $article)
{
  $tags = PluginTagTable::getAllTagNameWithCount(null, array('model' => 'Article', 'object_id' => $article->getPrimaryKey()));
  $cloud = "";
  foreach($tags as $tag => $count)
  {
    $cloud.= link_to("$tag ", sprintf("@search?query=%s", $tag), array("class" => "size$count"));
  }
  return $cloud;
}

function getPartial($slug, $published = false)
{
  $partial = ArticleTable::getInstance()->findOneBySlugAndContentType($slug, ARTICLE::PARTIAL);
  return $partial && $partial->isPublished() || $published ? $partial : false;
}

function getMenu($slug, $published = false)
{
  $menu = MenuTable::getInstance()->getMenu($slug);
  return $menu->isPublished() || $published ? $menu : false;
}

function getBreadcrumb(Menu $menu)
{
  return MenuTable::getInstance()->createQuery("menu")
          ->where("menu.root_id = ?", $menu['root_id'])
          ->andWhere("menu.level < ?", $menu['level'])
          ->andWhere("menu.lft < ?", $menu['lft'])
          ->andWhere("menu.rgt > ?", $menu['rgt'])
          ->orderBy("menu.lft ASC")
          ->groupBy("menu.level")
          ->execute();
}