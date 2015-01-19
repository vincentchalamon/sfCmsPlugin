<?php

require_once dirname(__FILE__).'/menuGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/menuGeneratorHelper.class.php';

/**
 * menu actions.
 *
 * @subpackage menu
 * @author     Vincent CHALAMON <vincentchalamon@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginMenuActions extends autoMenuActions
{
  protected function addSortQuery($query)
  {
    //don't allow sorting; always sort by menu and lft
    $query->addOrderBy('root_id, lft');
  }
  
  public function executeDown(sfWebRequest $request)
  {
    $this->getRoute()->getObject()->moveDown();
    $this->redirect($request->getReferer());
  }
  
  public function executeUp(sfWebRequest $request)
  {
    $this->getRoute()->getObject()->moveUp();
    $this->redirect($request->getReferer());
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

  public function executeBatch(sfWebRequest $request)
  {
    if ("batchOrder" == $request->getParameter('batch_action'))
    {
      return $this->executeBatchOrder($request);
    }

    parent::executeBatch($request);
  }

  public function executeBatchOrder(sfWebRequest $request)
  {
    $newparent = $request->getParameter('newparent');

    //manually validate newparent parameter

    //make list of all ids
    $ids = array();
    foreach ($newparent as $key => $val)
    {
      $ids[$key] = true;
      if (!empty($val))
        $ids[$val] = true;
    }
    $ids = array_keys($ids);

    //validate if all id's exist
    $validator = new sfValidatorDoctrineChoiceMany(array('model' => 'Menu'));
    try
    {
      // validate ids
      $ids = $validator->clean($ids);

      // the id's validate, now update the menu
      $count = 0;

      foreach ($newparent as $id => $parentId)
      {
        if (!empty($parentId))
        {
          $node = Doctrine_Core::getTable('Menu')->find($id);
          $parent = Doctrine_Core::getTable('Menu')->find($parentId);

          if (!$parent->getNode()->isDescendantOfOrEqualTo($node))
          {
            $node->getNode()->moveAsFirstChildOf($parent);
            $node->save();

            $count++;
          }
        }
      }

      if ($count > 0)
      {
        $this->getUser()->setFlash('notice', sprintf("Menu order updated, moved %s item%s", $count, ($count > 1 ? 's' : '')));
      }
      else
      {
        $this->getUser()->setFlash('error', "You must at least move one item to update the menu order");
      }
    }
    catch (sfValidatorError $e)
    {
      $this->getUser()->setFlash('error', 'Cannot update the menu order, maybe some item are deleted, try again');
    }

    $this->redirect('@menu');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

    $object = $this->getRoute()->getObject();
    if ($object->getNode()->isValidNode())
    {
      $object->getNode()->delete();
    }
    else
    {
      $object->delete();
    }

    $this->getUser()->setFlash('notice', 'The item was deleted successfully.');

    $this->redirect('@menu');
  }

  public function executeAdd(sfWebRequest $request)
  {
    $this->executeNew($request);
    $this->form->setDefault('parent_id', $request->getParameter('id'));
    $this->setTemplate('edit');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $values = $request->getParameter($form->getName());
    if (!$values['article_id']) {
      $form->getValidator('url')->setOption('required', true);
    } else {
      $form->getValidator('article_id')->setOption('required', true);
    }
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $this->getUser()->setFlash('notice', $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.');

      $menu = $form->save();

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $menu)));

      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $this->getUser()->getFlash('notice').' You can add another one below.');
        $this->redirect('@menu_new');
      }
      else
      {
        $this->redirect('@menu_edit?id='.$menu['id']);
      }
    }
    else
    {
      $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.');
    }
  }
}
