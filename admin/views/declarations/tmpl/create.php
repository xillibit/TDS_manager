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
?>
<div id="kadmin">
	<div class="kadmin-right">
		<form action="<?php echo JRoute::_('index.php?option=com_tdsmanager&view=declarations') ?>" method="post" id="adminForm" name="adminForm">
				<table class="kadmin-adminform">
					<tr>
						<td valign="top"><?php echo JText::_('COM_TDSMANAGER_DECLARATION_MOIS_CONCERNE'); ?></td>
						<td>
							<?php echo $this->list_mois; ?>
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_TDSMANAGER_DECLARATION_HEBERGEMENT_CONCERNE'); ?></td>
						<td>
							<?php echo $this->list_hebergements; ?>
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_TDSMANAGER_DECLARATION_PERSONNES_PLEIN_TARIF'); ?></td>
						<td>
              <input name="nb_personnes_plein_tarif" value="" />
						</td>
					</tr>
				</table>
    <input type="hidden" name="boxchecked" value="1" />
    <input type="hidden" name="task" value="save_first_part" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
	</div>
</div>