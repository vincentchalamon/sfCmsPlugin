<?php

/**
 * PluginMenu form.
 *
 * @package    sfCms
 * @subpackage form
 * @author     Vincent CHALAMON <vincentchalamon@gmail.com>
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginMenuForm extends BaseMenuForm
{
    protected $parentId = null;

    public function setup()
    {
        parent::setup();
        unset($this['created_at'], $this['updated_at'], $this['deleted_at'], $this['root_id'], $this['lft'], $this['rgt'], $this['level'], $this['slug']);

        // Parent
        $this->widgetSchema['parent_id'] = new sfWidgetFormDoctrineChoice(array('model' => 'Menu', 'add_empty' => '~ (racine)', 'order_by' => array('root_id, lft', ''), 'method' => 'getIndentedName'));
        $this->validatorSchema['parent_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Menu'));
        $this->setDefault('parent_id', $this->object->getParentId());
        $this->widgetSchema->setLabel('parent_id', 'Parent');

        // Authentication
        $this->widgetSchema['require_auth']->setLabel('Requiert une authentification');
        $this->getWidgetSchema()->setHelp("require_auth", "Nécessite que l'utilisateur SOIT authentifié sur le site pour voir ce menu.");
        $this->widgetSchema['require_no_auth']->setLabel('Ne requiert aucune authentification');
        $this->getWidgetSchema()->setHelp("require_no_auth", "Nécessite que l'utilisateur NE SOIT PAS authentifié sur le site pour voir ce menu.");

        // Name
        $this->widgetSchema['name']->setAttribute("class", "text-input validate[required]");
        $this->widgetSchema['name']->setAttribute("title", "Titre *");
        $this->widgetSchema['name']->setAttribute("placeholder", "Titre *");
        $this->widgetSchema['name']->setAttribute("alt", "Titre *");

        // Image path
        $this->widgetSchema['image_path'] = new sfWidgetFormInputUploadify(array(
            'is_image' => true,
            'fileDesc' => 'Images',
            'fileExt' => '*.jpg;*.JPG;*.png;*.PNG;*.gif;*.GIF;*.jpeg;*.JPEG'
        ));
        $this->widgetSchema['image_path']->setAttribute("class", "text-input");
        $this->widgetSchema['image_path']->setAttribute("title", "Image");
        $this->widgetSchema['image_path']->setAttribute("placeholder", "Image");
        $this->widgetSchema['image_path']->setAttribute("alt", "Image");

        // Url
        $this->widgetSchema['url']->setAttribute("class", "text-input validate[optional,custom[url]]");
        $this->widgetSchema['url']->setAttribute("title", "Adresse personnalisée");
        $this->widgetSchema['url']->setAttribute("placeholder", "Adresse personnalisée");
        $this->widgetSchema['url']->setAttribute("alt", "Adresse personnalisée");
        $this->validatorSchema['url'] = new sfValidatorUrlCustom(array('required' => false, 'allow_symfony_routes' => true, 'allow_external_routes' => true));
        $this->getWidgetSchema()->setHelp("url", "Saisissez une url commençant par / ou http, ou une url symfony.");

        // Article
        $this->widgetSchema['article_id']->setOption('query', ArticleTable::getInstance()->getArticlesQuery($this->getObject()->getArticleId()));

        // Start publication
        $this->widgetSchema['started_at'] = new sfWidgetFormInputDate();
        $this->widgetSchema['started_at']->setAttribute("class", "text-input maskedInputDate validate[optional,custom[date_custom]]");
        $this->widgetSchema['started_at']->setAttribute("title", "Début de publication");
        $this->widgetSchema['started_at']->setAttribute("placeholder", "Début de publication");
        $this->widgetSchema['started_at']->setAttribute("alt", "Début de publication");
        $this->validatorSchema['started_at'] = new sfValidatorDateCustom(array('required' => false));
        $this->getWidgetSchema()->setHelp("started_at", "Date à partir de laquelle le menu sera publié. Si vide, le menu ne sera pas publié.");

        // End publication
        $this->widgetSchema['ended_at'] = new sfWidgetFormInputDate();
        $this->widgetSchema['ended_at']->setAttribute("class", "text-input maskedInputDate validate[optional,custom[date_custom]]");
        $this->widgetSchema['ended_at']->setAttribute("title", "Fin de publication");
        $this->widgetSchema['ended_at']->setAttribute("placeholder", "Fin de publication");
        $this->widgetSchema['ended_at']->setAttribute("alt", "Fin de publication");
        $this->validatorSchema['ended_at'] = new sfValidatorDateCustom(array('required' => false));
        $this->getWidgetSchema()->setHelp("ended_at", "Date jusqu'à laquelle le menu doit être publié. Si vide, le menu sera publié indéfiniement.");
        
        // New window
        $this->getWidgetSchema()->setHelp("new_window", "Ouvre le lien dans une nouvelle fenêtre.");
    }

    public function updateParentIdColumn($parentId)
    {
        $this->parentId = $parentId;
    }

    protected function doSave($con = null)
    {
        parent::doSave($con);
        $node = $this->object->getNode();
        if ($this->parentId != $this->object->getParentId() || !$node->isValidNode()) {
            if (empty($this->parentId)) {
                //save as a root
                if ($node->isValidNode()) {
                    $node->makeRoot($this->object['id']);
                    $this->object->save($con);
                } else {
                    $this->object->getTable()->getTree()->createRoot($this->object);
                }
            } else {
                $parent = $this->object->getTable()->find($this->parentId);
                $method = ($node->isValidNode() ? 'move' : 'insert').'AsFirstChildOf';
                $node->$method($parent);
            }
        }
    }
}
