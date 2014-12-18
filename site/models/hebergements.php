<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die;

jimport('joomla.application.component.model');

/**
 * This models supports retrieving lists of contact categories.
 *
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @since		1.6
 */
class TdsmanagerModelHebergements extends JModel {
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState() {
		$app = JFactory::getApplication();

		// Get the parent id if defined.
		$Hosting_Id = $app->input->getInt('id', 0);
		$this->setState('com_tdsmanager.hosting.Id', $Hosting_Id);

		// List state information

		$value = $app->input->getInt('limit', $app->getCfg('list_limit', 0));
		$this->setState('list.limit', $value);

		$value = $app->input->getInt('limitstart', 0);
		$this->setState('list.start', $value);
	}

	/**
	 * redefine the function an add some properties to make the styling more easy
	 *
	 * @return mixed An array of data items on success, false on failure.
	 */
	public function getHebergements() 	{
		$user = JFactory::getUser();
    $db = JFactory::getDBO();

    if ( $user->id > 0 ) {
      /* $query = $db->getQuery(true);
      $query->select('hosting.*, class.description AS classement_name')->from('#__tdsmanager_hebergements AS hosting')->leftJoin('#__tdsmanager_classements AS class ON class.id=hosting.id_classement')->where("hosting.userid={$db->quote($user->id)}");
      */
      $query = "SELECT hosting.*, class.description AS classement_name FROM #__tdsmanager_hebergements AS hosting
                LEFT JOIN #__tdsmanager_classements AS class ON class.id=hosting.id_classement
                WHERE hosting.userid={$db->quote($user->id)}";
      $db->setQuery((string)$query);
      $hostings_list = $db->loadObjectList();

      $this->setState ( 'list.total', count($hostings_list) );

      $this->setState('com_tdsmanager.hosting.total', count($hostings_list));

  		return $hostings_list;
		}
		return array();
	}

	public function getHebergement() {
    $db = JFactory::getDBO();
    $app = JFactory::getApplication();

    $id = $app->getUserState('com_tdsmanager.edit.hebergement.id');
    if ( $id ) {
      /*$query = $db->getQuery(true);
      $query->select('*')->from('#__tdsmanager_hebergements')->where("id={$id}")*/
      $query = "SELECT * FROM #__tdsmanager_hebergements
                WHERE id={$id}";
      $db->setQuery((string)$query);
      $hosting = $db->loadObject();

   		return $hosting;
    } else {
      $hosting = new stdClass();
      return $hosting;
    }
  }

	public function getClassementList()	{
	  $db = JFactory::getDBO();
    /*$query = $db->getQuery(true);
    $query->select('*')->from('#__tdsmanager_classements')->where('state=1'); */
    $query = "SELECT * FROM #__tdsmanager_classements WHERE state=1";
    $db->setQuery((string)$query);
    $classement = $db->loadObjectlist();

    $classement_list = array();
    foreach($classement as $id=>$cl) {
     $classement_list[] = JHTML::_ ( 'select.option', $id, $cl->description );
    }
    $list = JHTML::_ ( 'select.genericlist', $classement_list, 'numero_classement', 'class="inputbox" size="1"', 'value', 'text' );

    return $list;
	}

  public function getLabelList()	{
	  $db = JFactory::getDBO();
    /*$query = $db->getQuery(true);
    $query->select('*')->from('#__tdsmanager_hebergements_label'); */
    $query = "SELECT * FROM #__tdsmanager_hebergements_label";
    $db->setQuery((string)$query);
    $labels = $db->loadObjectlist();

    $label_list = array();
    $label_list[] = JHTML::_ ( 'select.option', 0, JText::_('COM_TDSMANAGER_HEBERGEMENT_LABEL_NONE') );
    foreach($labels as $id=>$cl) {
     $label_list[] = JHTML::_ ( 'select.option', $id, $cl->nom );
    }
    $list = JHTML::_ ( 'select.genericlist', $label_list, 'labels', 'class="inputbox" size="1"', 'value', 'text' );

    return $list;
	}

	public function getIdentificationPeriode() {
    $identification_list = array();
    $identification_list[] = JHTML::_ ( 'select.option', 1, 'Janvier' );
    $identification_list[] = JHTML::_ ( 'select.option', 2, 'Février' );
    $identification_list[] = JHTML::_ ( 'select.option', 3, 'Mars' );
    $identification_list[] = JHTML::_ ( 'select.option', 4, 'Avril' );
    $identification_list[] = JHTML::_ ( 'select.option', 5, 'Mai' );
    $identification_list[] = JHTML::_ ( 'select.option', 6, 'Juin' );
    $identification_list[] = JHTML::_ ( 'select.option', 7, 'Juillet' );
    $identification_list[] = JHTML::_ ( 'select.option', 8, 'Aout' );
    $identification_list[] = JHTML::_ ( 'select.option', 9, 'Septembre' );
    $identification_list[] = JHTML::_ ( 'select.option', 10, 'Octobre' );
    $identification_list[] = JHTML::_ ( 'select.option', 11, 'Novembre' );
    $identification_list[] = JHTML::_ ( 'select.option', 12, 'Decembre' );
    $list = JHTML::_ ( 'select.genericlist', $identification_list, 'identification_period_list', 'class="inputbox" size="1"', 'value', 'text' );

    return $list;
  }

  public function getMyHebergementsList() {
    $myhebergements = $this->getHebergements();

    $hebergement_list = array();
    foreach($myhebergements as $hebergement) {
      $hebergement_list[] = JHTML::_ ( 'select.option', $hebergement->id, $hebergement->hostingname );
    }

    $list = JHTML::_ ( 'select.genericlist', $hebergement_list, 'hebergement_list', 'class="inputbox" size="1" onchange="this.form.submit()"', 'value', 'text' );

    return $list;
  }
}
