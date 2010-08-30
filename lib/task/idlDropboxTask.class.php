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

abstract class idlDropboxTask extends sfBaseTask {
  
  private $dropbox;
  /**
   * @return idlDropbox
   */
  public function getDropbox() {
	  if (!isset($this->dropbox)){
	    $this->dropbox = new idlDropbox(); //the Dropbox object creation and authentication
	  }
	  return $this->dropbox;
  }
  
}
