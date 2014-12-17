<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_tdsmanager
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHTML::_('behavior.tooltip');
?>
<div id="kadmin">
	<div class="kadmin-right">
		<form action="<?php echo JRoute::_('index.php?option=com_tdsmanager&view=declarations') ?>" method="post" id="adminForm" name="adminForm">
				<table class="kadmin-adminform">
					<tr>
						<td valign="top"><?php echo JText::_('COM_TDSMANAGER_DECLARATION_TARIF_NUIT_PAR_PERSONNE'); ?></td>
						<td>
							<!-- La valeur du tarif_nuit_par_personne doit être sélectionnée automatiquement quand on arrive sur la page -->
              <input name="tarif_nuit_par_personne" type="text" value="<?php echo $this->values_entered->tarif_hebergement; ?>" readonly="readonly" />
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_TDSMANAGER_DECLARATION_NB_NUITEE'); ?></td>
						<td>
							<input name="nb_nuitees_duree_sejour" type="text" value="" />
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_TDSMANAGER_DECLARATION_SOUS_TOTAL'); ?></td>
						<td>
							<input name="sous_total" type="text" value="" />
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JHTML::_('tooltip','Réduction de 30 % pour les familles comprenant 3 enfants de moins de 18 ans','Réduction de 30 %','',JText::_('COM_TDSMANAGER_DECLARATION_NB_PERSONNES_AVEC_REDUCTION_POURCENTAGE_30')); ?></td>
						<td>
							<input name="nb_personnes_reduction_30" type="text" value="" />
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JHTML::_('tooltip','Réduction de 40 % pour les familles comprenant 3 enfants de moins de 18 ans','Réduction de 40 %','',JText::_('COM_TDSMANAGER_DECLARATION_NB_PERSONNES_AVEC_REDUCTION_POURCENTAGE_40')); ?></td>
						<td>
							<input name="nb_personnes_reduction_40" type="text" value="" />
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JHTML::_('tooltip','Réduction de 50 % pour les familles comprenant 3 enfants de moins de 18 ans','Réduction de 40 %','',JText::_('COM_TDSMANAGER_DECLARATION_NB_PERSONNES_AVEC_REDUCTION_POURCENTAGE_50')); ?></td>
						<td>
							<input name="nb_personnes_reduction_50" type="text" value="" />
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JHTML::_('tooltip','Réduction de 75 % pour les familles comprenant 3 enfants de moins de 18 ans','Réduction de 40 %','',JText::_('COM_TDSMANAGER_DECLARATION_NB_PERSONNES_AVEC_REDUCTION_POURCENTAGE_75')); ?></td>
						<td>
							<input name="nb_personnes_reduction_75" type="text" value="" />
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_TDSMANAGER_DECLARATION_NB_NUITEES_POURCENTAGE_30'); ?></td>
						<td>
							<input name="nb_nuitees_30" type="text" value="" />
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_TDSMANAGER_DECLARATION_NB_NUITEES_POURCENTAGE_40'); ?></td>
						<td>
							<input name="nb_nuitees_40" type="text" value="" />
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_TDSMANAGER_DECLARATION_NB_NUITEES_POURCENTAGE_50'); ?></td>
						<td>
							<input name="nb_nuitees_50" type="text" value="" />
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_TDSMANAGER_DECLARATION_NB_NUITEES_POURCENTAGE_75'); ?></td>
						<td>
							<input name="nb_nuitees_75" type="text" value="" />
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_TDSMANAGER_DECLARATION_NB_PERSONNES_EXONEREES'); ?></td>
						<td>
							<input name="nb_personnes_exonerees" type="text" value="" />
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_TDSMANAGER_DECLARATION_SOUS_TOTAL_DEUX'); ?></td>
						<td>
							<input name="sous_total2" type="text" value="" />
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_TDSMANAGER_DECLARATION_MONTANT_TOTAL'); ?></td>
						<td>
							<input name="montant_total" type="text" value="" />
						</td>
					</tr>
				</table>
		<input type="hidden" name="task" value="save" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
	</div>
</div>