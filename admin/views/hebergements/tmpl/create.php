<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_banners
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::_('behavior.tooltip');
JHtml::_( 'behavior.calendar' );
?>
<div id="kadmin">
	<div class="kadmin-right">
		<form action="<?php echo JRoute::_('index.php?option=com_tdsmanager&view=hebergements') ?>" method="post" id="adminForm" name="adminForm">
				<table class="kadmin-adminform">
					<tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_HOSTINGNAME'); ?></td>
						<td>
							<textarea name="hostingname" cols="50" rows="6" style="width: 500px"><?php if(!empty($this->hebergement->hostingname)) echo $this->hebergement->hostingname; ?></textarea>
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_DESCRIPTION'); ?></td>
						<td>
							<textarea name="description" cols="50" rows="6" style="width: 500px"><?php if(!empty($this->hebergement->description)) echo $this->hebergement->description; ?></textarea>
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_ADRESS'); ?></td>
						<td>
							<input name="adress" value="<?php if(!empty($this->hebergement->adress)) echo $this->hebergement->adress; ?>" />
						</td>
					</tr>
					<tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_COMPLEMENT_ADRESS'); ?></td>
						<td>
							<input name="complement_adress" value="<?php if(!empty($this->hebergement->complement_adress)) echo $this->hebergement->complement_adress; ?>" />
						</td>
					</tr>
					<tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_CITY'); ?></td>
						<td>
							<input name="city" value="<?php if(!empty($this->hebergement->city)) echo $this->hebergement->city; ?>" />
						</td>
					</tr>
					<tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_WEBSITE'); ?></td>
						<td>
							<input name="website" value="<?php if(!empty($this->hebergement->website)) echo $this->hebergement->website; ?>" />
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_POSTALCODE'); ?></td>
						<td>
							<input name="postalcode" value="<?php if(!empty($this->hebergement->postalcode)) echo $this->hebergement->postalcode; ?>" />
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_CLASSEMENT'); ?></td>
						<td>
							<?php echo $this->classementlist; ?>
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_NUMERO_CLASSEMENT'); ?></td>
						<td>
						  <input name="numero_classement" value="<?php if(!empty($this->hebergement->numero_classement)) echo $this->hebergement->numero_classement; ?>" />
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_DATE_CLASSEMENT'); ?></td>
						<td>
						  <?php empty($this->hebergement->date_classement) ? $date_classement='0000-00-00 00:00:00' : $date_classement=$this->hebergement->date_classement;
               echo JHtml::calendar($date_classement, 'date_classement', 'date_classement', '%Y-%m-%d');?>
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_LABEL'); ?></td>
						<td>
						  <?php echo $this->labellist; ?>
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_TYPE'); ?></td>
						<td>
						  <?php echo $this->hebergement_typelist; ?>
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_OWNER_NAME'); ?></td>
						<td>
						  <?php echo $this->users_list; ?>
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_CAPACITE_CHAMBRES'); ?></td>
						<td>
						  <input name="capacite_chambres" value="<?php if(!empty($this->hebergement->capacite_chambres)) echo $this->hebergement->capacite_chambres; ?>" />
						</td>
					</tr>
          <tr>
						<td valign="top"><?php echo JText::_('COM_GESTTAXESEJOUR_CAPACITE_PERSONNES'); ?></td>
						<td>
						  <input name="capacite_personnes" value="<?php if(!empty($this->hebergement->capacite_personnes)) echo $this->hebergement->capacite_personnes; ?>" />
						</td>
					</tr>
				</table>
		<input type="hidden" name="id" value="<?php echo isset($this->hebergement->id) ? $this->hebergement->id : ''; ?>" />
    <input type="hidden" name="task" value="save" />
		<?php echo JHTML::_( 'form.token' ); ?>
	</div>
</div>