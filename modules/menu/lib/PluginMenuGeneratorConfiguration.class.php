<?php

/**
 * menu module configuration.
 *
 * @subpackage menu
 * @author     Vincent CHALAMON <vincentchalamon@gmail.com>
 * @version    SVN: $Id: configuration.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginMenuGeneratorConfiguration extends BaseMenuGeneratorConfiguration
{
  public function getMainDisplay()
  {
    return array("name", "url", "article_id", "parent_id");
  }

  public function getMetasDisplay()
  {
    return array("started_at", "ended_at");
  }
}
