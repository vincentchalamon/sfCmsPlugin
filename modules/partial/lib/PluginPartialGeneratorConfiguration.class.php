<?php

/**
 * partial module configuration.
 *
 * @subpackage partial
 * @author     Vincent CHALAMON <vincentchalamon@gmail.com>
 * @version    SVN: $Id: configuration.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginPartialGeneratorConfiguration extends BasePartialGeneratorConfiguration
{
  public function getMainDisplay()
  {
    return array("title", "contents");
  }

  public function getMetasDisplay()
  {
    return array("slug", "started_at", "ended_at");
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
