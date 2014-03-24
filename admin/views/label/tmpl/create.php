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
		<form action="<?php echo JRoute::_('index.php?option=com_tdsmanager&view=label') ?>" method="post" id="adminForm" name="adminForm">
				<table class="kadmin-adminform">
					<tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_LABEL_TYPE_NAME'); ?></td>
						<td>
							<textarea name="nom" cols="50" rows="6" style="width: 500px"><?php if(!empty($this->label->nom)) echo $this->label->nom; ?></textarea>
						</td>
					</tr>
				</table>
		<input type="hidden" name="id" value="<?php echo isset($this->label->id) ? $this->label->id : '0'; ?>" />
    <input type="hidden" name="task" value="save" />
		<?php echo JHTML::_( 'form.token' ); ?>
	</div>
</div>