<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_gesttaxesejour
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

require_once JPATH_ADMINISTRATOR . '/components/com_tdsmanager/libraries/controller.php';

/**
 * Users list controller class.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_gesttaxesejour
 * @since       1.6
 */
class TdsmanagerAdminControllerTarif_nuit extends TdsmanagerController {
  /**
	 * Constructor.
	 *
	 * @param	array An optional associative array of configuration settings.
	 * @see		JController
	 * @since	1.6
	 */
	public function __construct($config = array()) {
		parent::__construct($config);
		$this->baseurl = 'index.php?option=com_tdsmanager&view=tarif_nuit';
	}

	public function edit() {
    // Check for request forgeries.
    if (! JRequest::checkToken ()) {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }

    $cids = JRequest::getVar ( 'cid', array (), 'post', 'array' );
    $id = array_shift($cids);

    $this->app->setUserState( "com_tdsmanager.hebergement_tarif_nuit.id", $id );

		$this->setRedirect('index.php?option=com_tdsmanager&view=tarif_nuit&layout=create');
  }

  public function create() {
    // Check for request forgeries.
    if (! JRequest::checkToken ()) {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }

    $this->app->setUserState( "com_tdsmanager.hebergement_tarif_nuit.id", 0 );

		$this->setRedirect('index.php?option=com_tdsmanager&view=tarif_nuit&layout=create');
  }

  public function remove() {
    // Check for request forgeries.
    if (! JRequest::checkToken ()) {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }

    $ids = JRequest::getVar ( 'cid', array (), 'post', 'array' );
    if ( !empty($ids) ) {
      $ids = implode(',',$ids);

      $db = JFactory::getDBO();
      $query = "DELETE FROM #__tdsmanager_tarif_nuit WHERE id IN ($ids)";
      $db->setQuery((string)$query);
      $db->Query();

      // Check for a database error.
  		if ($db->getErrorNum()) {
  			JError::raiseWarning(500, $db->getErrorMsg());
  			return false;
  		}

  		$this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TARIF_NUIT_ITEMS_DELETED') );
  		$this->app->redirect($this->baseurl);
		} else {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_SELECTED'), 'error' );
      $this->app->redirect($this->baseurl);
    }
  }

  public function save() {
    // Check for request forgeries.
    if (! JRequest::checkToken ()) {
      $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }

    $id = JRequest::getInt('id', 0);
    $post = JRequest::get('post', JREQUEST_ALLOWRAW);

    $db = JFactory::getDBO();

    if ( !$id ) {
      $query = "INSERT INTO #__tdsmanager_tarif_nuit
                (tarif, id_classement, id_hebergement_type)
                VALUES({$db->quote($post['tarif'])}, {$db->quote($post['classement'])}, {$db->quote($post['hebergement_type'])})";
       $db->setQuery((string)$query);
       $db->Query();

        // Check for a database error.
    		if ($db->getErrorNum()) {
    			JError::raiseWarning(500, $db->getErrorMsg());
    			return false;
    		}

       $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TARIF_NUIT_NEW_SAVED') );
       $this->app->redirect($this->baseurl);
    } else {
        $query = "UPDATE #__tdsmanager_tarif_nuit
                  SET tarif={$db->quote($post['tarif'])},id_classement={$db->quote($post['classement'])}, id_hebergement_type={$db->quote($post['hebergement_type'])}
                  WHERE id={$db->quote($post['id'])}";
        $db->setQuery((string)$query);
        $db->Query();

        // Check for a database error.
    		if ($db->getErrorNum()) {
    			JError::raiseWarning(500, $db->getErrorMsg());
    			return false;
    		}

       $this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_TARIF_NUIT_EDITION_SAVED') );
       $this->app->redirect($this->baseurl);
    }
  }
}