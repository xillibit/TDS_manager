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
* TDS_Manager Users Controller
*
* @since 1.0
*/
class TdsmanagerAdminControllerUsers extends TdsmanagerController {
  /**
	 * Constructor.
	 *
	 * @param	array An optional associative array of configuration settings.
	 * @see		JController
	 * @since	1.6
	 */
	public function __construct($config = array()) {
		parent::__construct($config);
		$this->baseurl = 'index.php?option=com_tdsmanager&view=users';

	}

	public function create() {
    // Check for request forgeries.
    if (!JSession::checkToken()) {
      $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }

    $this->app->setUserState( 'com_tdsmanager.user.id', 0 );

    $this->setRedirect('index.php?option=com_tdsmanager&view=users&layout=create');
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

      $this->app->setUserState( 'com_tdsmanager.user.id', $id );

      $this->setRedirect('index.php?option=com_tdsmanager&view=users&layout=create');
    } else {
      $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_USER_NOTHING_SELECTED'), 'error' );
      $this->app->redirect($this->baseurl);
    }
  }
	
  /**
   * Remove user from tdsmanager and from Joomla! database
   * 
   * @return boolean
   */
  public function remove() {
    // Check for request forgeries.
    if (!JSession::checkToken()) {
		$this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_TOKEN'), 'error' );
		$this->app->redirect($this->baseurl);
    }

    $ids = $this->app->input->get('cid',array(),'ARRAY');
    if ( !empty($ids) ) {
		jimport( 'joomla.access.access' );
		$user = JFactory::getUser();
		
		$db = JFactory::getDBO();
		
		$ids = implode(',',$ids);
		$query = "DELETE FROM #__tdsmanager_users WHERE userid IN ($ids)";
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
		
		$user->delete();

		$this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_USER_DELETED') );
		$this->app->redirect($this->baseurl);
	} else {
		$this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_USER_NOTHING_SELECTED'), 'error' );
		$this->app->redirect($this->baseurl);
    }
  }
	
	/**
	 * Save user into tdsmanager if it exist
	 * 
	 * @return boolean
	 */
	public function save() {
		// Check for request forgeries.
		if (!JSession::checkToken()) {
			$this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_TOKEN'), 'error' );
			$this->app->redirect($this->baseurl);
		}

		$userid = $this->app->input->getInt('id', 0);

		if ( !empty($userid) ) {
			$name = $this->app->input->getString('name', null);
			$lastname = $this->app->input->getString('lastname', null);
			$adress = $this->app->input->getString('adress', null);
			$complement_adress = $this->app->input->getString('complement_adress', null);
			$postalcode = $this->app->input->getInt('postalcode', 0);
			$ville = $this->app->input->getString('ville', null);
			$telephone = $this->app->input->getString('telephone', null);
			$portable = $this->app->input->getString('portable ', null);

			$db = JFactory::getDBO();
			$query = "UPDATE #__tdsmanager_users
				SET name={$db->quote($name)},lastname={$db->quote($lastname)},adress={$db->quote($adress)},complement_adress={$db->quote($complement_adress)},postalcode={$db->quote($postalcode)},ville={$db->quote($ville)},telephone={$db->quote($telephone)},portable={$db->quote($portable)} WHERE userid={$db->quote($userid)}";
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

			$this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_USER_SAVED_SUCESSFULLY') );
			$this->app->redirect($this->baseurl);
		} else {
			$this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_USER_SAVE_FAILED_OR_USER_DOESNT_EXIST'), 'error' );
			$this->app->redirect($this->baseurl);
		}
  }

  public function block() {
    if (!JSession::checkToken()) {
      $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }

    $ids = $this->app->input->get('cid',array(),'ARRAY');

    if ( !empty($ids) ) {
       $this->setBlockStatus('1', $ids);

      $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_USER_BLOCKED_SUCCESSFULLY') );
      $this->app->redirect($this->baseurl);
    } else {
      $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_USER_NOTHING_SELECTED'), 'error' );
      $this->app->redirect($this->baseurl);
    }
  }

  public function unblock() {
    if (!JSession::checkToken()) {
      $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }

    $ids = $this->app->input->get('cid',array(),'ARRAY');
    if ( !empty($ids) ) {
      $this->setBlockStatus('0', $ids);

      $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_USER_UNBLOCKED_SUCCESSFULLY') );
      $this->app->redirect($this->baseurl);
    } else {
      $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_USER_NOTHING_SELECTED'), 'error' );
      $this->app->redirect($this->baseurl);
    }
  }

  protected function setBlockStatus($state, $ids) {
    $ids = implode(',',$ids);

    $db = JFactory::getDBO();
    $query = "UPDATE #__users SET block={$db->quote($state)} WHERE id IN ('$ids')";
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

    return true;
  }

  public function activate() {
    if (!JSession::checkToken()) {
      $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }

    $ids = $this->app->input->get('cid',array(),'ARRAY');
    if ( !empty($ids) ) {
      $this->setActivate('0', $ids);

      $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_USER_ACTIVATED_SUCCESSFULLY') );
      $this->app->redirect($this->baseurl);
    } else {
      $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_USER_NOTHING_SELECTED'), 'error' );
      $this->app->redirect($this->baseurl);
    }
  }

  public function unactivate() {
    if (!JSession::checkToken()) {
      $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }

    $ids = $this->app->input->get('cid',array(),'ARRAY');
    if ( !empty($ids) ) {
      $this->setActivate('1', $ids);

      $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_USER_UNACTIVATED_SUCCESSFULLY') );
      $this->app->redirect($this->baseurl);
    } else {
      $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_USER_NOTHING_SELECTED'), 'error' );
      $this->app->redirect($this->baseurl);
    }
  }

  public function mailinglist() {
    if (!JSession::checkToken()) {
      $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }

    // vider l'userstate
    $idsInState = $this->app->getUserState( 'com_tdsmanager.users.mailinglist.ids' );
    if ( !empty($idsInState) ) {
      $this->app->setUserState( 'com_tdsmanager.users.mailinglist.ids', null );
    }

    $ids = $this->app->input->get('cid',array(),'ARRAY');
    if ( !empty($ids) ) {
      // Afficher une fenêtre de confirmation

      // Demander d'entrer le titre du message ainsi que le contenu du message

      // stocker les ids dans l'user state
      $this->app->setUserState( 'com_tdsmanager.users.mailinglist.ids', $ids );
    } else {
      // Afficher le message vous n'avez sélectionné aucun élément
    }
  }

  public function mailinglistsend() {
    if (!JSession::checkToken()) {
      $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }

    // récupérer le titre du message ainsi que son contenu
    $title = $this->app->input->getString('title');
    $body = $this->app->input->getString('body');

    // récupérer les données depuis l'userstate
    $idsInState = $this->app->getUserState( 'com_tdsmanager.users.mailinglist.ids' );

    if ( !empty($idsInState) ) {
      // Envoyer les mails
      jimport( 'joomla.mail.mail' );
      $mailer = JFactory::getMailer();
      $config = JFactory::getConfig();
      $sender = array( $config->getValue( 'config.mailfrom' ), $config->getValue( 'config.fromname' ) );

      $mailer->setSender($sender);
      // récupérer le message et le titre du message
      $body   = $body;
      $mailer->setSubject($title);
      $mailer->setBody($body);

      // envoyer le mail
      $send = $mailer->Send();
      if ( $send !== true ) {
        $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_USERS_MAILING_LIST_ERROR'), 'error' );
        $this->app->redirect($this->baseurl);
      } else {
        $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_USERS_MAILING_LIST_MAILS_SENT') );
        $this->app->redirect($this->baseurl);
      }
    } else {
      // Afficher un message d'erreur
    }
  }

  protected function setActivate($state, $ids) {
    $ids = implode(',',$ids);

    $db = JFactory::getDBO();
    $query = "UPDATE #__users SET activation={$db->quote($state)} WHERE id IN ('$ids')";
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

    return true;
  }
}