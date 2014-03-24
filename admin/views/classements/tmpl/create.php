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
?>
<div id="kadmin">
	<div class="kadmin-right">
		<form action="<?php echo JRoute::_('index.php?option=com_tdsmanager&view=classements') ?>" method="post" id="adminForm" name="adminForm">
				<table class="kadmin-adminform">
					<tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_CLASSEMENT_DESCRIPTION'); ?></td>
						<td>
							<input name="description" value="<?php if(!empty($this->classement->description)) echo $this->classement->description; ?>" />
						</td>
					</tr>
					<tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_CLASSEMENT_STATE'); ?></td>
            <td>
							<input name="state" value="<?php if(!empty($this->classement->state)) echo $this->classement->state; ?>" />
						</td>
          </tr>
				</table>
		<input type="hidden" name="id" value="<?php echo isset($this->classement->id) ? $this->classement->id:'0'; ?>" />
    <input type="hidden" name="task" value="save" />
		<?php echo JHTML::_( 'form.token' ); ?>
	</div>
</div>