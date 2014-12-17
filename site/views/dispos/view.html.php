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
class TdsmanagerViewDispos extends JView {
  /**
	 * Display the view
	 *
	 * @return	mixed	False on error, null otherwise.
	 */
	function display($tpl = null) {
    $app = JFactory::getApplication();
    $layout = $app->input->getCmd('layout');
    $this->dispo = $app->getUserState( 'com_tdsmanager.dispos.dispo');

    if ( !empty($this->dispo) ) {
      $capacite_chambres = $this->dispo->chambres_max;
      $chambre_selected = $this->dispo->chambres_selected;
    } else {
      $capacite_chambres = $app->getUserState( 'com_tdsmanager.dispos.capacite');
      $chambre_selected = '';
    }

    $this->hostings_list = $this->get('hebergementslist');

    $this->dropdown = '';
    if ($capacite_chambres >0) {
      $options = array();
      for( $i=1; $i<=$capacite_chambres;$i++ ) {
        $options[] = JHTML::_('select.option', $i, $i);
      }
      $this->dropdown = JHTML::_('select.genericlist', $options, 'capacite_chambres', 'class="inputbox"', 'value', 'text', $chambre_selected);
    }

    if ( $layout == 'confirmdelete' ) {
      $this->ids_delete_dispos = $this->get('detailsdispos');
    } elseif ( $layout == 'results_dispo' ) {
      $this->search_query = $app->getUserState( 'com_tdsmanager.results.query' );

      $this->results_dispo = $app->getUserState( 'com_tdsmanager.dispos.results');
    }

    $this->dispos = $this->get('dispos');

    parent::display($tpl);
  }
}