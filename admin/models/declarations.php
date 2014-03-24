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
class TdsmanagerAdminModelDeclarations extends TdsmanagerModel {
  /**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState($ordering = null, $direction = null) {
	   // List state information
    $value = $this->getUserStateFromRequest ( "com_kunena.admin.declarations.list.limit", 'limit', $this->app->getCfg ( 'list_limit' ), 'int' );
    $this->setState ( 'list.limit', $value );

    $value = $this->getUserStateFromRequest ( 'com_kunena.admin.declarations.list.ordering', 'filter_order', 'ordering', 'cmd' );
    $this->setState ( 'list.ordering', $value );

    $value = $this->getUserStateFromRequest ( "com_kunena.admin.declarations.list.start", 'limitstart', 0, 'int' );
    $this->setState ( 'list.start', $value );

    $value = $this->getUserStateFromRequest ( 'com_kunena.admin.declarations.list.direction', 'filter_order_Dir', 'asc', 'word' );
    if ($value != 'asc')
    $value = 'desc';
    $this->setState ( 'list.direction', $value );

    $value = $this->getUserStateFromRequest ( 'com_kunena.admin.declarations.list.search', 'search', '', 'string' );
    $this->setState ( 'list.search', $value );
	}

	public function getDeclarations() {
    $db = JFactory::getDBO();

    $query = "SELECT COUNT(*) FROM #__tdsmanager_declarations";
    $db->setQuery((string)$query);
    $total = $db->loadResult();

    $this->setState ( 'list.total', $total );

    $query = "SELECT decl.id AS decl_id,decl.*, hosting.* FROM #__tdsmanager_declarations AS decl
              LEFT JOIN #__tdsmanager_hebergements AS hosting ON hosting.id=decl.hebergement_id";
    $db->setQuery((string)$query);
    $declarations = $db->loadObjectlist();

    return $declarations;
  }

  public function getDeclaration() {
    $db = JFactory::getDBO();

    $app = JFactory::getApplication();
    $id = $app->getUserState('com_gesttaxesejour.declaration.id');

    $query = "SELECT * FROM #__tdsmanager_declarations
              WHERE id={$id}";
    $db->setQuery((string)$query);
    $declaration = $db->loadObject();

    $this->setState('identification_periode', $declaration->identification_periode);
    $this->setState('hebergement_id', $declaration->hebergement_id);
    $this->setState('tarif_by_night', $declaration->tarif_by_night);

    return $declaration;
  }

  public function getListTarifsNuit() {
    $db = JFactory::getDBO();
    $query = "SELECT * FROM #__tdsmanager_tarif_nuit";
    $db->setQuery((string)$query);
    $tarifs_nuit = $db->loadObjectList();

    $tarif_list = array();
    foreach($tarifs_nuit as $tarif_nuit) {
     $tarif_list[] = JHTML::_ ( 'select.option', $tarif_nuit->id, $tarif_nuit->tarif );
    }
    $list = JHTML::_ ( 'select.genericlist', $tarif_list, 'tarif_by_night', 'class="inputbox" size="1"', 'value', 'text', $this->getState('tarif_by_night') );

    return $list;
  }

  public function getListMois() {
    $lesmois = array(1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril', 5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Aout', 9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre');

    $mois_list = array();
    $mois_list[] = JHTML::_ ( 'select.option', 0, 'Sélectionnez un mois' );
    foreach($lesmois as $id=>$mois_name) {
     $mois_list[] = JHTML::_ ( 'select.option', $id, $mois_name );
    }
    $list = JHTML::_ ( 'select.genericlist', $mois_list, 'mois', 'class="inputbox" size="1"', 'value', 'text', $this->getState('identification_periode') );

    return $list;
  }

  public function getListHebergements() {
    $db = JFactory::getDBO();
    $query = "SELECT hosting.id, hosting.hostingname AS h_name, classement.description AS cl_name FROM #__tdsmanager_hebergements AS hosting
              LEFT JOIN #__tdsmanager_classements AS classement ON hosting.id_classement=classement.id";
    $db->setQuery((string)$query);
    $hebergements = $db->loadObjectList();

    $heberg_list = array();
    $heberg_list[] = JHTML::_ ( 'select.option', 0, 'Sélectionnez un hébergement' );
    foreach($hebergements as $hebergement) {
      $heberg_list[] = JHTML::_ ( 'select.option', $hebergement->id, $hebergement->h_name.' ('.$hebergement->cl_name.')' );
    }
    $list = JHTML::_ ( 'select.genericlist', $heberg_list, 'hebergement_id', 'class="inputbox" size="1"', 'value', 'text', $this->getState('hebergement_id') );

    return $list;
  }

	public function getAdminNavigation() {
    $navigation = new JPagination ($this->getState ( 'list.total'), $this->getState ( 'list.start'), $this->getState ( 'list.limit') );
    return $navigation;
  }
}