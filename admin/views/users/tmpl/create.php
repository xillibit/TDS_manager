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
		<form action="<?php echo JRoute::_('index.php?option=com_tdsmanager&view=users') ?>" method="post" id="adminForm" name="adminForm">
				<table class="kadmin-adminform">
					<tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_USER_NAME'); ?></td>
						<td>
							<input name="name" value="<?php echo isset($this->user->name) ? $this->user->name :'' ?>" />
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_USER_LASTNAME'); ?></td>
						<td>
							<input name="lastname" value="<?php echo isset($this->user->lastname) ? $this->user->lastname :'' ?>" />
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_USER_ADRESS'); ?></td>
						<td>
							<input name="adress" value="<?php echo isset($this->user->adress) ? $this->user->adress :'' ?>" />
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_USER_COMPLEMENT_ADRESS'); ?></td>
						<td>
							<input name="complement_adress" value="<?php echo isset($this->user->complement_adress) ? $this->user->complement_adress :'' ?>" />
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_USER_POSTALCODE'); ?></td>
						<td>
							<input name="postalcode" value="<?php echo isset($this->user->postalcode) ? $this->user->postalcode :'' ?>" />
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_USER_VILLE'); ?></td>
						<td>
							<input name="ville" value="<?php echo isset($this->user->ville) ? $this->user->ville :'' ?>" />
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_USER_TELEPHONE'); ?></td>
						<td>
							<input name="telephone" value="<?php echo isset($this->user->telephone) ? $this->user->telephone :'' ?>" />
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_USER_PORTABLE'); ?></td>
						<td>
							<input name="portable" value="<?php echo isset($this->user->portable) ? $this->user->portable :'' ?>" />
						</td>
					</tr>
				</table>
		<input type="hidden" name="id" value="<?php echo isset($this->user->userid) ? $this->user->userid:''; ?>" />
    <input type="hidden" name="task" value="save" />
		<?php echo JHTML::_( 'form.token' ); ?>
	</div>
</div>