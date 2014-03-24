<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_gesttaxesejour
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');

$listOrder =	$this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
?>
<form action="<?php echo JRoute::_('index.php?option=com_tdsmanager&view=statistics');?>" method="post" name="adminForm" id="adminForm">
<fieldset id="filter-bar">
		<div class="filter-select fltrt">
				<?php echo $this->mois_list;?>

        <?php echo $this->trimestres_list;?>

				<?php echo $this->annees_list;?>
		</div>
	</fieldset>
	<div class="clr"> </div>

<div id="kadmin">
  <div class="kadmin-right">
    <div style=""><h2><?php echo JText::_('COM_GESTTAXESEJOUR_STATS_GEN_STATS');?></h2></div>
    <div class="kadmin-statscover">
      <!-- BEGIN: STATS -->
      <div class="kadmin-statscover">
        <div style="border-bottom: 1px solid #D5D5D5;">
        <h4><?php echo JText::_('COM_GESTTAXESEJOUR_STATS_TAUX_OCCUPATION_PAR_COMMUNES') ?></h4>
        <table class="kadmin-stat">
        <col class="col1" style="width:1%;" />
        <col class="col2" />
        <col class="col2" style="width:40%;" />
        <col class="col2" style="width:10%;" />
        <tbody>
        <tr>
        <th style="color:#146295;">#</th>
        <th><?php echo JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_NOM_COMMUNE') ?></th>
        <th><?php echo JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_TAUX_OCCUPATION') ?></th>
        <th><?php echo JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_TAUX_OCCUPATION_POURCENTAGE') ?></th>
        </tr>
        <?php foreach ($this->tauxoccupationstatscommunes as $id=>$item) : ?>
        <tr>
        <td><b><span style="color:#146295;"><?php echo $id+1 ?></span></b></td>
        <td style="text-align: center;">
        <?php echo $item->city ?>
        </td>
        <td style="text-align: center;">
        <img class="kstats-bar" src="<?php echo JURI::root().'administrator/components/com_gesttaxesejour/media/icons/bar.png' ?>" alt="" height="15" width="<?php echo ($item->pers_occup_total/$item->personnes_dispo_total)*100 ?>%" />
        </td>
        <td style="text-align: center;">
        <?php echo ($item->pers_occup_total/$item->personnes_dispo_total)*100 ?>
        </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
        </div>
        <div style="border-bottom: 1px solid #D5D5D5;">
        <h4><?php echo JText::_('COM_GESTTAXESEJOUR_STATS_TAUX_OCCUPATION_PAR_TYPE_HEBERGEMENT_TYPE') ?></h4>
        <table class="kadmin-stat">
        <col class="col1" style="width:1%;" />
        <col class="col2" />
        <col class="col2" style="width:40%;" />
        <col class="col2" style="width:10%;" />
        <tbody>
        <tr>
        <th style="color:#146295;">#</th>
        <th><?php echo JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_HEBERGEMENT_TYPE') ?></th>
        <th><?php echo JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_TAUX_OCCUPATION') ?></th>
        <th><?php echo JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_TAUX_OCCUPATION_POURCENTAGE') ?></th>
        <th><?php echo JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_TOTAL_CAPACITE_CHAMBRES') ?></th>
        <th><?php echo JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_TOTAL_CAPACITE_PERSONNES') ?></th>
        </tr>
        <?php foreach ($this->tauxoccupationstatshebertype as $id=>$item) : ?>
        <tr>
        <td><b><span style="color:#146295;"><?php echo $id+1 ?></span></b></td>
        <td style="text-align: center;">
        <?php echo $item->hosting_type_name ?>
        </td>
        <td style="text-align: center;">
        <img class="kstats-bar" src="<?php echo JURI::root().'administrator/components/com_gesttaxesejour/media/icons/bar.png' ?>" alt="" height="15" width="<?php echo ($item->pers_occup_total/$item->personnes_dispo_total)*100 ?>">
        </td>
        <td style="text-align: center;">
        <?php echo ($item->pers_occup_total/$item->personnes_dispo_total)*100 ?>
        </td>
        <td style="text-align: center;">
        <?php echo $item->pers_occup_total ?>
        </td>
        <td style="text-align: center;">
        <?php echo $item->personnes_dispo_total ?>
        </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
         </div>
         <div style="border-bottom: 1px solid #D5D5D5;">
         <h4><?php echo JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_PAR_COMMUNES') ?></h4>
        <table class="kadmin-stat">
        <col class="col1" style="width:1%;" />
        <col class="col2" />
        <col class="col2" style="width:40%;" />
        <col class="col2" style="width:10%;" />
        <tbody>
        <tr>
        <th style="color:#146295;">#</th>
        <th><?php echo JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_NOM_COMMUNE') ?></th>
        <th><?php echo JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_DUREE_SEJOUR') ?></th>
        <th><?php echo JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_NB_PERSONNES_ASSUJETTIES') ?></th>
        <th><?php echo JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_MONTANT_ENCAISSE_PAR_SEJOUR') ?></th>
        </tr>
        <?php foreach ($this->taxesejourstats as $id=>$item) : ?>
        <tr>
        <td><b><span style="color:#146295;"><?php echo $id+1 ?></span></b></td>
        <td style="text-align: center;">
        <?php echo $item->city ?>
        </td>
        <td style="text-align: center;">
        <?php echo $item->duree_sejour_total ?>
        </td>
        <td style="text-align: center;">
        <?php echo $item->nb_pers_assujetties_total ?>
        </td>
        <td style="text-align: center;">
        <?php echo $item->montant_enc_sejour_total ?>
        </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
        </div>
        <div>
         <h4><?php echo JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_GLOBAL') ?></h4>
        <table class="kadmin-stat">
        <col class="col1" style="width:1%;" />
        <col class="col2" />
        <col class="col2" style="width:40%;" />
        <col class="col2" style="width:10%;" />
        <tbody>
        <tr>
        <th style="color:#146295;">#</th>
        <th><?php echo JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_DUREE_SEJOUR') ?></th>

        <th><?php echo JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_NB_PERSONNES_ASSUJETTIES') ?></th>

        <th><?php echo JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_MONTANT_ENCAISSE_PAR_SEJOUR') ?></th>
        </tr>
        <?php foreach ($this->taxesejourstats as $id=>$item) : ?>
        <tr>
        <td><b><span style="color:#146295;"><?php echo $id+1 ?></span></b></td>
        <td style="text-align: center;">
        <?php echo $item->duree_sejour_total ?>
        </td>
        <td style="text-align: center;">
        <?php echo $item->nb_pers_assujetties_total ?>
        </td>
        <td style="text-align: center;">
        <?php echo $item->montant_enc_sejour_total ?>
        </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
        </div>
        <!-- FINISH: STATS -->
      </div>
    </div>
  </div>
</div>

<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="1" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>