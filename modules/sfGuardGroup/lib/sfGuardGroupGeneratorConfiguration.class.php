<?php

/**
 * sfGuardGroup module configuration.
 *
 * @package    sfGuardPlugin
 * @subpackage sfGuardGroup
 * @author     Fabien Potencier
 * @version    SVN: $Id: sfGuardGroupGeneratorConfiguration.class.php 23319 2009-10-25 12:22:23Z Kris.Wallsmith $
 */
class sfGuardGroupGeneratorConfiguration extends BaseSfGuardGroupGeneratorConfiguration
{
  public function getMainDisplay()
  {
    return array("name", "description");
  }

  public function getMetasDisplay()
  {
    return array("users_list", "permissions_list");
  }
}
