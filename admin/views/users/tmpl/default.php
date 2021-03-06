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
<form action="<?php echo JRoute::_('index.php?option=com_tdsmanager&view=users'); ?>" method="post" name="adminForm" id="adminForm">
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
					<?php echo JHtml::_('grid.sort', 'COM_TDSMANAGER_USER_ID', 'userid', $listDirn, $listOrder); ?>
				</th>
				<th width="10%" class="nowrap">
					<?php echo JHtml::_('grid.sort', 'COM_TDSMANAGER_USER_NAME', 'name', $listDirn, $listOrder); ?>
				</th>
				<th width="10%" class="nowrap">
					<?php echo JHtml::_('grid.sort', 'COM_TDSMANAGER_USER_LASTNAME', 'lastname', $listDirn, $listOrder); ?>
				</th>
				<th width="10%" class="nowrap">
					<?php echo JHtml::_('grid.sort', 'COM_TDSMANAGER_USER_ADRESS', 'adress', $listDirn, $listOrder); ?>
				</th>
        <th width="10%" class="nowrap">
					<?php echo JHtml::_('grid.sort',  'COM_TDSMANAGER_USER_COMPLEMENT_ADRESS', 'complement_adress', $listDirn, $listOrder); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'COM_TDSMANAGER_USER_POSTALCODE', 'postalcode', $listDirn, $listOrder); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'COM_TDSMANAGER_USER_VILLE', 'ville', $listDirn, $listOrder); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'COM_TDSMANAGER_USER_TELEPHONE', 'telephone', $listDirn, $listOrder); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'COM_TDSMANAGER_USER_PORTABLE', 'portable', $listDirn, $listOrder); ?>
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
		<?php if ( !empty($this->users) ):
		foreach ($this->users	 as $i => $item) : ?>
			<tr class="row<?php echo $i % 2; ?>">
				<td class="center">
					<?php echo JHtml::_('grid.id', $i, intval($item->userid)); ?>
				</td>
				<td>
				 <?php echo intval($item->userid); ?>
				</td>
				<td>
            <?php echo $item->name; ?>
				</td>
				<td>
            <?php echo $item->lastname; ?>
				</td>
				<td>
            <?php echo $item->adress; ?>
				</td>
				<td class="center">
					<?php echo $item->complement_adress; ?>
				</td>
				<td class="center">
					<?php echo $item->postalcode; ?>
				</td>
				<td class="order">
					<?php echo $item->ville; ?>
				</td>
				<td class="center">
					<?php echo $item->telephone; ?>
				</td>
				<td class="center">
					<?php echo $item->portable;?>
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