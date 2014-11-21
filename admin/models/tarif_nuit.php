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
class TdsmanagerAdminModelTarif_nuit extends TdsmanagerModel {
  /**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState($ordering = null, $direction = null) {
	   // List state information
    $value = $this->getUserStateFromRequest ( "com_tdsmanager.admin.tarif_nuit.list.limit", 'limit', $this->app->getCfg ( 'list_limit' ), 'int' );
    $this->setState ( 'list.limit', $value );

    $value = $this->getUserStateFromRequest ( 'com_tdsmanager.admin.tarif_nuit.list.ordering', 'filter_order', 'ordering', 'cmd' );
    $this->setState ( 'list.ordering', $value );

    $value = $this->getUserStateFromRequest ( "com_tdsmanager.admin.tarif_nuit.list.start", 'limitstart', 0, 'int' );
    $this->setState ( 'list.start', $value );

    $value = $this->getUserStateFromRequest ( 'com_tdsmanager.admin.tarif_nuit.list.direction', 'filter_order_Dir', 'asc', 'word' );
    if ($value != 'asc')
    $value = 'desc';
    $this->setState ( 'list.direction', $value );

    $value = $this->getUserStateFromRequest ( 'com_tdsmanager.admin.tarif_nuit.list.search', 'search', '', 'string' );
    $this->setState ( 'list.search', $value );
	}

  public function getTarifNuits() {
    $db = JFactory::getDBO();
    $query = "SELECT COUNT(*) FROM #__tdsmanager_tarif_nuit";
    $db->setQuery((string)$query);
    $total = $db->loadResult();

    $this->setState ( 'list.total', $total );

    $query = "SELECT tarif.*, class.description AS classement_name, type.name AS h_type FROM #__tdsmanager_tarif_nuit AS tarif
              LEFT JOIN #__tdsmanager_classements AS class ON tarif.id_classement=class.id
              LEFT JOIN #__tdsmanager_hebergements_type AS type ON tarif.id_hebergement_type=type.id";
    $db->setQuery((string)$query, $this->getState ( 'list.start' ),$this->getState ( 'list.limit' ));
    $tarifnuits = $db->loadObjectList();

    return $tarifnuits;
  }

  public function getTarifNuit() {
    $app = JFactory::getApplication();
    $id = $app->getUserState( "com_tdsmanager.hebergement_tarif_nuit.id" );

    if ( $id > 0 ) {
      $db = JFactory::getDBO();
      $query = "SELECT tarif.*,class.id AS classement_id, type.id AS h_type_id FROM #__tdsmanager_tarif_nuit AS tarif
                LEFT JOIN #__tdsmanager_classements AS class ON tarif.id_classement=class.id
                LEFT JOIN #__tdsmanager_hebergements_type AS type ON tarif.id_hebergement_type=type.id
                WHERE tarif.id={$db->quote($id)}";
      $db->setQuery((string)$query);
      $tarif_nuit = $db->loadObject();

      return $tarif_nuit;
    } else {
      return;
    }
  }

  protected function _getUserState() {
    $app = JFactory::getApplication();
    $id = $app->getUserState( "com_tdsmanager.hebergement_tarif_nuit.id" );

    if ( $id ) {
      $db = JFactory::getDBO();
      $query = "SELECT * FROM #__tdsmanager_tarif_nuit WHERE id={$db->quote($id)}";
      $db->setQuery((string)$query);
      $tarif_nuit = $db->loadObject();

      return $tarif_nuit;
    }
    $object = new StdClass;
    $object->id_classement = 0;
    $object->id_hebergement_type = 0;
    return $object;
  }

  public function getListClassement () {
    $db = JFactory::getDBO();
    $query = "SELECT * FROM #__tdsmanager_classements";
    $db->setQuery((string)$query);
    $classements = $db->loadObjectList();

    $tarif_nuit = $this->_getUserState();

    $classement_list = array();
    $classement_list[] = JHTML::_ ( 'select.option',0,'Choisissez un type de classement');
    foreach($classements as $classement) {
      $classement_list[] = JHTML::_ ( 'select.option', $classement->id, $classement->description );
    }
    $list = JHTML::_ ( 'select.genericlist', $classement_list, 'classement', 'class="inputbox" size="1"', 'value', 'text', $tarif_nuit->id_classement );

    return $list;
  }

  public function getListHebergementType() {
    $db = JFactory::getDBO();
    $query = "SELECT * FROM #__tdsmanager_hebergements_type";
    $db->setQuery((string)$query);
    $hebergement_types = $db->loadObjectList();

    $tarif_nuit = $this->_getUserState();

    $hebergement_type_list = array();
    $hebergement_type_list[] = JHTML::_ ( 'select.option',0,'Choissisez un type d\'hébergement');
    foreach($hebergement_types as $hebergement_type) {
      $hebergement_type_list[] = JHTML::_ ( 'select.option', $hebergement_type->id, $hebergement_type->name );
    }
    $list = JHTML::_ ( 'select.genericlist', $hebergement_type_list, 'hebergement_type', 'class="inputbox" size="1"', 'value', 'text', $tarif_nuit->id_hebergement_type );

    return $list;
  }

  public function getAdminNavigation() {
    $navigation = new JPagination ($this->getState ( 'list.total'), $this->getState ( 'list.start'), $this->getState ( 'list.limit') );
    return $navigation;
  }
}