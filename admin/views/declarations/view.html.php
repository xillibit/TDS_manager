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
class TdsmanagerAdminViewDeclarations extends TdsmanagerView {
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
		$this->declarations		= $this->get('Declarations');
    $this->mois = array(1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril', 5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Aout', 9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre');

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
		JToolBarHelper::title(JText::_('COM_GESTTAXESEJOUR_DECLARATIONS'), 'declarations.png');
	}

  function displayCreate($tpl = null) {
    $this->list_mois = $this->get('ListMois');
    $this->list_hebergements = $this->get('ListHebergements');

    $this->setToolBarCreate();
		parent::display($tpl);
  }

	function displayEdit($tpl = null) {
	  // Initialiase variables.
	  $this->declaration		= $this->get('declaration');
    $this->list_tarifs_nuit= $this->get('ListTarifsNuit');
    $this->list_mois = $this->get('ListMois');
    $this->list_hebergements = $this->get('ListHebergements');

		$this->setToolBarEdit();
		parent::display($tpl);
	}

  function displayDetail($tpl = null) {
		$values_first_step = $this->app->getUserState( 'com_gesttaxesejour.declaration.decl_first_part' );
    $this->values_entered = $values_first_step->tarif_hebergement;

    $this->setToolBarDetail();
		parent::display($tpl);
	}

  protected function setToolbarDetail() {
    // TODO: remplacer banners.png par une icône propre à l'application
		JToolBarHelper::title(JText::_('COM_GESTTAXESEJOUR_EDIT_DECLARATION'), 'declarations.png');
		JToolBarHelper::save('save');
		JToolBarHelper::cancel();
  }

  protected function setToolbarCreate() {
    // TODO: remplacer banners.png par une icône propre à l'application
		JToolBarHelper::title(JText::_('COM_GESTTAXESEJOUR_CREATE_DECLARATION'), 'declarations.png');
		// Mettre un bouton suivant à la place de sauver
    JToolBarHelper::custom( 'save_first_part', 'forward', 'icon over', 'COM_GESTTAXESEJOUR_DECLARATION_TOOLBAR_NEXT' );
    JToolBarHelper::cancel();
  }

	protected function setToolbarEdit() {
    // TODO: remplacer banners.png par une icône propre à l'application
		JToolBarHelper::title(JText::_('COM_GESTTAXESEJOUR_EDIT_DECLARATION'), 'declarations.png');
		JToolBarHelper::save('save');
		JToolBarHelper::cancel();
  }
}