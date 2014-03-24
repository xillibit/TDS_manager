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
<form action="<?php echo JRoute::_('index.php?option=com_tdsmanager&view=reglements'); ?>" method="post" name="adminForm" id="adminForm">
	<fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('COM_GESTTAXESEJOUR_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" id="filter_search" value="<?php //echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_GESTTAXESEJOUR_SEARCH_IN_TITLE'); ?>" />
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
					<?php echo JHtml::_('grid.sort', 'COM_GESTTAXESEJOUR_NAME_HOSTING', 'name_hosting', $listDirn, $listOrder); ?>
				</th>
        <th width="10%" class="nowrap">
					<?php echo JHtml::_('grid.sort',  'COM_GESTTAXESEJOUR_DESCRIPTION', 'description', $listDirn, $listOrder); ?>
				</th>
				<th width="10%" class="nowrap">
					<?php echo JText::_('COM_GESTTAXESEJOUR_REGLEMENT_STATUS'); ?>
				</th>
        <th width="10%" class="nowrap">
					<?php echo JText::_('COM_GESTTAXESEJOUR_REGLEMENT_DECLARATION_DATE'); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'COM_GESTTAXESEJOUR_ADDRESS', 'adress', $listDirn, $listOrder); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'COM_GESTTAXESEJOUR_COMPLEMENT_ADDRESS', 'complement_adress', $listDirn, $listOrder); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'COM_GESTTAXESEJOUR_POSTALCODE', 'postalcode', $listDirn, $listOrder); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'COM_GESTTAXESEJOUR_VILLE', 'ville', $listDirn, $listOrder); ?>
				</th>
				<th width="10%">
					<?php echo JHtml::_('grid.sort',  'COM_GESTTAXESEJOUR_DATE_CLASSEMENT', 'date_classement', $listDirn, $listOrder); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'COM_GESTTAXESEJOUR_NUMERO_CLASSEMENT', 'numero_classement', $listDirn, $listOrder); ?>
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
		<?php foreach ($this->reglements	 as $i => $item) : ?>
			<tr class="row<?php echo $i % 2; ?>">
				<td class="center">
					<?php echo JHtml::_('grid.id', $i, intval($item->id)); ?>
				</td>
				<td>
            <?php echo $item->hostingname; ?>
				</td>
				<td class="center">
					<?php echo $item->description; ?>
				</td>
				<td class="center">
					<?php echo JHtml::_('jgrid.published', $item->finaliser, $i, '', 1, 'cb'); ?>
				</td>
        <td class="center">
					<?php echo $item->date_declarer; ?>
				</td>
				<td class="center">
					<?php echo $item->adress; ?>
				</td>
				<td class="center">
					<?php echo $item->complement_adress;?>
				</td>
				<td class="center">
					<?php echo $item->postalcode; ?>
				</td>
				<td class="order">
					<?php echo $item->city; ?>
				</td>
        <td>
					<?php echo !empty($item->numero_agrement) ? $item->numero_agrement : JText::_('COM_GESTTAXESEJOUR_NO_CLASSEMENT_DEFINED'); ?>
				</td>
				<td class="center">
					<?php echo $item->date_classement; ?>
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