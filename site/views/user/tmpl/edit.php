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
		<?php echo JText::_('COM_TDSMANAGER_USER_EDITION_PROFIL') ?>
	</h1>
	<form class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_tdsmanager&view=user&task=save'); ?>" method="post">
		<div class="control-group">
			<label class="control-label" for="inputNom">Votre nom</label>
			<div class="controls">
				<input type="text" name="name" id="inputNom" value="<?php echo $this->userProfile->name ?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputPassword">Votre prénom</label>
			<div class="controls">
				<input type="text" name="lastname" id="inputPassword" value="<?php echo $this->userProfile->lastname ?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputAdress">Votre adresse</label>
			<div class="controls">
				<input type="text" name="adress" id="inputAdress" value="<?php echo $this->userProfile->adress ?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputComplementadress">Votre complément d'adresse</label>
			<div class="controls">
				<input type="text" name="complement_adress" id="inputComplementadress" value="<?php echo $this->userProfile->complement_adress ?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputCodepostal">Code postal</label>
			<div class="controls">
				<input type="text" name="postalcode" id="inputCodepostal" value="<?php echo $this->userProfile->postalcode ?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputVille">Ville</label>
			<div class="controls">
				<input type="text" name="ville" id="inputVille" value="<?php echo $this->userProfile->ville ?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputTelephone">Votre téléphone</label>
			<div class="controls">
				<input type="text" name="telephone" id="inputTelephone" value="<?php echo $this->userProfile->telephone ?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputPortable">Votre portable</label>
			<div class="controls">
				<input type="text" name="portable" id="inputPortable" value="<?php echo $this->userProfile->portable ?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputMail">Votre mail</label>
			<div class="controls">
				<input type="text" name="mail" id="inputMail" value="<?php echo $this->userProfile->mail ?>" />
			</div>
		</div>
	
		<input type="hidden" name="userid" value="<?php echo $this->profile->userid ?>" />
		
		<input class="btn btn btn-primary" type="submit" value="Enregister">
		<input class="btn btn-danger" type="button" onclick="javascript:history.back()" value="Annuler">
		
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>