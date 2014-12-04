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
		<form action="<?php echo JRoute::_('index.php?option=com_tdsmanager&view=hebergements_type') ?>" method="post" id="adminForm" name="adminForm">
				<table class="kadmin-adminform">
					<tr>
						<td valign="top"><?php echo JText::_('COM_TDSMANAGER_HEBRGEMENT_TYPE_NAME'); ?></td>
						<td>
							<textarea name="name" cols="50" rows="6" style="width: 500px"><?php if(!empty($this->hebergement_type->name)) echo $this->hebergement_type->name; ?></textarea>
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_TDSMANAGER_HEBRGEMENT_TYPE_DESCRIPTION'); ?></td>
						<td>
							<textarea name="description" cols="50" rows="6" style="width: 500px"><?php if(!empty($this->hebergement_type->description)) echo $this->hebergement_type->description; ?></textarea>
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_TDSMANAGER_HEBERGEMENT_STATUS'); ?></td>
						<td>
							<input name="state" value="<?php if(!empty($this->hebergement_type->state)) echo $this->hebergement_type->state; ?>" />
						</td>
					</tr>
				</table>
		<input type="hidden" name="id" value="<?php echo isset($this->hebergement_type->id) ? $this->hebergement_type->id : '0'; ?>" />
    <input type="hidden" name="task" value="save" />
		<?php echo JHTML::_( 'form.token' ); ?>
	</div>
</div>