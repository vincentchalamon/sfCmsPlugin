<?php

/**
 * PluginArticle form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormFilterPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginArticleFormFilter extends BaseArticleFormFilter
{

    public function setup()
    {
        parent::setup();

        // Search
        $this->widgetSchema['search'] = new sfWidgetFormInputText();
        $this->widgetSchema['search']->setAttribute("title", "Rechercher");
        $this->widgetSchema['search']->setAttribute("placeholder", "Rechercher");
        $this->widgetSchema['search']->setAttribute("alt", "Rechercher");
        $this->validatorSchema['search'] = new sfValidatorPass();

        // Publication
        $choices = array_merge(array(null => ''), Doctrine_Template_Publishable::getPublicationStates());
        $this->widgetSchema['publication'] = new sfWidgetFormSelect(array('choices' => $choices));
        $this->validatorSchema['publication'] = new sfValidatorChoice(array('choices' => array_keys($choices), "required" => false));
    }

    /**
     * Init search query using all text columns, and tags if table has template
     *
     * @param Doctrine_Query $query Search query
     * @param string $field Form field name
     * @param string $values Search value
     */
    public function addSearchColumnQuery(Doctrine_Query $query, $field, $values)
    {
        $where = "";
        $params = array();
        foreach ($this->getTable()->getColumns() as $name => $options) {
            if (in_array($options['type'], array('string', 'clob'))) {
                $where.= sprintf("%s %s.%s LIKE ?", count($params) ? " OR" : null, $query->getRootAlias(), $name);
                $params[] = "%$values%";
            }
        }
        // Tags
        if ($this->getTable()->hasTemplate('Taggable')) {
            $objects = TagTable::getObjectTaggedWithQuery($this->getTable()->getClassnameToReturn(), $values, $this->getTable()->createQuery()->where('deleted_at IS NULL'))->execute();
            if ($objects) {
                $ids = array();
                foreach ($objects as $object) {
                    if (!$object->getDeletedAt() && !in_array($object->getPrimaryKey(), $ids)) {
                        $ids[] = $object->getPrimaryKey();
                    }
                }
                if ($ids) {
                    $where.= sprintf("%s %s.id IN (%s)", count($params) ? " OR" : null, $query->getRootAlias(), implode(', ', $ids));
                }
            }
        }
        if (count($params)) {
            $query->andWhere("($where)", $params);
        }
    }

    public function addPublicationColumnQuery(Doctrine_Query $query, $field, $values)
    {
        switch ($values) {
            case Doctrine_Template_Publishable::NEVER_PUBLISHED:
                $query->andWhere($query->getRootAlias().".started_at IS NULL");
                $query->andWhere($query->getRootAlias().".ended_at IS NULL");
                break;
            case Doctrine_Template_Publishable::PUBLISHED:
                $query->andWhere($query->getRootAlias().".started_at IS NOT NULL AND ".$query->getRootAlias().".started_at <= NOW()");
                $query->andWhere($query->getRootAlias().".ended_at IS NULL");
                break;
            case Doctrine_Template_Publishable::PRE_PUBLISHED:
                $query->andWhere($query->getRootAlias().".started_at IS NOT NULL AND ".$query->getRootAlias().".started_at > NOW()");
                $query->andWhere($query->getRootAlias().".ended_at IS NULL OR ".$query->getRootAlias().".ended_at > NOW()");
                break;
            case Doctrine_Template_Publishable::PRE_PUBLISHED:
                $query->andWhere($query->getRootAlias().".started_at IS NOT NULL AND ".$query->getRootAlias().".started_at > NOW()");
                $query->andWhere($query->getRootAlias().".ended_at IS NULL OR ".$query->getRootAlias().".ended_at > NOW()");
                break;
            case Doctrine_Template_Publishable::UNPUBLISHED:
                $query->andWhere($query->getRootAlias().".started_at IS NULL");
                $query->andWhere($query->getRootAlias().".ended_at IS NOT NULL");
                break;
            case Doctrine_Template_Publishable::POST_PUBLISHED:
                $query->andWhere($query->getRootAlias().".started_at IS NOT NULL AND ".$query->getRootAlias().".started_at < NOW()");
                $query->andWhere($query->getRootAlias().".ended_at IS NOT NULL AND ".$query->getRootAlias().".ended_at < NOW()");
                break;
            case Doctrine_Template_Publishable::PUBLISHED_TEMP:
                $query->andWhere($query->getRootAlias().".started_at IS NOT NULL AND ".$query->getRootAlias().".started_at <= NOW()");
                $query->andWhere($query->getRootAlias().".ended_at IS NOT NULL AND ".$query->getRootAlias().".ended_at >= NOW()");
                break;
        }
    }
    
    public function buildQuery(array $values)
    {
        $query = parent::buildQuery($values);
        if ($this->getTable()->hasTemplate('SoftDelete')) {
            $query->andWhere($query->getRootAlias().'.deleted_at IS NULL');
        }
        return $query;
    }
}
