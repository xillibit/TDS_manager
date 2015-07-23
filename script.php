<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Script file of TDSManager component
 */
class com_tdsmanagerInstallerScript
{
	/**
	 * method to install the component
	 *
	 * @return void
	 */
	function install($parent)
	{
		// Create directory tds_mesbacs in root of Joomla! to create files for declaration data
		if ( !JFolder::exists(JPATH_ROOT . '/tds_mesbacs') )
		{
			JFolder::create(JPATH_ROOT . '/tds_mesbacs');
		}
		
		// $parent is the class calling this method
		$parent->getParent()->setRedirectURL('index.php?option=com_tdsmanager');
	}

	/**
	 * method to uninstall the component
	 *
	 * @return void
	 */
	function uninstall($parent)
	{
		// $parent is the class calling this method
		echo '<p>' . JText::_('COM_TDSMANAGER_UNINSTALL_TEXT') . '</p>';
	}

	/**
	 * method to update the component
	 *
	 * @return void
	 */
	function update($parent)
	{
		// $parent is the class calling this method
		echo '<p>' . JText::sprintf('COM_TDSMANAGER_UPDATE_TEXT', $parent->get('manifest')->version) . '</p>';
	}

	/**
	 * method to run before an install/update/uninstall method
	 *
	 * @return void
	 */
	function preflight($type, $parent)
	{
		// $parent is the class calling this method
		// $type is the type of change (install, update or discover_install)
		echo '<p>' . JText::_('COM_TDSMANAGER_PREFLIGHT_' . $type . '_TEXT') . '</p>';
	}

	/**
	 * method to run after an install/update/uninstall method
	 *
	 * @return void
	 */
	function postflight($type, $parent)
	{
		// $parent is the class calling this method
		// $type is the type of change (install, update or discover_install)
		echo '<p>' . JText::_('COM_TDSMANAGER_POSTFLIGHT_' . $type . '_TEXT') . '</p>';
	}
}
