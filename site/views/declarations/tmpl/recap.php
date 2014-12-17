<?php
 /**
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$document = JFactory::getDocument ();
$document->addStyleSheet(JURI::Root().'/components/com_tdsmanager/assets/facebox.css');
$document->addScript(JURI::Root().'/components/com_tdsmanager/assets/facebox.js');
$document->addScriptDeclaration ("
	jQuery(document).ready(function($) {
		$('div#full-tos').hide();
		$('a#terms-of-service').click(function(event) {
			event.preventDefault();
			$.facebox( { div: '#full-tos' }, 'my-groovy-style');
		});
	});
");
$document->addStyleDeclaration ('#facebox .content {display: block !important; height: 480px !important; overflow: auto; width: 560px !important; }');
$app    = JFactory::getApplication();
$params	= $app->getParams();
?>
<div>
  <h1>
	 <?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_RECAP_FOR_PAIEMENT') ?>
  </h1>
  <div style="border-top: 1px solid #E9E8E8;border-bottom: 1px solid #E9E8E8;margin: 10px 0 0;padding: 10px 0 25px;">
    <h4><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_RECAP_INFORMATIONS_FACTURATION') ?></h4>
    <div style="margin: 10px 0;">
      <ul style="list-style-type: none;">
        <li><?php echo $this->detailsHebergeur->name.' '.$this->detailsHebergeur->lastname; ?></li>
        <li><?php echo $this->detailsHebergeur->adress; ?></li>
        <li><?php echo $this->detailsHebergeur->complement_adress; ?></li>
        <li><?php echo $this->detailsHebergeur->postalcode.' '.$this->detailsHebergeur->ville; ?></li>
        <li><?php echo $this->detailsHebergeur->mail; ?></li>
      </ul>
      <input type="button" value="<?php echo JText::_('COM_TDSMANAGER_DECLARATION_RECAP_EDIT_USER_DETAILS') ?>" />
    </div>
  </div>
  <br />
  <h4><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_RECAP_DECLARATIONS_SELECTED') ?></h4>
  <br />
  <ul>
  <?php if ( !empty($this->detailsDecSelected) ):
          foreach($this->detailsDecSelected as $detail): ?>
    <li><?php echo JText::_('COM_TDSMANAGER_DECLARATION_DEC_FROM').' '.$detail->start_date.' '.JText::_('COM_TDSMANAGER_DECLARATION_DEC_TO').' '.$detail->end_date.' '.JText::_('COM_TDSMANAGER_DECLARATION_DEC_MONTANT').' '.$detail->montant_encaisse_sejour.' €' ?></li>
  <?php endforeach;
  else :
     echo JText::_('COM_TDSMANAGER_DEC_PAIE_NOTHING_SELECTED');
  endif; ?>
  </ul>
  <div style="text-align: right;">
  <?php if ( !empty($this->detailsDecSelected) ): ?>
  <h5><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_RECAP_BEFORE_COMMISION').' '.$this->totalDeclaration.' €' ?></h5>
  <h5><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_RECAP_TOTAL').' '.$this->totalDeclarationAfterCom.' €' ?></h5>
  <?php endif; ?>
  </div>
  <form id="checkoutForm" name="checkoutForm" method="post" action="<?php echo JRoute::_('index.php?option=com_tdsmanager&view=declarations&task=checkout') ?>">
	<label for="tosAccepted" style="border-top: 1px solid #E9E8E8;margin: 10px 0 0;padding: 10px 0 25px;">
	<input id="tosAccepted" type="checkbox" style="margin-right: 10px; display: inline-block;" value="1" name="tosAccepted" />
	<a href="<?php JRoute::_ ('index.php?option=com_tdsmanager&view=declarations&layout=tos') ?>" class="terms-of-service" id="terms-of-service" rel="facebox" target="_blank">
		<?php echo JText::_ ('COM_TDSMANAGER_DECLARATIONS_READ_ACCEPT_TOS'); ?>
	</a>
	</label>

	<div id="full-tos">
		<fieldset>
			<legend><?php echo JText::_ ('COM_TDSMANAGER_DECLARATIONS_RECAP_TOS'); ?></legend>
			<?php echo $params->get('content_tos', ''); ?>
		</fieldset>
	</div>

  <br />
  <div style="border-top: 1px solid #E9E8E8;border-bottom: 1px solid #E9E8E8;margin: 10px 0 0;padding: 10px 0 25px;">
    <h4><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_RECAP_SELECT_PAYEMENT') ?></h4>
    <?php echo $this->payementMethods ?>
  </div>

  <div id="cheque_text" style="display:none;">
    <fieldset>
  <legend>Instructions pour le paiement par chéque :</legend>

Vous avez choisi d'effectuer votre paiement par chèque bancaire. Nous vous remercions de bien vouloir nous faire parvenir votre chèque de <b><?php echo $this->totalDeclarationAfterCom ?> €</b> par courrier en inscrivant
la référence de la déclaration (Référence transaction :<?php echo $this->app->getUserState("com_tdsmanager.idtransaction") ?>) de la taxe de séjour au dos du chèque (chèque à l'ordre du Trésor public).

Merci d'envoyer votre courrier complet à l'adresse suivante :
<br /><br />
<ul>
<li>Office de Tourisme</li>
<li>Place</li>
<li>00000 Ville</li>
</ul>
Si votre règlement ne nous est pas parvenu sous 10 jours, le paiement de votre déclaration sera automatiquement annulée.
</fieldset>
  </div>

  <div id="virement_text" style="display:none;">
  <fieldset>
        <legend>Instructions pour le paiement par virement :</legend>
Vous avez choisi d'effectuer votre paiement par virement bancaire. Nous vous invitons à utiliser les coordonnées bancaires ci-dessous.

Ces informations vous seront récapitulées dans le mail de confirmation.

Merci de préciser dans l'objet de votre virement, la référence de la déclaration de la taxe de séjour (Référence transaction :<?php echo $this->app->getUserState("com_tdsmanager.idtransaction") ?>).
<br /><br />
Montant à payer : <b><?php echo $this->totalDeclarationAfterCom ?> €</b>
<br /><br />
<ul>
	<li>Code banque : 30047</li>
	<li>Code guichet : 14144</li>
	<li>Numéro de compte : 00037236001</li>
	<li>Clé : 96</li>
	<li>Domiciliation : CIC Grandes et moyennes entreprises Pays de Loire</li>
</ul>
Si votre règlement ne nous est pas parvenu sous 10 jours, le paiement de votre déclaration sera automatiquement annulée.
</fieldset>
  </div>

  <div id="paypal_paiement_text" style="display:none;">
    <fieldset>
		<legend>Paiement par Paypal :</legend>
		<a href="<?php echo JRoute::_('index.php?option=com_tdsmanager&view=declarations&task=sendcheckout') ?>">
			<input id="paypal_bouton" onclick="document.paypalForm.submit();" name="submit" src="https://www.paypalobjects.com/en_US/FR/i/bnr/bnr_horizontal_solution_PP_327wx80h.gif" alt="<?php echo JText::_('COM_TDSMANAGER_DECLARATION_PAY_WITH_PAYPAL') ?>" title="<?php echo JText::_('COM_TDSMANAGER_DECLARATION_PAY_WITH_PAYPAL') ?>" type="image" />
		</a>

	</fieldset>
  </div>
  <br />


  <a class="btn-validate-green" href="javascript:document.checkoutForm.submit();">
    <span>Terminer</span>
  </a>
  </form>
</div>