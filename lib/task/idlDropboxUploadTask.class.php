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
 * Symfony task used to upload file to a Dropbox account
 * Two parameters are needed:
 *   - The local source file with his full path
 *   - The destination path with file name and WITHOUT starting "/"
 * Configuration: see idlDropbox.class.php file

 * Usage example:
 *   php symfony dropbox:upload --source=C:/myfile.pdf --target=test/myfile.pdf
 *
 */
class idlDropboxUploadTask extends idlDropboxTask {
  protected function configure(){
    $this->addOptions(array(
      new sfCommandOption('source', null, sfCommandOption::PARAMETER_REQUIRED, 'The local file to upload (full path)'),
      new sfCommandOption('target', null, sfCommandOption::PARAMETER_REQUIRED, 'The target file (full path)'),
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application to use', "frontend"),
    ));
    
    $this->namespace        = 'dropbox';
    $this->name             = 'upload';
    $this->briefDescription = 'Upload a file to Dropbox';
    $this->detailedDescription = <<<EOF
You must specify the source file full path and the destination file name with his path inside dropbox account. Don't put a starting "/" in the destination path.
Configuration for Dropbox account must be done in app.yml file. Optionaly you can give an application parameter to use an other app.yml file than the one in frontend application.
4 keys provided by Dropbox team must be defined in "dropbox" section:
 - consumer_key       #you can get it by registering as dropbox developper
 - consumer_secret
 - user               #the email address used as login in dropbox account 
 - password           #the dropbox account password
EOF;
  }

  protected function execute($args = array(), $options = array()){
    $db = $this->getDropbox();
    if(!file_exists($options["source"]))
      throw new Exception("The source file given as parameter for the dropbox task does not exist");
      
  
    $db->upload($options["source"], $options["target"]);
    $this->logSection("dropbox","Upload success");
  }
}