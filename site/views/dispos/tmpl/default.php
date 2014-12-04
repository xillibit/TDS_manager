<?php
/**
 * TDS_Manager Component
 * @package		Tdsmanager.Site
 * @subpackage	Tdsmanager
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;
?>
<div>
  <h1>
	 <?php echo JText::_('COM_TDSMANAGER_DISPOS_GESTION_DISPOS') ?>
  </h1>

  <form action="<?php echo JRoute::_('index.php?option=com_tdsmanager&task=confirmdelete'); ?>" method="post" id="com_gesttaxe_dec_form">
    <table class="adminlist">
  		<thead>
  			<tr>
          <th width="5%" class="nowrap">
            <input name="checkbox_all" id="checkbox_all" type="checkbox" />
          </th>
  				<th width="10%" class="nowrap">
  					<?php echo JText::_('COM_TDSMANAGER_DATE_DEBUT'); ?>
  				</th>
          <th width="10%" class="nowrap">
  					<?php echo JText::_('COM_TDSMANAGER_DATE_FIN'); ?>
  				</th>
  				<th width="5%">
  					<?php echo JText::_('COM_TDSMANAGER_DISPOS_HEBERGEMENT'); ?>
  				</th>
  			</tr>
  		</thead>
  		<tfoot>
  		</tfoot>
  		<tbody>
  		<?php
        foreach ($this->dispos	 as $i => $dispo) : ?>
    			<tr class="row<?php echo $i % 2; ?>">
    				<td>
                <input class="check-me" name="cid[]" type="checkbox" value="<?php echo $dispo->id; ?>" />
    				</td>
            <td>
                <?php echo $dispo->startdate; ?>
    				</td>
    				<td class="center">
    					<?php echo $dispo->enddate; ?>
    				</td>
    				<td class="center">
    					<a href="<?php echo JRoute::_('index.php?option=com_tdsmanager&&view=dispos&task=edit_dispos&id='.$dispo->id);?>"><?php echo $dispo->description; ?></a>
    				</td>
    			</tr>
  			<?php endforeach;
         ?>
  		</tbody>
  	</table>
    <a href="<?php echo JRoute::_('index.php?option=com_tdsmanager&view=dispos&task=ch_dispos'); ?>"><input type="button" value="<?php echo JText::_('COM_TDSMANAGER_CREATE_NEW_DISPOS') ?>" /></a>
    <a href="<?php echo JRoute::_('index.php?option=com_tdsmanager&view=dispos&task=delete'); ?>"><input type="submit" value="<?php echo JText::_('COM_TDSMANAGER_DISPOS_DELETE') ?>" /></a>
    <?php echo JHtml::_('form.token'); ?>
  </form>
</div>