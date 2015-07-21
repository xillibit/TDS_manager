<?php
/**
* TDS_Manager Component
* @package TDS_Manager.Administrator
* @subpackage Controllers
*
* @copyright (C) 2010 - 2014 Florian DAL FITTO. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
**/

// No direct access
defined('_JEXEC') or die;

require_once JPATH_ADMINISTRATOR . '/components/com_tdsmanager/libraries/controller.php';

/**
* TDS_Manager Hebergements Controller
*
* @since 1.0
*/
class TdsmanagerAdminControllerHebergements extends TdsmanagerController {
   protected $baseurl = null;
    /**
	 * Constructor.
	 *
	 * @param	array An optional associative array of configuration settings.
	 * @see		JController
	 * @since	1.6
	 */
	public function __construct($config = array()) {
		parent::__construct($config);
		$this->baseurl = 'index.php?option=com_tdsmanager&view=hebergements';
	}

	/**
	 * @since	1.6
	 */
	public function create() {
		$app = JFactory::getApplication();
		
		// Check for request forgeries.
		if (!JSession::checkToken()) {
			$app->enqueueMessage ( JText::_('COM_TDSMANAGER_TOKEN'), 'error' );
			$app->redirect($this->baseurl);
		}

		$app->setUserState( "com_tdsmanager.hebergement.id", 0 );

		$this->setRedirect('index.php?option=com_tdsmanager&view=hebergements&layout=create');
	}

	/**
	 * @since	1.6
	 */
	public function edit() {
		$app = JFactory::getApplication();
		
		// Check for request forgeries.
		if (!JSession::checkToken()) {
			$app->enqueueMessage ( JText::_('COM_TDSMANAGER_TOKEN'), 'error' );
			$app->redirect($this->baseurl);
		}

		$cids = $app->input->get('cid',array(),'ARRAY');
		$cid = array_shift($cids);

		$app->setUserState( "com_tdsmanager.hebergement.id", $cid );

		$this->setRedirect('index.php?option=com_tdsmanager&view=hebergements&layout=create');
	}

