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
class TdsmanagerViewReglements extends JView {
  /**
	 * Display the view
	 *
	 * @return	mixed	False on error, null otherwise.
	 */
	function display($tpl = null) {
		// Initialise variables
		/*$this->reglements = $this->get('reglements');
		$this->own_hostings = $this->get('own_hostings');
		$this->montantToPay = $this->get('MontantToPay');*/

		$layout = JRequest::getCmd('layout');

		if ( $layout == 'create' ) {
		  $this->document->setTitle(JText::_('COM_TDSMANAGER_GESTION_TAXE_SEJOUR').' - '.JText::_('COM_TDSMANAGER_REGLEMENT_CREATE'));
		} else {
      $this->document->setTitle(JText::_('COM_TDSMANAGER_GESTION_TAXE_SEJOUR').' - '.JText::_('COM_TDSMANAGER_VISUALISATION_REGLEMENTS'));
    }

		//$this->_prepareDocument();

		parent::display($tpl);
	}
}