<?php
/**
 * @package		Tdsmanager.Site
 * @subpackage	Tdsmanager
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

/**
 * Tdsmanager Component Controller
 *
 * @package		Tdsmanager.Site
 * @subpackage	Tdsmanager
 * @since 1.5
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

		$cachable = true;

		// Get the document object.
		$document = JFactory::getDocument();

		// Set the default view name and format from the Request.
		$vName		= JFactory::getApplication()->input->getCmd('view', 'main');
		JFactory::getApplication()->input->set('view', $vName);

		$user = JFactory::getUser();


		$safeurlparams = array('catid'=>'INT', 'id'=>'INT', 'cid'=>'ARRAY', 'year'=>'INT', 'month'=>'INT', 'limit'=>'INT', 'limitstart'=>'INT',
			'showall'=>'INT', 'return'=>'BASE64', 'filter'=>'STRING', 'filter_order'=>'CMD', 'filter_order_Dir'=>'CMD', 'filter-search'=>'STRING', 'print'=>'BOOLEAN', 'lang'=>'CMD');

		parent::display($cachable, $safeurlparams);

		return $this;
	}
}
