<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_banners
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');
?>
<div id="kadmin">
	<div class="kadmin-right">
		<form action="<?php echo JRoute::_('index.php?option=com_tdsmanager&view=reglements') ?>" method="post" id="adminForm" name="adminForm">
				<table class="kadmin-adminform">
					<tr>
						<td valign="top"><?php echo JText::_('COM_TDSMANAGER_REGLEMENT_CHOOSE_DECLARATION'); ?></td>
						<td>
							<?php echo $this->declarationslist ?>
						</td>
					</tr>
					<tr>
						<td valign="top"><?php echo JText::_('COM_TDSMANAGER_REGLEMENT_DATE'); ?></td>
            <td>
							<?php echo JHtml::calendar('', 'date', 'date','%d-%m-%Y'); ?>
						</td>
          </tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_TDSMANAGER_REGLEMENT_MONTANT_DECLARE'); ?></td>
            <td>
							<input type="text" name="montant_declare" value="" />
						</td>
          </tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_TDSMANAGER_REGLEMENT_NUM_CHEQUE'); ?></td>
            <td>
							<input type="text" name="num_cheque" value="" />
						</td>
          </tr>
				</table>
		<input type="hidden" name="id" value="<?php //echo isset($this->classement->id) ? $this->classement->id:'0'; ?>" />
    <input type="hidden" name="task" value="savepaiement" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
	</div>
</div>