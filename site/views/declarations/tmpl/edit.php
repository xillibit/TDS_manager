<?php
 /**
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

?>
<form action="<?php echo JRoute::_('index.php?option=com_tdsmanager&view=declarations&task=createdec'); ?>" method="post">
	<fieldset>
	<legend><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_NEW_DECLARATION_CHOOSE_HOSTING'); ?></legend>
	<div class="control-group">
		<label class="control-label" for="inputHebergement"><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_CHOOSE_OUR_HEBERGEMENT') ?> :</label>
		<div class="controls">
			<?php echo $this->userhostings ?>
		</div>
	</div>
	</fieldset>
	<button class="btn btn-primary" type="submit"><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_VALIDER') ?></button>
	<button class="btn btn-danger" onclick="javascript:history.back()" type="button"><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_ANNULER') ?></button>
</form>