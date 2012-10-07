<?php

/**
 * sfCmsPlugin configuration.
 * 
 * @package    sfCmsPlugin
 * @subpackage config
 * @author     Vincent CHALAMON <vincentchalamon@gmail.com>
 */
class sfCmsPluginConfiguration extends sfPluginConfiguration
{

    /**
     * @see sfPluginConfiguration
     */
    public function initialize()
    {
        $this->dispatcher->connect('routing.load_configuration', array($this, 'listenToLoadRouting'));
        sfConfig::set('sf_error_404_module', 'sfCms');
        sfConfig::set('sf_error_404_action', 'error404');
        if (!sfConfig::get('app_sf_cms_contact')) {
            throw new sfException('Missing required parameter "app_sf_cms_contact".');
        }
    }

    public function listenToLoadRouting(sfEvent $event)
    {
        $routing = $event->getSubject();
        // Load article urls
        foreach (ArticleTable::getInstance()->findAll() as $article) {
            if ($article->isArticle() && (!$article->isSystem() || $article->getSlug() == "homepage")) {
                $routing->prependRoute($article->getRouteName(), new sfRoute($article->getRoute(), array('module' => 'sfCms', 'action' => 'view', 'slug' => $article->getSlug())));
            }
        }
    }
}
