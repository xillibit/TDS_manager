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
 * TDS_Manager Classements Controller
 *
 * @since 1.0
 */
class TdsmanagerAdminControllerClassements extends TdsmanagerController {
	protected $baseurl = null;

	/**
	 *
	 * @param unknown $config
	 */
	public function __construct($config = array()) {
		parent::__construct($config);

		$this->baseurl = 'index.php?option=com_tdsmanager&view=classements';
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

			$db = JFactory::getDBO();
			$query = "DELETE FROM #__tdsmanager_classements WHERE id IN ($ids)";
			$db->setQuery((string)$query);
			$db->Query();

			// Check for a database error.
			if ($db->getErrorNum()) {
				JError::raiseWarning(500, $db->getErrorMsg());
				return false;
			}

			$this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_CLASSEMENT_ITEMS_DELETED') );
			$this->app->redirect($this->baseurl);
		} else {
			$this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_CLASSEMENT_NO_SELECTED'), 'error' );
			$this->app->redirect($this->baseurl);
		}
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

			$this->app->setUserState( 'com_tdsmanager.classement.id', $id );

			$this->setRedirect('index.php?option=com_tdsmanager&view=classements&layout=create');
		} else {
			$this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_CLASSEMENT_NO_SELECTED'), 'error' );
			$this->app->redirect($this->baseurl);
		}
	}

	public function create() {
		// Check for request forgeries.
		if (!JSession::checkToken()) {
			$this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TOKEN'), 'error' );
			$this->app->redirect($this->baseurl);
		}

		$this->app->setUserState( 'com_tdsmanager.classement.id', '0' );

		$this->setRedirect('index.php?option=com_tdsmanager&view=classements&layout=create');
	}

	public function unpublish() {
		// Check for request forgeries.
		if (!JSession::checkToken()) {
			$this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TOKEN'), 'error' );
			$this->app->redirect($this->baseurl);
		}

		$ids = JRequest::getVar ( 'cid', array (), 'post', 'array' );
		if ( !empty($ids) ) {
			$state = $this->_setState($ids, 0);
			if ( $state ) {
				$this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_CLASSEMENT_UNPUSBLISHED') );
			} else {
				$this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_CLASSEMENT_CHANGE_STATE_FAILED'), 'error' );
			}
			$this->app->redirect($this->baseurl);
		} else {
			$this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_CLASSEMENT_NO_SELECTED'), 'error' );
			$this->app->redirect($this->baseurl);
		}
	}

	public function publish() {
		// Check for request forgeries.
		if (!JSession::checkToken()) {
			$this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TOKEN'), 'error' );
			$this->app->redirect($this->baseurl);
		}

		$ids = JRequest::getVar ( 'cid', array (), 'post', 'array' );

		if ( !empty($ids) ) {
			$state = $this->_setState($ids, 1);
			if ( $state ) {
				$this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_CLASSEMENT_PUSBLISHED') );
			} else {
				$this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_CLASSEMENT_CHANGE_STATE_FAILED'), 'error' );
			}
			$this->app->redirect($this->baseurl);
		} else {
			$this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_CLASSEMENT_NO_SELECTED'), 'error' );
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
		$post = JRequest::get('post', JREQUEST_ALLOWRAW);

		if ( !$id ) {
			$db = JFactory::getDBO();
			$query = "INSERT INTO #__tdsmanager_classements
				(description,state)
				VALUES({$db->quote($post['description'])},'1')";
			$db->setQuery((string)$query);
			$db->Query();

			// Check for a database error.
			if ($db->getErrorNum()) {
				JError::raiseWarning(500, $db->getErrorMsg());
				return false;
			}

			$this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_CLASSEMENT_SAVED_SUCESSFULLY') );
			$this->app->redirect($this->baseurl);
		} else {
			$db = JFactory::getDBO();
			$query = "UPDATE #__tdsmanager_classements
				SET description={$db->quote($post['description'])},state={$db->quote($post['state'])} WHERE id={$db->quote($id)}";
			$db->setQuery((string)$query);
			$db->Query();

			// Check for a database error.
			if ($db->getErrorNum()) {
				JError::raiseWarning(500, $db->getErrorMsg());
				return false;
			}

			$this->app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_CLASSEMENT_EDITED_SUCESSFULLY'));
			$this->app->redirect($this->baseurl);
		}
	}

	protected function _setState($ids, $state) {
		$ids = implode(',',$ids);

		$db = JFactory::getDBO();
		$query = "UPDATE #__tdsmanager_classements SET state={$db->Quote($state)} WHERE id IN ($ids)";
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
