<?php
/**
 * @package		Joomla.Site
 * @subpackage	Contact
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

class GesttaxesejourControllerReglements extends JControllerLegacy {
  public function details() {
    $this->setRedirect(JRoute::_('index.php?option=com_gesttaxesejour&view=reglement&layout=details', false));
    return false;
  }
  
  public function create() {
    $this->setRedirect(JRoute::_('index.php?option=com_gesttaxesejour&view=reglements&layout=create', false));
    return false;
  } 
  
  public function save() {
    $app	= JFactory::getApplication();    
    // Check for request forgeries.		
    if (! JRequest::checkToken ()) {
      $app->enqueueMessage ( JText::_('COM_GESTTAXESEJOUR_TOKEN'), 'error' );
      $app->redirect($this->baseurl);
    }
  } 
}