<?php
/**
 * Kunena Component
 * @package Kunena.Framework
 *
 * @copyright (C) 2008 - 2011 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/
defined ( '_JEXEC' ) or die ();

jimport ( 'joomla.application.component.controller' );
jimport ( 'joomla.application.component.helper' );

/**
 * Base controller class for Gesttaxe.
 *
 * @since		2.0
 */
class TdsmanagerController extends JControllerLegacy {
	public $app = null;
	public $me = null;
	public $config = null;

	var $_escape = 'htmlspecialchars';
	var $_redirect = null;
	var $_message= null;
	var $_messageType = null;

	function __construct() {
		parent::__construct ();

		$this->app = JFactory::getApplication();
	}

	/**
	 * Method to get the appropriate controller.
	 *
	 * @return	object	Kunena Controller
	 * @since	1.6
	 */
	public static function getInstance($prefix = 'Tdsmanager', $config = array()) {
		static $instance = null;

		if (! empty ( $instance ) && !isset($instance->home)) {
			return $instance;
		}
		
		$view = $this->app->input->getWord('view', 'none');
		
		$view = strtolower ($view);

		if (!$app->isAdmin()) {
			$home = $app->getMenu ()->getActive ();
			if (!$reload && !empty ( $home->query ['view'] ) && $home->query ['view'] == 'home' && !$this->app->input->getWord('task')) {
				$view = 'home';
			}
		}

		$path = JPATH_COMPONENT . "/controllers/{$view}.php";

		// If the controller file path exists, include it ... else die with a 500 error.
		if (file_exists ( $path )) {
			require_once $path;
		} else {
			JError::raiseError ( 500, JText::sprintf ( 'COM_TDSMANAGER_INVALID_CONTROLLER', ucfirst ( $view ) ) );
		}

		// Set the name for the controller and instantiate it.
		if ($this->app->isAdmin()) {
			$class = 'TdsmanagerAdminController' . ucfirst ( $view );
		} else {
			$class = 'TdsmanagerController' . ucfirst ( $view );
		}

		if (class_exists ( $class )) {
			$instance = new $class ();
		} else {
			JError::raiseError ( 500, JText::sprintf ( 'COM_TDSMANAGER_INVALID_CONTROLLER_CLASS', $class ) );
		}

		return $instance;
	}

	/**
	 * Method to display a view.
	 *
	 * @return	void
	 * @since	1.6
	 */
	public function display($cachable=false, $urlparams=false) {
		// Get the document object.
		$document = JFactory::getDocument ();

		// Set the default view name and format from the Request.
		$vName = $this->app->input->getWord('view', 'none');
		$lName = $this->app->input->getWord('layout', 'default');
		$vFormat = $document->getType ();

		$view = $this->getView ( ucfirst($vName), $vFormat );

			// Do any specific processing for the view.
			switch ($vName) {
				default :
					// Get the appropriate model for the view.
					$model = $this->getModel ( $vName );
					break;
			}

      if ( empty($model) ) JError::raiseError ( 500, JText::_( 'COM_TDSMANAGER_MODEL_NOT_FOUND' ) );

			// Push the model into the view (as default).
			$view->setModel ( $model, true );

			// Set the view layout.
			$view->setLayout ( $lName );

			// Push document object into the view.
			$view->assignRef ( 'document', $document );

			// Render the view.
			if ($vFormat=='html') {
				$view->displayAll ();
			} else {
				$view->displayLayout ();
			}
	}

	/**
	 * Escapes a value for output in a view script.
	 *
	 * If escaping mechanism is one of htmlspecialchars or htmlentities.
	 *
	 * @param  mixed $var The output to escape.
	 * @return mixed The escaped value.
	 */
	function escape($var) {
		if (in_array ( $this->_escape, array ('htmlspecialchars', 'htmlentities' ) )) {
			return call_user_func ( $this->_escape, $var, ENT_COMPAT, 'UTF-8' );
		}
		return call_user_func ( $this->_escape, $var );
	}

	/**
	 * Sets the _escape() callback.
	 *
	 * @param mixed $spec The callback for _escape() to use.
	 */
	function setEscape($spec) {
		$this->_escape = $spec;
	}

	function getRedirect() {
		return $this->_redirect;
	}
	function getMessage() {
		return $this->_message;
	}
	function getMessageType() {
		return $this->_messageType;
	}

	protected function redirectBack($fragment = '') {
		$httpReferer = $this->app->input->get('HTTP_REFERER', JURI::base ( true ), 'server');
		JFactory::getApplication ()->redirect ( $httpReferer.($fragment ? '#'.$fragment : '') );
	}

}
