<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_gesttaxesejour
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');
?>
<div id="kadmin">
	<div class="kadmin-right">
		<form action="<?php echo JRoute::_('index.php?option=com_tdsmanager&view=declarations') ?>" method="post" id="adminForm" name="adminForm">
				<table class="kadmin-adminform">
					<tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_DECLARATION_MOIS_CONCERNE'); ?></td>
						<td>
							<?php echo $this->list_mois; ?>
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_DECLARATION_HEBERGEMENT_CONCERNE'); ?></td>
						<td>
							<?php echo $this->list_hebergements; ?>
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_DECLARATION_PERSONNES_PLEIN_TARIF'); ?></td>
						<td>
							<input name="nb_personnes_plein_tarif" value="" />
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_DECLARATION_PERSONNES_EXONEREES'); ?></td>
						<td>
							<input name="nb_personnes_exonerees" value="<?php echo isset($this->declaration->nb_personnes_exonerees) ? $this->declaration->nb_personnes_exonerees :'' ?>" />
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_DECLARATION_PERSONNES_REDUCTION'); ?></td>
						<td>
							<input name="nb_personnes_reduction" value="<?php echo isset($this->declaration->nb_personnes_reduction) ? $this->declaration->nb_personnes_reduction :'' ?>" />
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_DECLARATION_PERSONNES_ASSUJETTIES'); ?></td>
						<td>
							<input name="nb_personnes_assujetties" value="<?php echo isset($this->declaration->nb_personnes_assujetties) ? $this->declaration->nb_personnes_assujetties :'' ?>" />
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_DECLARATION_PERSONNES_PERIODE'); ?></td>
						<td>
							<input name="identification_periode" value="<?php echo isset($this->declaration->identification_periode) ? $this->declaration->identification_periode :'' ?>" />
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_DECLARATION_DUREE_SEJOUR'); ?></td>
						<td>
							<input name="duree_sejour" value="<?php echo isset($this->declaration->duree_sejour) ? $this->declaration->duree_sejour :'' ?>" />
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_DECLARATION_TOTAL_NUITEE'); ?></td>
						<td>
							<input name="nb_total_nuitee" value="<?php echo isset($this->declaration->nb_total_nuitee) ? $this->declaration->nb_total_nuitee :'' ?>" />
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_DECLARATION_TARIF_NUIT'); ?></td>
						<td>
							<?php echo $this->list_tarifs_nuit; ?>
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_DECLARATION_MONTANT_ENCAISSE_JOUR'); ?></td>
						<td>
							<input name="montant_encaissee_jour" value="<?php echo isset($this->declaration->montant_encaissee_jour) ? $this->declaration->montant_encaissee_jour :'' ?>" />
						</td>
					</tr>
				</table>
		<input type="hidden" name="id" value="<?php echo isset($this->declaration->id) ? $this->declaration->id:''; ?>" />
    <input type="hidden" name="task" value="save" />
		<?php echo JHTML::_( 'form.token' ); ?>
	</div>
</div>