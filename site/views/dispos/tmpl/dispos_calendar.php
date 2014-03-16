<?php
 /**
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$date = new JDate('now');
JHTML::_('behavior.calendar');

$startdate = isset($this->dispo->startdate) ? $this->dispo->startdate : $date->toSql();
$enddate = isset($this->dispo->enddate) ? $this->dispo->enddate : $date->toSql();
?>
<div>
<h2>Entrez les réservations :</h2>
<br />
<form method="post" action="<?php echo JRoute::_('index.php?option=com_gesttaxesejour&view=dispos&task=savedispos'); ?>">
  Nombre de chambres disponibles (pour un gite entrez le nombre d'espace de logement disponibles) : 
  <br />
  <?php echo $this->dropdown ?>
  <br />
  Entrez la période :
  <br />
  Du <?php echo JHtml::calendar($startdate, 'startDate', 'startDate','%Y-%m-%d'); ?> au <?php echo JHtml::calendar($enddate, 'endDate', 'endDate','%Y-%m-%d'); ?>
  <br />
  <?php if (isset($this->dispo)): ?>  
    <input type="hidden" name="id_dispos" value="<?php echo $this->dispo->id ?>">
    <input type="hidden" name="updatedispos" value="1">
  <?php endif; ?>
  <br />
  <!-- Choix des chambres dispos, ajouter chambre simple ou double 
  Nombre de chambres disponibles simple :
  <input type="text" name="chambres_dispos_simple" value="" />
  <br />
  Nombre de chambres disponibles double :
  <input type="text" name="chambres_dispos_double" value="" />-->
  <input class="button btn btn-primary" type="submit" name="valid_hosting" value="Valider">
</form>
</div>