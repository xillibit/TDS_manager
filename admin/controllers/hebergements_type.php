<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_gesttaxesejour
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

require_once JPATH_ADMINISTRATOR . '/components/com_tdsmanager/libraries/controller.php';

/**
 * Hebergements list controller class.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_gesttaxesejour
 * @since       1.6
 */
class TdsmanagerAdminControllerHebergements_type extends TdsmanagerController {
   protected $baseurl = null;
    /**
	 * Constructor.
	 *
	 * @param	array An optional associative array of configuration settings.
	 * @see		JController
	 * @since	1.6
	 */
	public function __construct($config = array()) {
		parent::__construct($config);
		$this->baseurl = 'index.php?option=com_tdsmanager&view=hebergements_type';    		
	}
	
	public function remove() {
    // Check for request forgeries.		
    if (! JRequest::checkToken ()) {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }
    
    $db = JFactory::getDBO();
    
    $cids = JRequest::getVar ( 'cid', array (), 'post', 'array' );
    $id = array_shift($cids);    
    
    $query = "DELETE FROM #__gesttaxesejour_hebergements_type WHERE id={$db->quote($id)}";
    $db->setQuery((string)$query);
    $db->Query();
      
    // Check for a database error.
    if ($db->getErrorNum()) {
      JError::raiseWarning(500, $db->getErrorMsg());
    	return false;
    }
    
    $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_TYPE_DELETED_SUCCESSFULLY') );       
    $this->app->redirect($this->baseurl);
  }
  
  public function create() {
    // Check for request forgeries.		
    if (! JRequest::checkToken ()) {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }
    
    $this->app->setUserState( "com_gesttaxesejour.hebergement_type.id", 0 );
    
    $this->setRedirect('index.php?option=com_gesttaxesejour&view=hebergements_type&layout=create');
  }
  
  public function edit() {
    // Check for request forgeries.		
    if (! JRequest::checkToken ()) {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }
    
    $cids = JRequest::getVar ( 'cid', array (), 'post', 'array' );
    $id = array_shift($cids);
    
    $this->app->setUserState( "com_gesttaxesejour.hebergement_type.id", $id );	

		$this->setRedirect('index.php?option=com_gesttaxesejour&view=hebergements_type&layout=create');
  }
  
  public function save() {
    // Check for request forgeries.		
    if (! JRequest::checkToken ()) {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }
    
    $id = JRequest::getInt('id', 0);
    $post = JRequest::get('post', JREQUEST_ALLOWRAW);  
     
    $db = JFactory::getDBO();
    
     
    if ( !$id ) {
      $query = "INSERT INTO #__gesttaxesejour_hebergements_type 
                (name,description,state) 
                VALUES({$db->quote($post['name'])},{$db->quote($post['description'])},'1')";
       $db->setQuery((string)$query);
       $db->Query();
      
        // Check for a database error.
    		if ($db->getErrorNum()) {
    			JError::raiseWarning(500, $db->getErrorMsg());
    			return false;
    		}
      
       $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_TYPE_SAVED') );       
       $this->app->redirect($this->baseurl); 
    } else {
        $query = "UPDATE #__gesttaxesejour_hebergements_type 
                  SET name={$db->quote($post['name'])},description={$db->quote($post['description'])},state={$db->quote($post['state'])} WHERE id={$db->quote($id)}";
        $db->setQuery((string)$query);
        $db->Query();
      
        // Check for a database error.
    		if ($db->getErrorNum()) {
    			JError::raiseWarning(500, $db->getErrorMsg());
    			return false;
    		}
    
       $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_TYPE_EDITION_SAVED') );       
       $this->app->redirect($this->baseurl); 
    }
  }
}