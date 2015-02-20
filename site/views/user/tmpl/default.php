<?php
 /**
 * @package		Joomla.Site
 * @subpackage	com_tdsmanager
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<div>
	<h1>
		<?php echo JText::_('COM_TDSMANAGER_USER_GESTION_PROFIL') ?>
	</h1>
	<form action="<?php echo JRoute::_('index.php?option=com_tdsmanager&view=user&task=edit'); ?>" method="post">
		<fieldset>
			<legend>Profil</legend>
			<label><?php echo JText::_('COM_TDSMANAGER_USER_NAME') ?> :</label>
			<b><?php echo !empty($this->userProfile->name) ? $this->userProfile->name : 'Non renseigné' ?></b>
			<label><?php echo JText::_('COM_TDSMANAGER_USER_LASTNAME') ?> :</label>
			<b><?php echo !empty($this->userProfile->lastname) ? $this->userProfile->lastname : 'Non renseigné' ?></b>
			<label><?php echo  JText::_('COM_TDSMANAGER_USER_ADRESS') ?> :</label>
			<b><?php echo !empty($this->userProfile->adress) ? $this->userProfile->adress : 'Non renseigné' ?></b>
			<label><?php echo JText::_('COM_TDSMANAGER_USER_COMPLEMENT_ADRESS') ?> :</label>
			<b><?php echo !empty($this->userProfile->complement_adress) ? $this->userProfile->complement_adress : 'Non renseigné' ?></b>
			<label><?php echo JText::_('COM_TDSMANAGER_USER_POSTALCODE') ?> :</label>
			<b><?php echo !empty($this->userProfile->postalcode) ? $this->userProfile->postalcode : 'Non renseigné' ?></b>
			<label><?php echo JText::_('COM_TDSMANAGER_USER_VILLE') ?> :</label>
			<b><?php echo !empty($this->userProfile->ville) ? $this->userProfile->ville  : 'Non renseigné' ?></b>
			<label><?php echo JText::_('COM_TDSMANAGER_USER_TELEPHONE') ?> :</label>
			<b><?php echo !empty($this->userProfile->telephone) ? $this->userProfile->telephone  : 'Non renseigné' ?></b>
			<label><?php echo JText::_('COM_TDSMANAGER_USER_PORTABLE') ?> :</label>
			<b><?php echo !empty($this->userProfile->portable) ? $this->userProfile->portable  : 'Non renseigné' ?></b>
			<label><?php echo JText::_('COM_TDSMANAGER_USER_MAIL') ?> :</label>
			<b><?php echo !empty($this->userProfile->mail) ? $this->userProfile->mail  : 'Non renseigné' ?></b>
			<br />
			<button class="btn btn-primary" type="button">Modifier votre profil</button>
		</fieldset>

	<?php echo JHtml::_('form.token'); ?>
	</form>
</div>