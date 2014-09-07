<?php
/**
 * TDS Manager Component
 * @package Kunena.Framework
 *
 * @copyright (C) 2008 - 2011 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/
defined ( '_JEXEC' ) or die ();

if (defined ( 'GESTTAXESEJOUR_LOADED' ))
	return;

// Component name amd database prefix
define ( 'GESTTAXESEJOUR_COMPONENT_NAME', basename ( dirname ( __FILE__ ) ) );
define ( 'GESTTAXESEJOUR_NAME', substr ( GESTTAXESEJOUR_COMPONENT_NAME, 4 ) );

// Component location
define ( 'GESTTAXESEJOUR_COMPONENT_LOCATION', basename ( dirname ( dirname ( __FILE__ ) ) ) );

// Component paths
define ( 'GESTTAXESEJOUR_COMPONENT_RELATIVE', GESTTAXESEJOUR_COMPONENT_LOCATION . '/' . GESTTAXESEJOUR_COMPONENT_NAME );
define ( 'GESTTAXESEJOUR_SITE', JPATH_ROOT .'/'. GESTTAXESEJOUR_COMPONENT_RELATIVE );
define ( 'GESTTAXESEJOUR_ADMIN', JPATH_ADMINISTRATOR .'/'. GESTTAXESEJOUR_COMPONENT_RELATIVE );
define ( 'GESTTAXESEJOUR_MEDIA', JPATH_ROOT .'/media/'. GESTTAXESEJOUR_NAME );

// URLs
define ( 'GURL_COMPONENT', 'index.php?option=' . GESTTAXESEJOUR_COMPONENT_NAME );
define ( 'GURL_SITE', JURI::Root () . GESTTAXESEJOUR_COMPONENT_RELATIVE . '/' );
define ( 'GURL_MEDIA', JURI::Root () . 'media/' . GESTTAXESEJOUR_NAME . '/' );

// Register Joomla and Kunena autoloader
if (function_exists('__autoload')) spl_autoload_register('__autoload');
spl_autoload_register('GesttaxeAutoload');

// Give access to all Kunena tables
//jimport('joomla.database.table');
//JTable::addIncludePath(KPATH_ADMIN.'/libraries/tables');
// Give access to all JHTML functions
//jimport('joomla.html.html');
//JHTML::addIncludePath(KPATH_ADMIN.'/libraries/html/html');

/**
 * Intelligent library importer.
 *
 * @param	string	A dot syntax path.
 * @return	boolean	True on success
 * @since	1.6
 * @deprecated 2.0
 */
function Gimport($path) {}

/**
 * TDS_Manager auto loader
 *
 * @param string $class Class to be registered (case sensitive)
 */
function GesttaxeAutoload($class) {
	if (substr($class, 0, 6) != 'Tdsmanager') return;
	$file = GESTTAXESEJOUR_ADMIN . '/libraries' . strtolower(preg_replace( '/([A-Z])/', '/\\1', substr($class, 6)));
	if (is_dir($file)) {
		$file .= '/'.array_pop( explode( '/', $file ) );
	}
	$file .= '.php';
	if (file_exists($file)) {
		require_once $file;
		return true;
	}
	return false;
}

// Kunena has been initialized
define ( 'GESTTAXESEJOUR_LOADED', 1 );
