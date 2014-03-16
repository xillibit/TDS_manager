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
class GesttaxesejourModelDeclarations extends JModel {
  protected function populateState() {
		// Get the parent id if defined.
		$declaration_Id = JRequest::getInt('id');
		$this->setState('com_gesttaxesejour.declaration.Id', $declaration_Id);
	}
  
  public function getUserHostings() {
    $db = JFactory::getDBO();
    $user = JFactory::getUser();
    
    $query = "SELECT hosting.* FROM #__gesttaxesejour_hebergements AS hosting               
              WHERE hosting.userid={$db->quote($user->id)}";                             
    $db->setQuery((string)$query);
    $users_hosting = $db->loadObjectList();       
        
    // Check for a database error.
    if ($db->getErrorNum()) {
      JError::raiseWarning(500, $db->getErrorMsg());
      return false;
    }
    
    $hebergements_user = array();
    foreach($users_hosting as $hosting) {
      $hebergements_user[] = JHTML::_ ( 'select.option', $hosting->id, $hosting->hostingname );
    }
    $list = JHTML::_ ( 'select.genericlist', $hebergements_user, 'user_hebergement', 'class="inputbox" size="1"', 'value', 'text' );
    
    return $list;
  }
  
  public function getHostingTypes() {
    $db = JFactory::getDBO();
    
    $query = "SELECT * FROM #__gesttaxesejour_hebergements_type WHERE state=1";                   
    $db->setQuery((string)$query);
    $hosting_type = $db->loadObjectList();  
        
    // Check for a database error.
    if ($db->getErrorNum()) {
      JError::raiseWarning(500, $db->getErrorMsg());
      return false;
    }
    
    $hebergement_type = array();
    foreach($hosting_type as $id=>$hosting) {
      $hebergement_type[] = JHTML::_ ( 'select.option', $id, $hosting->name );
    }
    $list = JHTML::_ ( 'select.genericlist', $hebergement_type, 'types_hebergement', 'class="inputbox" size="1"', 'value', 'text' );
    
    return $list; 
  } 
  
  public function getDeclarations() {
    $db = JFactory::getDBO();
    $user = JFactory::getUser();
    
    $query = "SELECT decl.*, hosting.hostingname FROM #__gesttaxesejour_declarations AS decl 
              INNER JOIN #__gesttaxesejour_hebergements AS hosting ON decl.hebergement_id=hosting.id
              LEFT JOIN #__gesttaxesejour_paiement_done AS paiedone ON decl.id=paiedone.decl_id
              WHERE decl.declarant_userid={$db->quote($user->id)}";                   
    $db->setQuery((string)$query);
    $declarations_user = $db->loadObjectList();     
    
    // Check for a database error.
    if ($db->getErrorNum()) {
      JError::raiseWarning(500, $db->getErrorMsg());
      return false;
    }
    
    return $declarations_user;
  } 
  
  public function getTotalDeclaration() {
    $db = JFactory::getDBO();
    $user = JFactory::getUser();
    $application = JFactory::getApplication();
    
    $idsSelected = $application->getUserState('com_gesttaxesejour_recap_ids');
    
    $idsSelected = implode(',',$idsSelected);
    
    $query = "SELECT SUM(montant_encaisse_sejour) FROM #__gesttaxesejour_declarations             
              WHERE declarant_userid={$db->quote($user->id)} AND id IN (".$idsSelected.")";                   
    $db->setQuery((string)$query);
    $totalDeclaration = $db->loadResult();     
    
    // Check for a database error.
    if ($db->getErrorNum()) {
      JError::raiseWarning(500, $db->getErrorMsg());
      return false;
    }     
    
    return $totalDeclaration;
  }
  
  public function getDetailsDecSelected() {
    $application = JFactory::getApplication();
    $db = JFactory::getDBO();
    
    $idsSelected = $application->getUserState('com_gesttaxesejour_recap_ids');    
        
    if ( !empty($idsSelected) ) {
    
      $idsSelected = implode(',',$idsSelected);    
    
      $query = "SELECT * FROM #__gesttaxesejour_declarations AS decl                             
                WHERE id IN (".$idsSelected.")";                   
      $db->setQuery((string)$query);
      $declarations_sel = $db->loadObjectList();     
      
      // Check for a database error.
      if ($db->getErrorNum()) {
        JError::raiseWarning(500, $db->getErrorMsg());
        return false;
      }
      
      return $declarations_sel;
    }
    return;
  }
  
  public function getMontantByDeclaration() {
    $application = JFactory::getApplication();
    $db = JFactory::getDBO();
    $idsSelected = $application->getUserState('com_gesttaxesejour_recap_ids');
    
    $idsSelected = implode(',',$idsSelected);    
    
    // changer le LEFT JOIN par un INNER JOIN aprés avoir vérifier qu'on a les bonnes données
    
    $query = "SELECT decl.*, reg.* FROM #__gesttaxesejour_declarations AS decl
              LEFT JOIN #__gesttaxesejour_reglements AS reg ON decl.id=reg.declaration_id              
             WHERE decl.id IN (".$idsSelected.")";                      
    $db->setQuery((string)$query);
    $declarations_sel = $db->loadObjectList();     
      
    // Check for a database error.
    if ($db->getErrorNum()) {
      JError::raiseWarning(500, $db->getErrorMsg());
      return false;
    }
    
    return $declarations_sel;
  }
  
  public function getDetailsHebergeur() {
    $db = JFactory::getDBO();
    $user = JFactory::getUser();    
    
    if ( $user->id > 0 ) {    
      $query = "SELECT * FROM #__gesttaxesejour_users              
                  WHERE userid={$db->quote($user->id)}";                   
      $db->setQuery((string)$query);
      $detailsHebergeur = $db->loadObject();
      
      // Check for a database error.
      if ($db->getErrorNum()) {
        JError::raiseWarning(500, $db->getErrorMsg());
        return false;
      }
      
      return $detailsHebergeur;
    } else {    
      return;
    }
  }
  
  public function getPayementMethods() {
    $db = JFactory::getDBO();
    
    $query = "SELECT * FROM #__gesttaxesejour_methods_paiement              
                  WHERE state=1";                   
    $db->setQuery((string)$query);
    $paiementMethods = $db->loadObjectList();
      
    // Check for a database error.
    if ($db->getErrorNum()) {
      JError::raiseWarning(500, $db->getErrorMsg());
      return false;
    }
    
    return $paiementMethods;
  }
}
