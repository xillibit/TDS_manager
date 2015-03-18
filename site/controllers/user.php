<?php
/**
 * @package		Tdsmanager.Site
 * @subpackage	Tdsmanager
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

class TdsmanagerControllerUser extends JControllerLegacy {
	public function edit() {
		$app	= JFactory::getApplication();
		// Check for request forgeries.
		if (!JSession::checkToken()) {
			$app->enqueueMessage ( JText::_('COM_TDSMANAGER_TOKEN'), 'error' );
			$app->redirect($this->baseurl);
		}

		$this->setRedirect(JRoute::_('index.php?option=com_tdsmanager&view=user&layout=edit', false));
		return false;
	}

	public function save() {
		$app	= JFactory::getApplication();
		$user = JFactory::getUser();

		// Check for request forgeries.
		if (!JSession::checkToken()) {
			$app->enqueueMessage ( JText::_('COM_TDSMANAGER_TOKEN'), 'error' );
			$app->redirect($this->baseurl);
		}

		if ( $user->id > 0 ) {
			$db = JFactory::getDBO();

			$name = $app->input->getString('name', null);
			$lastname = $app->input->getString('lastname', null);
			$adress = $app->input->getString('adress', null);
			$complement_adress = $app->input->getString('complement_adress', null);
			$ville = $app->input->getString('ville', null);
			$postalcode = $app->input->getInt('postalcode', 0);
			$portable = $app->input->getString('portable', null);
			$telephone = $app->input->getString('telephone', null);
			$mail = $app->input->getString('mail', null);
			$userid = $app->input->getInt('userid', 0);

			if ( !empty($post) ) {
				$query = "UPDATE #__tdsmanager_users
					SET name={$db->quote($post['name'])},lastname={$db->quote($post['lastname'])},adress={$db->quote($post['adress'])},complement_adress={$db->quote($post['complement_adress'])},ville={$db->quote($post['ville'])},postalcode={$db->quote($post['postalcode'])},portable={$db->quote($post['portable'])},telephone={$db->quote($post['telephone'])},mail={$db->quote($post['mail'])} WHERE userid={$db->quote($post['userid'])}";
				$db->setQuery((string)$query);

				try
				{
					$db->Query();
				}
				catch (Exception $e)
				{
					$this->app->enqueueMessage ($e->getMessage());
					return false;
				}

				$app->enqueueMessage ( JText::_('COM_TDSMANAGER_PROFILE_EDITED_SUCCESSFULLY') );
			}
		} else {
			$app->enqueueMessage ( JText::_('COM_TDSMANAGER_NOT_LOGGUED') );
		}
	}
}