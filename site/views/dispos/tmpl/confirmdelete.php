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
<h2>Confirmez la suppression des éléments suivants :</h2>
<br />
<!-- Lister les éléments à supprimer -->
<ul>
  <?php foreach($this->ids_delete_dispos as $dispo_delete) : ?>
  <li><span style="font-weight:bold;">Date de début : </span><?php echo $dispo_delete->startdate ?><span style="font-weight:bold;"> Date de fin fin : </span><?php echo $dispo_delete->enddate ?><span style="font-weight:bold;"> Hébergement : </span><?php echo $dispo_delete->description ?></li>
  <?php endforeach; ?>
</ul>
<br />
<form method="post" action="<?php echo JRoute::_('index.php?option=com_tdsmanager&view=dispos&task=delete'); ?>">
  <input class="button btn btn-primary" type="submit" name="valid_hosting" value="Valider">
  <input class="button btn" type="button" name="valid_hosting" value="Annuler">
</form>
</div>