	/**
	 * Save or update declaration data
	 *
	 * @return boolean
	 */
	public function save() {
		$app = JFactory::getApplication();
		
		if (!JSession::checkToken()) {
			$app->enqueueMessage ( JText::_('COM_TDSMANAGER_TOKEN'), 'error' );
			$app->redirect($this->baseurl);
		}

		$db = JFactory::getDBO();

		$id = $app->getInt('id', 0);
		$hostingname = $app->input->getString('hostingname', null);
		$description  = $app->input->getString('description', null);
		$adress = $app->input->getString('adress', null);
		$complement_adress = $app->input->getString('complement_adress', null);
		$city = $app->input->getString('city', null);
		$website = $app->input->getString('website', null);
		$email = $app->input->getString('email', null);
		$postalcode = $app->input->getInt('postalcode', 0);
		$numero_classement = $app->input->getInt('numero_classement', 0);
		$date_classement = $app->input->getString('date_classement', null);
		$classement = $app->input->getInt('classement', 0);
		$hebergement_type  = $app->input->getInt('hebergement_type', 0);
		$label  = $app->input->getInt('label', 0);
		$capacite_personnes = $app->input->getInt('capacite_personnes', 0);
		$capacite_chambres = $app->input->getInt('capacite_chambres', 0);

		if ( !$id ) {
			$query = "INSERT INTO #__tdsmanager_hebergements
				(hostingname,description,adress,complement_adress,city,website,email,postalcode,numero_classement,date_classement,id_classement,id_hebergement_type,id_hebergement_label,capacite_personnes,capacite_chambres,userid)
				VALUES({$db->quote($hostingname)},{$db->quote($description)},{$db->quote($adress)},{$db->quote($complement_adress)},{$db->quote($city)}, {$db->quote($website)},{$db->quote($email)},{$db->quote($postalcode)},{$db->quote($numero_classement)},{$db->quote($date_classement)},{$db->quote($classement)},{$db->quote($hebergement_type)},{$db->quote($label)},{$db->quote($capacite_personnes)},{$db->quote($capacite_chambres)},{$db->quote($user_id)})";
			$db->setQuery((string)$query);

			try
			{
				$db->Query();
			}
			catch (Exception $e)
			{
				$app->enqueueMessage ($e->getMessage());
				return false;
			}

			$app->enqueueMessage ( JText::_('COM_TDSMANAGER_HEBERGEMENT_SAVED') );
			$app->redirect($this->baseurl);

       /* Récupérer le tarif de la taxe de séjour correspondant à l'hébergement
       $heberg_id = $db->insertid();

       // enregistrer les données dans hebergclass
       $query = "INSERT INTO #__tdsmanager_hebergclass (id_hebergement,id_classement,tarif,userid,id_hebergement_type,id_hebergement_label)
                VALUES ({$db->quote($heberg_id)},{$db->quote($post['classement'])},'',{$db->quote($post['user_id'])},{$db->quote($post['hebergement_type'])},{$db->quote($post['label'])})";
       $db->setQuery((string)$query);
       $db->Query();

       try
		{
			$db->Query();
		}
		catch (Exception $e)
		{
			$this->app->enqueueMessage ($e->getMessage());
			return false;
		}*/

		} else {
			$query = "UPDATE #__tdsmanager_hebergements
				SET hostingname={$db->quote($hostingname)},description={$db->quote($description)},adress={$db->quote($adress)},complement_adress={$db->quote($complement_adress)},city={$db->quote($city)},website={$db->quote($website)},email={$db->quote($email)},postalcode={$db->quote($postalcode)},id_classement={$db->quote($classement)},id_hebergement_type={$db->quote($hebergement_type)},id_hebergement_label={$db->quote($label)},numero_classement={$db->quote($numero_classement)},date_classement={$db->quote($date_classement)},capacite_personnes={$db->quote($capacite_personnes)},capacite_chambres={$db->quote($capacite_chambres)}
				WHERE id={$db->quote($id)}";
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

	        // mettre à jour les données dans hebergclass
	       /*$query = "UPDATE #__tdsmanager_hebergclass SET id_classement=,tarif=,userid=,id_hebergement_type=,id_hebergement_label= WHERE id_hebergement={$db->quote($id)}";
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

			$app->enqueueMessage ( JText::_('COM_TDSMANAGER_HEBERGEMENT_EDITION_SAVED') );
			$app->redirect($this->baseurl);
		}
	}

	/**
	 * @since	1.6
	 */
	public function trash() {
		$app = JFactory::getApplication();
		
		// Check for request forgeries.
		if (!JSession::checkToken()) {
			$app->enqueueMessage ( JText::_('COM_TDSMANAGER_TOKEN'), 'error' );
			$app->redirect($this->baseurl);
		}

		$cids = $app->input->get('cid',array(),'ARRAY');
		$id = array_shift($cids);

		if ( $id > 0 ) {
			$db = JFactory::getDBO();
			$query = "DELETE FROM #__tdsmanager_hebergements WHERE id={$db->Quote($id)}";
			$db->setQuery((string)$query);
			
			try
			{
				$db->Query();
			}
			catch (Exception $e)
			{
				$app->enqueueMessage ($e->getMessage());
				return false;
			}

			/**
			*  $state = 1 published
			*  $state = 2 unpublished
			*  $state = 3 trashed
			*/
			
			$app->enqueueMessage ( JText::_('COM_TDSMANAGER_HEBERGEMENT_TRASHED') );
			$app->redirect($this->baseurl);
		} else {
			$app->enqueueMessage ( JText::_('COM_TDSMANAGER_HEBERGEMENT_TRASHED_FAILED') );
			$app->redirect($this->baseurl);
		}
	}

	/**
	 * @since	1.6
	 */
	public function unpublish() {
		$app = JFactory::getApplication();
		
		// Check for request forgeries.
		if (!JSession::checkToken()) {
			$app->enqueueMessage ( JText::_('COM_TDSMANAGER_TOKEN'), 'error' );
			$app->redirect($this->baseurl);
		}

		//$cids =
		if ( !empty($cids) ) {
			$app->enqueueMessage ( JText::_('COM_TDSMANAGER_NO_HEBERGEMENT_SELECTED'), 'error' );
			$app->redirect($this->baseurl);
		} else {
			$state = $this->_setState($id,0);
			
			if ( $state ) {
				$app->enqueueMessage ( JText::_('COM_TDSMANAGER_HEBERGEMENT_UNPUSBLISHED'), 'error' );
			} else {
				$app->enqueueMessage ( JText::_('COM_TDSMANAGER_HEBERGEMENT_CHANGE_STATE_FAILED'), 'error' );
			}
			
			$app->redirect($this->baseurl);
		}
		die();
	}

	/**
	 * @since	1.6
	 */
	public function publish() {
		$app = JFactory::getApplication();
		
		// Check for request forgeries.
		if (!JSession::checkToken()) {
			$app->enqueueMessage ( JText::_('COM_TDSMANAGER_TOKEN'), 'error' );
			$app->redirect($this->baseurl);
		}
		
		$state = $this->_setState($id,1);
		if ( $state ) {
			$app->enqueueMessage ( JText::_('COM_TDSMANAGER_HEBERGEMENT_PUSBLISHED') );
		} else {
			$app->enqueueMessage ( JText::_('COM_TDSMANAGER_HEBERGEMENT_CHANGE_STATE_FAILED'), 'error' );
		}
		
		$app->redirect($this->baseurl);
	}

	/**
	 * @since	1.6
	 */
	protected function _setState($id, $state) {
		$app = JFactory::getApplication();
		
		$db = JFactory::getDBO();
		$query = "UPDATE #__tdsmanager_hebergements SET state={$db->Quote($state)} WHERE id={$db->Quote($id)}";
		$db->setQuery((string)$query);

		try
		{
			$db->Query();
		}
		catch (Exception $e)
		{
			$app->enqueueMessage ($e->getMessage());
			return false;
		}

		return true;
	}
}