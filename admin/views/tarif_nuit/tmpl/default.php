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

$listOrder =	'';//$this->state->get('list.ordering');
$listDirn	= '';//$this->state->get('list.direction');
?>
<form action="<?php echo JRoute::_('index.php?option=com_gesttaxesejour&view=tarif_nuit'); ?>" method="post" name="adminForm" id="adminForm">
	<div class="clr"> </div>

	<table class="adminlist">
		<thead>
			<tr>
				<th width="1%">
					<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('COM_GESTTAXESEJOUR_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
				</th>
				<th width="1%" class="nowrap">
        #			
				</th>        
				<th width="10%">
					<?php echo JText::_('COM_GESTTAXESEJOUR_TARIF_NUIT'); ?>
				</th>
        <th width="10%">
					<?php echo JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_TYPE'); ?>
				</th>
        <th width="10%">
					<?php echo JText::_('COM_GESTTAXESEJOUR_CLASSEMENT'); ?>
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
		<?php foreach ($this->tarifnuits	 as $i => $item) : ?>
			<tr class="row<?php echo $i % 2; ?>">
				<td class="center">
					<?php echo JHtml::_('grid.id', $i, intval($item->id)); ?>
				</td>
				<td class="center">
            <?php echo intval($item->id); ?>									
				</td>
				<td class="center">
					<?php echo $item->tarif; ?> €
				</td>
        <td class="center">
					<?php echo $item->h_type; ?>
				</td>
        <td class="center">
					<?php echo $item->classement_name==0 ? 'Aucun': $item->classement_name; ?>
				</td>												
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<div>
		<input type="hidden" name="task" value="" />    		
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php //echo intval ( $this->state->get('list.ordering') ) ?>" />
    <input type="hidden" name="filter_order_Dir" value="<?php //echo $this->escape ($this->state->get('list.direction')) ?>" />
    <input type="hidden" name="limitstart" value="<?php //echo intval ( $this->navigation->limitstart ) ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>