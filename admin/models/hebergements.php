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
class TdsmanagerAdminModelHebergements extends TdsmanagerModel {
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

    $value = $this->getUserStateFromRequest ( 'com_tdsmanager.admin.hebergements.list.search', 'filter_search', '', 'string' );
    $this->setState ( 'list.search', $value );

    $value = $this->getUserStateFromRequest ( "com_tdsmanager.admin.hebergements.list.levels", 'levellimit', 10, 'int' );
    $this->setState ( 'list.levels', $value );
	}

	public function getListHebergements() {
    $db = JFactory::getDBO();

    $query = "SELECT COUNT(*) FROM #__tdsmanager_hebergements AS hosting";
    $db->setQuery((string)$query);
    $total = $db->loadResult();

    $this->setState ( 'list.total', $total );
    $search = $this->getState ( 'list.search');
    $search_value='';
    if (!empty($search) ) {
      $search_value = " WHERE hosting.hostingname LIKE {$db->quote('%'.$search.'%')}";
    }

    $query = "SELECT hosting.id AS hosting_id,hosting.*, class.description AS class_desc, hosting_type.name AS hosting_type_name, label.nom AS label_nom
			FROM #__tdsmanager_hebergements AS hosting
			LEFT JOIN #__tdsmanager_hebergclass AS hclass ON hosting.id=hclass.id_hebergement
			LEFT JOIN #__tdsmanager_classements AS class ON class.id=hclass.id_classement
			LEFT JOIN #__tdsmanager_hebergements_type AS hosting_type ON hosting_type.id=hosting.id_hebergement_type
			LEFT JOIN #__tdsmanager_hebergements_label AS label ON label.id=hosting.id_hebergement_label".$search_value;
    $db->setQuery((string)$query, $this->getState ( 'list.start' ),$this->getState ( 'list.limit' ));
    $hebergementslist = $db->loadObjectlist();

    return $hebergementslist;
  }

  public function getHebergement() {
    $app = JFactory::getApplication();
    $id = $app->getUserState( "com_gesttaxesejour.hebergement.id" );

    $hebergement= new stdClass();

    if ( $id > 0 )
    {
      $db = JFactory::getDBO();
      $query = "SELECT * FROM #__tdsmanager_hebergements WHERE id={$db->quote($id)}";
      $db->setQuery((string)$query);
      $hebergement = $db->loadObject();

      $this->setState ( 'hebergement.typeid',$hebergement->id_hebergement_type);
      $this->setState ( 'hebergement.labelid',$hebergement->id_hebergement_label);
      $this->setState ( 'hebergement.classementid',$hebergement->id_classement);
      $this->setState ( 'hebergement.userid', $hebergement->userid );
    }
    return $hebergement;
  }

  public function getListLabel() {
    $labelid = $this->getState ( 'hebergement.labelid' );
    $h_labelid = 0;
    if ( !empty($labelid) ) $h_labelid = $labelid;

    $db = JFactory::getDBO();
    $query = "SELECT * FROM #__tdsmanager_hebergements_label";
    $db->setQuery((string)$query);
    $labels = $db->loadObjectlist();

    $label_list = array();
    $users_list[] = JHTML::_ ( 'select.option', 0, 'Choissisez le label de l\'hébergement' );
    foreach($labels as $label) {
     $label_list[] = JHTML::_ ( 'select.option', $label->id, $label->nom );
    }
    $list = JHTML::_ ( 'select.genericlist', $label_list, 'label', 'class="inputbox" size="1"', 'value', 'text', $h_labelid);

    return $list;
  }

  public function getListTypesHebergement() {
    $typeid = $this->getState ( 'hebergement.typeid' );
    $h_typeid = 0;
    if ( !empty($typeid) ) $h_typeid = $typeid;

    $db = JFactory::getDBO();
    $query = "SELECT * FROM #__tdsmanager_hebergements_type WHERE state='1'";
    $db->setQuery((string)$query);
    $types = $db->loadObjectlist();

    $types_list = array();
    $users_list[] = JHTML::_ ( 'select.option', 0, 'Choissisez le type de l\'hébergement' );
    foreach($types as $type) {
     $types_list[] = JHTML::_ ( 'select.option', $type->id, $type->name );
    }
    $list = JHTML::_ ( 'select.genericlist', $types_list, 'hebergement_type', 'class="inputbox" size="1"', 'value', 'text', $h_typeid);

    return $list;
  }

  public function getListClassement() {
    $classementid = $this->getState ( 'hebergement.classementid' );
    $h_classementid = 0;
    if ( !empty($classementid) ) $h_classementid = $classementid;

    $db = JFactory::getDBO();
    $query = "SELECT * FROM #__tdsmanager_classements WHERE state=1";
    $db->setQuery((string)$query);
    $classement = $db->loadObjectlist();

    $classement_list = array();
    $users_list[] = JHTML::_ ( 'select.option', 0, 'Choissisez le classement de l\'hébergement' );
    foreach($classement as $cl) {
     $classement_list[] = JHTML::_ ( 'select.option', $cl->id, $cl->description );
    }
    $list = JHTML::_ ( 'select.genericlist', $classement_list, 'classement', 'class="inputbox" size="1"', 'value', 'text', $h_classementid);

    return $list;
  }

  public function getListUsers() {
    $userid = $this->getState ( 'hebergement.userid' );
    $h_userid = 0;
    if ( !empty($userid) ) $h_userid = $userid;

    $db = JFactory::getDBO();
    $query = "SELECT * FROM #__tdsmanager_users";
    $db->setQuery((string)$query);
    $users = $db->loadObjectlist();

    $users_list = array();
    $users_list[] = JHTML::_ ( 'select.option', 0, 'Choissisez le propriétaire de l\'hébergement' );
    foreach($users as $user) {
     $users_list[] = JHTML::_ ( 'select.option', $user->userid, $user->name.' '.$user->lastname );
    }
    $list = JHTML::_ ( 'select.genericlist', $users_list, 'user_id', 'class="inputbox" size="1"', 'value', 'text', $h_userid );

    return $list;
  }

  public function getAdminNavigation() {
    $navigation = new JPagination ($this->getState ( 'list.total'), $this->getState ( 'list.start'), $this->getState ( 'list.limit') );
    return $navigation;
  }
}
?>