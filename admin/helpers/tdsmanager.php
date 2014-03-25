<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Gesttaxesejour component helper.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_gesttaxesejour
 * @since		1.6
 */
abstract  class TdsmanagerHelper {
	/**
	 * Configure the Linkbar.
	 *
	 * @param	string	The name of the active view.
	 *
	 * @return	void
	 * @since	1.6
	 */
	public static function addSubmenu($vName)
	{
		JSubMenuHelper::addEntry(
			JText::_('COM_TDSMANAGER_SUBMENU_CPANEL'),
			'index.php?option=com_tdsmanager',
			$vName == 'tdsmanager'
		);

		JSubMenuHelper::addEntry(
			JText::_('COM_TDSMANAGER_SUBMENU_OWNERS'),
			'index.php?option=com_tdsmanager&view=users',
			$vName == 'users'
		);

		JSubMenuHelper::addEntry(
			JText::_('COM_TDSMANAGER_SUBMENU_HEBERGEMENTS'),
			'index.php?option=com_tdsmanager&view=hebergements',
			$vName == 'hebergements'
		);

		JSubMenuHelper::addEntry(
			JText::_('COM_TDSMANAGER_SUBMENU_HEBERGEMENTS_TYPE'),
			'index.php?option=com_tdsmanager&view=hebergements_type',
			$vName == 'hebergements_type'
		);

		JSubMenuHelper::addEntry(
			JText::_('COM_TDSMANAGER_SUBMENU_LABEL'),
			'index.php?option=com_tdsmanager&view=label',
			$vName == 'label'
		);

		JSubMenuHelper::addEntry(
			JText::_('COM_TDSMANAGER_SUBMENU_TARIF_NUIT'),
			'index.php?option=com_tdsmanager&view=tarif_nuit',
			$vName == 'tarif_nuit'
		);

		JSubMenuHelper::addEntry(
			JText::_('COM_TDSMANAGER_SUBMENU_CLASSEMENTS'),
			'index.php?option=com_tdsmanager&view=classements',
			$vName == 'classements'
		);

		JSubMenuHelper::addEntry(
			JText::_('COM_TDSMANAGER_SUBMENU_DECLARATIONS'),
			'index.php?option=com_tdsmanager&view=declarations',
			$vName == 'declarations'
		);

    JSubMenuHelper::addEntry(
			JText::_('COM_TDSMANAGER_SUBMENU_REGLEMENTS'),
			'index.php?option=com_tdsmanager&view=reglements',
			$vName == 'reglements'
		);

		JSubMenuHelper::addEntry(
			JText::_('COM_TDSMANAGER_SUBMENU_STATISTICS'),
			'index.php?option=com_tdsmanager&view=statistics',
			$vName == 'statistics'
		);

	}
}