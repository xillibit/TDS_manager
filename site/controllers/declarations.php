<?php
/**
 * @package		Tdsmanager.Site
 * @subpackage	Tdsmanager
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

class TdsmanagerControllerDeclarations extends JControllerLegacy {
	/**
	 * On enregistre la déclaration avec les données fournies par l'hébergeur
	 *
	 * @return boolean
	 */
	public function save() {
		$app	= JFactory::getApplication();
		$user = JFactory::getUser();

		// Check for request forgeries.
		if (!JSession::checkToken()) {
			$app->enqueueMessage(JText::_('COM_TDSMANAGER_TOKEN'), 'error');
			$app->redirect($this->baseurl);
		}

		// TODO: vérifier que le bon fuseau horaire est appliqué
		$userTz = JFactory::getUser()->getParam('timezone');
		$timeZone = JFactory::getConfig()->getValue('offset');
		if($userTz) {
			$timeZone = $userTz;
		}
		$myTimezone = new DateTimeZone($timeZone);

		$date = new JDate('now');
		$date->setTimezone($myTimezone);

		$trimestre = $app->input->getString('choix_trimestre', null);
		$hebergement_id = $app->input->getInt('user_hebergement', 0);
		$mois_t1 = $app->input->getString('premier_trim', null);
		$mois_t2 = $app->input->getString('second_trim', null);
		$mois_t3 = $app->input->getString('troisieme_trim', null);
		$mois_t4 = $app->input->getString('quatrieme_trim', null);
		$tarif_par_nuite_par_personne = $app->input->getFloat('tarif_par_nuitees', 0);
		$nb_personnes_par_nuite = $app->input->getInt('nb_personnes_assujetties', 0);
		$nb_personnes_exonerees = $app->input->getInt('nb_personnes_exonerees', 0);
		$total_declare = $app->input->getFloat('total_dec', 0);
		$exactitude = $app->input->getInt('exactitude_document', 0);

		$mois = '';
		if (!empty($mois_t1))
		{
			$mois = $mois_t1;
		}
		elseif (!empty($mois_t2))
		{
			$mois = $mois_t2;
		}
		elseif (!empty($mois_t3))
		{
			$mois = $mois_t3;
		}
		elseif (!empty($mois_t4))
		{
			$mois = $mois_t4;
		}

		if ( $exactitude ) {
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);
			$values = array($db->quote($trimestre),
				$db->quote($mois),
				$hebergement_id,
				$db->quote($tarif_par_nuite_par_personne),
				$nb_personnes_par_nuite,
				$nb_personnes_exonerees,
				$db->quote($total_declare),
				$db->quote($date->toSql()),
				$exactitude,
				$user->id);

			$query->insert('#__tdsmanager_declarations')
				->columns('trimestre, mois, hebergement_id, tarif_par_nuite_par_personne, nb_personnes_par_nuite, nb_personnes_exonerees, total_declare, date_declaration, exactitude, user_id')
				->values(implode(',', $values));

			$db->setQuery((string)$query);

			try
			{
				$db->Query();
			}
			catch (Exception $e)
			{
				$this->app->enqueueMessage ($e->getMessage());
				return false;
			}

			$app->enqueueMessage(JText::_('COM_TDSMANAGER_DECLARATION_SAVED_SUCCESSFULLY'));
			$this->setRedirect(JRoute::_('index.php?option=com_tdsmanager&view=declarations', false) );
		} else {
			$app->enqueueMessage (JText::_('COM_TDSMANAGER_DECLARATION_EXACTITUDE_NOT_CHECKED'), 'error' );
			$this->setRedirect(JRoute::_('index.php?option=com_tdsmanager&view=declarations&layout=editform', false));
		}
	}

	public function edit() {
		$this->setRedirect(JRoute::_('index.php?option=com_tdsmanager&view=declarations&layout=editform', false));
		return false;
	}

  public function calcul_declaration() {
    $app	= JFactory::getApplication();
    $document = JFactory::getDocument();

    // Set the MIME type for JSON output.
    $document->setMimeEncoding('application/json');

    // Caculer et retourner les données en JSON
    $startdate = $app->input->getString('startdate', 0);
    $enddate = $app->input->getString('enddate', 0);
    $pers_assujetties = $app->input->getInt('nbpersonnesassujetties', 0);

    $results = array();
    $results['erreur'] = 0;

    if ( $startdate == $enddate || $pers_assujetties < 0 ) {
     $results['erreur'] = 1;
     $results['msg_erreur'] = 'Vous ne pouvez pas choisir une date d\'arrivée égale à la date de départ !';
    }

    $tarifs = $app->getUserState('com_tdsmanager.tarifs');
    $tarif = $tarifs->tarif;

    $nbSecondes= 60*60*24;

    $debut_ts = strtotime($startdate);
    $fin_ts = strtotime($enddate);
    $diff = $fin_ts - $debut_ts;
    $duree_sejour = round($diff / $nbSecondes);

    $total_nuitees = $pers_assujetties*$duree_sejour;

    $montant_sejour = $total_nuitees*$tarif;

    $results['duree_sejour'] = $duree_sejour;
    $results['total_nuitees']= $total_nuitees;
    $results['montant_sejour'] = $montant_sejour;

    echo json_encode($results);
  }

  public function createdec() {
    $db = JFactory::getDBO();
    $app	= JFactory::getApplication();
    // récupérer les tarifs en fonction de l'hébergement choisi
    $hosting_selected = $app->input->getInt('user_hebergement', 0);
    if ( $hosting_selected != 0 ) {
       $app->setUserState( 'com_tdsmanager.hosting_id', $hosting_selected );
       // récupérer les tarifs de la taxe de séjour
       /*$query = $db->getQuery(true);
       $query->select('')->from('')->where(''); */
       $query = "SELECT n.* FROM #__tdsmanager_tarif_nuit AS n INNER JOIN #__tdsmanager_hebergements AS h ON h.id_hebergement_type=n.id_hebergement_type WHERE h.id={$db->quote(intval($hosting_selected))}";
       $db->setQuery((string)$query);

       try
		{
			$tarifs = $db->loadObject();
		}
		catch (Exception $e)
		{
			$this->app->enqueueMessage ($e->getMessage());
			return false;
		}

      $app->setUserState( 'com_tdsmanager.tarifs', $tarifs );
    } else {
      // erreur
    }

    $this->setRedirect(JRoute::_('index.php?option=com_tdsmanager&view=declarations&layout=editform', false));
    return false;
  }

  public function delete() {
    $app	= JFactory::getApplication();
    $db = JFactory::getDBO();
    // Check for request forgeries.
    if (!JSession::checkToken()) {
      $app->enqueueMessage ( JText::_('COM_TDSMANAGER_TOKEN'), 'error' );
      $app->redirect($this->baseurl);
    }

    $ids = $app->input->get('cid',array(),'ARRAY');

    var_dump($ids);

    /*foreach($ids as $id) {
      // on vérifie qu'un paiement n'a pas été fait avant de supprimé la déclaration
      $query = "SELECT * FROM #__tdsmanager_reglements WHERE declaration_id={$declaration_Id};";
      $db->setQuery((string)$query);
      $reglement = $db->loadObject();

      if ( $reglement->date_regler ) {
        $query = "DELETE FROM #__tdsmanager_declarations WHERE id={$declaration_Id};";
        $db->setQuery((string)$query);

        try
		{
			$db->Query();
		}
		catch (Exception $e)
		{
			$this->app->enqueueMessage ($e->getMessage());
			return false;
		}

        $message = JText::_('COM_TDSMANAGER_DECLARATION_DELETE_SUCCESSFULLY');
      } else {
        $message = JText::_('COM_TDSMANAGER_DECLARATION_CANNOT_DELETE_REGLEMENT_EXIST');
      }
    }*/
  }

  public function detailsHebergements() {
    $db = JFactory::getDBO();
    $app	= JFactory::getApplication();
    $hebergement_id = $app->input->getInt('idHebergement',0);

    if( $hebergement_id != 0 ) {
      $query = "SELECT h.*,type.name AS heberg_type,class.description AS class_desc, tarif.tarif AS tarif_nuite FROM #__tdsmanager_hebergements AS h
                LEFT JOIN #__tdsmanager_hebergements_type AS type ON h.id_hebergement_type=type.id
                LEFT JOIN #__tdsmanager_classements AS class ON class.id=h.id_classement
                LEFT JOIN #__tdsmanager_tarif_nuit AS tarif ON tarif.id_hebergement_type=h.id_hebergement_type
                WHERE h.id={$hebergement_id};";
      $db->setQuery((string)$query);

      try
		{
			$hebergement = $db->loadObject();
		}
		catch (Exception $e)
		{
			$this->app->enqueueMessage ($e->getMessage());
			return false;
		}

      echo json_encode($hebergement);
    }
  }

  public function checkout() {
    $app	= JFactory::getApplication();

    // on vérifie que l'utilisateur a bien accepté les conditions générales
    $tosAccepted = $app->input->getInt('tosAccepted', 0);
    if ( !$tosAccepted ) {
      $app->enqueueMessage ( 'Vous n\'avez pas accepté les conditions générales avant de payer', 'error' );
      $app->redirect(JRoute::_('index.php?option=com_tdsmanager&view=declarations&layout=recap'));
    } else {
      $paiement_methods = $app->input->getString('paiement_methods');
      $montant = $app->input->getString('montant');

      // on redirige l'utilisateur vers la bonne vue
      if ( $paiement_methods == 'cartebancaire' ) {
        $this->sendCheckout();
      }
    }
  }

  public function cancelCheckout() {
    $app	= JFactory::getApplication();
    // enregistré que le paiement n'a pas été effectué ?
    $app->enqueueMessage ( 'La procédure de paiement a été annulée', 'error' );
    $app->redirect(JRoute::_('index.php?option=com_tdsmanager&view=declarations'));
  }

  public function generatePDF() {
    $app	= JFactory::getApplication();
    $db = JFactory::getDBO();
    $user = JFactory::getUser();
    
    // TODO: la librairie tcpdf a été supprimée du package
    require_once(JPATH_ADMINISTRATOR.'/components/com_tdsmanager/libraries/tcpdf/tcpdf.php');

    $query = "SELECT * FROM #__tdsmanager_users WHERE userid={$user->id};";
    $db->setQuery((string)$query);
    $gest_user = $db->loadObject();

    try
		{
			$gest_user = $db->loadObject();
		}
		catch (Exception $e)
		{
			$this->app->enqueueMessage ($e->getMessage());
			return false;
		}

    $model = $this->getModel();
    $decl_details = $model->getMontantByDeclaration();

    $pdf = new TCPDF('P', 'pt', 'A4', true, 'UTF-8', false);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetFont('helvetica','',10);
    $pdf->AddPage();
    $html = '<div><img src="'.JPATH_ROOT.'/media/com_tdsmanager/images/logo_odt.jpg" title="Logo ODT Faverges" alias="Logo ODT Faverges" />';
    $html .= '<span><h2>Récapitulatif de paiement de la taxe de séjour</h2></span>';
    $html .= '<table style="border:1px solid black;">
   <tr>
       <td>Référence paiement : '.$app->getUserState("com_tdsmanager.idtransaction").'</td>
       <td><ul style="list-style-type:none;"><li>'.$gest_user->name.' '.$gest_user->lastname.'</li><li>'.$gest_user->adress.'</li><li>'.$gest_user->complement_adress.'</li><li>'.$gest_user->postalcode.' '.$gest_user->ville.'</li></ul></td>
   </tr>
</table>';
    $html .= '<span><h2>Déclarations concernées par ce paiement</h2></span>';
    $html .= '<table style="border:1px solid black;">';
    foreach($decl_details as $decl) {
      $html .= '<tr>';
      $html .= '<td>Date début: '.$decl->start_date.' Date fin: '.$decl->end_date.' Nb. total nuitées : '.$decl->nb_total_nuitee.' Montant encaisse séjour : '.$decl->montant_encaisse_sejour.'</td>';
      $html .= '</tr>';
    }
    $html .= '</table>';
    $html .= '</div>';
    $pdf->writeHTML($html, true, 0, true, 0);
    ob_end_clean();
    $doc = $pdf->Output(JPATH_ROOT.'/media/com_tdsmanager/pdf/justificatif.pdf', 'F');
  }

  public function sendmailCheckout() {
    $db = JFactory::getDBO();
    $app	= JFactory::getApplication();
    $mailer = JFactory::getMailer();
    $config = JFactory::getConfig();
    $user = JFactory::getUser();
    $sender = array( $config->getValue( 'config.mailfrom' ), $config->getValue( 'config.fromname' ) );
    $mailer->setSender($sender);
    // récupération des infos du destinataire
    $query = "SELECT * FROM #__tdsmanager_users WHERE userid={$user->id};";
    $db->setQuery((string)$query);
    try
		{
			$gest_user = $db->loadObject();
		}
		catch (Exception $e)
		{
			$this->app->enqueueMessage ($e->getMessage());
			return false;
		}

    $mailer->addRecipient($gest_user->mail);
    $mailer->setSubject('Reçu de paiement de la Taxe de séjour');

    $body   = '<img src="cid:logo_odt" title="Logo Office de tourisme" alt="Logo Office de tourisme" />'
    . '<h2>Reçu de paiement de la Taxe de séjour</h2>'
    . '<div>Bonjour '.$gest_user->name.' '.$gest_user->lastname.',<br /><br />'
    . 'Par ce message, nous confirmons la bonne réception de votre paiement pour la déclaration '.$app->getUserState("com_tdsmanager.idtransaction").'. Si vous avez choisi de régler par chéque ou par virement le paiement sera complément validé quand il sera validé par nos services.<br /><br />'
    . 'Merci de votre confiance. A bientôt. </div>';
    $mailer->isHTML(true);
    $mailer->Encoding = 'base64';

    $mailer->setBody($body);

    $mailer->AddEmbeddedImage( JPATH_ROOT.'/media/com_tdsmanager/images/logo_odt.jpg', 'logo_odt', 'logo_odt.jpg', 'base64', 'image/jpeg' );
    $mailer->addAttachment(JPATH_ROOT.'/media/com_tdsmanager/pdf/justificatif.pdf');

    $send = $mailer->Send();
    if ( $send !== true ) {
      $app->enqueueMessage ( 'Un probléme s\'est produit durant l\'envoi du mail', 'error' );
      return false;
    } else {
      $app->enqueueMessage ( 'Le mail de récupilatif de paiement a bien été envoyé' );
      return true;
    }
  }

  public function getCheckout() {
    $app	= JFactory::getApplication();
    $payerid = urlencode($_GET['PayerID']);
    $token = urlencode($_GET['token']);
    $amount = $app->getUserState("com_tdsmanager.amount");
    $IDTransaction = $app->getUserState("com_tdsmanager.idtransaction");

    $baseurl = 'https://api-3t.sandbox.paypal.com/nvp'; //sandbox
    //$baseurl = 'https://api-3t.paypal.com/nvp'; //live
    $username = urlencode('seller_1349792730_biz_api1.gmail.com');
    $password = urlencode('1349792759');
    $signature = urlencode('AtxcpvyOhXAQLcWH3qBdYMRXyz0lAKKxJdTNEdXBQ82SvDkWr9YjMBDc');
    $post[] = "USER=$username";
    $post[] = "PWD=$password";
    $post[] = "SIGNATURE=$signature";
    $post[] = "VERSION=65.1";
    $post[] = "PAYMENTREQUEST_0_CURRENCYCODE=EUR";
    $post[] = "PAYMENTREQUEST_0_AMT=".$amount;
    $post[] = "PAYMENTREQUEST_0_ITEMAMT=".$amount;
    $post[] = "PAYMENTREQUEST_0_PAYMENTACTION=Sale";
    $post[] = "L_PAYMENTREQUEST_0_NAME0=".urlencode('Déclaration taxe de séjour :'.$IDTransaction); // use %20 for spaces
    $post[] = "L_PAYMENTREQUEST_0_ITEMCATEGORY0=Digital";
    $post[] = "L_PAYMENTREQUEST_0_QTY0=1";
    $post[] = "L_PAYMENTREQUEST_0_AMT0=".$amount;
    $post[] = "LOCALECODE=FR";
    $post['method'] = "METHOD=DoExpressCheckoutPayment";
    $post['token'] = "TOKEN=$token";
    $post['payerid'] = "PayerID=$payerid";
    $post_str = implode('&',$post);

    $ch = curl_init();
  	curl_setopt ($ch, CURLOPT_URL, $baseurl);
  	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false);
  	curl_setopt ($ch, CURLOPT_POST, 1);
  	curl_setopt ($ch, CURLOPT_POSTFIELDS, $post_str);
  	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
  	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 3); // 3 seconds to connect
  	curl_setopt ($ch, CURLOPT_TIMEOUT, 10); // 10 seconds to complete
  	$resultat_paypal = curl_exec($ch);
  	curl_close($ch);

     if (!$resultat_paypal) {
      echo "<p>Erreur</p><p>".curl_error($ch)."</p>";
     } else {
    	$liste_parametres = explode("&",$resultat_paypal); // Crée un tableau de paramètres
    	foreach($liste_parametres as $param_paypal) {
    		list($nom, $valeur) = explode("=", $param_paypal); // Sépare le nom et la valeur
    		$liste_param_paypal[$nom]=urldecode($valeur); // Crée l'array final
    	}

    	// Si la requête a été traitée avec succès
    	if ($liste_param_paypal['ACK'] == 'Success') {
        //$this->saveReglement($amount, 'cartebancaire');
        $this->generatePDF();
        $this->sendmailCheckout();
        $this->setRedirect(JRoute::_('index.php?option=com_tdsmanager&view=declarations', false));
    	} else {
        echo "<p>Erreur de communication avec le serveur PayPal.<br />".$liste_param_paypal['L_SHORTMESSAGE0']."<br />".$liste_param_paypal['L_LONGMESSAGE0']."</p>";
      }
    }
  }

  public function sendCheckout() {
    $app	= JFactory::getApplication();
    $amount = $app->getUserState("com_tdsmanager.amount");
    $IDTransaction = $app->getUserState("com_tdsmanager.idtransaction");

    $username = urlencode('seller_1349792730_biz_api1.gmail.com');
    $password = urlencode('1349792759');
    $signature = urlencode('AtxcpvyOhXAQLcWH3qBdYMRXyz0lAKKxJdTNEdXBQ82SvDkWr9YjMBDc');
    // $returnurl = urlencode('http://floriandalfitto.fr/odt_faverges/index.php/fr/taxe-sejour?view=declarations&task=getcheckout'); // where the user is sent upon successful completion
    // $cancelurl = urlencode('http://floriandalfitto.fr/odt_faverges/index.php/fr/taxe-sejour?view=declarations&task=cancelcheckout'); // where the user is sent upon canceling the transaction
    $post[] = "USER=$username";
    $post[] = "PWD=$password";
    $post[] = "SIGNATURE=$signature";
    $post[] = "VERSION=97.0"; // very important!
    $post[] = "PAYMENTREQUEST_0_CURRENCYCODE=EUR";
    $post[] = "PAYMENTREQUEST_0_AMT=".$amount;
    $post[] = "PAYMENTREQUEST_0_ITEMAMT=".$amount;
    $post[] = "PAYMENTREQUEST_0_PAYMENTACTION=Sale"; // do not alter
    $post[] = "L_PAYMENTREQUEST_0_NAME0=".urlencode('Déclaration taxe de séjour :'.$IDTransaction); // use %20 for spaces
    $post[] = "L_PAYMENTREQUEST_0_ITEMCATEGORY0=Digital"; // do not alter
    $post[] = "L_PAYMENTREQUEST_0_QTY0=1";
    $post[] = "L_PAYMENTREQUEST_0_AMT0=".$amount;
    $post[] = "LOCALECODE=FR";
    $post['returnurl'] = "RETURNURL=$returnurl"; // do not alter
    $post['cancelurl'] = "CANCELURL=$cancelurl"; // do not alter
    $post['method'] = "METHOD=SetExpressCheckout"; // do not alter

    $post_str = implode('&',$post);
        $ch = curl_init();
    curl_setopt ($ch, CURLOPT_URL, 'https://api-3t.sandbox.paypal.com/nvp?');
    	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false);
    	curl_setopt ($ch, CURLOPT_POST, 1);
    	curl_setopt ($ch, CURLOPT_POSTFIELDS, $post_str);
    	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 3); // 3 seconds to connect
    	curl_setopt ($ch, CURLOPT_TIMEOUT, 10); // 10 seconds to complete
        // Modifie l'option CURLOPT_SSL_VERIFYPEER afin d'ignorer la vérification du certificat SSL. Si cette option est à 1, une erreur affichera que la vérification du certificat SSL a échoué, et rien ne sera retourné.
      $resultat_paypal = curl_exec($ch);
    	curl_close($ch);

      if (!$resultat_paypal)
    	{echo "<p>Erreur</p><p>".curl_error($ch)."</p>";}
    else
    {
    	$liste_parametres = explode("&",$resultat_paypal); // Crée un tableau de paramètres
    	foreach($liste_parametres as $param_paypal) // Pour chaque paramètre
    	{
    		list($nom, $valeur) = explode("=", $param_paypal); // Sépare le nom et la valeur
    		$liste_param_paypal[$nom]=urldecode($valeur); // Crée l'array final
    	}

    	// Si la requête a été traitée avec succès
    	if ($liste_param_paypal['ACK'] == 'Success') {
    		// Redirige le visiteur sur le site de PayPal
    		header("Location: https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=".$liste_param_paypal['TOKEN']);
        exit();
    	} else {
        echo "<p>Erreur de communication avec le serveur PayPal.<br />".$liste_param_paypal['L_SHORTMESSAGE0']."<br />".$liste_param_paypal['L_LONGMESSAGE0']."</p>";
      }
    }
  }

  public function saveReglement($amount=null, $type_reglement=null) {
    $date_now = JFactory::date('now')->toSql();

    $app = JFactory::getApplication();
    $db = JFactory::getDBO();

    $ids = $app->getUserState( 'com_tdsmanager_recap_ids' );

    foreach($ids as $id) {
      $query = "INSERT INTO #__tdsmanager_reglements (`date_regler`, `montant`, `type_reglement`, `declaration_id`, `finaliser` ) VALUES ({$date_now}, {$amount}, {$type_reglement}, {$id}, 1)";
      $db->setQuery((string)$query);

      try
		{
			$db->Query();
		}
		catch (Exception $e)
		{
			$this->app->enqueueMessage ($e->getMessage());
			return false;
		}
    }
  }

  public function recap() {
    $app = JFactory::getApplication();

    // Get selected items
    $ids = $app->input->get('cid',array(),'ARRAY');

    $app->setUserState( 'com_tdsmanager_recap_ids', $ids );

    if ( empty($ids) ) {
      $app->enqueueMessage ( 'Veuillez sélectionner une déclaration avant de faire un paiement', 'error' );
      $app->redirect(JRoute::_('index.php?option=com_tdsmanager&view=declarations'));
    } else {
      $this->setRedirect(JRoute::_('index.php?option=com_tdsmanager&view=declarations&layout=recap', false));
      return false;
    }
  }
}