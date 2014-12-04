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
class TdsmanagerAdminModelStatistics extends TdsmanagerModel {
  /**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState($ordering = null, $direction = null) {
	   // List state information
    $value = $this->getUserStateFromRequest ( "com_tdsmanager.admin.statistics.list.limit", 'limit', $this->app->getCfg ( 'list_limit' ), 'int' );
    $this->setState ( 'list.limit', $value );

    $value = $this->getUserStateFromRequest ( 'com_tdsmanager.admin.statistics.list.ordering', 'filter_order', 'ordering', 'cmd' );
    $this->setState ( 'list.ordering', $value );

    $value = $this->getUserStateFromRequest ( "com_tdsmanager.admin.statistics.list.start", 'limitstart', 0, 'int' );
    $this->setState ( 'list.start', $value );

    $value = $this->getUserStateFromRequest ( 'com_tdsmanager.admin.statistics.list.direction', 'filter_order_Dir', 'asc', 'word' );
    if ($value != 'asc')
    $value = 'desc';
    $this->setState ( 'list.direction', $value );

    $mois = $this->getUserStateFromRequest ( 'com_tdsmanager.admin.statistics.list.mois_list', 'mois_list', '', 'int' );
    $this->setState ( 'list.mois', $mois );

    $trimestres = $this->getUserStateFromRequest ( 'com_tdsmanager.admin.statistics.list.trimestres_list', 'trimestres_list', '', 'int' );
    $this->setState ( 'list.trimestres', $trimestres );

    $annee = $this->getUserStateFromRequest ( 'com_tdsmanager.admin.statistics.list.annees_list', 'annees_list', '', 'int' );
    $this->setState ( 'list.annee', $annee );
	}

	protected function getOccupationState() {
    $where = '';
    $list_mois = $this->getState ( 'list.mois' );
    $list_trimestres = $this->getState ( 'list.trimestres' );
    $list_trimestres_query = '';
    if ( $list_trimestres == '1' ) $list_trimestres_query = '1,2,3';
    elseif( $list_trimestres == '2' ) $list_trimestres_query = '4,5,6';
    elseif( $list_trimestres == '3' ) $list_trimestres_query = '7,8,9';
    elseif( $list_trimestres == '4' )  $list_trimestres_query = '10,11,12';
    $list_annee = $this->getState ( 'list.annee' );

    if ($list_mois != 0) $where = "WHERE decl.identification_periode LIKE '%".$list_mois."%'";
    if ($list_trimestres != 0) $where = 'WHERE decl.identification_periode IN ('.$list_trimestres_query.')';
    if ($list_annee != 0) $where = "WHERE decl.date_declarer LIKE '%".$list_annee."%'";

    return $where;
  }

  public function getTauxOccupationStatsCommunes() {
    $where = $this->getOccupationState();

    $db = JFactory::getDBO();
    $query = "SELECT hosting.*, decl.*, COUNT(decl.nb_total_personnes) AS pers_occup_total, COUNT(hosting.capacite_personnes) AS personnes_dispo_total, YEAR(decl.date_declarer) AS annee_date_declarer, MONTH(decl.date_declarer) AS mois_date_declarer
    			FROM #__tdsmanager_hebergements AS hosting
				INNER JOIN  #__tdsmanager_declarations AS decl ON decl.hebergement_id=hosting.id ".$where." GROUP BY hosting.city";
    $db->setQuery((string)$query);
    $tauxoccupationstats = $db->loadObjectlist();

    return $tauxoccupationstats;
  }

  public function getTauxOccupationStatsHeberTypes() {
    $where = $this->getOccupationState();

    $db = JFactory::getDBO();

    $query = "SELECT hosting.*, type.name AS hosting_type_name, decl.*, COUNT(decl.nb_total_personnes) AS pers_occup_total, COUNT(hosting.capacite_chambres) AS chamb_dispo_total, COUNT(hosting.capacite_personnes) AS personnes_dispo_total FROM #__tdsmanager_hebergements AS hosting
              INNER JOIN #__tdsmanager_hebergements_type AS type ON hosting.id_hebergement_type=type.id
              LEFT JOIN  #__tdsmanager_declarations AS decl ON decl.hebergement_id=hosting.id
              ".$where."
              GROUP BY type.name";
    $db->setQuery((string)$query);
    $tauxoccupationstats = $db->loadObjectlist();

    return $tauxoccupationstats;
  }

  public function getTauxOccupationGlobalStats() {
    $where = $this->getOccupationState();

    $db = JFactory::getDBO();

    $query = "SELECT hosting.*, decl.*, COUNT(decl.nb_total_personnes) AS pers_occup_total, COUNT(hosting.capacite_personnes) AS personnes_dispo_total FROM #__tdsmanager_hebergements AS hosting
              LEFT JOIN  #__tdsmanager_declarations AS decl ON decl.hebergement_id=hosting.id ".$where;
    $db->setQuery((string)$query);
    $tauxoccupglob = $db->loadObjectlist();

    return $tauxoccupglob;
  }

  public function getTaxeSejourStats() {
    $where = $this->getOccupationState();

    $db = JFactory::getDBO();

    $query = "SELECT decl.*, hosting.*, SUM(decl.nb_personnes_assujetties) AS nb_pers_assujetties_total, SUM(decl.montant_encaisse_sejour) AS montant_enc_sejour_total, SUM(decl.duree_sejour) AS duree_sejour_total FROM #__tdsmanager_declarations AS decl
              INNER JOIN #__tdsmanager_hebergements AS hosting ON decl.hebergement_id=hosting.id
              ".$where."
              GROUP BY hosting.city";
    $db->setQuery((string)$query);
    $taxesejour = $db->loadObjectlist();

    return $taxesejour;
  }

  public function getTaxeSejourGlobalStats() {
    $where = $this->getOccupationState();

    $db = JFactory::getDBO();

    $query = "SELECT SUM(decl.nb_personnes_assujetties) AS nb_pers_assujetties_total, SUM(decl.montant_encaisse_sejour) AS montant_enc_sejour_total, SUM(decl.duree_sejour) AS duree_sejour_total FROM #__tdsmanager_declarations AS decl ".$where;
    $db->setQuery((string)$query);
    $taxesejourglobal = $db->loadObjectlist();

    return $taxesejourglobal;
  }

  protected function _getQueryCommuneStats($where) {
    $query = "SELECT hosting.*, type.name AS hosting_type_name, decl.*, class.description AS desc_classement, label.nom AS nom_label, users.adress AS adress_owner, users.postalcode AS cp_owner, users.ville AS ville_owner, decl.nb_total_personnes AS pers_occup_total, decl.nb_total_nuitee AS total_nuitee, (decl.nb_total_personnes/hosting.capacite_personnes) AS total_taux_occupation
              FROM #__tdsmanager_hebergements AS hosting
              INNER JOIN #__tdsmanager_hebergements_type AS type ON hosting.id_hebergement_type=type.id
              LEFT JOIN  #__tdsmanager_classements AS class ON hosting.id_classement=class.id
              LEFT JOIN  #__tdsmanager_hebergements_label AS label ON hosting.id_hebergement_label=label.id
              LEFT JOIN  #__tdsmanager_declarations AS decl ON decl.hebergement_id=hosting.id
              LEFT JOIN  #__tdsmanager_users AS users ON users.userid=hosting.userid
              ".$where;
    return $query;
  }

  public function getTotalByHeberType($city) {
    $db = JFactory::getDBO();
    $query = "SELECT hosting.id,hosting.id_hebergement_type,type.name, COUNT(type.name) AS total_type
              FROM #__tdsmanager_hebergements AS hosting
              INNER JOIN #__tdsmanager_hebergements_type AS type ON hosting.id_hebergement_type=type.id
              WHERE hosting.city='".$city."'
              GROUP BY type.name";
    $db->setQuery((string)$query);
    $stats_types = $db->loadObjectlist();
    return $stats_types;
  }

  public function getChevalineStats() {
    $where = $this->getOccupationState();
    if ( empty($where) ) {
      $where = " WHERE hosting.city='Chevaline'";
    } else {
       $where .= " AND hosting.city='Chevaline'";
    }

    $db = JFactory::getDBO();
    $query = $this->_getQueryCommuneStats($where);
    $db->setQuery((string)$query);
    $stats_chevaline = $db->loadObjectlist();

    return $stats_chevaline;
  }

  public function getConsStats() {
    $where = $this->getOccupationState();
    if ( empty($where) ) {
      $where = " WHERE hosting.city='Cons-Sainte-Colombe'";
    } else {
       $where .= " AND hosting.city='Cons-Sainte-Colombe'";
    }

    $db = JFactory::getDBO();
    $query = $this->_getQueryCommuneStats($where);
    $db->setQuery((string)$query);
    $stats_cons = $db->loadObjectlist();

    return $stats_cons;
  }

  public function getDoussardStats() {
    $where = $this->getOccupationState();
    if ( empty($where) ) {
      $where = " WHERE hosting.city='Doussard'";
    } else {
       $where .= " AND hosting.city='Doussard'";
    }

    $db = JFactory::getDBO();
    $query = $this->_getQueryCommuneStats($where);
    $db->setQuery((string)$query);
    $stats_doussard = $db->loadObjectlist();

    return $stats_doussard;
  }

  public function getFavergesStats() {
    $where = $this->getOccupationState();
    if ( empty($where) ) {
      $where = " WHERE hosting.city='Faverges'";
    } else {
       $where .= " AND hosting.city='Faverges'";
    }

    $db = JFactory::getDBO();
    $query = $this->_getQueryCommuneStats($where);
    $db->setQuery((string)$query);
    $stats_faverges = $db->loadObjectlist();

    return $stats_faverges;
  }

  public function getGiezStats() {
    $where = $this->getOccupationState();
    if ( empty($where) ) {
      $where = " WHERE hosting.city='Giez'";
    } else {
       $where .= " AND hosting.city='Giez'";
    }

    $db = JFactory::getDBO();
    $query = $this->_getQueryCommuneStats($where);
    $db->setQuery((string)$query);
    $stats_giez = $db->loadObjectlist();

    return $stats_giez;
  }

  public function getLathuileStats() {
    $where = $this->getOccupationState();
    if ( empty($where) ) {
      $where = " WHERE hosting.city='Lathuile'";
    } else {
       $where .= " AND hosting.city='Lathuile'";
    }

    $db = JFactory::getDBO();
    $query = $this->_getQueryCommuneStats($where);
    $db->setQuery((string)$query);
    $stats_lathuile = $db->loadObjectlist();

    return $stats_lathuile;
  }

  public function getMarlensStats() {
    $where = $this->getOccupationState();
    if ( empty($where) ) {
      $where = " WHERE hosting.city='Marlens'";
    } else {
       $where .= " AND hosting.city='Marlens'";
    }

    $db = JFactory::getDBO();
    $query = $this->_getQueryCommuneStats($where);
    $db->setQuery((string)$query);
    $stats_marlens = $db->loadObjectlist();

    return $stats_marlens;
  }

  public function getMontminStats() {
    $where = $this->getOccupationState();
    if ( empty($where) ) {
      $where = " WHERE hosting.city='Montmin'";
    } else {
       $where .= " AND hosting.city='Montmin'";
    }

    $db = JFactory::getDBO();
    $query = $this->_getQueryCommuneStats($where);
    $db->setQuery((string)$query);
    $stats_montmin = $db->loadObjectlist();

    return $stats_montmin;
  }

  public function getSaintferreolStats() {
    $where = $this->getOccupationState();
    if ( empty($where) ) {
      $where = " WHERE hosting.city='Saint-ferréol'";
    } else {
       $where .= " AND hosting.city='Saint-ferréol'";
    }

    $db = JFactory::getDBO();
    $query = $this->_getQueryCommuneStats($where);
    $db->setQuery((string)$query);
    $stats_montmin = $db->loadObjectlist();

    return $stats_montmin;
  }

  public function getSeythenexStats() {
    $where = $this->getOccupationState();
    if ( empty($where) ) {
      $where = " WHERE hosting.city='Seythenex'";
    } else {
       $where .= " AND hosting.city='Seythenex'";
    }

    $db = JFactory::getDBO();
    $query = $this->_getQueryCommuneStats($where);
    $db->setQuery((string)$query);
    $stats_montmin = $db->loadObjectlist();

    return $stats_montmin;
  }

  public function getMoisList() {
    $list_mois = $this->getState ( 'list.mois' );

    $mois_list = array();
    $mois_list[] = JHTML::_ ( 'select.option', 0, JText::_('COM_TDSMANAGER_SELECT_MOIS'));
    $mois_list[] = JHTML::_ ( 'select.option', 1, 'Janvier' );
    $mois_list[] = JHTML::_ ( 'select.option', 2, 'Février' );
    $mois_list[] = JHTML::_ ( 'select.option', 3, 'Mars' );
    $mois_list[] = JHTML::_ ( 'select.option', 4, 'Avril' );
    $mois_list[] = JHTML::_ ( 'select.option', 5, 'Mai' );
    $mois_list[] = JHTML::_ ( 'select.option', 6, 'Juin' );
    $mois_list[] = JHTML::_ ( 'select.option', 7, 'Juillet' );
    $mois_list[] = JHTML::_ ( 'select.option', 8, 'Aout' );
    $mois_list[] = JHTML::_ ( 'select.option', 9, 'Septembre' );
    $mois_list[] = JHTML::_ ( 'select.option', 10, 'Octobre' );
    $mois_list[] = JHTML::_ ( 'select.option', 11, 'Novembre' );
    $mois_list[] = JHTML::_ ( 'select.option', 12, 'Décembre' );

    $moisList = JHTML::_ ( 'select.genericlist', $mois_list, 'mois_list', 'class="inputbox" size="1" onchange="this.form.submit()"', 'value', 'text', $list_mois );

    return $moisList;
  }

  public function getTrimestreList() {
    $list_trimestres = $this->getState ( 'list.trimestres' );

    $trimestres_list = array();
    $trimestres_list[] = JHTML::_ ( 'select.option', 0, JText::_('COM_TDSMANAGER_SELECT_TRIMESTRE') );
    $trimestres_list[] = JHTML::_ ( 'select.option', 1, 'Trimestre 1' );
    $trimestres_list[] = JHTML::_ ( 'select.option', 2, 'Trimestre 2' );
    $trimestres_list[] = JHTML::_ ( 'select.option', 3, 'Trimestre 3' );
    $trimestres_list[] = JHTML::_ ( 'select.option', 4, 'Trimestre 4' );

    $trimestresList = JHTML::_ ( 'select.genericlist', $trimestres_list, 'trimestres_list', 'class="inputbox" size="1" onchange="this.form.submit()"', 'value', 'text', $list_trimestres );

    return $trimestresList;
  }

  public function getAnneeList() {
    $list_annee = $this->getState ( 'list.annee' );

    $annees_list = array();
    $annees_list[] = JHTML::_ ( 'select.option', 0, JText::_('COM_TDSMANAGER_SELECT_ANNEE'));
    $annees_list[] = JHTML::_ ( 'select.option', 2012, 2012 );
    $annees_list[] = JHTML::_ ( 'select.option', 2013, 2013 );
    $annees_list[] = JHTML::_ ( 'select.option', 2014, 2014 );
    $annees_list[] = JHTML::_ ( 'select.option', 2015, 2015 );

    $anneesList = JHTML::_ ( 'select.genericlist', $annees_list, 'annees_list', 'class="inputbox" size="1" onchange="this.form.submit()"', 'value', 'text', $list_annee );

    return $anneesList;
  }
}