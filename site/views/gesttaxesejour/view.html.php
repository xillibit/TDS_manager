<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * HTML Contact View class for the Contact component
 *
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @since 		1.5
 */
class GesttaxesejourViewGesttaxesejour extends JView {
	protected $state;
	protected $form;
	protected $item;
	protected $return_page;

  function display($tpl = null) {
		// Initialise variables.
		$app		= JFactory::getApplication();
		$user		= JFactory::getUser();
				
		if ( $user->id == 0 ) {
      $app->enqueueMessage( JText::_('COM_GESTTAXESEJOUR_NOT_LOGGUED') );
             
      echo $this->_getViewFile('common', 'login');
        
    return false;
    }    
    
    $this->myprofile = $this->getUserProfile();
    /*$this->reglementsNotDone = $this->get('ReglementsNotDone');
    if ( $this->reglementsNotDone ) {
      $app->enqueueMessage( JText::sprintf('COM_GESTTAXESEJOUR_REGLEMENTS_NOT_DONE', $this->reglementsNotDone->start_date, $this->reglementsNotDone->end_date) );
    }
    $this->declarationsNotDone = $this->get('DeclarationsNotDone'); 
    if ( $this->declarationsNotDone ) {
      $app->enqueueMessage( JText::sprintf('COM_GESTTAXESEJOUR_DECLARATIONS_NOT_DONE', '12/05/2012','12/06/2012') );
    } */
    
    $this->lasthostings = $this->get('LastHostings');
    $this->lastdeclarations = $this->get('LastDeclarations');
    $this->lastreglements =  $this->get('LastReglements');
				
		//$this->_prepareDocument();

		parent::display($tpl);
	}
	
	protected function getUserProfile() {
    $db = JFactory::getDBO();
    $user = JFactory::getUser();
    
    if ( $user->id > 0 ) {                  
      $query = "SELECT * FROM #__gesttaxesejour_users 
                WHERE userid={$db->quote($user->id)}";
      $db->setQuery((string)$query);
      $user_profile = $db->loadObject();
      
      return $user_profile;
    }
    return array(0);
  }
	
	protected function _getViewFile($view, $tpl) {     	  
    $tpl =  JPATH_BASE.'/components/com_gesttaxesejour/views/'.$view.'/tmpl/'.$tpl.'.php';
    if (!file_exists($tpl)) JError::raiseError(500, JText::sprintf('JLIB_APPLICATION_ERROR_LAYOUTFILE_NOT_FOUND', $tpl));
     
    ob_start();
		include $tpl;
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
  }

	/**
	 * Prepares the document
	 */
	protected function _prepareDocument()	{
		$app		= JFactory::getApplication();
		$menus		= $app->getMenu();
		$pathway	= $app->getPathway();
		$title 		= null;

		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu = $menus->getActive();

		if ($menu) {
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		}
		else {
			$this->params->def('page_heading', JText::_('COM_CONTACT_DEFAULT_PAGE_TITLE'));
		}

		$title = $this->params->get('page_title', '');

		$id = (int) @$menu->query['id'];

		// if the menu item does not concern this contact
		if ($menu && ($menu->query['option'] != 'com_contact' || $menu->query['view'] != 'contact' || $id != $this->item->id))
		{

			// If this is not a single contact menu item, set the page title to the contact title
			if ($this->item->name) {
				$title = $this->item->name;
			}
			$path = array(array('title' => $this->contact->name, 'link' => ''));
			$category = JCategories::getInstance('Contact')->get($this->contact->catid);

			while ($category && ($menu->query['option'] != 'com_contact' || $menu->query['view'] == 'contact' || $id != $category->id) && $category->id > 1)
			{
				$path[] = array('title' => $category->title, 'link' => ContactHelperRoute::getCategoryRoute($this->contact->catid));
				$category = $category->getParent();
			}

			$path = array_reverse($path);

			foreach($path as $item)
			{
				$pathway->addItem($item['title'], $item['link']);
			}
		}

		if (empty($title)) {
			$title = $app->getCfg('sitename');
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
			$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
			$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
		}

		if (empty($title)) {
			$title = $this->item->name;
		}
		$this->document->setTitle($title);

		if ($this->item->metadesc)
		{
			$this->document->setDescription($this->item->metadesc);
		}
		elseif (!$this->item->metadesc && $this->params->get('menu-meta_description'))
		{
			$this->document->setDescription($this->params->get('menu-meta_description'));
		}

		if ($this->item->metakey)
		{
			$this->document->setMetadata('keywords', $this->item->metakey);
		}
		elseif (!$this->item->metakey && $this->params->get('menu-meta_keywords'))
		{
			$this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		}

		if ($this->params->get('robots'))
		{
			$this->document->setMetadata('robots', $this->params->get('robots'));
		}

		$mdata = $this->item->metadata->toArray();

		foreach ($mdata as $k => $v)
		{
			if ($v) {
				$this->document->setMetadata($k, $v);
			}
		}
	}
}
