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
            'name' => new sfWidgetFormInputText(array('label' => 'Nom')),
            'email' => new sfWidgetFormInputText(array('label' => 'Email')),
            'message' => new sfWidgetFormTextarea(array('label' => 'Message'))
        ));
        $this->setValidators(array(
            'name' => new sfValidatorString(),
            'email' => new sfValidatorEmail(),
            'message' => new sfValidatorString()
        ));
        $this->getWidgetSchema()->setHelps(array(
            'name' => 'Saisissez votre nom',
            'email' => 'Saisissez votre adresse email',
            'message' => 'Saisissez votre message'
        ));
        $this->widgetSchema->setNameFormat('contact[%s]');
        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    }
}
