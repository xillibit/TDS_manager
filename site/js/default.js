/**
 * @copyright	Copyright (C) 2012 CCPF, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * TDS_manager component
 * 
 * @since		1.0
 */
jQuery( document ).ready(function() {
	jQuery('#decl_add_item').click(function() {
		//var newitem = $('com_gesttaxesejour-sejour1').clone().inject('com_gesttaxesejour-sejour1','after');
	});
	
	jQuery('#choix_trimestre').change(function() {
		var selected = jQuery('#choix_trimestre option:selected').val();
		
		jQuery('#premier_trim').hide();
		jQuery('#second_trim').hide();
		jQuery('#troisieme_trim').hide();
		jQuery('#quatrieme_trim').hide();
		
		if (selected=='premier_trim') {
			jQuery('#premier_trim').show();
		} else if (selected=='second_trim') {
			jQuery('#second_trim').show();
		} else if (selected=='troisieme_trim') {
			jQuery('#troisieme_trim').show();
		} else if (selected=='quatrieme_trim') {
			jQuery('#quatrieme_trim').show();
		}
	});
	
	// Récupération des informations de l'hébergement dans la liste déroulante la déclaration
	jQuery('#user_hebergement').change(function() {
		var idHebergement = jQuery('#user_hebergement option:selected').val();
		var url = 'index.php?option=com_tdsmanager&view=declarations&format=raw&task=detailsHebergements&idHebergement='+idHebergement;
		
		if (idHebergement!='-1')
		{
			jQuery.getJSON(url, {
				format: 'json'
			})
			.done(function( data ) {
				jQuery('#alert_dec_div').show();
				jQuery('#alert_dec_div').addClass('alert-success');
				jQuery('#alert_dec_title').text('Succés');
				jQuery('#alert_dec_content').text('Les données de l\'hébergement ont été récupérées avec succés');
				
				jQuery('#tarif_par_nuitees').val(data.tarif_nuite);
			})
			.fail(function() {
				jQuery('#alert_dec_div').show();
				jQuery('#alert_dec_div').addClass('alert-error'); 
				jQuery('#alert_dec_title').text('Erreur');
				jQuery('#alert_dec_content').text('Impossible de récupérer les données de l\'hébergement, veuillez réessayer plus tard.');  	
			});
		}
	});
	
	// Permet de calculer tarfis en appuyant sur valider dans le formulaire de déclaration 
	jQuery('#form_declaration').on('submit', function(e){
		e.preventDefault();  
	
		var tarif = jQuery('#tarif_par_nuitees').val();
		var personnes_assujetties = jQuery('#nb_personnes_assujetties').val(); 
		var total = tarif*personnes_assujetties;
		
		jQuery('#total_dec').val();
	});
});

