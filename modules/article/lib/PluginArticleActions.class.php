<?php

require_once dirname(__FILE__).'/articleGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/articleGeneratorHelper.class.php';

/**
 * article actions.
 *
 * @subpackage article
 * @author     Vincent CHALAMON <vincentchalamon@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginArticleActions extends autoArticleActions
{

    public function executeShow(sfWebRequest $request)
    {
        $this->redirect("@".$this->getRoute()->getObject()->getRouteName());
    }

    public function executePublish(sfWebRequest $request)
    {
        $this->getRoute()->getObject()->publish();
        $this->redirect($request->getReferer());
    }

    public function executeUnpublish(sfWebRequest $request)
    {
        $this->getRoute()->getObject()->unpublish();
        $this->redirect($request->getReferer());
    }

    public function executeTags_autocomplete(sfWebRequest $request)
    {
        $this->forward404Unless($request->isMethod("post") && $request->isXmlHttpRequest());
        $tags = TagTable::getInstance()->createQuery("tag")->select("tag.name AS id, tag.name AS name")->where("tag.name LIKE ?", "%".$request->getParameter("q")."%")->limit(10)->fetchArray();
        return $this->renderText(json_encode($tags));
    }

    protected function executeBatchDelete(sfWebRequest $request)
    {
        ArticleTable::getInstance()->createQuery()
                ->whereIn('id', $request->getParameter('ids'))
                ->andWhereNotIn('slug', Article::getSystemSlugs())
                ->delete()->execute();
        $this->getUser()->setFlash('notice', 'The selected items have been deleted successfully.');
        $this->redirect('@article');
    }
}
