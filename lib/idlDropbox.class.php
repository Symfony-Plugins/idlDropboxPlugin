<?php
/*
 * This file is part of the idlDropbox plugin
 * (c) 2010 Idael Software - http://www.idael.ch
 */

/**
 * This class give some tools to use Dropbox account in a Symfony project (https://www.dropbox.com/referrals/NTc5OTg0MzE5)
 * Some configuration are needed to use it.
 * In app.yml file, add the following dropbox key:
 * all:
 *   ...
 *    dropbox:
 *      consumer_key:               myconsumerkey
 *      consumer_secret:            myconsumersecret
 *      user:                       mydropboxemail@test.com
 *      password:                   MySecretPassword
 * 
 * You have to get consumer_key and consumer_secret by subscribing as Dropbox developper on Dropbox website. 
 * @author Gael Poffet <gael.poffet (at) idael.ch>
 * @package    idlDropboxPlugin
 * 
 */

class idlDropbox {
  
  private $consumerKey;
  private $consumerSecret;
  private $user;
  private $password;
  private $dropbox;
  
  /**
   * idlDropbox constructor
   */
  public function __construct(){
    
    //Let's retreive the config from app.yml
    $this->consumerKey = sfConfig::get("app_dropbox_consumer_key", "");
    $this->consumerSecret = sfConfig::get("app_dropbox_consumer_secret", "");
    $this->user = sfConfig::get("app_dropbox_user", "");
    $this->password = sfConfig::get("app_dropbox_password", "");
    $this->OAuthLib = sfConfig::get("app_dropbox_oauth_lib", "PHP");
    
    //Config validation
    if($this->consumerKey == "" || $this->consumerSecret == "")
      throw new Exception ("You must define 'consumer_key' and 'consumer_secret' in app.yml file!");
    if($this->user == "" || $this->password == "")
      throw new Exception ("You must define 'user' and 'password' in app.yml file !");
      
    //And now we authenticate ourself on dropbox API using OAuth
    $className = "Dropbox_OAuth_".$this->OAuthLib;
    $this->oauth = new $className($this->consumerKey, $this->consumerSecret);
    $this->dropbox = new Dropbox_API($this->oauth);
    $this->tokens = $this->dropbox->getToken($this->user, $this->password);
    //We store the token for future usage
    $this->oauth->setToken($this->tokens);    
  }
  
  /*
   * Upload function
   * @param $localFile the file to upload with his full path
   * @param $targetFile the target file on dropbox account with the full path but WITHOUT starting "/"
   */
  public function upload($localFile, $targetFile){
    $result = $this->dropbox->putFile($targetFile, $localFile);
    if(!$result){
      throw new Exception("Dropbox upload failed");
    }
  }
  
  /**
   * Account information function. It logs all Dropbox account info
   */
  public function getAccountInfo(){
    return $this->dropbox->getAccountInfo();
  }
  
  /**
   * 
   * @param String $path The new folder full path
   * @param String $root By default "dropbox" (null but set later to "dropbox" if null). 
   *                     Could be also changed to "sandbox" as soon as Dropbox team give sandbox environnment again.
   */
  public function createFolder($path, $root = null) {
    return $this->dropbox->createFolder($path, $root);
  }
}