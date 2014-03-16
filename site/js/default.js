/**
 * @copyright	Copyright (C) 2012 CCPF, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * gesttaxesejour component
 * 
 * @since		1.0
 */
window.addEvent('domready', function(){
   if ( $('decl_add_item') != undefined ) {
     $('decl_add_item').addEvent('click', function(event) {            
        var newitem = $('com_gesttaxesejour-sejour1').clone().inject('com_gesttaxesejour-sejour1','after');
        //newitem.set('id', 'com_gesttaxesejour-sejour');                 
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
       var url='index.php?option=com_gesttaxesejour&view=declarations&format=raw&task=detailsHebergements'+idHebergement;           
  
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
        url: 'index.php?option=com_gesttaxesejour&view=declarations&task=calcul_declaration',
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