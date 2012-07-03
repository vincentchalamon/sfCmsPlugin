<?php

class cmsIndexTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
    ));

    $this->namespace        = 'cms';
    $this->name             = 'index';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [cms:index|INFO] task update article index for search.
Call it with:

  [php symfony cms:index|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // Initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    // Update index
    ArticleTable::getInstance()->batchUpdateIndex();
  }
}
