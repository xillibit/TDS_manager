<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;
?>
<div style="text-align: right;font-weight: bold;color:#0088CC;font-size: 18px;padding-bottom: 10px;">Résultat de votre recherche</div>
<span><?php echo $this->search_query; ?></span>
<?php foreach($this->results_dispo as $dispo): ?>
<table style="border-bottom: 1px solid #0088CC;width: 770px;border-bottom-width: medium;">
  <tbody>
    <tr>
      <td style="background-color: #006DCC;width: <?php echo strlen($dispo->hostingname)*9 ?>px;padding: 4px 30px 4px 15px;color: #FFFFFF;font-size: 14px;
    font-weight: bold;
    text-transform: uppercase;" valign="middle" align="left"><?php echo $dispo->hostingname ?></td>
      <!-- Faire une fonction pour récupérer l'image correspondante an classement -->
      <td style="background-color:#0088CC;"><!-- Classement hébergeur --></td>
      <td><!-- Plus détails --><a style="font-size: 14px;font-weight: bold;" href="#">+ d'infos</a></td>
    </tr>
  </tbody>
</table>
<table>
  <tr>
    <td><!-- Image hébergement --></td>
    <td style="padding: 5px;border-right: 1px solid #0088CC; border-right-width: medium;">
    	<ul style="list-style-type: none;">
    		<li style="font-size: 14px;font-weight: bold;"><?php echo $dispo->hosting_type_name; ?></li>
    		<li><?php echo $dispo->adress; ?></li>
    		<li><?php echo $dispo->complement_adress; ?></li><li><?php echo $dispo->postalcode.' '.$dispo->city; ?></li>
    	</ul>
    </td>
    <td style="padding: 5px;border-right: 1px solid #0088CC; border-right-width: medium;"><span><?php echo $dispo->description ?></span></td>
    <td style="padding: 5px;"><!-- Prix, localisation --><a href="#">Localiser</a></td>
  </tr>
</table>
<?php endforeach; ?>