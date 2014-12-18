<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * Content categories view.
 *
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @since 1.6
 */
class TdsmanagerViewHebergements extends JView {
	protected $state = null;
	protected $item = null;
	protected $items = null;
	protected $pagination = null;

	/**
	 * Display the view
	 *
	 * @return	mixed	False on error, null otherwise.
	 */
	function display($tpl = null) {
		$app	= JFactory::getApplication();

    $editmode = $app->getUserState( 'com_tdsmanager.hebergement.editmode');

    // Initialise variables
    $this->editmode = false;
    if ( $editmode ) {
      $this->editmode = $editmode;
    }

		// En mode edition
		$layout = $app->input->getCmd('layout');
		if( $layout == 'edit') {
      $this->hebergement = $this->get('Hebergement');
      $this->label_list = $this->get('LabelList');
    } elseif( $layout == 'periode_ouverture' ) {
      $this->myhebergementslist = $this->get('MyHebergementsList');
    } else {
      $this->hebergements = $this->get('Hebergements');
      $this->count = count($this->hebergements);
    }
		// Implement it in model
    $this->classement_list = $this->get('ClassementList');

    $this->identification_period = $this->get('IdentificationPeriode');

		if ( $layout == 'create' ) {
		   $this->document->setTitle(JText::_('COM_TDSMANAGER_GESTION_TAXE_SEJOUR').' - '.JText::_('COM_TDSMANAGER_HEBERGEMENTS_CREATE'));
		} elseif ( $layout == 'edit' ) {
		  $this->document->setTitle(JText::_('COM_TDSMANAGER_GESTION_TAXE_SEJOUR').' - '.JText::_('COM_TDSMANAGER_HEBERGEMENTS_EDIT'));
		} elseif ( $layout == 'delete' ) {
		  $this->document->setTitle(JText::_('COM_TDSMANAGER_GESTION_TAXE_SEJOUR').' - '.JText::_('COM_TDSMANAGER_HEBERGEMENTS_DELETE'));
		} else {
      $this->document->setTitle(JText::_('COM_TDSMANAGER_GESTION_TAXE_SEJOUR').' - '.JText::_('COM_TDSMANAGER_HEBERGEMENTS_GESTION_HOSTINGS'));
    }

    JHtml::_('behavior.framework', true);
    $doc = JFactory::getDocument();
    $doc->addScript(JURI::root()."components/com_tdsmanager/js/default.js");

		//$this->_prepareDocument();

		parent::display($tpl);
	}

	protected function _getViewFile($view, $tpl) {
    $tpl =  JPATH_BASE.'/components/com_tdsmanager/views/'.$view.'/tmpl/'.$tpl.'.php';
    if (!file_exists($tpl)) JError::raiseError(500, JText::sprintf('JLIB_APPLICATION_ERROR_LAYOUTFILE_NOT_FOUND', $tpl));

    ob_start();
		include $tpl;
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
  }

  public function getPagination($maxpages) {
    include_once(JPATH_ADMINISTRATOR.'/components/com_tdsmanager/libraries/html/pagination.php');
    $pagination = new TdsmanagerHtmlPagination ( $this->count, 0, 50 );
    $pagination->setDisplay($maxpages);
    return $pagination->getPagesLinks();
  }

	/**
	 * Prepares the document
	 */
	protected function _prepareDocument() {
		$app	= JFactory::getApplication();
		$menus	= $app->getMenu();
		$title	= null;

		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu = $menus->getActive();
		if($menu) {
			$this->params->def('page_heading', $this->params->def('page_title', $menu->title));
		} else {
			$this->params->def('page_heading', JText::_('COM_CONTACT_DEFAULT_PAGE_TITLE'));
		}
		$title = $this->params->get('page_title', '');
		if (empty($title)) {
			$title = $app->getCfg('sitename');
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
			$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
			$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
		}
		$this->document->setTitle($title);

		if ($this->params->get('menu-meta_description')) {
			$this->document->setDescription($this->params->get('menu-meta_description'));
		}

		if ($this->params->get('menu-meta_keywords')) {
			$this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		}

		if ($this->params->get('robots')) {
			$this->document->setMetadata('robots', $this->params->get('robots'));
		}
	}
}
