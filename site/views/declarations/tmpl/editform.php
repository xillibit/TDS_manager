<?php
 /**
 * @package		Joomla.Site
 * @subpackage	com_tdsmanager
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport( 'joomla.html.html' );
?>
<form id="form_declaration" class="form-horizontal" action="<?php echo JRoute::_('index.php?option=com_tdsmanager&view=declarations&task=save'); ?>" method="post">
	<fieldset>
		<legend><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_NEW_DECLARATION'); ?></legend>
		<!-- Button to trigger modal -->
		<a href="#modal_obligations" role="button" class="btn btn-primary" data-toggle="modal"><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_DECLARATION_HOSTER') ?></a>

		<!-- Modal -->
		<div id="modal_obligations" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModalLabel"><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_DECLARATION_OBLIGATION_HOSTER') ?></h3>
			</div>
			<div class="modal-body">
				<b>Comment et quand reverser la taxe de séjour ?</b>
				<p>
					Vous devez transmettre  à la Communauté de Communes, <b>chaque trimestre</b>:
					<ul>
						<li>1er trimestre <?php echo date('Y') ?> - entre le 01/04 et le 10/04</li>
						<li>2éme trimestre entre le 01/07 et le 10/07</li>
						<li>3éme trimestre entre le 01/10 et le 10/10</li>
						<li>4éme trimestre entre le 01/01 et le 10/01/<?php echo date('Y')+1 ?></li>
					</ul>
					<u>uniquement la déclaration trimestrielle de taxe de séjour.</u>
					<u>Vous serez sollicité par la Trésorerie de Faverges pour le réglement de la taxe</u>
				</p>
				<b>Quelles sanctions pour retard ou absence de reversement ?</b>
				<p>
					Conformément aux articles R.2333-56 et R.2333-69 du CGCT, tout retard dans le versement du produit de la taxe donne lieu à l'application d'un intérêt de retard égal à 0.75% par mois de retard.<br />
					En cas de non paiement les poursuites sont effectuées selon les modalités prévues en matiére de contributions directes.
				</p>
				<b>Quelles sont les obligations de l'hébergeur ?</b>
				<p>
					Vous avez l'obligation d'afficher les tarifs de la taxe de séjour et de la faire figurer sur la facture émise au client, distinctement de vos propres prestations. La taxe de séjour au réel n'est pas assujettie
					à la TVA.<br /><br />
					Conformément à l'article L.2333-37 du CGCT, vous avez l'obligation de percevoir la taxe de séjour et la verser aux dates prévues par délibération  <br />
					Conformément à l'article R.2333-50 du CGCT, vous devez tenir un état, désigné par le terme "registre du logeur" précisant obligatoirement:
					<ul>
						<li>le nombre de personnes assujetties</li>
						<li>la durée du séjour,</li>
						<li>le cas échéant le nombre de personnes exonérées et les motifs d'éxonération</li>
						<li>la somme de taxe de séjour récoltée</li>
					</ul>
					<br />
					Le registre du logeur ne doit contenir aucune information relative à l'état civil des personnes assujetties à la taxe de séjour.  <br />
					Les logeurs professionnels ou occasionnels sont tenus de faire une déclaration à la mairie faisant état de la location dans les 15 jours qui suivent le début de celle-ci (article R.2333-51 du CGCT)<br /><br />
					</p>
					<b>VOIES DE RECOURS</b>
					<p>
						En application des articles R.2333-57 et R.2333-67 du CGCT le client redevable de la taxe de séjour, qui conteste le montant de la taxe, doit l'acquitter. Il peut au préalable saisir d'un réclamation le Président de la CCPF
						afin qu'il statue sur sa demande de remboursement, soit saisir directement d'un réclamation le Tribunal d'instance compétent.
					</p>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Fermer</button>
			</div>
		</div>
		<br /><br />
		<div id="alert_dec_div" class="alert" style="display:none;">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<span id="alert_dec_title" style="font-weight: bold;"></span>
			<div id="alert_dec_content"></div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputHebergement"><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_CHOOSE_OUR_HEBERGEMENT') ?> :</label>
			<div class="controls">
				<?php echo $this->userhostings ?>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputTrimestre"><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_CHOOSE_QUARTER') ?> :</label>
			<div class="controls">
				<select name="choix_trimestre" id="choix_trimestre">
					<option value="choix">Veuillez choisir un trimestre</option>
					<option value="premier_trim"><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_FIRST_QUARTER') ?></option>
					<option value="second_trim"><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_SECOND_QUARTER') ?></option>
					<option value="troisieme_trim"><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_THIRD_QUARTER') ?></option>
					<option value="quatrieme_trim"><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_FOURTH_QUARTER') ?></option>
				</select>
			</div>
		</div>		
		<div class="control-group">
			<label class="control-label" for="inputMois"><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_CHOOSE_MONTH') ?> :</label>
			<div class="controls">
				<select name="premier_trim" id="premier_trim" style="display: none;">
					<option value="janvier"><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_MONTH_JANUARY') ?></option>
					<option value="fevrier"><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_MONTH_FEBRUARY') ?></option>
					<option value="mars"><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_MONTH_MARCH') ?></option>
				</select>
				<select name="second_trim" id="second_trim" style="display: none;">
					<option value="avril"><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_MONTH_APRIL') ?></option>
					<option value="mai"><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_MONTH_MAY') ?></option>
					<option value="juin"><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_MONTH_JUNE') ?></option>
				</select>
				<select name="troisieme_trim" id="troisieme_trim" style="display: none;">
					<option value="juillet"><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_MONTH_JULY') ?></option>
					<option value="aout"><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_MONTH_AUGUST') ?></option>
					<option value="septembre"><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_MONTH_SEPTEMBER') ?></option>
				</select>
				<select name="quatrieme_trim" id="quatrieme_trim" style="display: none;">
					<option value="octobre"><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_MONTH_OCTOBER') ?></option>
					<option value="novembre"><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_MONTH_NOVEMBER') ?></option>
					<option value="decembre"><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_MONTH_DECEMBER') ?></option>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputTrimestre"><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_YEAR_CONCERNED') ?> :</label>
			<div class="controls">
				<input type="text" readonly="readonly" class="input-xlarge" value="<?php echo date('Y') ?>" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputEmail"><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_TARIF_PAR_NUITEES') ?> :</label>
			<div class="controls">
				<input type="text" class="input-xlarge" id="tarif_par_nuitees" readonly="readonly" name="tarif_par_nuitees" placeholder="Choisir l'hébergement concerné" value="" /> €
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputEmail"><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_NB_PERSONNES_ASSUJETTIES') ?> :</label>
			<div class="controls">
				<input type="text" class="input-xlarge" id="nb_personnes_assujetties" name="nb_personnes_assujetties" value="" required="required" placeholder="Entrer le nombre de personnes assuejeties" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputEmail"><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_NB_PERSONNES_EXONEREES') ?> :</label>
			<div class="controls">
				<input type="text" class="input-xlarge" name="nb_personnes_exonerees" required="required" placeholder="Entrer le nombre de personnes éxonérées" value="" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputEmail"><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_TOTAL_DECLARE') ?> :</label>
			<div class="controls">
				<input type="text" class="input-xlarge" id="total_dec" readonly="readonly" name="total_dec" value="" /> €
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputEmail">Calculer le montant total :</label>
			<div class="controls">
				<button id="calc_total_dec" class="btn btn-primary" type="button">Calculer</button>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputEmail"><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_EXACTITUDE_DOCUMENT') ?> :</label>
			<div class="controls">
				<input type="checkbox" name="exactitude_document" required="required" value="1" />
			</div>
		</div>
	</fieldset>

	<button class="btn btn-primary" type="submit"><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_VALIDER') ?></button>
	<button class="btn btn-danger" onclick="javascript:history.back()" type="button"><?php echo JText::_('COM_TDSMANAGER_DECLARATIONS_ANNULER') ?></button>

	<?php echo JHtml::_('form.token'); ?>
</form>