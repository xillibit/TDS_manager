<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * Content categories view.
 *
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @since 1.6
 */
class TdsmanagerViewUser extends JViewLegacy {
	/**
	 * Display the view
	 *
	 * @return	mixed	False on error, null otherwise.
	 */
	function display($tpl = null) {
		$app = JFactory::getApplication();

		// Vérifier que l'utilisateur est bien connecté avant de passer à la suite
		$user = JFactory::getUser();
		$layout = $app->input->getCmd('layout');

		if ( $user->id < 0 ) {
			$app->enqueueMessage( JText::_('COM_TDSMANAGER_NOT_LOGGUED') );

			echo $this->_getViewFile('common', 'login');

			return false;
		}

		// Initialise variables
		$this->profile = $this->get('UserProfile');

		$this->userProfile = new stdClass();

		if ( empty($this->profile->adress) ) $this->userProfile->adress = '';
		else $this->userProfile->adress = $this->profile->adress;

		if ( empty($this->profile->complement_adress) ) $this->userProfile->complement_adress = '';
		else $this->userProfile->complement_adress = $this->profile->complement_adress;

		if ( empty($this->profile->postalcode) ) $this->userProfile->postalcode = '';
		else $this->userProfile->postalcode = $this->profile->postalcode;

		if ( empty($this->profile->ville) ) $this->userProfile->ville = '';
		else $this->userProfile->ville = $this->profile->ville;

		if ( empty($this->profile->telephone) ) $this->userProfile->telephone = '';
		else $this->userProfile->telephone = $this->profile->telephone;

		if ( empty($this->profile->portable) ) $this->userProfile->portable = '';
		else $this->userProfile->portable = $this->profile->portable;

		if ( empty($this->profile->name) ) $this->userProfile->name = '';
		else $this->userProfile->name = $this->profile->name;

		if ( empty($this->profile->lastname) ) $this->userProfile->lastname = '';
		else $this->userProfile->lastname = $this->profile->lastname;

		if ( empty($this->profile->mail) ) $this->userProfile->mail = '';
		else $this->userProfile->mail = $this->profile->mail;

		if ( $layout == 'edit' ) {
			$this->document->setTitle(JText::_('COM_TDSMANAGER_GESTION_TAXE_SEJOUR').' - '.JText::_('COM_TDSMANAGER_USER_EDITION_PROFIL'));
		} else {
			$this->document->setTitle(JText::_('COM_TDSMANAGER_GESTION_TAXE_SEJOUR').' - '.JText::_('COM_TDSMANAGER_USER_GESTION_PROFIL'));
		}

		//$this->_prepareDocument();

		parent::display($tpl);
	}

	protected function _getViewFile($view, $tpl) {
		$tpl =  JPATH_BASE.'/components/com_tdsmanager/views/'.$view.'/tmpl/'.$tpl.'.php';
		if (!file_exists($tpl)) JError::raiseError(500, JText::sprintf('JLIB_APPLICATION_ERROR_LAYOUTFILE_NOT_FOUND', $tpl));

		ob_start();
		include $tpl;
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}
}