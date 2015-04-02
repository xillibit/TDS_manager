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
		<?php echo JText::_('COM_TDSMANAGER_CONTROL_PANEL_TAXE_SEJOUR') ?>
	</h1>
	<!-- Afficher une alerte quand l'utilisateur n'a pas payé -->
	<div>
		<?php if ( $this->myprofile ){ ?><span>Bonjour <b><?php echo $this->myprofile->lastname.' '.$this->myprofile->name ?></b>,</span>
		<?php } else {  ?>
		<span>Votre profil n'a pas encore été créé</span>
		<?php } ?>
	</div>

	<!-- Afficher des onglets avec les dernières déclarations, derniers réglements -->
	<ul class="nav nav-tabs" style="list-style: none;">
		<li class="active"><a data-toggle="tab" href="#sectionA"><?php echo JText::_('COM_TDSMANAGER_LAST_HOSTINGS_PANEL') ?></a></li>
		<li><a data-toggle="tab" href="#sectionB"><?php echo JText::_('COM_TDSMANAGER_LAST_DECLARATIONS_PANEL') ?></a></li>
		<li><a data-toggle="tab" href="#sectionC"><?php echo JText::_('COM_TDSMANAGER_LAST_REGLEMENTS_PANEL') ?></a></li>
	</ul>

	<div class="tab-content">
		<div id="sectionA" class="tab-pane fade in active">
			<?php if ( $this->lasthostings ) {
				foreach($this->lasthostings as $hosting) { ?>
					<ul style="border-bottom: 2px solid #555555;">
						<li style="border-bottom: 1px solid #DDDDDD;"><?php echo $hosting->hostingname ?></li>
						<li style="border-bottom: 1px solid #DDDDDD;"><?php echo $hosting->adress ?></li>
						<li style="border-bottom: 1px solid #DDDDDD;"><?php echo $hosting->city ?></li>
					</ul>
			<?php }
			} else { ?>
				<p><?php echo JText::_('COM_TDSMANAGER_NO_LAST_HEBERGEMENTS'); ?></p>
			<?php } ?>
		</div>

		<div id="sectionB" class="tab-pane fade">
			<?php if ( $this->lastdeclarations ) {
			foreach($this->lastdeclarations as $dec) { ?>
				<ul style="border-bottom: 2px solid #555555;">
					<li style="border-bottom: 1px solid #DDDDDD;"><span style="font-weight:bold;"><?php echo JText::_('COM_TDSMANAGER_RESUME_MONTANT_ENCAISSE_SEJOUR') ?></span> <?php echo $dec->montant_encaisse_sejour ?> €</li>
					<li style="border-bottom: 1px solid #DDDDDD;"><span style="font-weight:bold;"><?php echo JText::_('COM_TDSMANAGER_RESUME_DATE_DECLARER') ?></span> <?php echo $dec->date_declarer ?></li>
					<li style="border-bottom: 1px solid #DDDDDD;"><span style="font-weight:bold;"><?php echo JText::_('COM_TDSMANAGER_RESUME_NB_PERSONNES_ASSUJETTIES') ?> </span><?php echo $dec->nb_personnes_assujetties ?></li>
				</ul>
			<?php }
			} else {?>
				<p><?php echo JText::_('COM_TDSMANAGER_NO_LAST_DECLARATIONS'); ?></p>
			<?php } ?>
		</div>

		<div id="sectionC" class="tab-pane fade">
			<?php if ( $this->lastreglements ) {
			foreach($this->lastreglements as $regl) { ?>
				<ul style="border-bottom: 2px solid #555555;">
					<li style="border-bottom: 1px solid #DDDDDD;"><span style="font-weight:bold;"><?php echo JText::_('COM_TDSMANAGER_RESUME_DATE_REGLER') ?></span> <?php echo $regl->date_regler ?></li>
					<li style="border-bottom: 1px solid #DDDDDD;"><span style="font-weight:bold;"><?php echo JText::_('COM_TDSMANAGER_RESUME_MONTANT') ?></span> <?php echo $regl->montant ?> €</li>
					<li style="border-bottom: 1px solid #DDDDDD;"><span style="font-weight:bold;"><?php echo JText::_('COM_TDSMANAGER_RESUME_TYPE_REGLEMENT') ?></span> <?php echo $regl->type_reglement ?></li>
				</ul>
			<?php }
			} else { ?>
				<p><?php  echo JText::_('COM_TDSMANAGER_NO_LAST_REGLEMENTS'); ?></p>
			<?php } ?>
		</div>
	</div>
</div>