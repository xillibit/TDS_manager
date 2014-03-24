<?php
/**
bv * @package		Joomla.Site
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.model');

/**
 * @package		Joomla.Site
 * @subpackage	com_contact
 */
class GesttaxesejourModelUser extends JModel {
  public function getUserProfile() {
    $user = JFactory::getUser();
    $db = JFactory::getDBO();
        
    $query = "SELECT * FROM #__gesttaxesejour_users 
              WHERE userid={$user->id}";                   
    $db->setQuery((string)$query);
    $profile = $db->loadObject();  
        
    // Check for a database error.
    if ($db->getErrorNum()) {
      JError::raiseWarning(500, $db->getErrorMsg());
      return false;
    } 
    
    return $profile;
  }  	
}