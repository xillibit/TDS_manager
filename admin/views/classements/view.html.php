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
class TdsmanagerAdminViewClassements extends TdsmanagerView {
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
		$this->classements		= $this->get('Classements');

		$this->navigation = $this->get ( 'AdminNavigation' );

    $this->addToolbar();

		parent::display($tpl);
	}

	protected function addToolbar() {
    JToolBarHelper::addNew('create');
    JToolBarHelper::editList();
		JToolBarHelper::divider();
		JToolBarHelper::publish('publish', 'JTOOLBAR_PUBLISH', true);
		JToolBarHelper::unpublish('unpublish', 'JTOOLBAR_UNPUBLISH', true);
		JToolBarHelper::divider();
		JToolBarHelper::deleteList('delete');
		// TODO: remplacer banners.png par une icône propre à l'application
		JToolBarHelper::title(JText::_('COM_GESTTAXESEJOUR_CLASSEMENTS'), 'banners.png');
	}

	function displayCreate($tpl = null) {
	  // Initialiase variables.
		$this->classement		= $this->get('Classement');

    $app = JFactory::getApplication();
    $id = $app->getUserState( "com_gesttaxesejour.classement.id" );

		if ($id) $this->setToolBarEdit();
    else $this->setToolBarCreate();
		parent::display($tpl);
	}

	protected function setToolbarCreate() {
    // TODO: remplacer banners.png par une icône propre à l'application
		JToolBarHelper::title(JText::_('COM_GESTTAXESEJOUR_CREATE_CLASSEMENT'), 'classements.png');
		JToolBarHelper::save('save');
		JToolBarHelper::cancel();
  }

  protected function setToolbarEdit() {
    // TODO: remplacer banners.png par une icône propre à l'application
		JToolBarHelper::title(JText::_('COM_GESTTAXESEJOUR_EDIT_CLASSEMENT'), 'banners.png');
		JToolBarHelper::save('save');
		JToolBarHelper::cancel();
  }
}
