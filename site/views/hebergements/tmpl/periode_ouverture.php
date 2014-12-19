<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHTML::_('behavior.calendar');
?>
<div>
  <h1>
	 <?php echo JText::_('COM_TDSMANAGER_HEBERGEMENTS_PERIODE_OUVERTURE'); ?>
  </h1>
  <form action="<?php echo JRoute::_('index.php?option=com_tdsmanager&view=hebergements&task=save_period'); ?>" method="post">
    <ul style="list-style-type:none;">
      <!-- Choix hébergement dans une liste déroulante -->
      <li><span><?php echo JText::_('COM_TDSMANAGER_HEBERGEMENT_CONCERNEE') ?></span><?php echo $this->myhebergementslist ?></li>

      <li><span><?php echo JText::_('COM_TDSMANAGER_HEBERGEMENT_FERMEE_DEPUIS_LE') ?></span> <?php echo JHTML::_( 'calendar','','fermee_depuis','fermee_depuis', '%Y-%m-%d') ?></li>
      <li><span><?php echo JText::_('COM_TDSMANAGER_HEBERGEMENT_REOUVERTURE_LE') ?></span> <?php echo JHTML::_( 'calendar','','reouverture_le','reouverture_le', '%Y-%m-%d') ?></li>
      <li><span><?php echo JText::_('COM_TDSMANAGER_HEBERGEMENT_MOTIF') ?></span> <input type="text" name="motif" value="<?php ?>" /></li>

    </ul>

	<button class="btn btn-primary" type="submit"><?php echo JText::_('COM_TDSMANAGER_HEBERGEMENTS_EDIT_ENREGISTRER') ?></button>
	<button class="btn btn-danger" type="button" onclick="javascript:history.back()"><?php echo JText::_('COM_TDSMANAGER_HEBERGEMENTS_EDIT_ANNULER') ?></button>

    <?php echo JHtml::_('form.token'); ?>
  </form>
</div>