<?php
/**
 * @package		Joomla.Site
 * @subpackage	Contact
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

class GesttaxesejourControllerHebergements extends JController {
  public function edit() {
    $app	= JFactory::getApplication();
    $task = JRequest::getCmd('task');
    
    $app->setUserState( 'com_gesttaxesejour.hebergement.editmode', '1' );
    
    // redirect back if nothing is selected
    $cids = JRequest::getVar ( 'cid', array (), 'post', 'array' );
    
    if ( !empty($cids) ) {
      $id = array_shift($cids);
      
      $app->setUserState( "com_gesttaxesejour.edit.hebergement.id", $id );
    }
    
    $this->setRedirect(JRoute::_('index.php?option=com_gesttaxesejour&view=hebergements&layout=edit', false));
    return false;
  }
  
  public function create() {
    $app	= JFactory::getApplication();
    
    // unset hebergement id 
    $id = $app->getUserState( 'com_gesttaxesejour.edit.hebergement.id' );
    if ( $id ) $app->setUserState( 'com_gesttaxesejour.edit.hebergement.id', null );
    
    $app->setUserState( 'com_gesttaxesejour.hebergement.editmode', null );
    
    $this->setRedirect(JRoute::_('index.php?option=com_gesttaxesejour&view=hebergements&layout=edit', false));
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
      $edit_mode = JRequest::getInt('edit_mode');      
            
      $db = JFactory::getDBO();
      
      if ( $edit_mode ) {
        $hebergement_id = JRequest::getInt('hebergement_id',0);
      
        // si c'est l'édition d'un hébergement existant
        $query = "UPDATE #__gesttaxesejour_hebergements 
                  SET hostingname={$db->quote($post['hostingname'])},description={$db->quote($post['description'])},adress={$db->quote($post['adress'])},complement_adress={$db->quote($post['complement_adress'])},city={$db->quote($post['city'])},website={$db->quote($post['website'])},postalcode={$db->quote($post['postalcode'])},numero_classement={$db->quote($post['numero_classement'])},date_classement={$db->quote($post['date_classement'])},id_hebergement_label={$db->quote($post['labels'])} 
                  WHERE id={$hebergement_id}"; 
        $db->setQuery((string)$query);
        $db->Query();  
        
        // Check for a database error.
      	if ($db->getErrorNum()) {
      	 JError::raiseWarning(500, $db->getErrorMsg());
      	 return false;
      	} 
      	
      	$app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_EDITED_SUCCESSFULLY') );
      } else {
        $date_now = JFactory::getDate('now')->toUnix(); 
        
        $this->_upload();
                      
        // Si c'est un nouvel hébergement, on enregistre de nouvelles données
        $query = "INSERT INTO #__gesttaxesejour_hebergements 
                  (hostingname,description,adress,complement_adress,city,website,postalcode,numero_classement,date_classement, date_enregistre, userid, id_hebergement_label) 
                  VALUES({$db->quote($post['hostingname'])},{$db->quote($post['description'])},{$db->quote($post['adress'])},{$db->quote($post['complement_adress'])},{$db->quote($post['city'])}, {$db->quote($post['website'])},{$db->quote($post['postalcode'])},{$db->quote($post['numero_classement'])},{$db->quote($post['date_classement'])},{$db->quote($date_now)}, {$db->quote(intval($user->id))},{$db->quote($post['labels'])} )";                   
        $db->setQuery((string)$query);
        $db->Query();
        $hosting_id = $db->insertid();
        
        // faire que l'hébergement appartienne à l'utilisateur courant
        $query = "INSERT INTO #__gesttaxesejour_users_hosting_owned 
                  (hosting_id,user_id) 
                  VALUES({$db->quote($hosting_id)},{$db->quote($user->id)})";
        $db->setQuery((string)$query);
        $db->Query();
        
        // Check for a database error.
      	if ($db->getErrorNum()) {
      	 JError::raiseWarning(500, $db->getErrorMsg());
      	 return false;
      	}
      	
      	$app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_NEW_HEBERGEMENT_SAVED') );
        $this->setRedirect(JRoute::_('index.php?option=com_gesttaxesejour&view=hebergements', false));
    	}
  	} else {
      $app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_NOT_LOGGUED') );
    }
  }
  
  protected function _upload() {
    jimport( 'joomla.filesystem.file' );
    $app	= JFactory::getApplication();
    
    if(isset($_FILES['hostingimage'])) { 
     $dossier = 'upload/';
     $extensions = array('png', 'gif', 'jpg', 'jpeg');
     $mimes_allowed = array('image/gif', 'image/jpeg', 'image/png', 'image/pjpeg', 'image/x-png');
     
     $filename = $_FILES['hostingimage']['name'];
     $tmp_filename = $_FILES['hostingimage']['tmp_name'];
     
     $extension = JFile::getExt($filename);
     
     $taille = filesize($tmp_filename);
     /*if ( $taille>$taille_allowed ) {
      $app->enqueueMessage ( JText::sprintf('COM_GESTTAXESEJOUR_NEW_HEBERGEMENT_IMAGE_SIZE_NOT_ALLOWED', $taille_allowed) );
     }  */
          
     // Detect MIME type
     $filemimetype = mime_content_type($tmp_filename);
          
     if(!in_array($filemimetype, $mimes_allowed)) {
        $app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_NEW_HEBERGEMENT_IMAGE_MIME_REQ_NOT') );
     }
          
     // on supprime tous les caractéres accentués
     $filename = preg_replace('/([^.a-z0-9]+)/i', '-', $filename);
     
     if(!in_array($extension, $extensions)) {
        $app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_NEW_HEBERGEMENT_IMAGE_EXTENSION_REQ_NOT') );
     }
         
     if(move_uploaded_file($tmp_filename, JPATH_ROOT.'/media/com_gesttaxesejour/hosting/'.$filename)) {
          $upload = $this->_save_upload_db($filename, $taille);
          if ( $upload ) $app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_NEW_HEBERGEMENT_IMAGE_SAVED') );
          else $app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_NEW_HEBERGEMENT_IMAGE_DB_FAILED') );
     } else {
          $app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_NEW_HEBERGEMENT_IMAGE_UPLOAD_FAILED') );
     }     
    }
  }
  
  protected function _save_upload_db($name, $size) {
    $db = JFactory::getDBO();
    
    $query = "INSERT INTO #__gesttaxesejour_attachments (name,size) VALUES({$db->quote($name)},{$db->quote($size)})";
    $db->setQuery((string)$query);
    $db->Query();
    
    // Check for a database error.
    if ($db->getErrorNum()) {
      JError::raiseWarning(500, $db->getErrorMsg());
    	return false;
    }
    
    return true;
  }
  
  public function delete() {
    $app	= JFactory::getApplication();
    $user = JFactory::getUser();
    // Check for request forgeries.		
    if (! JRequest::checkToken ()) {
      $app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TOKEN'), 'error' );
      $app->redirect($this->baseurl);
    }       
    
    $cids = JRequest::getVar ( 'cid', array (), 'post', 'array' );    
    
    if ( $user->id > 0 ) {
      $db = JFactory::getDBO();
      $query = "DELETE FROM #__gesttaxesejour_hebergements WHERE id IN ({$db->quote($id)})";
      $db->setQuery((string)$query);
      $db->Query();
      
      // Check for a database error.
    	if ($db->getErrorNum()) {
    	 JError::raiseWarning(500, $db->getErrorMsg());
    	 return false;
    	}
      
      $app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_DELETED') );
    } else {
      $app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_NOT_LOGGUED') );
    }
  }
  
  public function publish() {
    $app	= JFactory::getApplication();
    // Check for request forgeries.		
    if (! JRequest::checkToken ()) {
      $app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TOKEN'), 'error' );
      $app->redirect($this->baseurl);
    }
    
    $this->setState($id, '1');    
  }
  
  public function unpublish() {
    $app	= JFactory::getApplication();
    // Check for request forgeries.		
    if (! JRequest::checkToken ()) {
      $app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TOKEN'), 'error' );
      $app->redirect($this->baseurl);
    }
    
    $this->setState($id, '0');    
  }
  
  public function setState($id, $state) {
    $app	= JFactory::getApplication();
    $db = JFactory::getDBO(); 
    
    if ( $user->id > 0 ) {
      $query = "UPDATE #__gesttaxesejour_hebergements WHERE id={$db->quote($id)}";
      $db->setQuery((string)$query);
      $db->Query();
      
      // Check for a database error.
    	if ($db->getErrorNum()) {
    	 JError::raiseWarning(500, $db->getErrorMsg());
    	 return false;
    	}
    	
    	if ( !$state ) $app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_UNPUBLISHED') );
    	else $app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_PUBLISHED') );
    } else {
      $app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_NOT_LOGGUED') );
    }  	 
  }
  
  public function periode_ouverture() {    
    // redirect to the view
    
    $this->setRedirect(JRoute::_('index.php?option=com_gesttaxesejour&view=hebergements&layout=periode_ouverture', false));
    return false;
  }
  
  public function save_period() {
    $app	= JFactory::getApplication();
    $db = JFactory::getDBO();
    // Check for request forgeries.		
    if (! JRequest::checkToken ()) {
      $app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TOKEN'), 'error' );
      $app->redirect($this->baseurl);
    }
    
    if ( $user->id > 0 ) {
      $post = JRequest::get('post', JREQUEST_ALLOWRAW);
              
      $query = "INSERT INTO #__gesttaxesejour_periode_ouverture 
                    (date_fermeture,date_ouverture,motif,id_hebergement) 
                    VALUES({$db->quote($post['fermee_depuis'])},{$db->quote($post['reouverture_le'])},{$db->quote($post['motif'])},{$db->quote($post['hebergement_list'])} )";                                         
      $db->setQuery((string)$query);
      $db->Query();
          
      // Check for a database error.
      if ($db->getErrorNum()) {
        JError::raiseWarning(500, $db->getErrorMsg());
        return false;
      }
      
      $app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_PERIOD_OUVERTURE_SAVED_SUCCESSFULLY') );
    } else {
      $app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_NOT_LOGGUED') );
    }
  }    
}