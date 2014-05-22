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
class TdsmanagerModelReglements extends JModel {
  public function getReglements() {
    $db = JFactory::getDBO();

    /*$query = $db->getQuery(true);
    $query->select('*')->from('#__tdsmanager_reglements'); */
    $query = "SELECT * FROM #__tdsmanager_reglements";
    $db->setQuery((string)$query);
    $reglements = $db->loadObjectList();

    // Check for a database error.
    if ($db->getErrorNum()) {
      JError::raiseWarning(500, $db->getErrorMsg());
      return false;
    }

    return $reglements;
  }

  public function getReglement() {
    $db = JFactory::getDBO();
    $id_reglement = '';

    /*$query = $db->getQuery(true);
    $query->select('*')->from('#__tdsmanager_reglements')->where("id='{$db->quote($id_reglement)}'"); */
    $query = "SELECT * FROM #__tdsmanager_reglements
              WHERE id='{$db->quote($id_reglement)}'";
    $db->setQuery((string)$query);
    $reglement = $db->loadObject();

    // Check for a database error.
    if ($db->getErrorNum()) {
      JError::raiseWarning(500, $db->getErrorMsg());
      return false;
    }

    return $reglement;
  }

  public function getOwn_hostings() {
    $db = JFactory::getDBO();
    $user = JFactory::getUser();

    /*$query = $db->getQuery(true);
    $query->select('decl.*, hostings.hostingname')->from('#__tdsmanager_declarations AS decl')->innerJoin('#__tdsmanager_hebergements AS hostings ON decl.hebergement_id=hostings.id')->where("decl.declarant_userid={$db->quote($user->id)}"); */
    $query = "SELECT decl.*, hostings.hostingname FROM #__tdsmanager_declarations AS decl
              INNER JOIN #__tdsmanager_hebergements AS hostings ON decl.hebergement_id=hostings.id
              WHERE decl.declarant_userid={$db->quote($user->id)}";
    $db->setQuery((string)$query);
    $user_declarations = $db->loadObjectList();

    // Check for a database error.
    if ($db->getErrorNum()) {
      JError::raiseWarning(500, $db->getErrorMsg());
      return false;
    }

    $declarations_user = array();
    foreach($user_declarations as $id=>$decla) {
      $declarations_user[] = JHTML::_ ( 'select.option', $id, $decla->hostingname );
    }
    $user_declarations_list = JHTML::_ ( 'select.genericlist', $declarations_user, 'user_hosting', 'class="inputbox" size="1"', 'value', 'text' );

    return $user_declarations_list;
  }

  public function getMontantToPay() {
    $user = JFactory::getUser();
    $db = JFactory::getDBO();
    /*$query = "SELECT * FROM #__tdsmanager_declarations WHERE declarant_userid={db->quote($user->id)}";
    $db->setQuery((string)$query);
    $montantToPay = $db->loadResult();*/

    $montantToPay = '';

    // Check for a database error.
    if ($db->getErrorNum()) {
      JError::raiseWarning(500, $db->getErrorMsg());
      return false;
    }

    return $montantToPay;
  }
}
