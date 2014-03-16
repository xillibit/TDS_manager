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

$listOrder =	$this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
?>
<form action="<?php echo JRoute::_('index.php?option=com_gesttaxesejour&view=declarations'); ?>" method="post" name="adminForm" id="adminForm">
	<fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('COM_GESTTAXESEJOUR_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_GESTTAXESEJOUR_SEARCH_IN_TITLE'); ?>" />
			<button type="submit"><?php echo JText::_('COM_GESTTAXESEJOUR_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('COM_GESTTAXESEJOUR_FILTER_CLEAR'); ?></button>
		</div>
		<div class="filter-select fltrt">

			<select name="filter_state" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('COM_GESTTAXESEJOUR_SELECT_STATUS');?></option>
				<?php //echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.state'), true);?>
			</select>

		</div>
	</fieldset>
	<div class="clr"> </div>

	<table class="adminlist">
		<thead>
			<tr>
				<th width="1%">
					<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('COM_GESTTAXESEJOUR_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
				</th>
				<th width="10%" class="nowrap">
					<?php echo JHtml::_('grid.sort', 'COM_GESTTAXESEJOUR_DATE_DECLARATION', 'start_date', $listDirn, $listOrder); ?>
				</th>
        <th width="10%" class="nowrap">
					<?php echo JHtml::_('grid.sort',  'COM_GESTTAXESEJOUR_DATE_DECLARATION_FIN', 'end_date', $listDirn, $listOrder); ?>
				</th>
				<th width="10%" class="nowrap">
					<?php echo JText::_('COM_GESTTAXESEJOUR_DECLARATION_PAIEMENT'); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'COM_GESTTAXESEJOUR_PERIOD', 'identification_period', $listDirn, $listOrder); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'COM_GESTTAXESEJOUR_NB_PERSONNES_ASSUJETTIES', 'nb_personnes_assujetties', $listDirn, $listOrder); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'COM_GESTTAXESEJOUR_MONTANT_ENCAISSE_SEJOUR', 'motant_encaisse_sejour', $listDirn, $listOrder); ?>
				</th>
				<th width="5%">
					<?php echo JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_USER_OWNER'); ?>
				</th>
				<th width="5%">
					<?php echo JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_CONCERN'); ?>
				</th>				 												
			</tr>
		</thead>
		<tfoot>
			<tr>
        <td colspan="14">
          <div class="pagination">
          <div class="limit"><?php echo JText::_('COM_GESTTAXESEJOUR_A_DISPLAY'); ?> <?php echo $this->navigation->getLimitBox (); ?></div>
          <?php echo $this->navigation->getPagesLinks (); ?>
          <div class="limit"><?php echo $this->navigation->getResultsCounter (); ?></div>
          </div>
        </td>
      </tr>
		</tfoot>
		<tbody>
		<?php foreach ($this->declarations	as $i => $item) : ?>
			<tr class="row<?php echo $i % 2; ?>">
				<td class="center">
					<?php echo JHtml::_('grid.id', $i, intval($item->decl_id)); ?>
				</td>
				<td>
            <?php echo $item->start_date; ?>									
				</td>
				<td class="center">
					<?php echo $item->end_date; ?>
				</td>
				<td class="center">
					<?php echo JHtml::_('jgrid.published', $item->paiement_ok, $i, '', 1, 'cb'); ?>
				</td>
				<td class="center">
				  <?php echo $item->identification_periode ? $this->mois[$item->identification_periode] : JText::_('COM_DECLARATION_IDENTIFICATION_PERIOD_UNKNOWN'); ?>
        </td>
				<td class="center">
					<?php echo $item->nb_personnes_assujetties; ?>
				</td>
				<td class="center">
					<?php echo $item->montant_encaisse_sejour;?>
				</td>
				<td class="center">
					<?php echo $item->owner_lastname.' '.$item->owner_name ?>
				</td>
				<td class="order">
					<?php echo $item->hostingname; ?>						
				</td> 												
			</tr>
			<?php endforeach; ?>
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