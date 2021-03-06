<?php
 /**
 * @package		Joomla.Site
 * @subpackage	com_tdsmanager
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$view = JFactory::getApplication()->input->getCmd('view');
?>
<div class="navbar">
	<div class="navbar-inner">
		<a class="brand" href="#">TDSManager</a>
			<ul class="nav" style="list-style: none;">
				<?php if ($view == 'tdsmanager'): ?>
					<li class="active">
				<?php else: ?>
					<li>
				<?php endif; ?>
						<a href="<?php echo JRoute::_ ('index.php?com_tdsmanager') ?>">Gestion</a>
					</li>
				<?php if ($view == 'hebergements'): ?>
					<li class="active">
				<?php else: ?>
					<li>
				<?php endif; ?>
						<a href="<?php echo JRoute::_ ('index.php?com_tdsmanager&view=hebergements') ?>">Hébergements</a>
					</li>
				<?php if ($view == 'declarations'): ?>
					<li class="active">
				<?php else: ?>
					<li>
				<?php endif; ?>
						<a href="<?php echo JRoute::_ ('index.php?com_tdsmanager&view=declarations') ?>">Déclarations</a>
					</li>
				<?php if ($view == 'reglements'): ?>
					<li class="active">
				<?php else: ?>
					<li>
				<?php endif; ?>
						<a href="<?php echo JRoute::_ ('index.php?com_tdsmanager&view=reglements') ?>">Réglements</a>
					</li>
				<?php if ($view == 'user'): ?>
					<li class="active">
				<?php else: ?>
					<li>
				<?php endif; ?>
						<a href="<?php echo JRoute::_ ('index.php?com_tdsmanager&view=user') ?>">Profil</a>
					</li>
			</ul>
		</div>
</div>

<!--<div>
  <ul style="display: inline;">
    <li style="display: inline; list-style: none; margin : 45px;">
      <a href="<?php //echo JRoute::_ ('index.php?com_tdsmanager&view=hebergements') ?>">
        <img src="<?php //echo JURI::root().'administrator/components/com_tdsmanager/media/icons/large/hebergements.png' ?>" title="<?php //echo count($this->lasthostings) == '1' ? JText::_('COM_TDSMANAGER_CONTROL_PANEL_MANAGE_HOSTING') : JText::_('COM_TDSMANAGER_CONTROL_PANEL_MANAGE_HOSTINGS') ?>" alt="<?php //echo count($this->lasthostings) == '1' ? JText::_('COM_TDSMANAGER_CONTROL_PANEL_MANAGE_HOSTING') : JText::_('COM_TDSMANAGER_CONTROL_PANEL_MANAGE_HOSTINGS') ?>" />
      </a>
    </li>
    <li style="display: inline; list-style: none;margin: 45px;">
      <a href="<?php //echo JRoute::_ ('index.php?com_tdsmanager&view=declarations') ?>">
        <img src="<?php //echo JURI::root().'administrator/components/com_tdsmanager/media/icons/large/icon-48-declarations.png' ?>" title="<?php //echo count($this->lastdeclarations) == '1' ? JText::_('COM_TDSMANAGER_CONTROL_PANEL_MANAGE_DECLARATION') : JText::_('COM_TDSMANAGER_CONTROL_PANEL_MANAGE_DECLARATIONS') ?>" alt="<?php //echo count($this->lastdeclarations) == '1' ? JText::_('COM_TDSMANAGER_CONTROL_PANEL_MANAGE_DECLARATION') : JText::_('COM_TDSMANAGER_CONTROL_PANEL_MANAGE_DECLARATIONS') ?>" />
      </a>
    </li>
    <li style="display: inline; list-style: none;margin: 45px;">
      <a href="<?php //echo JRoute::_ ('index.php?com_tdsmanager&view=reglements') ?>">
        <img src="<?php //echo JURI::root().'administrator/components/com_tdsmanager/media/icons/large/icon-48-reglements.png' ?>" title="<?php //echo count($this->lastreglements) == '1' ? JText::_('COM_TDSMANAGER_CONTROL_PANEL_MANAGE_REGLEMENT') : JText::_('COM_TDSMANAGER_CONTROL_PANEL_MANAGE_REGLEMENTS') ?>" alt="<?php //echo count($this->lastreglements) == '1' ? JText::_('COM_TDSMANAGER_CONTROL_PANEL_MANAGE_REGLEMENT') : JText::_('COM_TDSMANAGER_CONTROL_PANEL_MANAGE_REGLEMENTS') ?>" />
      </a>
    </li>
    <li style="display: inline; list-style: none;margin: 45px">
      <a href="<?php //echo JRoute::_ ('index.php?com_tdsmanager&view=user') ?>">
        <img src="<?php //echo JURI::root().'administrator/components/com_tdsmanager/media/icons/large/icon-48-users.png' ?>" alt="<?php //echo JText::_('COM_TDSMANAGER_CONTROL_PANEL_MANAGE_PROFILE') ?>" title="<?php echo JText::_('COM_TDSMANAGER_CONTROL_PANEL_MANAGE_PROFILE') ?>" />
      </a>
    </li>
  </ul>
</div>
<div>
  <ul style="display: inline;">
    <li style="display: inline; list-style: none; margin : 25px;">
      <span><b>Hébergements</b></span>
    </li>
    <li style="display: inline; list-style: none;margin: 25px;">
      <span><b>Déclarations</b></span>
    </li>
    <li style="display: inline; list-style: none;margin: 25px;">
      <span><b>Réglements</b></span>
    </li>
    <li style="display: inline; list-style: none;margin: 45px">
      <span><b>Votre profil</b></span>
    </li>
  </ul>
</div> -->