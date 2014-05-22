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
class GesttaxesejourViewDeclarations extends JView {
  /**
	 * Display the view
	 *
	 * @return	mixed	False on error, null otherwise.
	 */
	function display($tpl = null) {
		// Initialise variables
		//$this->declarations = $this->get('declarations');
		$this->userhostings = $this->get('UserHostings');
		$this->hostingtypes = $this->get('HostingTypes');

    $this->app	= JFactory::getApplication();

		$layout = JRequest::getCmd('layout');

		if ( $layout == 'edit' ) {
		  $this->document->setTitle(JText::_('COM_TDSMANAGER_GESTION_TAXE_SEJOUR').' - '.JText::_('COM_TDSMANAGER_DECLARATIONS_EDIT_DECLARATION'));
		} elseif( $layout == 'create' ) {
      $this->document->setTitle(JText::_('COM_TDSMANAGER_GESTION_TAXE_SEJOUR').' - '.JText::_('COM_TDSMANAGER_DECLARATIONS_NEW_DECLARATION'));
    } elseif ( $layout == 'recap' || $layout == 'cheque' || $layout == 'virement' ) {
      if ( $layout == 'recap' ) {

      } elseif ( $layout == 'cheque' ) {
        $this->document->setTitle(JText::_('COM_TDSMANAGER_GESTION_TAXE_SEJOUR').' - '.JText::_('COM_TDSMANAGER_DECLARATIONS_GESTION_PAIEMENT_CHEQUE'));
      } elseif ( $layout == 'virement' )  {
        $this->document->setTitle(JText::_('COM_TDSMANAGER_GESTION_TAXE_SEJOUR').' - '.JText::_('COM_TDSMANAGER_DECLARATIONS_GESTION_PAIEMENT_VIREMENT'));
      }
      $this->document->setTitle(JText::_('COM_TDSMANAGER_GESTION_TAXE_SEJOUR').' - '.JText::_('COM_TDSMANAGER_DECLARATIONS_RECAPITULATIF'));


      $this->detailsDecSelected = $this->get('DetailsDecSelected');
      $this->detailsHebergeur = $this->get('DetailsHebergeur');
      $this->payementMethods = $this->get('PayementMethods');

      if ( !empty($this->payementMethods) ) {
        $options = array();
        $options[] = JHTML::_('select.option', 0, 'Sélectionner un moyen de paiement dans la liste');
        foreach($this->payementMethods as $method) {
          $options[] = JHTML::_('select.option', $method->alias, $method->name);
        }
        $dropdown = JHTML::_('select.genericlist', $options, 'paiement_methods', 'class="inputbox"', 'value', 'text', 0);

        $this->payementMethods = $dropdown;
      } else {
        $this->payementMethods = 'Pas de méthodes de paiement enregistrés';
      }

      $this->totalDeclaration = $this->get('TotalDeclaration');

      // ajouter la commission de Paypal
      $prt = ($this->totalDeclaration*3.4)/100;

      $this->totalDeclarationAfterCom = round($this->totalDeclaration+$prt+0.25, 2);

      if ( $layout == 'recap' ) {
        $this->IDTransaction = substr(uniqid(),6);

        $this->app->setUserState( "com_tdsmanager.amount", $this->totalDeclarationAfterCom );
        $this->app->setUserState( "com_tdsmanager.idtransaction", $this->IDTransaction );
      }
    } else {
      $this->document->setTitle(JText::_('COM_TDSMANAGER_GESTION_TAXE_SEJOUR').' - '.JText::_('COM_GESTTAXESEJOUR_DECLARATIONS_GESTION_DECLARATIONS'));
    }
    JHtml::_('behavior.framework', true);
    $doc = JFactory::getDocument();
    $doc->addScript(JURI::root()."components/com_tdsmanager/js/default.js");

		//$this->_prepareDocument();

		parent::display($tpl);
	}
}