<?php

/**
 * Partial form.
 *
 * @package    esterel-orthopedie
 * @subpackage form
 * @author     Vincent CHALAMON <vincentchalamon@gmail.com>
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PartialForm extends ArticleForm
{

    public function configure()
    {
        unset($this['created_at'], $this['updated_at'], $this['deleted_at'],
              $this['gabarit'], $this['keywords'], $this['description'], $this['url']);
        $this->setDefault("content_type", Article::PARTIAL);

        // Slug
        $this->widgetSchema['slug'] = new sfWidgetFormInputText();
        $this->widgetSchema['slug']->setAttribute("class", "text-input validate[required]");
        $this->widgetSchema['slug']->setAttribute("title", "Clé");
        $this->widgetSchema['slug']->setAttribute("placeholder", "Clé");
        $this->widgetSchema['slug']->setAttribute("alt", "Clé");
        $this->getWidgetSchema()->setHelp("slug", "Clé unique permettant la récupération du bloc.");
    }
}
