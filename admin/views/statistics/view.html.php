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
class TdsmanagerAdminViewStatistics extends TdsmanagerView {
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
		$this->tauxoccupationstatscommunes		= $this->get('TauxOccupationStatsCommunes');
		$this->tauxoccupationstatshebertype = $this->get('TauxOccupationStatsHeberTypes');
		$this->tauxoccupationglobalstats = $this->get ( 'TauxOccupationGlobalStats' );
		$this->taxesejourstats = $this->get ( 'TaxeSejourStats' );
		$this->taxesejourglobalstats = $this->get ( 'TaxeSejourGlobalStats' );

		$this->mois_list = $this->get('MoisList');
		$this->trimestres_list = $this->get('TrimestreList');
		$this->annees_list = $this->get('AnneeList');

		$this->setToolbarDefault();

		parent::display($tpl);
	}

	protected function setToolbarDefault() {
		JToolBarHelper::title(JText::_('COM_GESTTAXESEJOUR_STATS_GEN_STATS'), 'statistics.png');

		JToolBarHelper::custom('export', 'unblock.png', 'unblock_f2.png', 'COM_GESTTAXESEJOUR_STATISTICS_EXPORT_EXCEL', true);
	}
}