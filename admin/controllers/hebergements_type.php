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
* TDS_Manager Hebergements Type Controller
*
* @since 1.0
*/
class TdsmanagerAdminControllerHebergements_type extends TdsmanagerController {
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
		$this->baseurl = 'index.php?option=com_tdsmanager&view=hebergements_type';
	}

	public function remove() {
    // Check for request forgeries.
    if (!JSession::checkToken()) {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }

    $db = JFactory::getDBO();

    $cids = JRequest::getVar ( 'cid', array (), 'post', 'array' );
    $id = array_shift($cids);

    $query = "DELETE FROM #__tdsmanager_hebergements_type WHERE id={$db->quote($id)}";
    $db->setQuery((string)$query);
    $db->Query();

    // Check for a database error.
    if ($db->getErrorNum()) {
      JError::raiseWarning(500, $db->getErrorMsg());
    	return false;
    }

    $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_TYPE_DELETED_SUCCESSFULLY') );
    $this->app->redirect($this->baseurl);
  }

  public function create() {
    // Check for request forgeries.
    if (!JSession::checkToken()) {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }

    $this->app->setUserState( "com_gesttaxesejour.hebergement_type.id", 0 );

    $this->setRedirect('index.php?option=com_tdsmanager&view=hebergements_type&layout=create');
  }

  public function edit() {
    // Check for request forgeries.
    if (!JSession::checkToken()) {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }

    $cids = JRequest::getVar ( 'cid', array (), 'post', 'array' );
    $id = array_shift($cids);

    $this->app->setUserState( "com_gesttaxesejour.hebergement_type.id", $id );

		$this->setRedirect('index.php?option=com_tdsmanager&view=hebergements_type&layout=create');
  }

  public function save() {
    // Check for request forgeries.
    if (!JSession::checkToken()) {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }

    $id = JRequest::getInt('id', 0);
    $post = JRequest::get('post', JREQUEST_ALLOWRAW);

    $db = JFactory::getDBO();


    if ( !$id ) {
      $query = "INSERT INTO #__tdsmanager_hebergements_type
                (name,description,state)
                VALUES({$db->quote($post['name'])},{$db->quote($post['description'])},'1')";
       $db->setQuery((string)$query);
       $db->Query();

        // Check for a database error.
    		if ($db->getErrorNum()) {
    			JError::raiseWarning(500, $db->getErrorMsg());
    			return false;
    		}

       $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_TYPE_SAVED') );
       $this->app->redirect($this->baseurl);
    } else {
        $query = "UPDATE #__tdsmanager_hebergements_type
                  SET name={$db->quote($post['name'])},description={$db->quote($post['description'])},state={$db->quote($post['state'])} WHERE id={$db->quote($id)}";
        $db->setQuery((string)$query);
        $db->Query();

        // Check for a database error.
    		if ($db->getErrorNum()) {
    			JError::raiseWarning(500, $db->getErrorMsg());
    			return false;
    		}

       $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_TYPE_EDITION_SAVED') );
       $this->app->redirect($this->baseurl);
    }
  }
}