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
	<h1>
		Connexion
	</h1>
	<form action="<?php echo JRoute::_('index.php'); ?>" method="post">
		<p id="form-login-username">
			<label for="modlgn-username"><?php echo JText::_('COM_TDSMANAGER_LOGIN_USERNAME') ?></label>
			<input id="modlgn-username" type="text" name="username" class="inputbox"  size="18" />
		</p>
		<p id="form-login-password">
			<label for="modlgn-passwd"><?php echo JText::_('COM_TDSMANAGER_LOGIN_PASSWORD') ?></label>
			<input id="modlgn-passwd" type="password" name="password" class="inputbox" size="18"  />
		</p>
		<button class="btn btn-primary" type="submit"><?php echo JText::_('COM_TDSMANAGER_LOGIN_BUTTON') ?></button>
		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="user.login" />
		<input type="hidden" name="return" value="<?php //echo $this->returnUrl; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>