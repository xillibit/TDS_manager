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

JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');

$listOrder =	$this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
?>
<form action="<?php echo JRoute::_('index.php?option=com_tdsmanager&view=declarations'); ?>" method="post" name="adminForm" id="adminForm">
	<fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('COM_TDSMANAGER_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_TDSMANAGER_SEARCH_IN_TITLE'); ?>" />
			<button type="submit"><?php echo JText::_('COM_TDSMANAGER_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('COM_TDSMANAGER_FILTER_CLEAR'); ?></button>
		</div>
		<div class="filter-select fltrt">

			<select name="filter_state" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('COM_TDSMANAGER_SELECT_STATUS');?></option>
				<?php //echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.state'), true);?>
			</select>

		</div>
	</fieldset>
	<div class="clr"> </div>

	<table class="adminlist">
		<thead>
			<tr>
				<th width="1%">
					<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('COM_TDSMANAGER_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
				</th>
				<th width="10%" class="nowrap">
					<?php echo JHtml::_('grid.sort', 'COM_TDSMANAGER_PERIODE_DECLARATION', 'start_date', $listDirn, $listOrder); ?>
				</th>
				<th width="10%" class="nowrap">
					<?php echo JHtml::_('grid.sort',  'COM_TDSMANAGER_DATE_DECLARATION', 'end_date', $listDirn, $listOrder); ?>
				</th>
				<th width="10%" class="nowrap">
					<?php echo JText::_('COM_TDSMANAGER_DECLARATION_TARIFICATION'); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'COM_TDSMANAGER_NB_PERSONNES_PAR_NUITEES', 'nb_personnes_assujetties', $listDirn, $listOrder); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'COM_TDSMANAGER_TOTAL_PERCU_TAXE_DE_SEJOUR', 'motant_encaisse_sejour', $listDirn, $listOrder); ?>
				</th>
				<th width="5%">
					<?php echo JText::_('COM_TDSMANAGER_HEBERGEMENT_USER_OWNER'); ?>
				</th>
				<th width="5%">
					<?php echo JText::_('COM_TDSMANAGER_HEBERGEMENT_NAME'); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="14">
					<div class="pagination">
						<div class="limit"><?php echo JText::_('COM_TDSMANAGER_A_DISPLAY'); ?> <?php echo $this->navigation->getLimitBox (); ?></div>
						<?php echo $this->navigation->getPagesLinks (); ?>
						<div class="limit"><?php echo $this->navigation->getResultsCounter (); ?></div>
					</div>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php if ( !empty($this->declarations) ):
		foreach ($this->declarations	as $i => $item) : ?>
			<tr class="row<?php echo $i % 2; ?>">
				<td class="center">
					<?php echo JHtml::_('grid.id', $i, intval($item->decl_id)); ?>
				</td>
				<td>
				<?php if ($item->trimestre=='premier_trim') {
						echo 'Premier trimestre ('.ucfirst($item->mois).')';
					} else if ($item->trimestre=='second_trim') {
						echo 'Deuxiéme trimestre ('.ucfirst($item->mois).')';
					} else if ($item->trimestre=='troisieme_trim') {
						echo 'Troisiéme trimestre ('.ucfirst($item->mois).')';
					} else if ($item->trimestre=='quatrieme_trim') {
						echo 'Quatriéme trimestre ('.ucfirst($item->mois).')';
					} else {
						echo 'Période inconnue';
					} ?>
				</td>
				<td class="center">
					<?php echo $item->date_declaration; ?>
				</td>
				<td class="center">
					<?php echo number_format((float)$item->tarif_par_nuite_par_personne, 2, '.', ''); ?> €
				</td>
				<td class="center">
					<?php echo $item->nb_personnes_par_nuite; ?>
				</td>
				<td class="center">
					<?php echo number_format((float)$item->total_declare, 2, '.', '') ?> €
				</td>
				<td class="center">
					<?php echo $item->owner_lastname.' '.$item->owner_name ?>
				</td>
				<td class="order">
					<?php echo $item->hostingname; ?>
				</td>
			</tr>
			<?php endforeach;
			endif; ?>
		</tbody>
	</table>
	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo intval ( $this->state->get('list.ordering') ) ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $this->escape ($this->state->get('list.direction')) ?>" />
		<input type="hidden" name="limitstart" value="<?php echo intval ( $this->navigation->limitstart ) ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>