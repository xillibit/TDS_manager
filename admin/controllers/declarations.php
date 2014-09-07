<?php
/**
* TDS_Manager Component
* @package TDS_Manager.Administrator
* @subpackage Controllers
*
* @copyright (C) 2012 - 2014 Florian DAL FITTO. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
**/

// No direct access
defined('_JEXEC') or die;

require_once JPATH_ADMINISTRATOR . '/components/com_tdsmanager/libraries/controller.php';

/**
 * TDS_Manager Declarations Controller
 *
 * @since 1.0
 */
class TdsmanagerAdminControllerDeclarations extends TdsmanagerController {

	function __construct($config = array()) {
		parent::__construct($config);
		$this->baseurl = 'administrator/index.php?option=com_tdsmanager&view=declarations';
	}

	public function edit() {
    // Check for request forgeries.
    if (!JSession::checkToken()) {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }

    $ids = JRequest::getVar ( 'cid', array (), 'post', 'array' );
    if ( !empty($ids) ) {
      $id = array_shift($ids);

      $this->app->setUserState( 'com_gesttaxesejour.declaration.id', $id );

      $this->setRedirect('index.php?option=com_tdsmanager&view=declarations&layout=edit');
    } else {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_DECLARATION_NOTHING_SELECTED'), 'error' );
      $this->app->redirect($this->baseurl);
    }
  }

  public function remove() {
    // Check for request forgeries.
    if (!JSession::checkToken()) {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }

    $ids = JRequest::getVar ( 'cid', array (), 'post', 'array' );
    if ( !empty($ids) ) {
      $ids = implode(',',$ids);

      /*$db = JFactory::getDBO();
      $query = "DELETE FROM #__gesttaxesejour_declarations WHERE id IN ($ids)";
      $db->setQuery((string)$query);
      $db->Query();    */

      // Check for a database error.
  		if ($db->getErrorNum()) {
  			JError::raiseWarning(500, $db->getErrorMsg());
  			return false;
  		}

  		$this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_DECLARATION_ITEMS_DELETED') );
  		$this->app->redirect($this->baseurl);
		} else {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_DECLARATION_NOTHING_SELECTED'), 'error' );
      $this->app->redirect($this->baseurl);
    }
  }

  public function save() {
    // Check for request forgeries.
    if (!JSession::checkToken()) {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }

    $id = JRequest::getInt ( 'id', 0 );
    //if ( !empty($id) ) {
      $userTz = JFactory::getUser()->getParam('timezone');
      $timeZone = JFactory::getConfig()->getValue('offset');
      $myTimezone = new DateTimeZone($timeZone);
      $date = new JDate('now', $myTimezone);
      $date = $date->toSql();

     $post = JRequest::get('post', JREQUEST_ALLOWRAW);

     /*$db = JFactory::getDBO();
     $query = "INSERT INTO #__gesttaxesejour_declarations
              (mois,hebergement_id,nb_personnes_plein_tarif,tarif_nuit_par_personne,nb_nuitees_duree_sejour,sous_total,nb_personnes_reduction_30,nb_personnes_reduction_40,nb_personnes_reduction_50,nb_personnes_reduction_75,
              nb_nuitees_30, nb_nuitees_40, nb_nuitees_50, nb_nuitees_75, nb_personnes_exonerees, sous_total2, montant_total, date_declarer)
              VALUES({$db->quote($post['mois'])},{$db->quote($post['hebergement_id'])},{$db->quote($post['nb_personnes_plein_tarif'])},
              {$db->quote($post['tarif_nuit_par_personne'])},{$db->quote($post['nb_nuitees_duree_sejour'])},
              {$db->quote($post['sous_total'])},{$db->quote($post['nb_personnes_reduction_30'])},{$db->quote($post['nb_personnes_reduction_40'])},{$db->quote($post['nb_personnes_reduction_50'])},
              ,{$db->quote($post['nb_personnes_reduction_75'])},{$db->quote($post['nb_nuitees_30'])},{$db->quote($post['nb_nuitees_40'])},{$db->quote($post['nb_nuitees_50'])},{$db->quote($post['nb_nuitees_75'])},
              {$db->quote($post['nb_personnes_exonerees'])},{$db->quote($post['sous_total2'])},{$db->quote($post['montant_total'])},{$db->quote($post['montant_total'])},{$date})";
     $db->setQuery((string)$query);
     $db->Query();

     // Check for a database error.
     if ($db->getErrorNum()) {
      JError::raiseWarning(500, $db->getErrorMsg());
    	return false;
     }

     $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_DECLARATION_SAVED_SUCESSFULLY') );
  	 $this->app->redirect($this->baseurl);*/
    /*} else {
     $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_DECLARATION_SAVE_ISSUE'), 'error' );
     $this->app->redirect($this->baseurl);
    } */
  }

  public function create() {
    $this->setRedirect('index.php?option=com_tdsmanager&view=declarations&layout=create');
  }

  public function save_first_part() {
    // Check for request forgeries.
    if (!JSession::checkToken()) {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }

    $post = JRequest::get('post', JREQUEST_ALLOWRAW);

    /*if (  $post['hebergement']==0 ) {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_NONE_HOSTING_SELECTED'), 'error' );
      $this->app->redirect('index.php?option=com_gesttaxesejour&view=declarations&layout=create');
    }

    if ( $post['mois']==0 ) {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_NONE_MONTH_SELECTED'), 'error' );
      $this->app->redirect('index.php?option=com_gesttaxesejour&view=declarations&layout=create');
    }

    // A revoir avec la nouvelle structure de la base de donnée
    $db = JFactory::getDBO();
    $query = "SELECT tarif FROM #__gesttaxesejour_hebergclass
              WHERE id_hebergement='{$post['hebergement']}'";
    $db->setQuery((string)$query);
    $tarif_hebergement = $db->loadResult();

    // Check for a database error.
  	if ($db->getErrorNum()) {
  	 JError::raiseWarning(500, $db->getErrorMsg());
  	 return false;
  	}

    if ( $tarif_hebergement != '0.00' ) {*/
      $object = new StdClass;
      $object->mois = $post['mois'];
      $object->hebergement_id = $post['hebergement'];
      $object->nb_personnes_plein_tarif = $post['nb_personnes_plein_tarif'];
      $object->tarif_hebergement = $tarif_hebergement;

      $this->app->setUserState( 'com_gesttaxesejour.declaration.decl_first_part', $object );

      $this->setRedirect('index.php?option=com_tdsmanager&view=declarations&layout=detail');
    /*} else {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_NONE_TARIF_SAVED_FOR_THIS_HOSTING'), 'error' );
      $this->app->redirect('index.php?option=com_gesttaxesejour&view=declarations&layout=create');
    }*/
  }
}