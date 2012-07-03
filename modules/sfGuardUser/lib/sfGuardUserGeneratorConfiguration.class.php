<?php

/**
 * sfGuardUser module configuration.
 *
 * @package    sfGuardPlugin
 * @subpackage sfGuardUser
 * @author     Fabien Potencier
 * @version    SVN: $Id: sfGuardUserGeneratorConfiguration.class.php 23319 2009-10-25 12:22:23Z Kris.Wallsmith $
 */
class sfGuardUserGeneratorConfiguration extends BaseSfGuardUserGeneratorConfiguration
{
  public function getMainDisplay()
  {
    return array("username", "password", "password_again", "email_address", "first_name", "last_name");
  }

  public function getMetasDisplay()
  {
    return array("is_active", "is_super_admin", "redirect_url", "groups_list", "permissions_list");
  }
}
