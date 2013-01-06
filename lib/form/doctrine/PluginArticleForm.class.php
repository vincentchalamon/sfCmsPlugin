<?php

/**
 * PluginArticle form.
 *
 * @package    sfCms
 * @subpackage form
 * @author     Vincent CHALAMON <vincentchalamon@gmail.com>
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginArticleForm extends BaseArticleForm
{

    public function setup()
    {
        parent::setup();
        unset($this['created_at'], $this['updated_at'], $this['deleted_at'], $this['slug']);
        $this->widgetSchema['content_type'] = new sfWidgetFormInputHidden();
        if ($this->getUser()->hasGroup("Association") || !$this->isNew()) {
            $this->widgetSchema['author_id'] = new sfWidgetFormInputHidden();
        }
        $this->setDefault("author_id", sfContext::getInstance()->getUser()->getGuardUser()->getId());
        $this->setDefault("content_type", Article::ARTICLE);

        // Title
        $this->widgetSchema['title']->setAttribute("class", "text-input validate[required]");
        $this->widgetSchema['title']->setAttribute("title", "Titre *");
        $this->widgetSchema['title']->setAttribute("placeholder", "Titre *");
        $this->widgetSchema['title']->setAttribute("alt", "Titre *");

        // Authentication
        $this->widgetSchema['require_auth']->setLabel('Requiert une authentification');
        $this->getWidgetSchema()->setHelp("require_auth", "Nécessite que l'utilisateur SOIT authentifié sur le site pour accéder à cette page.");
        $this->widgetSchema['require_no_auth']->setLabel('Ne requiert aucune authentification');
        $this->getWidgetSchema()->setHelp("require_no_auth", "Nécessite que l'utilisateur NE SOIT PAS authentifié sur le site pour accéder à cette page.");

        // Gabarit
        $gabarits = array();
        $files = sfFinder::type("file")->name("*.php")
                ->in(sfConfig::get('sf_app_module_dir').'/gabarits/templates', sfConfig::get('sf_plugins_dir').'/sfCmsPlugin/modules/gabarits/templates')
        ;
        foreach ($files as $gabarit) {
            $name = preg_replace(sprintf('~%s/_(.*).php~i', dirname($gabarit)), '$1', $gabarit);
            $gabarits[$name] = $name;
        }
        $this->widgetSchema['gabarit'] = new sfWidgetFormSelect(array('choices' => $gabarits));
        $this->setDefault("gabarit", "default");
        $this->getWidgetSchema()->setHelp("gabarit", "Permet de changer l'affichage d'une page : 1 colonne, 2 colonnes, gabarit spécial...");

        // Contents
        $this->widgetSchema['contents'] = new sfWidgetFormInputCkeditor();
        $this->widgetSchema['contents']->setAttribute("class", "text-input validate[required]");
        $this->widgetSchema['contents']->setAttribute("title", "Contenu *");
        $this->widgetSchema['contents']->setAttribute("placeholder", "Contenu *");
        $this->widgetSchema['contents']->setAttribute("alt", "Contenu *");

        // Tags
        $this->widgetSchema['tags'] = new sfWidgetFormInputToken(array('url' => $this->genUrl("@article_tags_autocomplete")));
        $this->widgetSchema['tags']->setAttribute("class", "text-input noTransform");
        $this->widgetSchema['tags']->setAttribute("title", "Tags");
        $this->widgetSchema['tags']->setAttribute("placeholder", "Tags");
        $this->widgetSchema['tags']->setAttribute("alt", "Tags");
        $this->validatorSchema['tags'] = new sfValidatorString(array('required' => false));

        // Keywords
        $this->widgetSchema['keywords']->setAttribute("class", "text-input validate[required]");
        $this->widgetSchema['keywords']->setAttribute("title", "Mots-clé");
        $this->widgetSchema['keywords']->setAttribute("placeholder", "Mots-clé");
        $this->widgetSchema['keywords']->setAttribute("alt", "Mots-clé");
        $this->getWidgetSchema()->setHelp("keywords", "Liste de mots-clé pour le référencement, séparés par des virgules.");

        // Description
        $this->widgetSchema['description']->setAttribute("class", "text-input validate[required]");
        $this->widgetSchema['description']->setAttribute("title", "Description");
        $this->widgetSchema['description']->setAttribute("placeholder", "Description");
        $this->widgetSchema['description']->setAttribute("alt", "Description");
        $this->getWidgetSchema()->setHelp("description", "Description brève de la page pour le moteur de recherche et le référencement.");

        // Url
        $this->widgetSchema['url']->setAttribute("class", "text-input validate[optional,custom[url_symfony]]");
        $this->widgetSchema['url']->setAttribute("title", "Adresse personnalisée");
        $this->widgetSchema['url']->setAttribute("placeholder", "Adresse personnalisée");
        $this->widgetSchema['url']->setAttribute("alt", "Adresse personnalisée");
        $this->validatorSchema['url'] = new sfValidatorUrlCustom(array('required' => false));
        $this->getWidgetSchema()->setHelp("url", "Doit obligatoirement commencer par /");

        // Start publication
        $this->widgetSchema['started_at'] = new sfWidgetFormDateJQueryUI();
        $this->widgetSchema['started_at']->setAttribute("class", "text-input maskedInputDate validate[optional,custom[date_custom]]");
        $this->widgetSchema['started_at']->setAttribute("title", "Début de publication");
        $this->widgetSchema['started_at']->setAttribute("placeholder", "Début de publication");
        $this->widgetSchema['started_at']->setAttribute("alt", "Début de publication");
        $this->validatorSchema['started_at'] = new sfValidatorDateCustom(array('required' => false));
        $this->getWidgetSchema()->setHelp("started_at", "Date à partir de laquelle l'article sera publié. Si vide, l'article ne sera pas publié.");

        // End publication
        $this->widgetSchema['ended_at'] = new sfWidgetFormDateJQueryUI();
        $this->widgetSchema['ended_at']->setAttribute("class", "text-input maskedInputDate validate[optional,custom[date_custom]]");
        $this->widgetSchema['ended_at']->setAttribute("title", "Fin de publication");
        $this->widgetSchema['ended_at']->setAttribute("placeholder", "Fin de publication");
        $this->widgetSchema['ended_at']->setAttribute("alt", "Fin de publication");
        $this->validatorSchema['ended_at'] = new sfValidatorDateCustom(array('required' => false));
        $this->getWidgetSchema()->setHelp("ended_at", "Date jusqu'à laquelle l'article doit être publié. Si vide, l'article sera publié indéfiniement.");

        if ($this->getObject()->isSystem() || $this->getObject()->isPartial()) {
            unset($this['started_at'], $this['ended_at'], $this['url'], $this['require_auth'], $this['require_no_auth']);
        }
        foreach ($this->getValidatorSchema()->getPostValidator()->getValidators() as $validator) {
            if (in_array('url', $validator->getOption('column'))) {
                $validator->setMessage('invalid', 'Cette url existe déjà.');
            }
            if (in_array('slug', $validator->getOption('column'))) {
                $validator->setMessage('invalid', 'Ce slug existe déjà.');
            }
        }
    }

    protected function updateDefaultsFromObject()
    {
        parent::updateDefaultsFromObject();
        if (isset($this->widgetSchema['tags'])) {
            $this->setDefault('tags', $this->getObject()->getTags());
        }
        if (isset($this->widgetSchema['url']) && !$this->isNew()) {
            $this->setDefault('url', $this->getObject()->getRoute());
        }
    }

    protected function doSave($con = null)
    {
        $this->saveTags($con);
        parent::doSave($con);
    }

    public function saveTags($con = null)
    {
        if (!$this->isValid()) {
            throw $this->getErrorSchema();
        }
        if (!isset($this->widgetSchema['tags'])) {
            return;
        }
        if (null === $con) {
            $con = $this->getConnection();
        }
        $existing = array_values($this->getObject()->getTags());
        $values = explode(',', $this->getValue('tags'));
        if (!is_array($values)) {
            $values = array();
        }
        $unlink = array_diff($existing, $values);
        if (count($unlink)) {
            $this->getObject()->removeTag(implode(',', array_values($unlink)));
        }
        $link = array_diff($values, $existing);
        if (count($link)) {
            $this->getObject()->addTag(implode(',', array_values($link)));
        }
    }

    /**
     *
     * @return sfGuardSecurityUser
     */
    protected function getUser()
    {
        return $this->getContext()->getUser();
    }

    /**
     *
     * @return sfGuardSecurityUser
     */
    protected function genUrl($url)
    {
        return $this->getContext()->getController()->genUrl($url);
    }

    /**
     *
     * @return sfContext
     */
    protected function getContext()
    {
        if (!sfContext::hasInstance()) {
            throw new sfException("No context");
        }
        return sfContext::getInstance();
    }
}
