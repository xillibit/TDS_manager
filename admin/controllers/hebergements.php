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
 * Hebergements list controller class.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_gesttaxesejour
 * @since       1.6
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
    // Check for request forgeries.
    if (!JSession::checkToken()) {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }

    $this->app->setUserState( "com_gesttaxesejour.hebergement.id", 0 );

		$this->setRedirect('index.php?option=com_tdsmanager&view=hebergements&layout=create');
	}

	/**
	 * @since	1.6
	 */
	public function edit() {
    // Check for request forgeries.
		if (!JSession::checkToken()) {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }

    $cids = JRequest::getVar ( 'cid', array (), 'post', 'array' );
    $cid = array_shift($cids);

    $this->app->setUserState( "com_gesttaxesejour.hebergement.id", $cid );

		$this->setRedirect('index.php?option=com_tdsmanager&view=hebergements&layout=create');
	}

	public function save() {
	   if (!JSession::checkToken()) {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
      }

     $id = JRequest::getInt('id', 0);
     $post = JRequest::get('post', JREQUEST_ALLOWRAW);

     $db = JFactory::getDBO();

     if ( !$id ) {
       $query = "INSERT INTO #__tdsmanager_hebergements
                (hostingname,description,adress,complement_adress,city,website,email,postalcode,numero_classement,date_classement,id_classement,id_hebergement_type,id_hebergement_label,capacite_personnes,capacite_chambres,userid)
                VALUES({$db->quote($post['hostingname'])},{$db->quote($post['description'])},{$db->quote($post['adress'])},{$db->quote($post['complement_adress'])},{$db->quote($post['city'])}, {$db->quote($post['website'])},{$db->quote($post['email'])},{$db->quote($post['postalcode'])},{$db->quote($post['numero_classement'])},{$db->quote($post['date_classement'])},{$db->quote($post['classement'])},{$db->quote($post['hebergement_type'])},{$db->quote($post['label'])},{$db->quote($post['capacite_personnes'])},{$db->quote($post['capacite_chambres'])},{$db->quote($post['user_id'])})";
       $db->setQuery((string)$query);
       $db->Query();

        // Check for a database error.
    		if ($db->getErrorNum()) {
    			JError::raiseWarning(500, $db->getErrorMsg());
    			return false;
    		}

       /* Récupérer le tarif de la taxe de séjour correspondant à l'hébergement
       $heberg_id = $db->insertid();

       // enregistrer les données dans hebergclass
       $query = "INSERT INTO #__tdsmanager_hebergclass (id_hebergement,id_classement,tarif,userid,id_hebergement_type,id_hebergement_label)
                VALUES ({$db->quote($heberg_id)},{$db->quote($post['classement'])},'',{$db->quote($post['user_id'])},{$db->quote($post['hebergement_type'])},{$db->quote($post['label'])})";
       $db->setQuery((string)$query);
       $db->Query();

        // Check for a database error.
    		if ($db->getErrorNum()) {
    			JError::raiseWarning(500, $db->getErrorMsg());
    			return false;
    		}*/

       $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_SAVED') );
       $this->app->redirect($this->baseurl);
     } else {
       $query = "UPDATE #__tdsmanager_hebergements
                SET hostingname={$db->quote($post['hostingname'])},description={$db->quote($post['description'])},adress={$db->quote($post['adress'])},complement_adress={$db->quote($post['complement_adress'])},city={$db->quote($post['city'])},website={$db->quote($post['website'])},email={$db->quote($post['email'])},postalcode={$db->quote($post['postalcode'])},id_classement={$db->quote($post['classement'])},id_hebergement_type={$db->quote($post['hebergement_type'])},id_hebergement_label={$db->quote($post['label'])},numero_classement={$db->quote($post['numero_classement'])},date_classement={$db->quote($post['date_classement'])},capacite_personnes={$db->quote($post['capacite_personnes'])},capacite_chambres={$db->quote($post['capacite_chambres'])}
                WHERE id={$db->quote($id)}";
       $db->setQuery((string)$query);
       $db->Query();

        // Check for a database error.
    		if ($db->getErrorNum()) {
    			JError::raiseWarning(500, $db->getErrorMsg());
    			return false;
    		}

        // mettre à jour les données dans hebergclass
       /*$query = "UPDATE #__tdsmanager_hebergclass SET id_classement=,tarif=,userid=,id_hebergement_type=,id_hebergement_label= WHERE id_hebergement={$db->quote($id)}";
       $db->setQuery((string)$query);
       $db->Query();

        // Check for a database error.
    		if ($db->getErrorNum()) {
    			JError::raiseWarning(500, $db->getErrorMsg());
    			return false;
    		} */

       $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_EDITION_SAVED') );
       $this->app->redirect($this->baseurl);
     }
	}

	/**
	 * @since	1.6
	 */
	public function trash() {
		// Check for request forgeries.
		if (!JSession::checkToken()) {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }

    $cids = JRequest::getVar ( 'cid', array (), 'post', 'array' );
    $id = array_shift($cids);

    if ( $id > 0 ) {
      $db = JFactory::getDBO();
      $query = "DELETE FROM #__tdsmanager_hebergements WHERE id={$db->Quote($id)}";
      $db->setQuery((string)$query);
      $db->Query();

      // Check for a database error.
  		if ($db->getErrorNum()) {
  			JError::raiseWarning(500, $db->getErrorMsg());
  			return false;
  		}
      /**
       *  $state = 1 published
       *  $state = 2 unpublished
       *  $state = 3 trashed
       */
       $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_TRASHED') );
       $this->app->redirect($this->baseurl);
     } else {
       $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_TRASHED_FAILED') );
       $this->app->redirect($this->baseurl);
     }
	}

	/**
	 * @since	1.6
	 */
	public function unpublish() {
		// Check for request forgeries.
		if (!JSession::checkToken()) {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }

    //$cids =
    if ( !empty($cids) ) {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_NO_HEBERGEMENT_SELECTED'), 'error' );
      $this->app->redirect($this->baseurl);
    } else {
      $state = $this->_setState($id,0);
      if ( $state ) {
        $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_UNPUSBLISHED'), 'error' );
      } else {
        $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_CHANGE_STATE_FAILED'), 'error' );
      }
      $this->app->redirect($this->baseurl);
    }
    die();
	}

	/**
	 * @since	1.6
	 */
	public function publish() {
		// Check for request forgeries.
		if (!JSession::checkToken()) {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }
    $state = $this->_setState($id,1);
    if ( $state ) {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_PUSBLISHED') );
    } else {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_CHANGE_STATE_FAILED'), 'error' );
    }
    $this->app->redirect($this->baseurl);
	}

	/**
	 * @since	1.6
	 */
	protected function _setState($id, $state) {
    $db = JFactory::getDBO();
    $query = "UPDATE #__tdsmanager_hebergements SET state={$db->Quote($state)} WHERE id={$db->Quote($id)}";
    $db->setQuery((string)$query);
    $db->Query();

    // Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
			return false;
		}

		return true;
  }
}