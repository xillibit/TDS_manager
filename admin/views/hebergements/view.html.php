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
class TdsmanagerAdminViewHebergements extends TdsmanagerView {
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
		$document = JFactory::getDocument();
		$document->addStyleSheet ( JUri::base(true).'/components/com_tdsmanager/media/css/admin.css' );

		// Initialiase variables.
		$this->hebergements		= $this->get('ListHebergements');

		$this->navigation = $this->get ( 'AdminNavigation' );
		$this->setToolbarDefault();

		parent::display($tpl);
	}

	function displayCreate($tpl = null) {
	  $app = JFactory::getApplication();

    // Initialiase variables.
		$this->hebergement		= $this->get('Hebergement');

		$this->classementlist		= $this->get('ListClassement');
		$this->labellist        = $this->get('ListLabel');
		$this->hebergement_typelist = $this->get('ListTypesHebergement');
    $this->users_list = $this->get('ListUsers');

    $id = $app->getUserState( "com_tdsmanager.hebergement.id" );

		if ($id) $this->setToolBarEdit();
    else $this->setToolBarCreate();
		parent::display($tpl);
	}

	protected function setToolbarDefault() {
		// vérifier les droits sur les éléments suivants
		JToolBarHelper::addNew('create');
    JToolBarHelper::editList();
		JToolBarHelper::divider();
		JToolBarHelper::trash('trash');
		JToolBarHelper::divider();

		JToolBarHelper::title(JText::_('COM_GESTTAXESEJOUR_HERBERGEMENTS'), 'hebergements.png');
	}

	protected function setToolbarCreate() {
		JToolBarHelper::title(JText::_('COM_GESTTAXESEJOUR_CREATE_HERBERGEMENT'), 'hebergements.png');
		JToolBarHelper::save('save');
		JToolBarHelper::cancel();
  }

	protected function setToolbarEdit() {
		JToolBarHelper::title(JText::_('COM_GESTTAXESEJOUR_EDIT_HERBERGEMENT'), 'hebergements.png');
		JToolBarHelper::save('save');
		JToolBarHelper::cancel();
  }
}
