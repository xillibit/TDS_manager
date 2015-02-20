<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');
require_once JPATH_COMPONENT.'/helpers/route.php';

$view = strtolower ( JRequest::getWord ( 'view' ) );
$controller = 'TdsmanagerController' . ucfirst ( $view );

$path = JPATH_COMPONENT . "/controllers/{$view}.php";
if (file_exists ( $path )) {
	require_once $path;
} else {
	JError::raiseError ( 500, JText::sprintf ( 'COM_TDSMANAGER_INVALID_CONTROLLER', ucfirst ( $view ) ) );
}

$instance = new $controller ();
$instance->execute(JRequest::getCmd('task'));
$instance->redirect();
