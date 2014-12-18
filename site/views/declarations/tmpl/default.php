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
	 <?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_GESTION_DECLARATIONS') ?>
  </h1>

  <form action="<?php echo JRoute::_('index.php?option=com_tdsmanager&view=declarations'); ?>" method="post" id="com_gesttaxe_dec_form">
    <table class="adminlist">
  		<thead>
  			<tr>
          <th width="5%" class="nowrap">
            <input name="checkbox_all" id="checkbox_all" type="checkbox" />
          </th>
  				<th width="10%" class="nowrap">
  					<?php echo JText::_('COM_TDSMANAGER_DATE_DEBUT'); ?>
  				</th>
          <th width="10%" class="nowrap">
  					<?php echo JText::_('COM_TDSMANAGER_DATE_FIN'); ?>
  				</th>
  				<th width="5%">
  					<?php echo JText::_('COM_TDSMANAGER_DUREE_SEJOUR'); ?>
  				</th>
  				<th width="5%">
  					<?php echo JText::_('COM_TDSMANAGER_MONTANT_ENCAISSE_SEJOUR'); ?>
  				</th>
  				<th width="5%">
  					<?php echo JText::_('COM_TDSMANAGER_DATE_DECLARATION'); ?>
  				</th>
  				<th width="5%">
  					<?php echo JText::_('COM_TDSMANAGER_PAIEMENT_OK'); ?>
  				</th>
  				<th width="10%">
  					<?php echo JText::_('COM_TDSMANAGER_NOM_HEBERGEMENT'); ?>
  				</th>
  			</tr>
  		</thead>
  		<tfoot>
  		</tfoot>
  		<tbody>
  		<?php
       if ( !empty($this->declarations) ) {
        foreach ($this->declarations	 as $i => $item) : ?>
    			<tr class="row<?php echo $i % 2; ?>">
    				<td>
                <input class="check-me" name="cid[]" type="checkbox" value="<?php echo $item->id; ?>" />
    				</td>
            <td>
                <?php echo $item->start_date; ?>
    				</td>
    				<td class="center">
    					<?php echo $item->end_date; ?>
    				</td>
    				<td class="center">
    					<?php echo $item->duree_sejour; ?>
    				</td>
    				<td class="center">
    					<?php echo $item->montant_encaisse_sejour;?>
    				</td>
    				<td class="center">
    					<?php echo $item->date_declarer; ?>
    				</td>
    				<td class="order">
    					<?php echo $item->paiement_ok ? JText::_('COM_TDSMANAGER_DECLARATION_PAID') : JText::_('COM_TDSMANAGER_DECLARATION_NO_PAID'); ?>
    				</td>
    				<td class="center">
    					<?php echo $item->hostingname;?>
    				</td>
    			</tr>
  			<?php endforeach;
        }
         ?>
  		</tbody>
  	</table>
    <a href="<?php echo JRoute::_('index.php?option=com_tdsmanager&view=declarations&task=edit'); ?>" class="btn btn-primary"><?php echo JText::_('COM_TDSMANAGER_CREATE_NEW_DECLARATION') ?></a>
    <!--<input type="button" id="sup_declaration" value="<?php //echo JText::_('COM_TDSMANAGER_DECLARATION_DELETE_DECLARATION') ?>" />  -->
    <button class="btn btn-primary" type="button"><?php echo JText::_('COM_TDSMANAGER_CREATE_PAIEMENT_DECLARATION') ?></button>
    <input type="hidden" name="task" value="recap" />
    <?php echo JHtml::_('form.token'); ?>
  </form>
</div>