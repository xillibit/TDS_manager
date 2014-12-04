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
  <fieldset style="border: 1px solid #CCCCCC;margin: 10px 0 15px;padding: 15px;">
    <legend> Profil </legend>
    <dl>
      <dt><span style="font-weight: bold;"><?php echo JText::_('COM_TDSMANAGER_USER_NAME') ?>: </span> <?php echo $this->userProfile->name ?></dt>
      <dd><span style="font-weight: bold;"><?php echo JText::_('COM_TDSMANAGER_USER_LASTNAME') ?>: </span><?php echo $this->userProfile->lastname ?></dd>
      <dt><span style="font-weight: bold;"><?php echo JText::_('COM_TDSMANAGER_USER_ADRESS') ?>: </span><?php echo $this->userProfile->adress ?></dt>
      <dd><span style="font-weight: bold;"><?php echo JText::_('COM_TDSMANAGER_USER_COMPLEMENT_ADRESS') ?>: </span><?php echo $this->userProfile->complement_adress ?></dd>
      <dt><span style="font-weight: bold;"><?php echo JText::_('COM_TDSMANAGER_USER_POSTALCODE') ?>: </span><?php echo $this->userProfile->postalcode ?></dt>
      <dd><span style="font-weight: bold;"><?php echo JText::_('COM_TDSMANAGER_USER_VILLE') ?>: </span><?php echo $this->userProfile->ville ?></dd>
      <dt><span style="font-weight: bold;"><?php echo JText::_('COM_TDSMANAGER_USER_TELEPHONE') ?>: </span><?php echo $this->userProfile->telephone ?></dt>
      <dd><span style="font-weight: bold;"><?php echo JText::_('COM_TDSMANAGER_USER_PORTABLE') ?>: </span><?php echo $this->userProfile->portable ?></dd>
      <dd><span style="font-weight: bold;"><?php echo JText::_('COM_TDSMANAGER_USER_MAIL') ?>: </span><?php echo $this->userProfile->mail ?></dd>
    </dl>
  </fieldset>

    <input type="submit" value="Modifier votre profil" />
    <?php echo JHtml::_('form.token'); ?>
  </form>
</div>