<?php
/**
 * @copyright	Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

/**
 * TDSmanager master display controller.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_tdsmanager
 * @since		1.6
 */
class TdsmanagerController extends JControllerLegacy {
	/**
	 * Method to display a view.
	 *
	 * @param	boolean			If true, the view output will be cached
	 * @param	array			An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController		This object to support chaining.
	 * @since	1.5
	 */
	public function display($cachable = false, $urlparams = false) {
		require_once JPATH_COMPONENT.'/helpers/tdsmanager.php';

		$view = JFactory::getApplication()->input->getCmd('view', 'controlpanel');

		// Load the submenu.
		TdsmanagerHelper::addSubmenu($view);

		// set default view if not set
		JFactory::getApplication()->input->set('view', $view);

		// call parent behavior
		parent::display($cachable);
	}
}