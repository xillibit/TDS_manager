<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_tdsmanager
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHTML::_('behavior.calendar');
?>
<div>
  <h1>
	 <?php echo JText::_('COM_GESTTAXESEJOUR_HEBERGEMENTS_NEW_HOSTINGS'); ?>
  </h1>
  <form action="<?php echo JRoute::_('index.php?option=com_tdsmanager&view=hebergements&task=save'); ?>" method="post" enctype="multipart/form-data">
    <ul style="list-style-type:none;">
      <li><span><?php echo JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_HOSTING_NAME') ?></span> <input type="text" name="hostingname" value="<?php echo isset($this->hebergement->hostingname) ? $this->hebergement->hostingname : '' ?>" /></li>
      <li><span><?php echo JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_DESCRIPTION') ?></span> <textarea name="description" rows="2" cols="20"><?php echo isset($this->hebergement->description) ? $this->hebergement->description : '' ?></textarea></li>
      <li><span><?php echo JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_ADRESS') ?></span> <input type="text" name="adress" value="<?php echo isset($this->hebergement->adress) ? $this->hebergement->adress : '' ?>" /></li>
      <li><span><?php echo JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_COMPLEMENT_ADRESS') ?></span> <input type="text" name="complement_adress" value="<?php echo isset($this->hebergement->complement_adress) ? $this->hebergement->complement_adress : '' ?>" /></li>
      <li><span><?php echo JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_POSTAL_CODE') ?></span> <input type="text" name="postalcode" value="<?php echo isset($this->hebergement->postalcode) ? $this->hebergement->postalcode : '' ?>" /></li>
      <li><span><?php echo JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_CITY') ?></span> <input type="text" name="city" value="<?php echo isset($this->hebergement->city) ? $this->hebergement->city : '' ?>" /></li>
      <li><span><?php echo JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_PHONE') ?></span> <input type="text" name="phone" value="<?php echo isset($this->hebergement->phone) ? $this->hebergement->phone : '' ?>" /></li>
      <li><span><?php echo JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_PORTABLE') ?></span> <input type="text" name="portable" value="<?php echo isset($this->hebergement->portable) ? $this->hebergement->portable : '' ?>" /></li>
      <li><span><?php echo JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_IDENTIFICATION_PERIODE') ?></span> <?php echo isset($this->hebergement->identification_period) ? $this->hebergement->identification_period : '' ?></li>
      <li><span><?php echo JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_WEBSITE') ?></span> <input type="text" name="website" value="<?php echo isset($this->hebergement->website) ? $this->hebergement->website : '' ?>" /></li>
      <li><span><?php echo JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_CLASSEMENT_NUMBER') ?></span> <input type="text" name="numero_classement" value="<?php echo isset($this->hebergement->numero_classement) ? $this->hebergement->numero_classement : '' ?>" /></li>
      <li><span><?php echo JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_DATE_CLASSEMENT') ?></span>
      <?php if ( !empty($this->hebergement->date_classement) ) echo JHTML::_( 'calendar',$this->hebergement->date_classement,'date_classement','date_classement', '%d-%m-%Y');
      else echo JHTML::_( 'calendar','','date_classement','date_classement', '%d-%m-%Y'); ?></li>
      <li><span><?php echo JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_TYPE_CLASSEMENT') ?></span> <?php echo isset($this->classement_list) ? $this->classement_list : ''; ?></li>
      <li><span><?php echo JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_LABEL') ?></span> <?php echo isset($this->label_list) ? $this->label_list : ''; ?></li>
      <?php if (!$this->editmode): ?><li><span><?php echo JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_IMAGE_UPLOAD') ?></span> <input type="file" name="hostingimage" /> </li><?php endif; ?>
      <input type="submit" value="<?php echo JText::_('COM_GESTTAXESEJOUR_HEBERGEMENTS_EDIT_ENREGISTRER') ?>">
      <input type="button" onclick="javascript:history.back()" value="<?php echo JText::_('COM_GESTTAXESEJOUR_HEBERGEMENTS_EDIT_ANNULER') ?>">
      <?php if ($this->editmode): ?>
        <input type="hidden" name="edit_mode" value="1" />
      <?php else: ?>
        <input type="hidden" name="edit_mode" value="0" />
      <?php endif; ?>
    </ul>
    <input type="hidden" name="hebergement_id" value="<?php echo $this->hebergement->id ?>" />
    <?php echo JHtml::_('form.token'); ?>
  </form>
</div>