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
class TdsmanagerModelUser extends JModelLegacy {
	public function getUserProfile() {
    $user = JFactory::getUser();
    $db = JFactory::getDBO();

    /*$query = $db->getQuery(true);
    $query->select('*')->from('#__tdsmanager_users')->where("userid={$user->id}"); */
    $query = "SELECT * FROM #__tdsmanager_users
              WHERE userid={$user->id}";
    $db->setQuery((string)$query);
    $profile = $db->loadObject();

	try
	{
		$profile = $db->loadObject();
	}
	catch (Exception $e)
	{
		$this->app->enqueueMessage ($e->getMessage());
		return false;
	}

    return $profile;
  }
}
