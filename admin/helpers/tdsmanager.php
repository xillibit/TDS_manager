<?php
/**
* TDS_Manager Component
* @package TDS_Manager.Administrator
* @subpackage Helpers
*
* @copyright (C) 2012 - 2014 Florian DAL FITTO. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
**/

defined('_JEXEC') or die;

/**
 * TDS_Manager Helper
 *
 * @since 1.0
 */
abstract  class TdsmanagerHelper {
	/**
	 * AddSubmenu links.
	 *
	 * @param	string	The name of the active view.
	 *
	 * @return	void
	 * @since	1.0
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