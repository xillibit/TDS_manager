<?php
/**
 * TDS Manager Component
 * @package Kunena.Administrator
 *
 * @copyright (C) 2012 - 2014 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Initialize component 
require_once JPATH_ADMINISTRATOR . '/components/com_tdsmanager/libraries/controller.php'; 
 
$view = JRequest::getCmd ( 'view', 'controlpanel' );
$task = JRequest::getCmd('task');
JRequest::setVar( 'view', $view );

require_once JPATH_COMPONENT.'/helpers/tdsmanager.php';
		
// Load the submenu.
TdsmanagerHelper::addSubmenu(JRequest::getCmd('view', 'controlpanel'));

$controller = TdsmanagerController::getInstance('Tdsmanager');   

// Perform the Request task
$controller->execute($task);
    
// Redirect if set by the controller
$controller->redirect();

 