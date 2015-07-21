<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_tdsmanager
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

/*$document = JFactory::getDocument();
$document->addScript( JURI::root().'components/com_tdsmanager/js/default.js' ); */

echo $this->_getViewFile('common', 'menu');
?>
<div>
	<h1>
		<?php echo JText::_('COM_TDSMANAGER_HEBERGEMENTS_GESTION_HOSTINGS'); ?>
	</h1>
	<?php if ( empty($this->hebergements) ) { ?>
		<span><?php echo 'Vous n\'avez aucun hébergement d\'enregistré'; ?></span>
		<br />
		<form action="<?php echo JRoute::_('index.php?option=com_tdsmanager&view=hebergements&task=create'); ?>" method="post">
			<button class="btn btn-primary" type="submit">Ajouter un nouvel hébergement</button>
		</form>
	<?php } else {    ?>
		<form id="taxe-hebergements" name="taxehebergements" action="<?php echo JRoute::_('index.php?option=com_tdsmanager&view=hebergements'); ?>" method="post">
			<table class="table table-bordered">
		<thead>
			<tr>
				<th>
					<input type="checkbox" name="checkall-toggle" title="<?php echo JText::_('COM_TDSMANAGER_CHECK_ALL'); ?>" onclick="" />
				</th>
				<th class="nowrap">
					<?php echo JHtml::_('grid.sort', 'COM_TDSMANAGER_NAME_HOSTING', 'name_hosting'); ?>
				</th>
        <th class="nowrap">
					<?php echo JHtml::_('grid.sort',  'COM_TDSMANAGER_DESCRIPTION', 'description'); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_TDSMANAGER_ADDRESS', 'adress'); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_TDSMANAGER_COMPLEMENT_ADDRESS', 'complement_adress'); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_TDSMANAGER_POSTALCODE', 'postalcode'); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_TDSMANAGER_VILLE', 'ville'); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_TDSMANAGER_CLASSEMENT', 'classement'); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort',  'COM_TDSMANAGER_DATE_CLASSEMENT', 'date_classement'); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_TDSMANAGER_NUMERO_CLASSEMENT', 'numero_classement'); ?>
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
  					<input id="cb<?php echo intval($i) ?>" type="checkbox" title="<?php echo JText::_('COM_TDSMANAGER_SELECT') ?>" onclick="" value="<?php echo intval($item->id) ?>" name="cid[]" />
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
  					<?php echo $item->classement_name==0 ? JText::_('COM_TDSMANAGER_NO_CLASSEMENT_DEFINED') : 'classed';?>
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
	
	<!-- <a class="btn btn-primary" href="<?php //echo JRoute::_('index.php?option=com_tdsmanager&view=hebergements&task=create'); ?>" onclick="" >
		<?php //echo JText::_('COM_TDSMANAGER_HEBERGEMENT_NEW') ?>
	</a>
	<button class="btn btn-primary" id="taxehebergementedit" type="button"><?php //echo JText::_('COM_TDSMANAGER_HEBERGEMENT_EDIT') ?></button>
	<button class="btn btn-danger" id="taxehebergementdelete" type="button"><?php //echo JText::_('COM_TDSMANAGER_HEBERGEMENT_DELETE') ?></button>
	<a class="btn btn-primary" href="<?php //echo JRoute::_('index.php?option=com_tdsmanager&view=hebergements&task=periode_ouverture'); ?>" onclick="" ><?php //echo JText::_('COM_TDSMANAGER_HEBERGEMENTS_PERIODE_OUVERTURE') ?></a>-->
	<?php echo JHtml::_('form.token'); ?>
  <div>
    <?php //echo $this->getPagination(7) ?>
  </div>
	</form>
	<?php } ?>
</div>