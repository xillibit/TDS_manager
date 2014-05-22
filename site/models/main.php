<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die;

jimport('joomla.application.component.model');

/**
 * This models supports retrieving lists of contact categories.
 *
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @since		1.6
 */
class TdsmanagerModelMain extends JModel {
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState() {

	}

  public function getReglementsNotDone() {
    $db = JFactory::getDBO();
    $user = JFactory::getUser();

    $query = "SELECT start_date, end_date FROM #__gesttaxesejour_declarations
              WHERE declarant_userid={$db->quote($user->id)} AND paiement_ok='0'";
    $db->setQuery((string)$query);
    $reglement_not_done = $db->loadObject();

    return $reglement_not_done;
  }

  public function getDeclarationsNotDone() {
    jimport( 'joomla.utilities.date' );

    $today = getdate();
    $db = JFactory::getDBO();
    $user = JFactory::getUser();

    $mois_dernier = $today['year'].'-'.$today['mon']-1;

    // On vérifie que les déclarations ont été faites
    /*if ( $date_jour['tm_mon'] > '15' ) {
       $query = "SELECT * FROM #__gesttaxesejour_hebergements AS herbeg
              LEFT JOIN #__gesttaxesejour_declarations AS decl ON herbeg.id=decl.hebergement_id
              WHERE herbeg.userid={$db->quote($user->id)} AND decl.end_date LIKE '%$mois_dernier%'";
      $db->setQuery((string)$query);
      $declarations_not_done = $db->loadObjectList();

      $declarations_not_done = count($declarations_not_done);

      return $declarations_not_done;
    } */

    return null;
  }

  public function getLastHostings() {
    $db = JFactory::getDBO();
    $user = JFactory::getUser();

    if ( $user->id > 0 ) {
      $query = "SELECT * FROM #__gesttaxesejour_hebergements
                WHERE userid={$db->quote($user->id)} LIMIT 0,3";
      $db->setQuery((string)$query);
      $user_last_hostings = $db->loadObjectList();

      return $user_last_hostings;
    }
  }

  public function getLastDeclarations() {
    $db = JFactory::getDBO();
    $user = JFactory::getUser();

    /*if ( $user->id > 0 ) {
      $query = "SELECT * FROM #__gesttaxesejour_declarations
                WHERE declarant_userid={$db->quote($user->id)} ORDER BY date_declarer LIMIT 0,3";
      $db->setQuery((string)$query);
      $user_last_declarations = $db->loadObjectList();

      return $user_last_declarations;
    }*/
  }

  public function getLastReglements() {
    $db = JFactory::getDBO();
    $user = JFactory::getUser();

    if ( $user->id > 0 ) {
      $query = "SELECT * FROM #__gesttaxesejour_reglements";
      $db->setQuery((string)$query);
      $user_last_reglements = $db->loadObjectList();

      return $user_last_reglements;
    }
  }
}