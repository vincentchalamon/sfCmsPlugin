<?php

class Doctrine_Template_Publishable extends Doctrine_Template
{
    const NEVER_PUBLISHED = 0;
    const PUBLISHED = 1;
    const PRE_PUBLISHED = 2;
    const UNPUBLISHED = 3;
    const POST_PUBLISHED = 4;
    const PUBLISHED_TEMP = 5;

    public static function getPublicationStates()
    {
        $states = array();
        for ($i = 0; $i <= 5; $i++) {
            $states[$i] = self::getPublicationLabel($i);
        }
        return $states;
    }
    
    /**
     * Array of Publishable options
     *
     * @var string
     */
    protected $_options = array(
        'type' => 'timestamp',
        'names' => array('started_at', 'ended_at')
    );

    /**
     * Set table definition for Publishable behavior
     *
     * @return void
     */
    public function setTableDefinition()
    {
        $this->hasColumn($this->_options['names'][0], $this->_options['type']);
        $this->hasColumn($this->_options['names'][1], $this->_options['type']);
        $this->addListener(new Doctrine_Template_Listener_Publishable($this->_options));
    }

    /**
     * Find all published objects
     *
     * @param string $time Comparison time
     * @param string $order Query order or null for default order (started_at ASC)
     * @param int $limit Query limit or null for no limit
     * @return Doctrine_Collection Published objects
     */
    public function findAllPublishedTableProxy($time = "now", $order = null, $limit = null, Doctrine_Query $query = null)
    {
        $time = date('Y-m-d H:i:s', strtotime($time));
        if (is_null($query)) {
            $query = $this->getInvoker()->getTable()->createQuery("q");
        }
        $query->andWhere(sprintf("%s.%s <= ?", $query->getRootAlias(), $this->_options['names'][0]), $time)
                ->andWhere(sprintf("%s.%s IS NULL OR %s.%s >= ?", $query->getRootAlias(), $this->_options['names'][1], $query->getRootAlias(), $this->_options['names'][1]), $time)
                ->orderBy(sprintf("%s.%s", $query->getRootAlias(), is_null($order) ? $this->_options['names'][0]." ASC" : $order));
        return is_null($limit) ? $query->execute() : $query->limit($limit)->execute();
    }

    /**
     * Test if object is published
     *
     * @param string $time Comparison time
     * @return Boolean True if object is published, false otherwise
     */
    public function isPublished($time = "now")
    {
        $time = strtotime($time);
        $object = $this->getInvoker();
        $start = $object[$this->_options['names'][0]];
        $end = $object[$this->_options['names'][1]];
        return !is_null($start) && strtotime($start) <= $time && (is_null($end) || strtotime($end) >= $time);
    }

    public function getPublicationState()
    {
        $object = $this->getInvoker();
        $time = time();
        $start = $object[$this->_options['names'][0]];
        $end = $object[$this->_options['names'][1]];
        if (is_null($start) && is_null($end)) {
            return self::getPublicationLabel(self::NEVER_PUBLISHED);
        } elseif (!is_null($start) && strtotime($start) <= $time && is_null($end)) {
            return self::getPublicationLabel(self::PUBLISHED);
        } elseif (!is_null($start) && strtotime($start) > $time && (is_null($end) || strtotime($end) > $time)) {
            return self::getPublicationLabel(self::PRE_PUBLISHED);
        } elseif (is_null($start) && !is_null($end)) {
            return self::getPublicationLabel(self::UNPUBLISHED);
        } elseif (!is_null($start) && strtotime($start) < $time && !is_null($end) && strtotime($end) < $time) {
            return self::getPublicationLabel(self::POST_PUBLISHED);
        } elseif (!is_null($start) && strtotime($start) <= $time && !is_null($end) && strtotime($end) >= $time) {
            return self::getPublicationLabel(self::PUBLISHED_TEMP);
        }
    }

    public static function getPublicationLabel($code)
    {
        switch ($code) {
            default:
            case self::NEVER_PUBLISHED:
                return "Jamais publié";
                break;
            case self::PUBLISHED:
                return "Publié";
                break;
            case self::PRE_PUBLISHED:
                return "Pré-publié";
                break;
            case self::UNPUBLISHED:
                return "Dépublié";
                break;
            case self::POST_PUBLISHED:
                return "Post-publié";
                break;
            case self::PUBLISHED_TEMP:
                return "Publié temporairement";
                break;
        }
    }

    public function publish($start = "now", $end = null)
    {
        $object = $this->getInvoker();
        $object[$this->_options['names'][0]] = date('Y-m-d H:i:s', strtotime($start));
        $object[$this->_options['names'][1]] = !is_null($end) ? date('Y-m-d H:i:s', strtotime($end)) : null;
        $object->save();
    }

    public function unpublish()
    {
        $object = $this->getInvoker();
        $object[$this->_options['names'][0]] = null;
        $object->save();
    }
}