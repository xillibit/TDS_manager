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
      $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }

    $ids = $this->app->input->get('cid',array(),'ARRAY');

    if ( !empty($ids) ) {
      $id = array_shift($ids);

      $this->app->setUserState( 'com_tdsmanager.declaration.id', $id );

      $this->setRedirect('index.php?option=com_tdsmanager&view=declarations&layout=edit');
    } else {
      $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_DECLARATION_NOTHING_SELECTED'), 'error' );
      $this->app->redirect($this->baseurl);
    }
  }

  public function remove() {
    // Check for request forgeries.
    if (!JSession::checkToken()) {
      $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }

    $ids = $this->app->input->get('cid',array(),'ARRAY');
    if ( !empty($ids) ) {
      $ids = implode(',',$ids);

      /*$db = JFactory::getDBO();
      $query = "DELETE FROM #__tdsmanager_declarations WHERE id IN ($ids)";
      $db->setQuery((string)$query);
      try
		{
			$db->Query();
		}
		catch (Exception $e)
		{
			$this->app->enqueueMessage ($e->getMessage());
			return false;
		}*/

  		$this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_DECLARATION_ITEMS_DELETED') );
  		$this->app->redirect($this->baseurl);
		} else {
      $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_DECLARATION_NOTHING_SELECTED'), 'error' );
      $this->app->redirect($this->baseurl);
    }
  }

	/**
	 * Save declaration into database
	 */
	public function save() {
		// Check for request forgeries.
		if (!JSession::checkToken()) {
			$this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_TOKEN'), 'error' );
			$this->app->redirect($this->baseurl);
		}

		$id = $this->app->input->getInt('id', 0);

		//if ( !empty($id) ) {
		$userTz = JFactory::getUser()->getParam('timezone');
		$timeZone = JFactory::getConfig()->getValue('offset');
		$myTimezone = new DateTimeZone($timeZone);
		$date = new JDate('now', $myTimezone);
		$date = $date->toSql();

		$mois = $this->app->input->getString('mois');
		$hebergement_id = $this->app->input->getInt('hebergement_id', 0);
		$nb_personnes_plein_tarif = $this->app->input->getInt('nb_personnes_plein_tarif', 0);
		$tarif_nuit_par_personne = $this->app->input->getFloat('tarif_nuit_par_personne');
		$nb_nuitees_duree_sejour = $this->app->input->getInt('nb_nuitees_duree_sejour', 0);
		$sous_total = $this->app->input->getFloat('sous_total');
		$nb_personnes_reduction_30 = $this->app->input->getInt('nb_personnes_reduction_30', 0);
		$nb_personnes_reduction_40 = $this->app->input->getInt('nb_personnes_reduction_40', 0);
		$nb_personnes_reduction_50 = $this->app->input->getInt('nb_personnes_reduction_50', 0);
		$nb_personnes_reduction_75 = $this->app->input->getInt('nb_personnes_reduction_75', 0);
		$nb_nuitees_30 = $this->app->input->getFloat('nb_nuitees_30');
		$nb_nuitees_40 = $this->app->input->getFloat('nb_nuitees_40');
		$nb_nuitees_50 = $this->app->input->getFloat('nb_nuitees_50');
		$nb_nuitees_75 = $this->app->input->getFloat('nb_nuitees_75');
		$nb_personnes_exonerees = $this->app->input->getInt('nb_personnes_exonerees', 0);
		$sous_total2 = $this->app->input->getFloat('sous_total2');
		$montant_total = $this->app->input->getFloat('montant_total');

		/*$db = JFactory::getDBO();
		$query = "INSERT INTO #__tdsmanager_declarations
			(mois,hebergement_id,nb_personnes_plein_tarif,tarif_nuit_par_personne,nb_nuitees_duree_sejour,sous_total,nb_personnes_reduction_30,nb_personnes_reduction_40,nb_personnes_reduction_50,nb_personnes_reduction_75,
			nb_nuitees_30, nb_nuitees_40, nb_nuitees_50, nb_nuitees_75, nb_personnes_exonerees, sous_total2, montant_total, date_declarer)
			VALUES({$db->quote($post['mois'])},{$db->quote($post['hebergement_id'])},{$db->quote($post['nb_personnes_plein_tarif'])},
			{$db->quote($post['tarif_nuit_par_personne'])},{$db->quote($post['nb_nuitees_duree_sejour'])},
			{$db->quote($post['sous_total'])},{$db->quote($post['nb_personnes_reduction_30'])},{$db->quote($post['nb_personnes_reduction_40'])},{$db->quote($post['nb_personnes_reduction_50'])},
			,{$db->quote($post['nb_personnes_reduction_75'])},{$db->quote($post['nb_nuitees_30'])},{$db->quote($post['nb_nuitees_40'])},{$db->quote($post['nb_nuitees_50'])},{$db->quote($post['nb_nuitees_75'])},
			{$db->quote($post['nb_personnes_exonerees'])},{$db->quote($post['sous_total2'])},{$db->quote($post['montant_total'])},{$db->quote($post['montant_total'])},{$date})";
		$db->setQuery((string)$query);

		try
		{
			$db->Query();
		}
		catch (Exception $e)
		{
			$this->app->enqueueMessage ($e->getMessage());
			return false;
		}

		$this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_DECLARATION_SAVED_SUCESSFULLY') );
		$this->app->redirect($this->baseurl);*/
		/*} else {
		$this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_DECLARATION_SAVE_ISSUE'), 'error' );
		$this->app->redirect($this->baseurl);
		} */
	}

  public function create() {
    $this->setRedirect('index.php?option=com_tdsmanager&view=declarations&layout=create');
  }

  public function save_first_part() {
    // Check for request forgeries.
    if (!JSession::checkToken()) {
      $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }

    $hebergement = $this->app->input->getInt('hebergement', 0);
    $mois = $this->app->input->getInt('mois', 0);

    /*if (  $hebergement==0 ) {
      $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_NONE_HOSTING_SELECTED'), 'error' );
      $this->app->redirect('index.php?option=com_tdsmanager&view=declarations&layout=create');
    }

    if ( $mois==0 ) {
      $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_NONE_MONTH_SELECTED'), 'error' );
      $this->app->redirect('index.php?option=com_tdsmanager&view=declarations&layout=create');
    }

    // A revoir avec la nouvelle structure de la base de donnée
    $db = JFactory::getDBO();
    $query = "SELECT tarif FROM #__tdsmanager_hebergclass
              WHERE id_hebergement='{$hebergement}'";
    $db->setQuery((string)$query);

    // Check for a database error.
  	try
		{
			$tarif_hebergement = $db->loadResult();
		}
		catch (Exception $e)
		{
			$this->app->enqueueMessage ($e->getMessage());
			return false;
		}

    if ( $tarif_hebergement != '0.00' ) {*/
      $object = new StdClass;
      $object->mois = $mois;
      $object->hebergement_id = $hebergement;
      $object->nb_personnes_plein_tarif = $post['nb_personnes_plein_tarif'];
      $object->tarif_hebergement = $tarif_hebergement;

      $this->app->setUserState( 'com_tdsmanager.declaration.decl_first_part', $object );

      $this->setRedirect('index.php?option=com_tdsmanager&view=declarations&layout=detail');
    /*} else {
      $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_NONE_TARIF_SAVED_FOR_THIS_HOSTING'), 'error' );
      $this->app->redirect('index.php?option=com_tdsmanager&view=declarations&layout=create');
    }*/
  }
}