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
class TdsmanagerAdminViewReglements extends TdsmanagerView {
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
		$this->reglements		= $this->get('ListReglements');

    $this->navigation = $this->get ( 'AdminNavigation' );

    $this->setToolbarDefault();

		parent::display($tpl);
	}

	protected function setToolbarDefault() {
		// TODO: remplacer banners.png par une icône propre à l'application
		JToolBarHelper::editList();
		JToolBarHelper::divider();
    JToolBarHelper::custom('validpaiement', 'checkin', JText::_('COM_TDSMANAGER_REGLEMENTS_VALIDATE'), JText::_('COM_TDSMANAGER_REGLEMENTS_VALIDATE'));
    JToolBarHelper::custom('relaunch', 'refresh', JText::_('COM_TDSMANAGER_REGLEMENTS_RELAUCNH'), JText::_('COM_TDSMANAGER_REGLEMENTS_RELAUCNH'));
    JToolBarHelper::preferences('com_tdsmanager');
    JToolBarHelper::title(JText::_('COM_TDSMANAGER_MANAGE_REGLEMENTS'), 'reglements.png');
	}

  function displayEdit($tpl = null) {
	  // Initialiase variables.
		$this->classement		= $this->get('Classement');

		$this->setToolBarEdit();
		parent::display($tpl);
	}

  protected function setToolbarEdit() {
    // TODO: remplacer banners.png par une icône propre à l'application
		JToolBarHelper::title(JText::_('COM_TDSMANAGER_EDIT_REGLEMENT'), 'reglements.png');
		JToolBarHelper::save('save');
		JToolBarHelper::cancel();
  }
}