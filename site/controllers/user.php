<?php
/**
 * @package		Joomla.Site
 * @subpackage	Contact
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

class GesttaxesejourControllerUser extends JControllerForm {
  public function edit() {
    $app	= JFactory::getApplication();    
    // Check for request forgeries.		
    if (! JRequest::checkToken ()) {
      $app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TOKEN'), 'error' );
      $app->redirect($this->baseurl);
    }
          
    $this->setRedirect(JRoute::_('index.php?option=com_gesttaxesejour&view=user&layout=edit', false));
    return false;
  }
  
  public function save() {
    $app	= JFactory::getApplication();
    $user = JFactory::getUser();
    
    // Check for request forgeries.		
    if (! JRequest::checkToken ()) {
      $app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TOKEN'), 'error' );
      $app->redirect($this->baseurl);
    }    
    
    if ( $user->id > 0 ) {    
      $post = JRequest::get('post', JREQUEST_ALLOWRAW);
      $db = JFactory::getDBO();
      
      if ( !empty($post) ) {      
        $query = "UPDATE #__gesttaxesejour_users 
                    SET name={$db->quote($post['name'])},lastname={$db->quote($post['lastname'])},adress={$db->quote($post['adress'])},complement_adress={$db->quote($post['complement_adress'])},ville={$db->quote($post['ville'])},postalcode={$db->quote($post['postalcode'])},portable={$db->quote($post['portable'])},telephone={$db->quote($post['telephone'])},mail={$db->quote($post['mail'])} WHERE userid={$db->quote($post['userid'])}";        
        $db->setQuery((string)$query);
        $db->Query();       
                 
        // Check for a database error.
        if ($db->getErrorNum()) {
          JError::raiseWarning(500, $db->getErrorMsg());
        	return false;
        } 
        
        $app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_PROFILE_EDITED_SUCCESSFULLY') ); 
      }           
  	} else {
      $app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_NOT_LOGGUED') );
    }
  }
}