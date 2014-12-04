<?php
/**
 * @package		Tdsmanager.Site
 * @subpackage	Tdsmanager
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

class TdsmanagerControllerReglements extends JControllerLegacy {
	public function details() {
		$this->setRedirect(JRoute::_('index.php?option=com_tdsmanager&view=reglement&layout=details', false));
		return false;
	}

	public function create() {
		$this->setRedirect(JRoute::_('index.php?option=com_tdsmanager&view=reglements&layout=create', false));
		return false;
	}

	public function save() {
		$app	= JFactory::getApplication();
		// Check for request forgeries.
		if (!JSession::checkToken()) {
			$app->enqueueMessage ( JText::_('COM_TDSMANAGER_TOKEN'), 'error' );
			$app->redirect($this->baseurl);
		}
	}
}