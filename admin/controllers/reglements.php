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
 * Reglements list controller class.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_gesttaxesejour
 * @since       1.6
 */
class TdsmanagerAdminControllerReglements extends TdsmanagerController {
  /**
	 * Constructor.
	 *
	 * @param	array An optional associative array of configuration settings.
	 * @see		JController
	 * @since	1.6
	 */
	public function __construct($config = array()) {
		parent::__construct($config);
		$this->baseurl = 'index.php?option=com_tdsmanager&view=reglements'; 		
	}
	
	public function validpaiement() {
    // Check for request forgeries.		
    if (! JRequest::checkToken ()) {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }
    
    $ids = JRequest::getVar ( 'cid', array (), 'post', 'array' );
    if ( !empty($ids) ) {      
      $db = JFactory::getDBO();
      $query = "UPDATE #__gesttaxesejour_reglements SET finaliser='1' WHERE id IN ($ids)";
      $db->setQuery((string)$query);
      $db->Query(); 
      
      if ($db->getErrorNum()) {
  			JError::raiseWarning(500, $db->getErrorMsg());
  			return false;
  		}
      
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_REGLEMENT_VALIDATED'), 'error' );
      $this->app->redirect($this->baseurl);
    } else {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_NOTHING_SELECTED'), 'error' );
      $this->app->redirect($this->baseurl);
    } 
  }
  
  // Relancer les personnes qui n'ont pas payé, en leur envoyant un mail. Ceci est une procédure manuelle
  public function relaunch() {
    // Check for request forgeries.		
    if (! JRequest::checkToken ()) {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }
    
    $ids = JRequest::getVar ( 'cid', array (), 'post', 'array' );
    if ( !empty($ids) ) {
      // Vérifier avant d'envoyer le mail que le réglement n'a pas été fait 
      $db = JFactory::getDBO();
      $query = "SELECT * FROM #__gesttaxesejour_reglements WHERE id IN ($ids) AND finaliser='0'";
      $db->setQuery((string)$query);
      $items = $db->loadObjectList(); 
      
      if ($db->getErrorNum()) {
  			JError::raiseWarning(500, $db->getErrorMsg());
  			return false;
  		}  
  		
  		if ( !empty($items) ) {      
        jimport( 'joomla.mail.mail' );
        $mailer = JFactory::getMailer();
        $config = JFactory::getConfig();
        $sender = array( $config->getValue( 'config.mailfrom' ), $config->getValue( 'config.fromname' ) );
   
        $mailer->setSender($sender);
        // récupérer le message et le titre du message
        $body   = "Your body string\nin double quotes if you want to parse the \nnewlines etc";
        $mailer->setSubject('Your subject string');
        $mailer->setBody($body);
        
        // envoyer le mail
        $send = $mailer->Send();
        if ( $send !== true ) {
          $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_REGLEMENTS_RELAUNCH_ERROR'), 'error' );
          $this->app->redirect($this->baseurl);
        } else {
          $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_REGLEMENTS_RELAUNCH_MAIL_SENT') );
          $this->app->redirect($this->baseurl);
        }
      } else {
        $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_REGLEMENTS_SELECTED_ALREADY_FINALISER'), 'error' );
        $this->app->redirect($this->baseurl);
      }
    } else {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_NOTHING_SELECTED'), 'error' );
      $this->app->redirect($this->baseurl);
    }
  }
  
  public function add() {
    // rediriger vers la bonne vue
    $this->setRedirect('index.php?option=com_gesttaxesejour&view=reglements&layout=create');
  }
  
  public function savepaiement() {
    // Check for request forgeries.		
    if (! JRequest::checkToken ()) {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }
    
    $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_REGLEMENT_SAVED_SUCESSFULLY'), 'error' );
    $this->app->redirect($this->baseurl);
  }
}