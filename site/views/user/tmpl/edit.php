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
  <form action="<?php echo JRoute::_('index.php?option=com_tdsmanager&view=user&task=save'); ?>" method="post">
    <ul style="list-style-type:none;">
      <li><span>Votre nom</span> <input type="text" name="name" value="<?php echo $this->userProfile->name ?>" /></li>
      <li><span>Votre prénom</span> <input type="text" name="lastname" value="<?php echo $this->userProfile->lastname ?>" /></li>
      <li><span>Votre adresse</span> <input type="text" name="adress" value="<?php echo $this->userProfile->adress ?>" /></li>
      <li><span>Votre complément d'adresse</span> <input type="text" name="complement_adress" value="<?php echo $this->userProfile->complement_adress ?>" /></li>
      <li><span>Code postal</span> <input type="text" name="postalcode" value="<?php echo $this->userProfile->postalcode ?>" /></li>
      <li><span>Ville</span> <input type="text" name="ville" value="<?php echo $this->userProfile->ville ?>" /></li>
      <li><span>Votre téléphone</span> <input type="text" name="telephone" value="<?php echo $this->userProfile->telephone ?>" /></li>
      <li><span>Votre portable</span> <input type="text" name="portable" value="<?php echo $this->userProfile->portable ?>" /></li>
      <li><span>Votre portable</span> <input type="text" name="portable" value="<?php echo $this->userProfile->portable ?>" /></li>
      <li><span>Votre mail</span> <input type="text" name="mail" value="<?php echo $this->userProfile->mail ?>" /></li>

    </ul>

	<input type="hidden" name="userid" value="<?php echo $this->profile->userid ?>" />

	<input type="button" onclick="javascript:history.back()" value="Annuler">
	<input type="submit" value="Enregister">
	<?php echo JHtml::_('form.token'); ?>
  </form>
</div>