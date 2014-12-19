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
* TDS_Manager Reglement Controller
*
* @since 1.0
*/
class TdsmanagerAdminControllerReglements extends TdsmanagerController {
  /**
	 * Constructor.
	 *
	 * @param	array An optional associative array of configuration settings.
	 * @see		JController
	 * @since	1.6
	 */
	public function __construct($config = array()) {
		parent::__construct($config);
		$this->baseurl = 'index.php?option=com_tdsmanager&view=reglements';
	}

	public function validpaiement() {
    // Check for request forgeries.
    if (!JSession::checkToken()) {
      $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }

    $ids = $this->app->input->get('cid',array(),'ARRAY');

    if ( !empty($ids) ) {
      $db = JFactory::getDBO();
      $query = "UPDATE #__tdsmanager_reglements SET finaliser='1' WHERE id IN ($ids)";
      $db->setQuery((string)$query);
      $db->Query();

      if ($db->getErrorNum()) {
  			JError::raiseWarning(500, $db->getErrorMsg());
  			return false;
  		}

      $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_REGLEMENT_VALIDATED'), 'error' );
      $this->app->redirect($this->baseurl);
    } else {
      $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_NOTHING_SELECTED'), 'error' );
      $this->app->redirect($this->baseurl);
    }
  }

  // Relancer les personnes qui n'ont pas payé, en leur envoyant un mail. Ceci est une procédure manuelle
  public function relaunch() {
    // Check for request forgeries.
    if (!JSession::checkToken()) {
      $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }

    $ids = $this->app->input->get('cid',array(),'ARRAY');
    if ( !empty($ids) ) {
      // Vérifier avant d'envoyer le mail que le réglement n'a pas été fait
      $db = JFactory::getDBO();
      $query = "SELECT * FROM #__tdsmanager_reglements WHERE id IN ($ids) AND finaliser='0'";
      $db->setQuery((string)$query);
      $items = $db->loadObjectList();

      if ($db->getErrorNum()) {
  			JError::raiseWarning(500, $db->getErrorMsg());
  			return false;
  		}

  		if ( !empty($items) ) {
        jimport( 'joomla.mail.mail' );
        $mailer = JFactory::getMailer();
        $config = JFactory::getConfig();
        $sender = array( $config->getValue( 'config.mailfrom' ), $config->getValue( 'config.fromname' ) );

        $mailer->setSender($sender);
        // récupérer le message et le titre du message
        $body   = "Your body string\nin double quotes if you want to parse the \nnewlines etc";
        $mailer->setSubject('Your subject string');
        $mailer->setBody($body);

        // envoyer le mail
        $send = $mailer->Send();
        if ( $send !== true ) {
          $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_REGLEMENTS_RELAUNCH_ERROR'), 'error' );
          $this->app->redirect($this->baseurl);
        } else {
          $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_REGLEMENTS_RELAUNCH_MAIL_SENT') );
          $this->app->redirect($this->baseurl);
        }
      } else {
        $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_REGLEMENTS_SELECTED_ALREADY_FINALISER'), 'error' );
        $this->app->redirect($this->baseurl);
      }
    } else {
      $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_NOTHING_SELECTED'), 'error' );
      $this->app->redirect($this->baseurl);
    }
  }

  public function add() {
    // rediriger vers la bonne vue
    $this->setRedirect('index.php?option=com_tdsmanager&view=reglements&layout=create');
  }

  public function savepaiement() {
    // Check for request forgeries.
    if (!JSession::checkToken()) {
      $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_TOKEN'), 'error' );
      $this->app->redirect($this->baseurl);
    }

    $this->app->enqueueMessage ( JText::_('COM_TDSMANAGER_REGLEMENT_SAVED_SUCESSFULLY'), 'error' );
    $this->app->redirect($this->baseurl);
  }
}