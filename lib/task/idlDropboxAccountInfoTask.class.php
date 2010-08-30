<?php

/*
 * This file is part of the idlDropbox plugin
 * (c) 2010 Idael Software - http://www.idael.ch
 */

/**
 * @package    idlDropboxPlugin
 * @subpackage Tasks
 * @author     Gael Poffet <gael.poffet (at) idael.ch> 
 */

/**
 * Symfony Task used to get Dropbox account information
 */
class idlDropboxAccountInfoTask extends idlDropboxTask {
  protected function configure(){
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application to use', "frontend"),
    ));
    
    $this->namespace        = 'dropbox';
    $this->name             = 'account-info';
    $this->briefDescription = 'Show Dropbox account information';
    $this->detailedDescription = <<<EOF
Configuration for Dropbox account must be done in app.yml file. Optionaly you can give an application parameter to use an other app.yml file than the one ine frontend application.
Two keys provided by Dropbox team must be defined in "dropbox" section:
 - consumer_key
 - consumer_secret
EOF;
  }

  protected function execute($args = array(), $options = array()){
    $db = $this->getDropbox();
    $this->log(print_r($db->getAccountInfo()));
  }
}
