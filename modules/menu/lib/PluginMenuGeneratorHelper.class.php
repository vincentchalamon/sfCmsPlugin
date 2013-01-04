<?php

/**
 * menu module helper.
 *
 * @subpackage menu
 * @author     Vincent CHALAMON <vincentchalamon@gmail.com>
 * @version    SVN: $Id: helper.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PluginMenuGeneratorHelper extends BaseMenuGeneratorHelper
{

  public function linkToPublish($object, $params)
  {
    if($object->isPublished())
    {
      return '';
    }
    return '<li class="sf_admin_action_publish">'.link_to(__($params['label'], array(), 'sf_admin'), $this->getUrlForAction('publish'), $object).'</li>';
  }

  public function linkToUnpublish($object, $params)
  {
    if(!$object->isPublished())
    {
      return '';
    }
    return '<li class="sf_admin_action_unpublish">'.link_to(__($params['label'], array(), 'sf_admin'), $this->getUrlForAction('unpublish'), $object).'</li>';
  }
}
