<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_banners
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
		<form action="<?php echo JRoute::_('index.php?option=com_gesttaxesejour&view=tarif_nuit') ?>" method="post" id="adminForm" name="adminForm">
				<table class="kadmin-adminform">
					<tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_TARIF_NUIT_TARIF'); ?></td>
						<td>
							<input name="tarif" value="<?php if(!empty($this->tarifnuit->tarif)) echo $this->tarifnuit->tarif; ?>" />
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_TARIF_NUIT_CLASSEMENT'); ?></td>
						<td>
						  <?php echo $this->classement_list; ?>	
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_TARIF_NUIT_HEBERGEMENT_TYPE'); ?></td>
						<td>
						  <?php echo $this->hebergement_type; ?>	
						</td>
					</tr>										
				</table>
		<input type="hidden" name="id" value="<?php echo isset($this->tarifnuit->id) ? $this->tarifnuit->id : '0'; ?>" />		
    <input type="hidden" name="task" value="save" />		
		<?php echo JHTML::_( 'form.token' ); ?>
	</div>	
</div>