<?php
/**
 * @copyright	Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

/**
 * Gesttaxesejour master display controller.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_gesttaxesejour
 * @since		1.6
 */
class TdsmanagerController extends JController {
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
		
		// Load the submenu.
		TdsmanagerHelper::addSubmenu(JRequest::getCmd('view', 'controlpanel'));
    
    // set default view if not set
		JRequest::setVar('view', JRequest::getCmd('view', 'controlpanel'));
 
		// call parent behavior
		parent::display($cachable);
	}
}