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
* TDS_Manager Label Controller
*
* @since 1.0
*/
class TdsmanagerAdminControllerLabel extends TdsmanagerController {
  /**
	 * Constructor.
	 *
	 * @param	array An optional associative array of configuration settings.
	 * @see		JController
	 * @since	1.6
	 */
	public function __construct($config = array()) {
		parent::__construct($config);
		$this->baseurl = 'index.php?option=com_tdsmanager&view=label';
	}

	public function edit() {
    // Check for request forgeries.
    if (!JSession::checkToken()) {
      $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }

    $cids = $this->app->input->get('cid',array(),'ARRAY');
    $id = array_shift($cids);

    $this->app->setUserState( "com_tdsmanager.hebergement_label.id", $id );

		$this->setRedirect('index.php?option=com_tdsmanager&view=label&layout=create');
  }

  public function create() {
    // Check for request forgeries.
    if (!JSession::checkToken()) {
      $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }

    $this->app->setUserState( "com_tdsmanager.hebergement_label.id", 0 );

		$this->setRedirect('index.php?option=com_tdsmanager&view=label&layout=create');
  }

  public function remove() {
    // Check for request forgeries.
    if (!JSession::checkToken()) {
      $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }

    $db = JFactory::getDBO();

    $cids = $this->app->input->get('cid',array(),'ARRAY');
    $id = array_shift($cids);

    $query = "DELETE FROM #__tdsmanager_hebergements_label WHERE id={$db->quote($id)}";
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

    $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_HEBERGEMENT_LABEL_DELETED_SUCCESSFULLY') );
    $this->app->redirect($this->baseurl);
  }

  public function save() {
    // Check for request forgeries.
    if (!JSession::checkToken()) {
      $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }

    $id = $this->app->input->getInt('id', 0);
    $nom = $this->app->input->getString('nom', null);

    $db = JFactory::getDBO();

    if ( !$id ) {
      $query = "INSERT INTO #__tdsmanager_hebergements_label
                (nom)
                VALUES({$db->quote($nom)})";
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

       $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_HEBERGEMENT_LABEL_SAVED') );
       $this->app->redirect($this->baseurl);
    } else {
        $query = "UPDATE #__tdsmanager_hebergements_label
                  SET nom={$db->quote($nom)} WHERE id={$db->quote($id)}";
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

       $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_HEBERGEMENT_LABEL_EDITION_SAVED') );
       $this->app->redirect($this->baseurl);
    }
  }
}