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
<h2>Choisissez l'hébergement concerné pour affecter les réservations :</h2>
<br />
<form method="post" action="<?php echo JRoute::_('index.php?option=com_gesttaxesejour&view=dispos&task=dispos'); ?>">
  <?php
  echo $this->hostings_list;
  ?>
  <br />  
  <input class="button btn btn-primary" type="submit" name="valid_hosting" value="Valider">
</form>
</div>