window.addEvent('domready', function(){
   if ( $('decl_add_item') != undefined ) {
     $('decl_add_item').addEvent('click', function(event) {            
        var newitem = $('com_gesttaxesejour-sejour1').clone().inject('com_gesttaxesejour-sejour1','after');
        //newitem.set('id', 'com_gesttaxesejour-sejour');                 
     });
   }
   
	if ( $('choix_trimestre') != undefined ) {
		$('choix_trimestre').addEvent('change', function(event) { 
			var selected = $('choix_trimestre').getSelected().get('value');

			$('premier_trim').setStyle('display', 'none');
			$('second_trim').setStyle('display', 'none');
			$('troisieme_trim').setStyle('display', 'none');
			$('quatrieme_trim').setStyle('display', 'none');

			if (selected=='premier_trim') {
				$('premier_trim').setStyle('display');
			} else if (selected=='second_trim') {
				$('second_trim').setStyle('display');
			} else if (selected=='troisieme_trim') {
				$('troisieme_trim').setStyle('display');
			} else if (selected=='quatrieme_trim') {
				$('quatrieme_trim').setStyle('display');
			}
		});
	}
   
   if ( $('decl_remove_item') != undefined ) {
     $('decl_remove_item').addEvent('click', function(event) { 
            
     });
   }
   if ( $('checkbox_all') != undefined ) {
     $('checkbox_all').addEvent('click', function(event) {      
        if ( document.id('checkbox_all').getProperty('checked') == false ) {
          $$('.check-me').each(function(box){
          box.removeProperty('checked');
          });
       } else {
          $$('.check-me').each(function(box){
          box.setProperty('checked', 'checked');
          });
        }                                  
     });
   }   
   if ( $('user_hebergement') != undefined ) {
     $('user_hebergement').addEvent('change', function(event) {
       var idHebergement = '&idHebergement='+$('user_hebergement').getSelected().get('value'); 
       var url='index.php?option=com_tdsmanager&view=declarations&format=raw&task=detailsHebergements'+idHebergement;           
  
       var request = new Request({
        url: url,
        method:'post',      
        async: true,
        onSuccess: function(responseText){
          // Vidange des éléments
          $('decl_hebergement_type').empty();
          $('decl_adress_hebergement').empty();
          $('decl_proprietaire').empty();
          $('decl_nom_hebergement').empty();
          $('decl_classement').empty();
          $('decl_date_classement').empty();
          $('decl_numero_classement').empty();
          // Remplissage des éléments avec du contenu
          var myObject = JSON.decode(responseText); 
          $('decl_hebergement_type').appendText(myObject.heberg_type);
          $('decl_adress_hebergement').appendText(myObject.adress);
          $('decl_proprietaire').appendText(myObject.owner_lastname);
          $('decl_proprietaire').appendText(' '+myObject.owner_name);
          $('decl_nom_hebergement').appendText(myObject.hostingname);
          $('decl_classement').appendText(myObject.class_desc);
          $('decl_date_classement').appendText(myObject.date_classement);
          $('decl_numero_classement').appendText(myObject.numero_classement);
        }
        }).send(); 
     });
   }
    
   if ( $('paiement_methods') != undefined ) { 
    $('paiement_methods').addEvent('change', function(event) {
      var tmp = $('paiement_methods').getSelected();
      if ( tmp.get('value') == 'cartebancaire' ) {
        $('cheque_text').setStyle('display', 'none');
        $('virement_text').setStyle('display', 'none');
        $('paypal_paiement_text').setStyle('display');
      } else if ( tmp.get('value') == 'cheque' ) {
        $('paypal_paiement_text').setStyle('display', 'none');
        $('virement_text').setStyle('display', 'none');
        $('cheque_text').setStyle('display');
      } else if ( tmp.get('value') == 'virement' ) {
        $('paypal_paiement_text').setStyle('display', 'none');
        $('cheque_text').setStyle('display', 'none');
        $('virement_text').setStyle('display');
      }
      
    });
   }
   
   if ( $('declaration_calcul') != undefined ) { 
     var start_date = document.id('start_date');
     var end_date = document.id('end_date');
     var nb_personnes_assujetties = document.id('nb_personnes_assujetties');
     
     var duree_sejour_nuitee = document.id('duree_sejour_nuitee');
     var nuitees = document.id('nuitees');
     var montant_encaisse_sejour = document.id('montant_encaisse_sejour');
     
     var myRequest = new Request({
        url: 'index.php?option=com_tdsmanager&view=declarations&task=calcul_declaration',
        method: 'get',
        onRequest: function(){
            //myElement.set('text', 'loading...');
        },
        onSuccess: function(responseText){
            var object = JSON.decode(responseText);
            if ( !object.erreur ) { 
              if ( duree_sejour_nuitee.get('value').length ) duree_sejour_nuitee.set('value','');
              duree_sejour_nuitee.set('value',object.duree_sejour);
              if ( nuitees.get('value').length ) nuitees.set('value','');
              nuitees.set('value',object.total_nuitees);
              if ( montant_encaisse_sejour.get('value').length ) montant_encaisse_sejour.set('value','');
              montant_encaisse_sejour.set('value',object.montant_sejour);
            } else {
              alert(object.msg_erreur);
            }
        },
        onFailure: function(){
            //myElement.set('text', 'Sorry, your request failed :(');
        }
    }); 
    
    $('declaration_calcul').addEvent('click', function(event) {
      event.stop();
      myRequest.send('startdate='+start_date.get('value')+'&enddate='+end_date.get('value')+'&nbpersonnesassujetties='+nb_personnes_assujetties.get('value')+'&format=raw');      
    }); 
   }
   
   if ( $('sup_declaration') != undefined ) {
    $('sup_declaration').addEvent('click', function(event) {
      $('com_gesttaxe_dec_form').submit();
    });
   }
   
   if ( $('taxe-hebergements') != undefined ) {
    if ( $('taxehebergementedit') != undefined ) {
      $('taxehebergementedit').addEvent('click', function(event) {
        var myEditElement  = new Element('input', {type: 'hidden',name:'task',value:'edit'});
        $('taxe-hebergements').grab(myEditElement);
        document.taxehebergements.submit();
      });
    }
    
    $('taxehebergementdelete').addEvent('click', function(event) {
      var myTaskElement  = new Element('input', {type: 'hidden',name:'task',value:'delete'});
      $('taxe-hebergements').grab(myTaskElement);
      document.taxehebergements.submit();
    });
   }    	
});