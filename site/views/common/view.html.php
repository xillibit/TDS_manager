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
class GesttaxesejourViewCommon extends JView {
  function display($tpl = null) {
    
    
    $this->lasthostings = $this->get('LastHostings');
    $this->lastdeclarations = $this->get('LastDeclarations');
    $this->lastreglements =  $this->get('LastReglements'); 
  }
}