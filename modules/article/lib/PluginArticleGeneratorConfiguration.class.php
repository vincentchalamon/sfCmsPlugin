<?php

/**
 * article module configuration.
 *
 * @subpackage article
 * @author     Vincent CHALAMON <vincentchalamon@gmail.com>
 * @version    SVN: $Id: configuration.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginArticleGeneratorConfiguration extends BaseArticleGeneratorConfiguration
{
  public function getMainDisplay()
  {
    return array("title", "gabarit", "contents");
  }

  public function getMetasDisplay()
  {
    return array("author_id", "url", "tags", "keywords", "description", "started_at", "ended_at", "require_auth", "require_no_auth", "song");
  }

  public function compile()
  {
    parent::compile();
    $this->configuration['metas'] = $this->configuration['edit'];
    $this->configuration['main'] = $this->configuration['edit'];
  }

  protected function getConfig()
  {
    return array_merge(array('main' => $this->getFieldsDefault(), 'metas' => $this->getFieldsDefault()), parent::getConfig());
  }
}
