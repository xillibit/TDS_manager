<?php
 /**
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport( 'joomla.html.html' );
jimport( 'joomla.utilities.date' );
$date_now = JFactory::getDate('now')->toFormat('%d-%m-%Y');
$tarifs = $this->app->getUserState('com_tdsmanager.tarifs');
?>
<div>
  <h1>
	 <?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_NEW_DECLARATION'); ?>
  </h1>
  <form action="<?php echo JRoute::_('index.php?option=com_tdsmanager&view=declarations&task=save'); ?>" method="post">
    <ul style="list-style-type:none;">
      <li><span><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_CHOOSE_DECLARATION_PEDIOD') ?><br /></span><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_DATE_DEBUT') ?> : <?php echo JHTML::calendar($date_now,'start_date', 'start_date', '%d-%m-%Y') ?> <?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_DATE_FIN') ?> : <?php echo JHTML::calendar($date_now,'end_date', 'end_date', '%d-%m-%Y') ?> </li>
      <br />
      <!-- Afficher par défaut une ligne pour entrer un nouveau séjour, afficher un bouton pour entrer ou supprimer un séjour -->

      <li>
        <div id="com_gesttaxesejour-sejour1">
          <span>
            <b><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_SEJOUR') ?></b>
          </span>
          <br />
          <ul>
            <li><span><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_NB_PERSONNES_EXONEREES') ?></span>
            <input type="text" name="nb_personnes_exonerees" value="" /></li>
            <li><span><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_NB_PERSONNES_REDUCTION') ?></span>
            <input type="text" name="nb_personnes_reduction" value="" /></li>
            <li><span><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_NB_PERSONNES_ASSUJETTIES') ?></span>
            <input type="text" id="nb_personnes_assujetties" name="nb_personnes_assujetties" value="" /></li>
            <li><span><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_NB_PERSONNES_DUREE_SEJOUR_NUITEE') ?></span>
            <input type="text" id="duree_sejour_nuitee" readonly="readonly" name="duree_sejour_nuitee" value="" /></li>
            <li><span><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_NB_PERSONNES_NB_TOTAL_NUITEES') ?></span>
            <input type="text" id="nuitees" readonly="readonly" name="nb_total_nuitees" value="" /></li>
            <li><span><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_TARIF_PAR_NUITEES') ?></span>
            <input type="text" readonly="readonly" name="tarif_par_nuitees" value="<?php echo $tarifs->tarif ?>" />€ </li>
            <li><span><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_MONTANT_ENCAISSE_SEJOUR') ?></span>
            <input id="montant_encaisse_sejour" type="text" name="montant_encaisse_sejour" readonly="readonly" value="" />€</li>
          </ul>
          </div>
      </li>
      <!--<li> Afficher deux boutons pour avoir deux calendriers pour entrer le début et la fin de la période <img src="<?php //echo JURI::root()."administrator/templates/bluestork/images/menu/icon-16-cpanel.png" ?>" id="decl_add_item" alt="Ajouter une ligne" title="Ajouter une ligne" /><img src="<?php //echo JURI::root()."administrator/templates/bluestork/images/menu/icon-16-delete.png" ?>" id="decl_remove_item" alt="Supprimer une ligne" title="Supprimer une ligne" /></li>-->
      <li><input id="declaration_calcul" type="button" value="Calculer"> </li>

      <li><span><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_OK') ?></span>: <input type="checkbox" name="exactitude_document" value="1" /> </li>

      <input type="button" onclick="javascript:history.back()" value="<?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_ANNULER') ?>">
      <input type="submit" value="<?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_VALIDER') ?>">
    </ul>
    <?php echo JHtml::_('form.token'); ?>
  </form>
</div>