<?php
/**
 * Kunena Component
 * @package Kunena.Framework
 *
 * @copyright (C) 2008 - 2012 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/
defined ( '_JEXEC' ) or die ();

?>
<form action="<?php echo JRoute::_('index.php?option=com_gesttaxesejour&view=user'); ?>" method="post" name="adminForm" id="adminForm">
  <ul style="list-style-type:none;">
    <li><span>Votre nom</span> <input type="text" name="" value="user_firstname" /></li>
    <li><span>Votre prénom</span> <input type="text" name="" value="user_lastname" /></li>
    <li><span>Votre adresse</span> <input type="text" name="" value="adress" /></li>
    <li><span>Complément d'adresse</span> <input type="text" name="complement_adress" value="" /></li>
    <li><span>Code postal</span> <input type="text" name="postalcode" value="" /></li>
    <li><span>Ville</span> <input type="text" name="ville" value="" /></li>
    <li><span>Téléphone</span> <input type="text" name="telephone" value="" /></li>
    <li><span>Portable</span> <input type="text" name="portable" value="" /></li>
  </ul>
  <input type="submit" value="Enregistrer" />
  <input type="hidden" name="task" value="save" />
  <?php echo JHtml::_('form.token'); ?>
</form>