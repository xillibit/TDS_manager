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
  <ul style="display: inline;">
    <li style="display: inline; list-style: none; margin : 45px;">
      <a href="<?php echo JRoute::_ ('index.php?com_tdsmanager&view=hebergements') ?>">
        <img src="<?php echo JURI::root().'administrator/components/com_tdsmanager/media/icons/large/hebergements.png' ?>" title="<?php echo count($this->lasthostings) == '1' ? JText::_('COM_GESTTAXESEJOUR_CONTROL_PANEL_MANAGE_HOSTING') : JText::_('COM_GESTTAXESEJOUR_CONTROL_PANEL_MANAGE_HOSTINGS') ?>" alt="<?php echo count($this->lasthostings) == '1' ? JText::_('COM_GESTTAXESEJOUR_CONTROL_PANEL_MANAGE_HOSTING') : JText::_('COM_GESTTAXESEJOUR_CONTROL_PANEL_MANAGE_HOSTINGS') ?>" />
      </a>
    </li>
    <li style="display: inline; list-style: none;margin: 45px;">
      <a href="<?php echo JRoute::_ ('index.php?com_tdsmanager&view=declarations') ?>">
        <img src="<?php echo JURI::root().'administrator/components/com_tdsmanager/media/icons/large/declarations.png' ?>" title="<?php echo count($this->lastdeclarations) == '1' ? JText::_('COM_GESTTAXESEJOUR_CONTROL_PANEL_MANAGE_DECLARATION') : JText::_('COM_GESTTAXESEJOUR_CONTROL_PANEL_MANAGE_DECLARATIONS') ?>" alt="<?php echo count($this->lastdeclarations) == '1' ? JText::_('COM_GESTTAXESEJOUR_CONTROL_PANEL_MANAGE_DECLARATION') : JText::_('COM_GESTTAXESEJOUR_CONTROL_PANEL_MANAGE_DECLARATIONS') ?>" />
      </a>
    </li>
    <li style="display: inline; list-style: none;margin: 45px;">
      <a href="<?php echo JRoute::_ ('index.php?com_tdsmanager&view=reglements') ?>">
        <img src="<?php echo JURI::root().'administrator/components/com_tdsmanager/media/icons/large/reglements.png' ?>" title="<?php echo count($this->lastreglements) == '1' ? JText::_('COM_GESTTAXESEJOUR_CONTROL_PANEL_MANAGE_REGLEMENT') : JText::_('COM_GESTTAXESEJOUR_CONTROL_PANEL_MANAGE_REGLEMENTS') ?>" alt="<?php echo count($this->lastreglements) == '1' ? JText::_('COM_GESTTAXESEJOUR_CONTROL_PANEL_MANAGE_REGLEMENT') : JText::_('COM_GESTTAXESEJOUR_CONTROL_PANEL_MANAGE_REGLEMENTS') ?>" />
      </a>
    </li>
    <li style="display: inline; list-style: none;margin: 45px">
      <a href="<?php echo JRoute::_ ('index.php?com_tdsmanager&view=user') ?>">
        <img src="<?php echo JURI::root().'administrator/components/com_tdsmanager/media/icons/large/users.png' ?>" alt="<?php echo JText::_('COM_GESTTAXESEJOUR_CONTROL_PANEL_MANAGE_PROFILE') ?>" title="<?php echo JText::_('COM_GESTTAXESEJOUR_CONTROL_PANEL_MANAGE_PROFILE') ?>" />
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
</div>