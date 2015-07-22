<?php
 /**
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

echo $this->_getViewFile('common', 'menu');
?>
<div>
	<h1>
		<?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_GESTION_DECLARATIONS') ?>
	</h1>

	<form action="<?php echo JRoute::_('index.php?option=com_tdsmanager&view=declarations'); ?>" method="post" id="com_gesttaxe_dec_form">
		<table class="table table-bordered">
		<thead>
			<tr>
				<th class="nowrap">
					<input name="checkbox_all" id="checkbox_all" type="checkbox" />
				</th>
				<th class="nowrap">
					<?php echo JText::_('COM_TDSMANAGER_PERIODE_DECLARATION'); ?>
				</th>
				<th>
					<?php echo JText::_('COM_TDSMANAGER_NOM_HEBERGEMENT'); ?>
				</th>
				<th>
					<?php echo JText::_('COM_TDSMANAGER_NB_PERSONNES_PAR_NUITE'); ?>
				</th>
				<th>
					<?php echo JText::_('COM_TDSMANAGER_TOTAL_TAXE_PERCUE'); ?>
				</th>
				<th>
					<?php echo JText::_('COM_TDSMANAGER_DATE_DECLARATION'); ?>
				</th>
				<!-- <th>
					<?php //echo JText::_('COM_TDSMANAGER_PAIEMENT_OK'); ?>
				</th>-->
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
                <?php if ($item->trimestre=='premier_trim') {
                   echo 'Premier trimestre ('.ucfirst($item->mois).')';
                } else if ($item->trimestre=='second_trim') {
                   echo 'Deuxiéme trimestre ('.ucfirst($item->mois).')';
                } else if ($item->trimestre=='troisieme_trim') {
                   echo 'Troisiéme trimestre ('.ucfirst($item->mois).')';
                } else if ($item->trimestre=='quatrieme_trim') {
                   echo 'Quatriéme trimestre ('.ucfirst($item->mois).')';
                } ?>
    				</td>
            <td class="center">
    					<?php echo $item->hostingname;?>
    				</td>
    				<td class="center">
    					<?php echo $item->nb_personnes_par_nuite; ?>
    				</td>
    				<td class="center">
    					<?php echo $item->total_declare;?> €
    				</td>
    				<td class="center">
    					<?php echo $item->date_declaration; ?>
    				</td>
    				<!-- <td class="order">
    					<?php //echo $item->paiement_ok ? JText::_('COM_TDSMANAGER_DECLARATION_PAID') : JText::_('COM_TDSMANAGER_DECLARATION_NO_PAID'); ?>
    				</td>-->
    			</tr>
  			<?php endforeach;
        }
         ?>
  		</tbody>
  	</table>
    <a href="<?php echo JRoute::_('index.php?option=com_tdsmanager&view=declarations&task=edit'); ?>" class="btn btn-primary"><?php echo JText::_('COM_TDSMANAGER_CREATE_NEW_DECLARATION') ?></a>
    <!--<input type="button" id="sup_declaration" value="<?php //echo JText::_('COM_TDSMANAGER_DECLARATION_DELETE_DECLARATION') ?>" />  -->
    <!--<button class="btn btn-primary" type="button"><?php //echo JText::_('COM_TDSMANAGER_CREATE_PAIEMENT_DECLARATION') ?></button>-->
    <input type="hidden" name="task" value="recap" />
    <?php echo JHtml::_('form.token'); ?>
  </form>
</div>
<?php echo $this->_getViewFile('common', 'footer'); ?>