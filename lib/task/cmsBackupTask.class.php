<?php

class cmsBackupTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
    ));

    $this->namespace        = 'cms';
    $this->name             = 'backup';
    $this->briefDescription = 'Export database in a local sql file.';
    $this->detailedDescription = <<<EOF
The [cms:backup|INFO] task export database in a local sql file.
Call it with:

  [php symfony cms:backup|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // Create dir if doesn't exist
    if(!is_dir(sfConfig::get('sf_data_dir').'/export')) {
      mkdir(sfConfig::get('sf_data_dir').'/export', 0777);
    }
    // Force 777 on export folder
    chmod(sfConfig::get('sf_data_dir').'/export', 0777);
    // Export database in sql
    $config = sfYaml::load(sfConfig::get('sf_config_dir')."/databases.yml");
    $database = isset($config[$options['env']]) ? array_merge($config['all'][$options['connection']]['param'], $config[$options['env']][$options['connection']]['param']) : $config['all'][$options['connection']]['param'];
    $host = preg_replace('/(.*)host=([^;]+)(.*)/i', '$2', $database['dsn']);
    $user = $database['username'];
    $password = $database['password'];
    $dbname = preg_replace('/(.*)dbname=([^;]+)(.*)/i', '$2', $database['dsn']);
    $filename = date('Y-m-d').".sql";
    system("mysqldump -h $host -u $user -p$password $dbname > data/export/$filename");
  }
}
