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
 * @subpackage	com_tdsmanager
 * @since		1.6
 */
class TdsmanagerAdminModelHebergements_type extends TdsmanagerModel {
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState($ordering = null, $direction = null) {
  	// List state information
    $value = $this->getUserStateFromRequest ( "com_tdsmanager.admin.hebergements_type.list.limit", 'limit', $this->app->getCfg ( 'list_limit' ), 'int' );
    $this->setState ( 'list.limit', $value );

    $value = $this->getUserStateFromRequest ( 'com_tdsmanager.admin.hebergements_type.list.ordering', 'filter_order', 'ordering', 'cmd' );
    $this->setState ( 'list.ordering', $value );

    $value = $this->getUserStateFromRequest ( "com_tdsmanager.admin.hebergements_type.list.start", 'limitstart', 0, 'int' );
    $this->setState ( 'list.start', $value );

    $value = $this->getUserStateFromRequest ( 'com_tdsmanager.admin.hebergements_type.list.direction', 'filter_order_Dir', 'asc', 'word' );
    if ($value != 'asc')
    $value = 'desc';
    $this->setState ( 'list.direction', $value );

    $value = $this->getUserStateFromRequest ( 'com_tdsmanager.admin.hebergements_type.list.search', 'search', '', 'string' );
    $this->setState ( 'list.search', $value );

    $value = $this->getUserStateFromRequest ( "com_tdsmanager.admin.hebergements_type.list.levels", 'levellimit', 10, 'int' );
    $this->setState ( 'list.levels', $value );
	}

	public function getListHebergementsType() {
    $db = JFactory::getDBO();

    $query = "SELECT COUNT(*) FROM #__tdsmanager_hebergements_type";
    $db->setQuery((string)$query);
    $total = $db->loadResult();

    $this->setState ( 'list.total', $total );

    $query = "SELECT * FROM #__tdsmanager_hebergements_type";
    $db->setQuery((string)$query);
    $hebergements_typelist = $db->loadObjectlist();

    return $hebergements_typelist;
  }

  public function getHebergementType() {
    $db = JFactory::getDBO();

    $app = JFactory::getApplication();
    $id = $app->getUserState('com_gesttaxesejour.hebergement_type.id');

    $query = "SELECT * FROM #__tdsmanager_hebergements_type WHERE id={$db->quote($id)}";
    $db->setQuery((string)$query);
    $hebergements_type = $db->loadObject();

    return $hebergements_type;
  }

  public function getAdminNavigation() {
    $navigation = new JPagination ($this->getState ( 'list.total'), $this->getState ( 'list.start'), $this->getState ( 'list.limit') );
    return $navigation;
  }
}
?>