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
class TdsmanagerAdminViewLabel extends TdsmanagerView {
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
		$this->labels		= $this->get('Labels');

    $this->navigation = $this->get ( 'AdminNavigation' );

    $this->setToolbarDefault();

		parent::display($tpl);
	}

	protected function setToolbarDefault() {
    JToolBarHelper::addNew('create');
		JToolBarHelper::divider();
    JToolBarHelper::editList();
		JToolBarHelper::divider();
    JToolBarHelper::deleteList('delete');
		// TODO: remplacer banners.png par une icône propre à l'application
		JToolBarHelper::title(JText::_('COM_TDSMANAGER_LABEL'), 'label.png');
	}

	function displayCreate($tpl = null) {
	  // Initialiase variables.
	  $this->label		= $this->get('label');

    $app = JFactory::getApplication();
    $id = $app->getUserState( "com_tdsmanager.hebergement_label.id" );

		if ($id) $this->setToolBarEdit();
    else $this->setToolBarCreate();
		parent::display($tpl);
	}

	protected function setToolbarCreate() {
    // TODO: remplacer banners.png par une icône propre à l'application
		JToolBarHelper::title(JText::_('COM_TDSMANAGER_CREATE_LABEL'), 'label.png');
		JToolBarHelper::save('save');
		JToolBarHelper::cancel();
  }

  protected function setToolbarEdit() {
    // TODO: remplacer banners.png par une icône propre à l'application
		JToolBarHelper::title(JText::_('COM_TDSMANAGER_EDITION_LABEL'), 'label.png');
		JToolBarHelper::save('save');
		JToolBarHelper::cancel();
  }
}