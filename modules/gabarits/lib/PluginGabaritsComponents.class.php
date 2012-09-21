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
            die("<pre>".print_r($request->getParameter($this->form->getName(), array()), true)."</pre>");
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
