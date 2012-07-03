<?php

class Doctrine_Template_Listener_Publishable extends Doctrine_Record_Listener {

  /**
   * Array of Publishable options
   *
   * @var string
   */
  protected $_options = array();

  /**
   * __construct
   *
   * @param string $array
   * @return void
   */
  public function __construct(array $options) {
    $this->_options = $options;
  }

  public function preInsert(Doctrine_Event $event) {
    $this->validateDates($event->getInvoker());
  }

  public function preUpdate(Doctrine_Event $event) {
    $this->validateDates($event->getInvoker());
  }

  protected function validateDates($object) {
    $time = time();
    $start = $this->_options['names'][0];
    $end = $this->_options['names'][1];
    if(!is_null($start) && !is_null($end) && strtotime($start) > strtotime($end))
    {
      throw new InvalidArgumentException("End publication date cannot be earlier than start publication date.", 500);
    }
  }

}