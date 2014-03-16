<?php
/**
 * @package		Joomla.Site
 * @subpackage	Contact
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

class GesttaxesejourControllerDispos extends JControllerForm {
  public function confirmdelete() {
    $app = JFactory::getApplication();
    $ids = JRequest::getVar ( 'cid', array (), 'post', 'array' );
    
    if( !empty($ids) ) {
       $app->setUserState('com_gesttaxesejour.dispos.ids.delete',$ids);
       // rediriger l'utilisateur vers la page de confirmation
       $this->setRedirect(JRoute::_('index.php?option=com_gesttaxesejour&view=dispos&layout=confirmdelete', false));
       return false;
    } else {
      // afficher un message pour dire qu'il n'y a aucun élément sélectionné
    }
  }
  
  public function delete(){
    $app = JFactory::getApplication();
    $db = JFactory::getDBO();
    
    $ids = $app->getUserState('com_gesttaxesejour.dispos.ids.delete');
        
    $ids = implode(',',$ids);   
        
    $query = "DELETE FROM #__gesttaxesejour_dispos WHERE id IN ({$ids})";
    $db->setQuery((string)$query);
    $db->query();
                
    // Check for a database error.
    if ($db->getErrorNum()) {
      JError::raiseWarning(500, $db->getErrorMsg());
      $message = JText::_('COM_GESTTAXESEJOUR_DISPOS_DELETED_FAILED');
      return false;
    }     
  }
  
  public function savedispos() {
    $app = JFactory::getApplication();
    $db = JFactory::getDBO();
    
    $hosting_id = $app->getUserState( 'com_gesttaxesejour.dispos.hostingid' ); 
    $capacite_chambres = JRequest::getInt('capacite_chambres', 0); 
    $startDate = JRequest::getString('startDate');
    $endDate = JRequest::getString('endDate');
    $updatedispos = JRequest::getInt('updatedispos',0);
    /* Enregistrer dans la base les dispos */
    $chambres_dispos_simple = JRequest::getInt('chambres_dispos_simple',0);
    $chambres_dispos_double = JRequest::getInt('chambres_dispos_double',0);
        
    if ( $updatedispos ) {
      $id_dispos = JRequest::getInt('id_dispos',0);
        
      $query = "UPDATE #__gesttaxesejour_dispos SET startdate={$db->quote($startDate)},enddate={$db->quote($endDate)} WHERE id={$db->quote($id_dispos)}";
      $db->setQuery((string)$query);
      $db->query();
                
      // Check for a database error.
      if ($db->getErrorNum()) {
        JError::raiseWarning(500, $db->getErrorMsg());
        $message = JText::_('COM_GESTTAXESEJOUR_DISPOS_EDIT_FAILED');
        return false;
      }
      
      $app->enqueueMessage ( 'Votre disponiblité a bien été enregistrée');
      $app->redirect(JRoute::_('index.php?option=com_gesttaxesejour&view=dispos')); 
    } else {
      $query = "INSERT INTO #__gesttaxesejour_dispos (startdate,enddate,id_hebergement) VALUES({$db->quote($startDate)},{$db->quote($endDate)},{$db->quote($hosting_id)})";
      $db->setQuery((string)$query);
      $db->query();
                
      // Check for a database error.
      if ($db->getErrorNum()) {
        JError::raiseWarning(500, $db->getErrorMsg());
        $message = JText::_('COM_GESTTAXESEJOUR_DISPOS_SAVED_FAILED');
        return false;
      }
      
      $app->enqueueMessage ( 'Votre nouvelle disponiblité a bien été enregistrée');
      $app->redirect(JRoute::_('index.php?option=com_gesttaxesejour&view=dispos'));
    }   
  }   
  
  public function edit_dispos() {
    $app = JFactory::getApplication();
    $hosting_id = JRequest::getInt('id',0);
  
    $model = $this->getModel();
   
    $dispo = $model->getDispo($hosting_id);
    
    $app->setUserState( 'com_gesttaxesejour.dispos.dispo', $dispo );
  
    $this->setRedirect(JRoute::_('index.php?option=com_gesttaxesejour&view=dispos&layout=dispos_calendar', false));
    return false;
  }
  
  public function ch_dispos() {
    $this->setRedirect(JRoute::_('index.php?option=com_gesttaxesejour&view=dispos&layout=choix_hebergement', false));
    return false;
  }
  
  public function dispos() {
    $app = JFactory::getApplication();
    
    $hosting = JRequest::getInt('user_hebergement',0);
    
    $app->setUserState( 'com_gesttaxesejour.dispos.hostingid', $hosting );
    
    $model = $this->getModel();
   
    $capacite_chambres = $model->getCapaciteChambresMax($hosting);
        
    $app->setUserState( 'com_gesttaxesejour.dispos.capacite', $capacite_chambres );        
    
    $this->setRedirect(JRoute::_('index.php?option=com_gesttaxesejour&view=dispos&layout=dispos_calendar', false));
    return false; 
  }
  
  public function search_dispos() {
    $app = JFactory::getApplication();
    $db = JFactory::getDBO();
    
    $startsejourdate = JRequest::getString('startsejourdate');
    $startsejourdate = JFactory::getDate($startsejourdate )->toUnix ();
    $dureesejour = JRequest::getInt('duree_sejour');
    $id_type_hebergement = JRequest::getInt('dispos_types_hebergement', 0);
    
    $where = array();
    if( $id_type_hebergement != 0 ) {
      $where[] = " WHERE type.id={$db->quote($id_type_hebergement)}";
    }
    
    $choix_commune = JRequest::getString('choix_commune');
    if ( $choix_commune != 'indifferent' ) {
      $where[] = "city LIKE %{$choix_commune}%";
    }
    
    $nb_peronnes = JRequest::getInt('nb_peronnes', 0);
    /* Necessaire de créer un champ dans la table hébergements pour entrer le nombre de personnes disponibles
    if ( $nb_peronnes != 0 ) {
      $where[] = "={$db->quote($nb_peronnes)}";
    } */
    
    $where = implode(' AND ',$where);
        
    // calcul de la date de fin du séjour par rapport à la date de début
    $dureesejour = $dureesejour*3600;
    $startdatetounix = JFactory::getDate($startsejourdate)->toUnix ();
    $startdatetounix = $startdatetounix+$dureesejour;
    
    $finsejour = JFactory::getDate($startdatetounix)->toSql();       
    
    $query = "SELECT hosts.*, type.name AS hosting_type_name, UNIX_TIMESTAMP(disp.startdate) AS dispstartdate,UNIX_TIMESTAMP(disp.enddate) AS dispendate FROM #__gesttaxesejour_dispos AS disp 
              INNER JOIN #__gesttaxesejour_hebergements AS hosts ON disp.id_hebergement=hosts.id
              INNER JOIN #__gesttaxesejour_hebergements_type AS type ON type.id=hosts.id_hebergement_type
              ".$where;                          
    $db->setQuery((string)$query);
    $dispos = $db->loadObjectList();
              
    // Check for a database error.
    if ($db->getErrorNum()) {
      JError::raiseWarning(500, $db->getErrorMsg());
      $message = JText::_('COM_GESTTAXESEJOUR_SEARCH_DISPOS_FAILED');
      return false;
    }
    
    // Remise en forme pour la query
    $query_user = '';
    if ( $nb_peronnes == 0 ) {
      $nb_personnes_query = 'pour un nombre indéterminé de personnes';
    } else {
      $nb_personnes_query = 'pour un nombre de '.$nb_peronnes.' personnes';
    }
    if ( $choix_commune == 'indifferent' ) {
      $query_user = 'Vous avez recherché un hébergement comprenant sur toutes les communes du '.$startsejourdate.' au '.$finsejour.' '.$nb_personnes_query;   
    } else {
      $query_user = 'Vous avez recherché un hébergement de type sur la commune de '.$choix_commune.' du '.$startsejourdate.' au '.$finsejour.' '.$nb_personnes_query;
    }
        
    $app->setUserState( 'com_gesttaxesejour.results.query', $query_user );
    
    if ( empty($dispos) ) {
      $app->enqueueMessage ( 'Aucun résultat trouvé');
      return null;
    }
          
    $availaibility = array();
    foreach( $dispos as $dispo ) {
      if ( $startsejourdate > $dispo->dispstartdate && $startsejourdate < $dispo->dispendate && $startdatetounix > $dispo->dispstartdate && $startdatetounix < $dispo->dispendate ) {
        $ava = new stdClass();
        $ava->id = $dispo->id;
        $ava->description = $dispo->description;
        $ava->hostingname = $dispo->hostingname;
        $ava->adress = $dispo->adress;
        $ava->complement_adress = $dispo->complement_adress;
        $ava->postalcode = $dispo->postalcode;
        $ava->latitude = $dispo->latitude;
        $ava->longitude = $dispo->longitude;
        $ava->city = $dispo->city;
        $ava->website = $dispo->website;
        $ava->hosting_type_name = $dispo->hosting_type_name;
        $availaibility[] = $ava;  
      }
    }    
    
    if ( empty($availaibility) ) {
      $app->enqueueMessage ( 'Aucun résultat correspondant trouvé');
      return null;
    }
    
    $app->setUserState( 'com_gesttaxesejour.dispos.results', $availaibility );
    
    // rediriger l'utilisateur vers la bonne vue pour afficher les résultats
    $this->setRedirect(JRoute::_('index.php?option=com_gesttaxesejour&view=dispos&layout=results_dispo', false));
    return false;     
  }
}