<?php

/**
 * Contact form.
 *
 * @package    sfCms
 * @subpackage form
 * @author     Vincent CHALAMON <vincentchalamon@gmail.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ContactForm extends BaseForm
{

    public function configure()
    {
        $this->setWidgets(array(
            'name' => new sfWidgetFormInputText(),
            'email' => new sfWidgetFormInputText(),
            'website' => new sfWidgetFormInputText(),
            'message' => new sfWidgetFormTextarea()
        ));
        $this->setValidators(array(
            'name' => new sfValidatorString(),
            'email' => new sfValidatorEmail(),
            'website' => new sfValidatorUrl(array('required' => false)),
            'message' => new sfValidatorString()
        ));
    }
}
