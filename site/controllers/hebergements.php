<?php
/**
 * @package		Tdsmanager.Site
 * @subpackage	Tdsmanager
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

class TdsmanagerControllerHebergements extends JControllerLegacy {
	public function edit() {
		$app	= JFactory::getApplication();
		$task = $app->input->getCmd('task');

		$app->setUserState( 'com_tdsmanager.hebergement.editmode', '1' );

		// redirect back if nothing is selected
		$cids = $app->input->get('cid',array(),'ARRAY');

		if ( !empty($cids) ) {
			$id = array_shift($cids);

			$app->setUserState( "com_tdsmanager.edit.hebergement.id", $id );
		}

		$this->setRedirect(JRoute::_('index.php?option=com_tdsmanager&view=hebergements&layout=edit', false));
		return false;
	}

	public function create() {
		$app	= JFactory::getApplication();

		// unset hebergement id
		$id = $app->getUserState( 'com_tdsmanager.edit.hebergement.id' );
		if ( $id ) $app->setUserState( 'com_tdsmanager.edit.hebergement.id', null );

		$app->setUserState( 'com_tdsmanager.hebergement.editmode', null );

		$this->setRedirect(JRoute::_('index.php?option=com_tdsmanager&view=hebergements&layout=edit', false));
		return false;
	}

	public function save() {
		$app	= JFactory::getApplication();
		$user = JFactory::getUser();

		// Check for request forgeries.
		if (!JSession::checkToken()) {
			$app->enqueueMessage ( JText::_('COM_TDSMANAGER_TOKEN'), 'error' );
			$app->redirect($this->baseurl);
		}

		if ( $user->id > 0 ) {
			$db = JFactory::getDBO();

			$edit_mode = $app->input->getInt('edit_mode');

			$hostingname = $app->input->getString('hostingname', null);
			$description = $app->input->getString('description', null);
			$adress = $app->input->getString('adress', null);
			$complement_adress = $app->input->getString('complement_adress', null);
			$city = $app->input->getString('city', null);
			$website = $app->input->getString('website', null);
			$postalcode = $app->input->getInt('postalcode', 0);
			$numero_classement = $app->input->getString('numero_classement', null);
			$date_classement = $app->input->getString('date_classement', null);
			$labels = $app->input->getInt('labels', 0);

			if ( empty($hostingname) )
			{
				$app->enqueueMessage ( JText::_('COM_TDSMANAGER_HEBERGEMENT_HOSTINGNAME_MISSING'), 'error');
				$this->setRedirect(JRoute::_('index.php?option=com_tdsmanager&view=hebergements', false));
				return false;
			}
			else if ( empty($adress) )
			{
				$app->enqueueMessage ( JText::_('COM_TDSMANAGER_HEBERGEMENT_ADRESS_MISSING'), 'error' );
				$this->setRedirect(JRoute::_('index.php?option=com_tdsmanager&view=hebergements', false));
				return false;
			}

			if ( $edit_mode ) {
				$hebergement_id = $app->input->getInt('hebergement_id',0);

				// si c'est l'édition d'un hébergement existant
				$query = "UPDATE #__tdsmanager_hebergements
					SET hostingname={$db->quote($hostingname)},description={$db->quote($description)},adress={$db->quote($adress)},complement_adress={$db->quote($complement_adress)},city={$db->quote($city)},website={$db->quote($website)},postalcode={$db->quote($postalcode)},numero_classement={$db->quote($numero_classement)},date_classement={$db->quote($date_classement)},id_hebergement_label={$db->quote($labels)}
					WHERE id={$hebergement_id}";
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

			$app->enqueueMessage ( JText::_('COM_TDSMANAGER_HEBERGEMENT_EDITED_SUCCESSFULLY') );
		} else {
			$date_now = JFactory::getDate('now')->toUnix();

			$this->_upload();

			// Si c'est un nouvel hébergement, on enregistre de nouvelles données
			$query = "INSERT INTO #__tdsmanager_hebergements
				(hostingname,description,adress,complement_adress,city,website,postalcode,numero_classement,date_classement, date_enregistre, userid, id_hebergement_label)
				VALUES({$db->quote($hostingname)},{$db->quote($description)},{$db->quote($adress)},{$db->quote($complement_adress)},{$db->quote($city)}, {$db->quote($website)},{$db->quote($postalcode)},{$db->quote($numero_classement)},{$db->quote($date_classement)},{$db->quote($date_now)}, {$db->quote(intval($user->id))},{$db->quote($labels)} )";
			$db->setQuery((string)$query);
			$db->Query();
			$hosting_id = $db->insertid();

			// faire que l'hébergement appartienne à l'utilisateur courant
			$query = "INSERT INTO #__tdsmanager_users_hosting_owned
				(hosting_id,user_id)
				VALUES({$db->quote($hosting_id)},{$db->quote($user->id)})";
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

			$app->enqueueMessage ( JText::_('COM_TDSMANAGER_NEW_HEBERGEMENT_SAVED') );
			$this->setRedirect(JRoute::_('index.php?option=com_tdsmanager&view=hebergements', false));
		}
	} else {
		$app->enqueueMessage ( JText::_('COM_TDSMANAGER_NOT_LOGGUED') );
	}
}

  protected function _upload() {
    jimport( 'joomla.filesystem.file' );
    $app	= JFactory::getApplication();
    $files = $app->input->files->get('hostingimage');

    if(!empty($files['tmp_name'])) {
     $dossier = 'upload/';
     $extensions = array('png', 'gif', 'jpg', 'jpeg');
     $mimes_allowed = array('image/gif', 'image/jpeg', 'image/png', 'image/pjpeg', 'image/x-png');

     $filename = $_FILES['hostingimage']['name'];
     $tmp_filename = $_FILES['hostingimage']['tmp_name'];

     $extension = JFile::getExt($filename);

     $taille = filesize($tmp_filename);
     /*if ( $taille>$taille_allowed ) {
      $app->enqueueMessage ( JText::sprintf('COM_TDSMANAGER_NEW_HEBERGEMENT_IMAGE_SIZE_NOT_ALLOWED', $taille_allowed) );
     }  */

     // Detect MIME type
     $filemimetype = mime_content_type($tmp_filename);

     if(!in_array($filemimetype, $mimes_allowed)) {
        $app->enqueueMessage ( JText::_('COM_TDSMANAGER_NEW_HEBERGEMENT_IMAGE_MIME_REQ_NOT') );
     }

     // on supprime tous les caractéres accentués
     $filename = preg_replace('/([^.a-z0-9]+)/i', '-', $filename);

     if(!in_array($extension, $extensions)) {
        $app->enqueueMessage ( JText::_('COM_TDSMANAGER_NEW_HEBERGEMENT_IMAGE_EXTENSION_REQ_NOT') );
     }

     if(move_uploaded_file($tmp_filename, JPATH_ROOT.'/media/com_tdsmanager/hosting/'.$filename)) {
          $upload = $this->_save_upload_db($filename, $taille);
          if ( $upload ) $app->enqueueMessage ( JText::_('COM_TDSMANAGER_NEW_HEBERGEMENT_IMAGE_SAVED') );
          else $app->enqueueMessage ( JText::_('COM_TDSMANAGER_NEW_HEBERGEMENT_IMAGE_DB_FAILED') );
     } else {
          $app->enqueueMessage ( JText::_('COM_TDSMANAGER_NEW_HEBERGEMENT_IMAGE_UPLOAD_FAILED') );
     }
    }
  }

  protected function _save_upload_db($name, $size) {
    $db = JFactory::getDBO();

    $query = "INSERT INTO #__tdsmanager_attachments (name,size) VALUES({$db->quote($name)},{$db->quote($size)})";
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

  public function delete() {
    $app	= JFactory::getApplication();
    $user = JFactory::getUser();
    // Check for request forgeries.
    if (! JSession::getFormToken()) {
      $app->enqueueMessage ( JText::_('COM_TDSMANAGER_TOKEN'), 'error' );
      $app->redirect($this->baseurl);
    }

    $cids = $app->input->get('cid',array(),'ARRAY');

    if ( $user->id > 0 ) {
      $db = JFactory::getDBO();
      $query = "DELETE FROM #__tdsmanager_hebergements WHERE id IN ({$db->quote($id)})";
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

      $app->enqueueMessage ( JText::_('COM_TDSMANAGER_HEBERGEMENT_DELETED') );
    } else {
      $app->enqueueMessage ( JText::_('COM_TDSMANAGER_NOT_LOGGUED') );
    }
  }

  public function publish() {
    $app	= JFactory::getApplication();
    // Check for request forgeries.
    if (!JSession::checkToken()) {
      $app->enqueueMessage ( JText::_('COM_TDSMANAGER_TOKEN'), 'error' );
      $app->redirect($this->baseurl);
    }

    $this->setState($id, '1');
  }

  public function unpublish() {
    $app	= JFactory::getApplication();
    // Check for request forgeries.
    if (!JSession::checkToken()) {
      $app->enqueueMessage ( JText::_('COM_TDSMANAGER_TOKEN'), 'error' );
      $app->redirect($this->baseurl);
    }

    $this->setState($id, '0');
  }

  public function setState($id, $state) {
    $app	= JFactory::getApplication();
    $db = JFactory::getDBO();

    if ( $user->id > 0 ) {
      $query = "UPDATE #__tdsmanager_hebergements WHERE id={$db->quote($id)}";
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

    	if ( !$state ) $app->enqueueMessage ( JText::_('COM_TDSMANAGER_HEBERGEMENT_UNPUBLISHED') );
    	else $app->enqueueMessage ( JText::_('COM_TDSMANAGER_HEBERGEMENT_PUBLISHED') );
    } else {
      $app->enqueueMessage ( JText::_('COM_TDSMANAGER_NOT_LOGGUED') );
    }
  }

  public function periode_ouverture() {
    // redirect to the view

    $this->setRedirect(JRoute::_('index.php?option=com_tdsmanager&view=hebergements&layout=periode_ouverture', false));
    return false;
  }

  public function save_period() {
    $app	= JFactory::getApplication();
    $db = JFactory::getDBO();
    // Check for request forgeries.
    if (!JSession::checkToken()) {
      $app->enqueueMessage ( JText::_('COM_TDSMANAGER_TOKEN'), 'error' );
      $app->redirect($this->baseurl);
    }

    if ( $user->id > 0 ) {
      $fermee_depuis = $app->input->getString('fermee_depuis', null);
      $reouverture_le  = $app->input->getString('reouverture_le', null);
      $motif = $app->input->getString('motif', null);
      $hebergement_list = $app->input->getInt('hebergement_list', null);

      $query = "INSERT INTO #__tdsmanager_periode_ouverture
                    (date_fermeture,date_ouverture,motif,id_hebergement)
                    VALUES({$db->quote($fermee_depuis)},{$db->quote($reouverture_le)},{$db->quote($motif)},{$db->quote($hebergement_list)} )";
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

      $app->enqueueMessage ( JText::_('COM_TDSMANAGER_PERIOD_OUVERTURE_SAVED_SUCCESSFULLY') );
    } else {
      $app->enqueueMessage ( JText::_('COM_TDSMANAGER_NOT_LOGGUED') );
    }
  }
}