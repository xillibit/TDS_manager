<?php
 /**
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$options = array(
    'onActive' => 'function(title, description){
        description.setStyle("display", "block");
        title.addClass("open").removeClass("closed");
    }',
    'onBackground' => 'function(title, description){
        description.setStyle("display", "none");
        title.addClass("closed").removeClass("open");
    }',
    'startOffset' => 0,  // 0 starts on the first tab, 1 starts the second, etc...
    'useCookie' => false, // this must not be a string. Don't use quotes.
);

echo $this->_getViewFile('common', 'menu');
?>
<div>
	<h1>
		<?php echo JText::_('COM_TDSMANAGER_CONTROL_PANEL_TAXE_SEJOUR') ?>
	</h1>
	<!-- Afficher une alerte quand l'utilisateur n'a pas payer -->
	<div>
		<?php if ( $this->myprofile ){ ?><span>Bonjour <b><?php echo $this->myprofile->lastname.' '.$this->myprofile->name ?></b>,</span>
		<?php } else {  ?>
		<span>Votre profil n'éxiste pas</span>
		<?php } ?>
	</div>
	<!-- Afficher des onglets avec les dernières déclarations, derniers réglements -->
	<?php
	echo JHtml::_('tabs.start', 'tab_group_id', $options);

	echo JHtml::_('tabs.panel', JText::_('COM_TDSMANAGER_LAST_HOSTINGS_PANEL'), 'panel_1_id');
	if ( $this->lasthostings ) {
		foreach($this->lasthostings as $hosting) { ?>
			<ul style="border-bottom: 2px solid #555555;">
				<li style="border-bottom: 1px solid #DDDDDD;"><?php echo $hosting->hostingname ?></li>
				<li style="border-bottom: 1px solid #DDDDDD;"><?php echo $hosting->adress ?></li>
				<li style="border-bottom: 1px solid #DDDDDD;"><?php echo $hosting->city ?></li>
			</ul>
		<?php }
	} else {
		echo 'Vous n\'avez pas d\'hébergements';
	}

	echo JHtml::_('tabs.panel', JText::_('COM_TDSMANAGER_LAST_DECLARATIONS_PANEL'), 'panel_2_id');
	if ( $this->lastdeclarations ) {
		foreach($this->lastdeclarations as $dec) { ?>
			<ul style="border-bottom: 2px solid #555555;">
				<li style="border-bottom: 1px solid #DDDDDD;"><span style="font-weight:bold;"><?php echo JText::_('COM_TDSMANAGER_RESUME_MONTANT_ENCAISSE_SEJOUR') ?></span> <?php echo $dec->montant_encaisse_sejour ?> €</li>
				<li style="border-bottom: 1px solid #DDDDDD;"><span style="font-weight:bold;"><?php echo JText::_('COM_TDSMANAGER_RESUME_DATE_DECLARER') ?></span> <?php echo $dec->date_declarer ?></li>
				<li style="border-bottom: 1px solid #DDDDDD;"><span style="font-weight:bold;"><?php echo JText::_('COM_TDSMANAGER_RESUME_NB_PERSONNES_ASSUJETTIES') ?> </span><?php echo $dec->nb_personnes_assujetties ?></li>
			</ul>
		<?php }
	} else {
		echo 'Vous n\'avez pas de déclarations';
	}

	echo JHtml::_('tabs.panel', JText::_('COM_TDSMANAGER_LAST_REGLEMENTS_PANEL'), 'panel_3_id');
	if ( $this->lastreglements ) {
		foreach($this->lastreglements as $regl) { ?>
			<ul style="border-bottom: 2px solid #555555;">
				<li style="border-bottom: 1px solid #DDDDDD;"><span style="font-weight:bold;"><?php echo JText::_('COM_TDSMANAGER_RESUME_DATE_REGLER') ?></span> <?php echo $regl->date_regler ?></li>
				<li style="border-bottom: 1px solid #DDDDDD;"><span style="font-weight:bold;"><?php echo JText::_('COM_TDSMANAGER_RESUME_MONTANT') ?></span> <?php echo $regl->montant ?> €</li>
				<li style="border-bottom: 1px solid #DDDDDD;"><span style="font-weight:bold;"><?php echo JText::_('COM_TDSMANAGER_RESUME_TYPE_REGLEMENT') ?></span> <?php echo $regl->type_reglement ?></li>
			</ul>
		<?php }
	} else {
		echo 'Vous n\'avez pas de réglements';
	}

	echo JHtml::_('tabs.end');
?>
</div>