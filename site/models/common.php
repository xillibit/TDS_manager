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
class GesttaxesejourModelGesttaxesejour extends JModel {
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState() {

	}

	public function getLastHostings() {
		$db = JFactory::getDBO();
		$user = JFactory::getUser();

		if ( $user->id > 0 ) {
			$query = "SELECT * FROM #__tdsmanager_hebergements
				WHERE userid={$db->quote($user->id)} LIMIT 0,3";
			$db->setQuery((string)$query);
			$user_last_hostings = $db->loadObjectList();

			return $user_last_hostings;
		}
	}

	public function getLastDeclarations() {
		$db = JFactory::getDBO();
		$user = JFactory::getUser();

		if ( $user->id > 0 ) {
			$query = "SELECT * FROM #__tdsmanager_declarations
				WHERE declarant_userid={$db->quote($user->id)} ORDER BY date_declarer LIMIT 0,3";
			$db->setQuery((string)$query);
			$user_last_declarations = $db->loadObjectList();

			return $user_last_declarations;
		}
	}

	public function getLastReglements() {
		$db = JFactory::getDBO();
		$user = JFactory::getUser();

		if ( $user->id > 0 ) {
			$query = "SELECT * FROM #__tdsmanager_reglements";
			$db->setQuery((string)$query);
			$user_last_reglements = $db->loadObjectList();

			return $user_last_reglements;
		}
	}
}