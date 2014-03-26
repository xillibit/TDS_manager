<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_banners
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');

?>
<div id="kadmin">
  <div class="kadmin-right">
    <table class="thisform">
      <tr class="thisform">
        <td width="100%" valign="top" class="thisform">
          <div id="cpanel">
            <div class="icon-container">
              <div class="icon"> <a href="<?php echo JURI::root().'administrator/index.php?option=com_tdsmanager&view=hebergements' ?>" title="<?php echo JText::_('COM_TDSMANAGER_CONTROLPANEL_HEBERGEMENTS');?>"> <img src="<?php echo JURI::base(true); ?>/components/com_tdsmanager/media/icons/large/hebergements.png" align="middle" border="0" alt="" /> <span> <?php echo JText::_('COM_TDSMANAGER_CONTROLPANEL_HEBERGEMENTS'); ?> </span></a> </div>
            </div>
            <div class="icon-container">
            <div class="icon"> <a href="<?php echo JURI::root().'administrator/index.php?option=com_tdsmanager&view=declarations' ?>" title="<?php echo JText::_('COM_TDSMANAGER_CONTROLPANEL_DECLARATIONS');?>"> <img src="<?php echo JURI::base(true); ?>/components/com_tdsmanager/media/icons/large/icon-48-declarations.png" align="middle" border="0" alt="" /> <span> <?php echo JText::_('COM_TDSMANAGER_CONTROLPANEL_DECLARATIONS'); ?> </span></a> </div>
            </div>
            <div class="icon-container">
              <div class="icon"> <a href="<?php echo JURI::root().'administrator/index.php?option=com_tdsmanager&view=reglements' ?>" title="<?php echo JText::_('COM_TDSMANAGER_CONTROLPANEL_REGLEMENTS');?>"> <img src="<?php echo JURI::base(true); ?>/components/com_tdsmanager/media/icons/large/icon-48-reglements.png" align="middle" border="0" alt="" /> <span> <?php echo JText::_('COM_TDSMANAGER_CONTROLPANEL_REGLEMENTS'); ?> </span> </a> </div>
            </div>
            <div class="icon-container">
              <div class="icon"> <a href="<?php echo JURI::root().'administrator/index.php?option=com_tdsmanager&view=users' ?>" title="<?php echo JText::_('COM_TDSMANAGER_CONTROLPANEL_OWNERS');?>"> <img src="<?php echo JURI::base(true); ?>/components/com_tdsmanager/media/icons/large/icon-48-users.png" align="middle" border="0" alt="" /> <span> <?php echo JText::_('COM_TDSMANAGER_CONTROLPANEL_OWNERS'); ?> </span></a> </div>
            </div>
          </div>
        </td>
      </tr>
    </table>
  </div>
</div>


