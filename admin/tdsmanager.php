<?php
/**
 * TDS Manager Component
 * @package TDS_manager.Administrator
 *
 * @copyright (C) 2012 - 2014 Florian DAL FITTO. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.pays-de-faverges.com
 **/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Initialize component
require_once JPATH_ADMINISTRATOR . '/components/com_tdsmanager/libraries/controller.php';

$view = JFactory::getApplication()->input->getCmd('view', 'controlpanel');
$task = JFactory::getApplication()->input->getCmd('task');
JRequest::setVar( 'view', $view );

require_once JPATH_COMPONENT.'/helpers/tdsmanager.php';

// Load the submenu.
TdsmanagerHelper::addSubmenu($view);

$controller = TdsmanagerController::getInstance('Tdsmanager');

// Perform the Request task
$controller->execute($task);

// Redirect if set by the controller
$controller->redirect();


