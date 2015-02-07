<?php

/**
 * sfCms actions.
 *
 * @subpackage sfCms
 * @author     Vincent CHALAMON <vincentchalamon@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PluginGabaritsComponents extends sfComponents
{

    public function executeContact(sfWebRequest $request)
    {
        $this->form = new ContactForm();
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter($this->form->getName(), array()));
            if ($this->form->isValid()) {
                $this->getContext()->getConfiguration()->loadHelpers('Partial');
                $message = $this->getMailer()->compose(
                        array($this->form->getValue('email') => $this->form->getValue('name')),
                        array(sfConfig::get('app_sf_cms_contact') => sfConfig::get('app_sf_guard_plugin_default_from_name')),
                        $this->getContext()->getI18N()->__('New contact message', array(), 'sf_cms'),
                        get_partial('sfCms/mail', array(
                            'title' => $this->getContext()->getI18N()->__('New contact message', array(), 'sf_cms'),
                            'message' => $this->form->getValue('message')
                        ))
                )->setContentType('text/html');
                $this->getMailer()->send($message);
                $this->getUser()->setFlash('notice', $this->getContext()->getI18N()->__('Message has been successfully sent.', array(), 'sf_cms'));
                $this->form = new ContactForm();
            } else {
                $this->getUser()->setFlash('error', $this->getContext()->getI18N()->__('Form has errors.', array(), 'sf_cms'), false);
            }
        }
    }

    public function executeDefault(sfWebRequest $request)
    {
        
    }

    public function executeError(sfWebRequest $request)
    {
        
    }

    public function executeHomepage(sfWebRequest $request)
    {
        
    }

    public function executeSitemap(sfWebRequest $request)
    {
        
    }
}
