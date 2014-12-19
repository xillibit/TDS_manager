<?php
 /**
 * @package		Joomla.Site
 * @subpackage	com_tdsmanager
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

?>
<div>
  <h1>
	 <?php echo JText::_('COM_TDSMANAGER_REGLEMENT_CREATE') ?>
  </h1>
  <form action="<?php echo JRoute::_('index.php?option=com_tdsmanager&view=reglements&task=save'); ?>" method="post">
    Choissisez la ou les déclarations pour lesquelles vous voulez effectuer un réglement : <?php echo $this->own_hostings ?>
    <br />
    Mode de paiement : <select name="mode_paiement"><option value="cheque">Chéque</option><option value="virement">Virement</option><option value="espéce">Espéce</option></select>
    <br />
    A régler : <?php echo $this->montantToPay ?>
    <br />
    <?php echo JHTML::_( 'form.token' ); ?>

	<button class="btn btn-primary" type="submit">Valider</button>
	<button class="btn btn-danger" onclick="javascript:history.back()" type="button">Annuler</button>
  </form>
</div>