<?php

/**
 * sfCms actions.
 *
 * @subpackage sfCms
 * @author     Vincent CHALAMON <vincentchalamon@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PluginSfCmsActions extends sfActions
{

    public function executeRss(sfWebRequest $request)
    {
        $query = ArticleTable::getInstance()->createQuery()
                ->whereNotIn('slug', Article::getSystemSlugs())
                ->andWhere('content_type = ?', Article::ARTICLE);
        $this->articles = ArticleTable::getInstance()->findAllPublished("now", "started_at DESC", null, $query);
    }

    public function executeSitemap(sfWebRequest $request)
    {
        $query = ArticleTable::getInstance()->createQuery()
                ->whereNotIn('slug', Article::getSystemSlugs())
                ->andWhere('content_type = ?', Article::ARTICLE);
        $this->articles = ArticleTable::getInstance()->findAllPublished("now", "started_at DESC", null, $query);
    }

    public function executeView(sfWebRequest $request)
    {
        $this->page = ArticleTable::getInstance()->findOneBySlugAndContentType($request->getParameter('slug', 'homepage'), Article::ARTICLE);
        $this->forward404Unless($this->page);
        $this->forwardUnless($this->page->isPublished() || $this->getUser()->hasCredential("Article"), $this->getModuleName(), "unpublished");
        $this->getResponse()->setTitle($this->page->getTitle());
        $this->getResponse()->addMeta("description", $this->page->getDescription());
        $this->getResponse()->addMeta("keywords", $this->page->getKeywords());
        if ($this->page->getRequireAuth()) {
            $this->forwardUnless($this->getUser()->isAuthenticated(), sfConfig::get('sf_login_module'), sfConfig::get('sf_login_action'));
        }
        if ($this->page->getRequireNoAuth()) {
            $this->forwardUnless(!$this->getUser()->isAuthenticated(), sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
        }
        $this->menu = $this->page->getMenu();
        if (!$this->page->isPublished()) {
            $this->getUser()->setFlash('info', "Cet article n'est pas encore publié !");
        }
        $this->gabarit = !$this->page->getGabarit() ? "default" : $this->page->getGabarit();
    }

    public function executeSearch(sfWebRequest $request)
    {
        if (!$request->hasParameter("query") || !strlen($request->getParameter("query"))) {
            $this->getUser()->setFlash("error", "Veuillez saisir une recherche");
            $this->redirect("@homepage");
        }
        $query = ArticleTable::getInstance()->getSearchQuery(preg_replace('/[^A-z^0-9\ ]/i', '', Doctrine_Inflector::unaccent($request->getParameter("query"))));
        $this->pager = new sfDoctrinePager("Article", sfConfig::get('app_max_per_page', 10));
        $this->pager->setPage($request->getParameter("page", 1));
        $this->pager->setQuery($query);
        $this->pager->init();
    }

    public function executeError404(sfWebRequest $request)
    {
        $request->setParameter("slug", "error404");
        $this->executeView($request);
    }

    public function executeError500(sfWebRequest $request)
    {
        $request->setParameter("slug", "error500");
        $this->executeView($request);
    }

    public function executeUnpublished(sfWebRequest $request)
    {
        $request->setParameter("slug", "unpublished");
        $this->executeView($request);
    }

    protected function setMeta($name)
    {
        if (!is_null($this->page[$name]) && strlen($this->page[$name])) {
            $this->getResponse()->addMeta($name, $this->page[$name]);
        }
    }
}
