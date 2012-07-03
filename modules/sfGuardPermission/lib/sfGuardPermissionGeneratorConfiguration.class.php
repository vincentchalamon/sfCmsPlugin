<?php

/**
 * sfGuardPermission module configuration.
 *
 * @package    sfGuardPlugin
 * @subpackage sfGuardPermission
 * @author     Fabien Potencier
 * @version    SVN: $Id: sfGuardPermissionGeneratorConfiguration.class.php 23319 2009-10-25 12:22:23Z Kris.Wallsmith $
 */
class sfGuardPermissionGeneratorConfiguration extends BaseSfGuardPermissionGeneratorConfiguration
{
  public function getMainDisplay()
  {
    return array("name", "description");
  }

  public function getMetasDisplay()
  {
    return array("users_list", "groups_list");
  }
}
