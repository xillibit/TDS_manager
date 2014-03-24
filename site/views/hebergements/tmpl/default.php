<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

/*$document = JFactory::getDocument();
$document->addScript( JURI::root().'components/com_gesttaxesejour/js/default.js' ); */

//echo $this->_getViewFile('common', 'menu');
?>
<div>
  <h1>
	 <?php echo JText::_('COM_GESTTAXESEJOUR_HEBERGEMENTS_GESTION_HOSTINGS'); ?>
  </h1>
  <?php if ( empty($this->hebergements) ) { ?>
      <span><?php echo 'Aucun Hébergement enregistré'; ?></span>
      <br />
      <form action="<?php echo JRoute::_('index.php?option=com_gesttaxesejour&view=hebergements&task=create'); ?>" method="post">
        <input type="submit" value="Enregister un nouvel hébergement">         
      </form>
  <?php } else {    ?>
  <form id="taxe-hebergements" name="taxehebergements" action="<?php echo JRoute::_('index.php?option=com_gesttaxesejour&view=hebergements'); ?>" method="post">
  <table class="adminlist">
		<thead>
			<tr>
				<th width="1%">
					<input type="checkbox" name="checkall-toggle" title="<?php echo JText::_('COM_GESTTAXESEJOUR_CHECK_ALL'); ?>" onclick="" />
				</th>
				<th width="10%" class="nowrap">
					<?php echo JHtml::_('grid.sort', 'COM_GESTTAXESEJOUR_NAME_HOSTING', 'name_hosting'); ?>
				</th>
        <th width="10%" class="nowrap">
					<?php echo JHtml::_('grid.sort',  'COM_GESTTAXESEJOUR_DESCRIPTION', 'description'); ?>
				</th>				
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'COM_GESTTAXESEJOUR_ADDRESS', 'adress'); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'COM_GESTTAXESEJOUR_COMPLEMENT_ADDRESS', 'complement_adress'); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'COM_GESTTAXESEJOUR_POSTALCODE', 'postalcode'); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'COM_GESTTAXESEJOUR_VILLE', 'ville'); ?>
				</th>				
				<th width="10%">
					<?php echo JHtml::_('grid.sort', 'COM_GESTTAXESEJOUR_CLASSEMENT', 'classement'); ?>
				</th>
				<th width="10%">
					<?php echo JHtml::_('grid.sort',  'COM_GESTTAXESEJOUR_DATE_CLASSEMENT', 'date_classement'); ?>					
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'COM_GESTTAXESEJOUR_NUMERO_CLASSEMENT', 'numero_classement'); ?>
				</th> 												
			</tr>
		</thead>
		<tfoot>			
		</tfoot>
		<tbody>
		<?php      
      foreach ($this->hebergements	 as $i => $item) : ?>
  			<tr class="row<?php echo $i % 2; ?>">
  				<td class="center">
  					<input id="cb<?php echo intval($i) ?>" type="checkbox" title="<?php echo JText::_('COM_GESTTAXESEJOUR_SELECT') ?>" onclick="" value="<?php echo intval($item->id) ?>" name="cid[]" />
  				</td>
  				<td>
              <?php echo $item->hostingname; ?>									
  				</td>
  				<td class="center">
  					<?php echo $item->description; ?>
  				</td>   				
  				<td class="center">
  					<?php echo $item->adress; ?>
  				</td>
  				<td class="center">
  					<?php echo $item->complement_adress;?>
  				</td>
  				<td class="center">
  					<?php echo $item->postalcode; ?>
  				</td>
  				<td class="order">
  					<?php echo $item->city; ?>						
  				</td>
  				<td class="center">
  					<?php echo $item->classement_name==0 ? JText::_('COM_GESTTAXESEJOUR_NO_CLASSEMENT_DEFINED') : 'classed';?>
  				</td>
  				<td class="center">
  					<?php echo $item->date_classement; ?> 
  				</td>
  				<td>
  					<?php echo $item->numero_classement; ?>
  				</td>				
  			</tr>
			<?php endforeach;
       ?>
		</tbody>
	</table>
  <a href="<?php echo JRoute::_('index.php?option=com_gesttaxesejour&view=hebergements&task=create'); ?>" onclick="" ><input type="button" value="<?php echo JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_NEW') ?>"" /></a>
  <input type="button" id="taxehebergementedit" name="soumis" value="<?php echo JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_EDIT') ?>" />
  <input type="button" id="taxehebergementdelete" name="soumis" value="<?php echo JText::_('COM_GESTTAXESEJOUR_HEBERGEMENT_DELETE') ?>" />
  <a href="<?php echo JRoute::_('index.php?option=com_gesttaxesejour&view=hebergements&task=periode_ouverture'); ?>" onclick="" ><input type="button" value="<?php echo JText::_('COM_GESTTAXESEJOUR_HEBERGEMENTS_PERIODE_OUVERTURE') ?>" /></a>
  <?php echo JHtml::_('form.token'); ?>
  <div>
    <?php //echo $this->getPagination(7) ?>
  </div>	
	</form>
	<?php } ?>
</div>