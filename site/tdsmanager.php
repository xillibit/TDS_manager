<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_tdsmanager
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');
require_once JPATH_COMPONENT.'/helpers/route.php';

$view = JFactory::getApplication()->input->getWord('view');
$task = JFactory::getApplication()->input->getCmd('task');

$view = strtolower($view);
$controller = 'TdsmanagerController' . ucfirst ( $view );

$path = JPATH_COMPONENT . "/controllers/{$view}.php";
if (file_exists ( $path )) {
	require_once $path;
} else {
	JError::raiseError ( 500, JText::sprintf ( 'COM_TDSMANAGER_INVALID_CONTROLLER', ucfirst ( $view ) ) );
}

$instance = new $controller ();
$instance->execute($task);
$instance->redirect();
