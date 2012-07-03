<?php

/**
 * article module helper.
 *
 * @subpackage article
 * @author     Vincent CHALAMON <vincentchalamon@gmail.com>
 * @version    SVN: $Id: helper.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PluginArticleGeneratorHelper extends BaseArticleGeneratorHelper
{
  public function linkToShow($object, $params)
  {
    if ($object->isNew())
    {
      return '';
    }
    $route = $object->getRoute();
    return '<li class="sf_admin_action_show">'.link_to(__($params['label'], array(), 'sf_admin'), sfConfig::get('sf_environment', 'prod') == 'dev' ? "/frontend_dev.php$route" : $route).'</li>';
  }

  public function linkToDelete($object, $params)
  {
    return '';
  }

  public function linkToPublish($object, $params)
  {
    if($object->isSystem() || $object->isPublished())
    {
      return '';
    }
    return '<li class="sf_admin_action_publish">'.link_to(__($params['label'], array(), 'sf_admin'), $this->getUrlForAction('publish'), $object).'</li>';
  }

  public function linkToUnpublish($object, $params)
  {
    if($object->isSystem() || !$object->isPublished())
    {
      return '';
    }
    return '<li class="sf_admin_action_unpublish">'.link_to(__($params['label'], array(), 'sf_admin'), $this->getUrlForAction('unpublish'), $object).'</li>';
  }
}