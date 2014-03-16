<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_banners
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

require_once JPATH_ADMINISTRATOR . '/components/com_tdsmanager/libraries/view.php';

/**
 * View class for a list of banners.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_banners
 * @since       1.6
 */
class TdsmanagerAdminViewControlpanel extends TdsmanagerView
{
	
	/**
	 * Method to display the view.
	 *
	 * @param   string  $tpl  A template file to load. [optional]
	 *
	 * @return  mixed  A string if successful, otherwise a JError object.
	 *
	 * @since   1.6
	 */
	public function display($tpl = null) {
		$this->addToolbar();
		
		$document = JFactory::getDocument();		
		$document->addStyleSheet ( JUri::base(true).'/components/com_tdsmanager/media/css/admin.css' );

		parent::display($tpl);
	}

	protected function addToolbar() {    
    JToolBarHelper::preferences('com_tdsmanager');
		JToolBarHelper::divider();
				
		JToolBarHelper::title( JText::_('COM_TDSMANAGER_TITLE_PAGE_LABEL') .': '. JText::_('COM_TDSMANAGER_TITLE_PAGE_CONTROLPANEL_LABEL'), 'tdsmanager.png');
		
		JToolBarHelper::help('COM_TDSMANAGER_HELP_LABEL');
	}
}
