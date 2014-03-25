<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport ( 'joomla.application.component.model' );
jimport( 'joomla.html.pagination' );

require_once JPATH_ADMINISTRATOR . '/components/com_tdsmanager/libraries/model.php';

/**
 * Methods supporting a list of banner records.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_gesttaxesejour
 * @since		1.6
 */
class TdsmanagerAdminModelReglements extends TdsmanagerModel {
  /**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState($ordering = null, $direction = null) {
	   // List state information
    $value = $this->getUserStateFromRequest ( "com_tdsmanager.admin.hebergements.list.limit", 'limit', $this->app->getCfg ( 'list_limit' ), 'int' );
    $this->setState ( 'list.limit', $value );

    $value = $this->getUserStateFromRequest ( 'com_tdsmanager.admin.hebergements.list.ordering', 'filter_order', 'ordering', 'cmd' );
    $this->setState ( 'list.ordering', $value );

    $value = $this->getUserStateFromRequest ( "com_tdsmanager.admin.hebergements.list.start", 'limitstart', 0, 'int' );
    $this->setState ( 'list.start', $value );

    $value = $this->getUserStateFromRequest ( 'com_tdsmanager.admin.hebergements.list.direction', 'filter_order_Dir', 'asc', 'word' );
    if ($value != 'asc')
    $value = 'desc';
    $this->setState ( 'list.direction', $value );

    $value = $this->getUserStateFromRequest ( 'com_tdsmanager.admin.hebergements.list.search', 'search', '', 'string' );
    $this->setState ( 'list.search', $value );
	}

	public function getListReglements() {
    $db = JFactory::getDBO();

    /* Créer une table spécifique pour avoir la relation entre le reglement et l'hébergement */

    $query = "SELECT COUNT(*) FROM #__tdsmanager_reglements";
    $db->setQuery((string)$query);
    $total = $db->loadResult();

    $this->setState ( 'list.total', $total );

    $query = "SELECT reg.*,heb.*,decl.date_declarer FROM #__tdsmanager_reglements AS reg
              LEFT JOIN #__tdsmanager_declarations AS decl ON decl.hebergement_id=reg.declaration_id
              LEFT JOIN #__tdsmanager_hebergements AS heb ON heb.id=decl.hebergement_id";
    $db->setQuery((string)$query, $this->getState ( 'list.start' ),$this->getState ( 'list.limit' ));
    $reglementslist = $db->loadObjectlist();

    return $reglementslist;
  }

	public function getAdminNavigation() {
    $navigation = new JPagination ($this->getState ( 'list.total'), $this->getState ( 'list.start'), $this->getState ( 'list.limit') );
    return $navigation;
  }
}