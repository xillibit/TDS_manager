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
class TdsmanagerModelDispos extends JModel {
  public function getHebergementsList() {
    $db = JFactory::getDBO();
    $user = JFactory::getUser();

    /*$query = $db->getQuery(true);
    $query->select('hosting.*')->from('#__tdsmanager_hebergements AS hosting')->where("hosting.userid={$db->quote($user->id)}"); */
    $query = "SELECT hosting.* FROM #__tdsmanager_hebergements AS hosting
              WHERE hosting.userid={$db->quote($user->id)}";
    $db->setQuery((string)$query);

    try
	{
		$users_hosting = $db->loadObjectList();
	}
	catch (Exception $e)
	{
		$this->app->enqueueMessage ($e->getMessage());
		return false;
	}

    $hebergements_user = array();
    foreach($users_hosting as $hosting) {
      $hebergements_user[] = JHTML::_ ( 'select.option', $hosting->id, $hosting->hostingname );
    }
    $list = JHTML::_ ( 'select.genericlist', $hebergements_user, 'user_hebergement', 'class="inputbox" size="1"', 'value', 'text' );

    return $list;
  }

  public function getCapaciteChambresMax($id) {
    $db = JFactory::getDBO();

    /*$query = $db->getQuery(true);
    $query->select('nb_chambres_max')->from('#__tdsmanager_hebergements')->where("id={$db->quote($id)}"); */
    $query = "SELECT nb_chambres_max FROM #__tdsmanager_hebergements
              WHERE id={$db->quote($id)}";
    $db->setQuery((string)$query);
    $chambres_max = $db->loadResult();

    return $chambres_max;
  }

  public function getDispo($id) {
    $db = JFactory::getDBO();
    /*$query = $db->getQuery(true);
    $query->select('*')->from('#__tdsmanager_dispos')->where("id={$db->quote($id)}"); */
    $query = "SELECT * FROM #__tdsmanager_dispos
              WHERE id={$db->quote($id)}";
    $db->setQuery((string)$query);
    $dispo = $db->loadObject();

    return $dispo;
  }

  public function getDispos() {
    $db = JFactory::getDBO();
    /* $query = $db->getQuery(true);
    $query->select('d.*, h.description')->from('#__tdsmanager_dispos AS d'); */
    $query = "SELECT d.*, h.description FROM #__tdsmanager_dispos AS d INNER JOIN #__tdsmanager_hebergements AS h ON d.id_hebergement=h.id";
    $db->setQuery((string)$query);
    $dispos = $db->loadObjectlist();

    return $dispos;
  }

  public function getDetailsDispos() {
    $app = JFactory::getApplication();
    $ids = $app->getUserState('com_tdsmanager.dispos.ids.delete');
    $ids = implode(',', $ids);

    $db = JFactory::getDBO();
    $query = "SELECT d.*, h.description FROM #__tdsmanager_dispos AS d INNER JOIN #__tdsmanager_hebergements AS h ON d.id_hebergement=h.id
              WHERE d.id IN ({$ids})";
    $db->setQuery((string)$query);
    $details_dispos = $db->loadObjectList();

    return $details_dispos;
  }
}