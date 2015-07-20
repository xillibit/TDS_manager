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
class TdsmanagerViewReglements extends JViewLegacy {
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

		$app = JFactory::getApplication();

		$layout = $app->input->getCmd('layout');

		if ( $layout == 'create' ) {
		  $this->document->setTitle(JText::_('COM_TDSMANAGER_GESTION_TAXE_SEJOUR').' - '.JText::_('COM_TDSMANAGER_REGLEMENT_CREATE'));
		} else {
      $this->document->setTitle(JText::_('COM_TDSMANAGER_GESTION_TAXE_SEJOUR').' - '.JText::_('COM_TDSMANAGER_VISUALISATION_REGLEMENTS'));
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
	}s
}