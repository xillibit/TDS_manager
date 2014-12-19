<?php
 /**
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

?>
<div>
	<h1>
		<?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_NEW_DECLARATION_CHOOSE_HOSTING'); ?>
	</h1>
	<br />
	<form action="<?php echo JRoute::_('index.php?option=com_tdsmanager&view=declarations&task=createdec'); ?>" method="post">
		<ul style="list-style-type:none;">
			<!-- Utiliser choosen pour choisir l'hébergement -->
			<li><span><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_CHOOSE_OUR_HEBERGEMENT') ?></span></li>
			<li><?php echo $this->userhostings ?></li>
			<li><button class="btn btn-primary" type="submit"><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_VALIDER') ?></button></li>
		</ul>
	</form>
</div>