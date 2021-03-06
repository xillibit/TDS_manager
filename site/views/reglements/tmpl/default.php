<?php
 /**
 * @package		Joomla.Site
 * @subpackage	com_tdsmanager
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

echo $this->_getViewFile('common', 'menu');
?>
<div>
  <h1>
	 <?php echo JText::_('COM_TDSMANAGER_VISUALISATION_REGLEMENTS') ?>
  </h1>

  <table class="table table-bordered">
		<thead>
			<tr>
				<th class="nowrap">
					<?php echo JHtml::_('grid.sort', 'COM_TDSMANAGER_REGLEMENT_DATE_REGLER', 'name_hosting'); ?>
				</th>
				<th class="nowrap">
					<?php echo JHtml::_('grid.sort',  'COM_TDSMANAGER_REGLEMENT_MONTANT', 'description'); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_TDSMANAGER_REGLEMENT_TYPE_REGLEMENT', 'adress'); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_TDSMANAGER_REGLEMENT_FINALISER', 'complement_adress'); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
		</tfoot>
		<tbody>
		<?php
     if ( !empty($this->reglements) ) {
      foreach ($this->reglements	 as $i => $item) : ?>
  			<tr class="row<?php echo $i % 2; ?>">
  				<td>
              <?php echo $item->date_regler; ?>
  				</td>
  				<td class="center">
  					<?php echo $item->montant; ?>
  				</td>
  				<td class="center">
  					<?php echo $item->type_reglement; ?>
  				</td>
  				<td class="center">
  					<?php echo isset($item->finaliser) ? JText::_('COM_TDSMANAGER_REGLEMENT_NOT_FINALISED'): JText::_('COM_TDSMANAGER_REGLEMENT_FINALISED');?>
  				</td>
  			</tr>
			<?php endforeach;
      }
       ?>
		</tbody>
	</table>
</div>
<?php echo $this->_getViewFile('common', 'footer'); ?>