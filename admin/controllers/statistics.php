<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_gesttaxesejour
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

require_once JPATH_ADMINISTRATOR . '/components/com_tdsmanager/libraries/controller.php';

/**
 * Statistics list controller class.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_gesttaxesejour
 * @since       1.6
 */
class TdsmanagerAdminControllerStatistics extends TdsmanagerController {
   
  /**
	 * Class Constructor
	 *
	 * @param	array	$config		An optional associative array of configuration settings.
	 * @return	void
	 * @since	1.5
	 */
	function __construct($config = array()) {
		parent::__construct($config); 
		$this->baseurl = 'index.php?option=com_tdsmanager&view=statistics';    	
	}	
    
	public function export() {    
    $model = $this->getModel('statistics');
            
    if (file_exists(JPATH_ADMINISTRATOR.'/components/com_tdsmanager/libraries/export_excel/PHPExcel.php')) {
      require_once JPATH_ADMINISTRATOR.'/components/com_tdsmanager/libraries/export_excel/PHPExcel.php';
      require_once JPATH_ADMINISTRATOR.'/components/com_tdsmanager/libraries/export_excel/PHPExcel/Writer/Excel2007.php';
      
      // create an instance of the class
      $workbook = new PHPExcel;
      
      // Définition des propriétés du document
      $workbook->getProperties()->setCreator('Site ODT Faverges');
      $workbook->getProperties()->setLastModifiedBy('Site ODT Faverges'); 
      $workbook->getProperties()->setTitle('Statistiques de la taxe de séjour');
      $workbook->getProperties()->setSubject('Taxe de séjour');
      $workbook->getProperties()->setDescription('Statistiques de la taxe de séjour pour la période du ');            
      
      $sheet = $workbook->getActiveSheet();
      //nom de la feuille
      //$sheet->setTitle(JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_PAR_COMMUNES'));
      $sheet->setTitle('Stats par communes');
      
      // Titre des colonnes
      $sheet->setCellValue('A1',JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_NOM_COMMUNE'));
      $sheet->setCellValue('B1',JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_TAUX_OCCUPATION'));
      
      // Appliquer un style aux titres des deux colonnes
      $style = $this->setStyle($sheet, 'A1');                
      $sheet->duplicateStyle($style,'B1');
      $this->setColumnWidth($sheet,array('A'=>'28', 'B' => '30'));      
      
      $this->setBackgroundColor($sheet, array('A1','B1'), '017DC5');
      
      // Ajout des données dans la feuille
      $tauxoccupationcommunes = $model->getTauxOccupationStatsCommunes();      
            
      $i = 2;
      foreach($tauxoccupationcommunes as $tauxoc_communes) {
        $sheet->setCellValue('A'.$i, $tauxoc_communes->city);        
        if ( $tauxoc_communes->pers_occup_total > '0' ) {          
          $sheet->setCellValue('B'.$i, ($tauxoc_communes->nb_total_personnes/$tauxoc_communes->pers_occup_total)*100);
        } 
        $i++;                       
      }
      
      // Stats pour Chevaline
      $sheet22 = $workbook->createSheet();
      
      $sheet22->setTitle('Chevaline');
      
      $this->_setCommunesEntetes($sheet22);
      
      // Appliquer un style aux titres des deux colonnes
      $style = $this->setStyle($sheet22, 'A1');
      $sheet22->duplicateStyle($style,'B1:S1');
      $this->setColumnWidth($sheet22,array('A'=>'28', 'B' => '30', 'C' => '30', 'D' => '30', 'E' => '30', 'F' => '30', 'G' => '30', 'H' => '30', 'I' => '30', 'J' => '30', 'K' => '30', 'L' => '30', 'M' => '30', 'N' => '30', 'O' => '30', 'P' => '30', 'Q' => '30', 'R' => '30', 'S' => '30'));
      
      $this->setBackgroundColor($sheet22, array('A1','B1','C1','D1','E1','F1','G1','H1','I1','J1','K1','L1','M1','N1','O1','P1','Q1','R1','S1'), '017DC5');
      
      // Taux d'occupation par type d'hébergement
      $stats_chevaline_herbertypes = $model->getChevalineStats();      
      
      if ( !empty($stats_chevaline_herbertypes) ) {      
        $i = 2;
        foreach($stats_chevaline_herbertypes as $tauxocc_hebertype) {        
          $sheet22->setCellValue('A'.$i, $tauxocc_hebertype->hosting_type_name); 
          $sheet22->setCellValue('B'.$i, $tauxocc_hebertype->owner_lastname.' '.$tauxocc_hebertype->owner_name);
          $sheet22->setCellValue('C'.$i, $tauxocc_hebertype->hostingname); 
          $sheet22->setCellValue('D'.$i, $tauxocc_hebertype->adress_owner);
          $sheet22->setCellValue('E'.$i, $tauxocc_hebertype->cp_owner);
          $sheet22->setCellValue('F'.$i, $tauxocc_hebertype->ville_owner);
          $sheet22->setCellValue('G'.$i, $tauxocc_hebertype->adress);
          $sheet22->setCellValue('H'.$i, $tauxocc_hebertype->phone);
          $sheet22->setCellValue('I'.$i, $tauxocc_hebertype->email);
          $sheet22->setCellValue('J'.$i, $tauxocc_hebertype->desc_classement);
          $sheet22->setCellValue('K'.$i, $tauxocc_hebertype->nom_label);
          $sheet22->setCellValue('L'.$i, $tauxocc_hebertype->numero_classement);
          $sheet22->setCellValue('M'.$i, $tauxocc_hebertype->numero_classement);
          $sheet22->setCellValue('N'.$i, $tauxocc_hebertype->numero_classement); 
          if ( $tauxocc_hebertype->pers_occup_total > '0' ) {
            $sheet22->setCellValue('O'.$i, ($tauxoc_communes->nb_total_personnes/$tauxoc_communes->pers_occup_total)*100);
          }
          $sheet22->setCellValue('P'.$i, $tauxocc_hebertype->capacite_chambres);
          $sheet22->setCellValue('Q'.$i, $tauxocc_hebertype->nb_total_personnes);
          $sheet22->setCellValue('R'.$i, $tauxocc_hebertype->total_nuitee);
          $sheet22->setCellValue('S'.$i, $tauxocc_hebertype->total_taux_occupation);         
          $i++;                
        }
      } 
      
      $chevaline_types = $model->getTotalByHeberType('Chevaline');
      $nb_item_chevaline = count($stats_chevaline_herbertypes);
      $nb_item_chevaline = $nb_item_chevaline+3;
            
      foreach($chevaline_types as $type) {        
        $sheet22->setCellValue('B'.$nb_item_chevaline, 'Total '.$type->name);
        $sheet22->setCellValue('C'.$nb_item_chevaline, $type->total_type);        
        $nb_item_chevaline++; 
      }       
      
      // Stats pour Cons
      $sheet23 = $workbook->createSheet();
      
      $sheet23->setTitle('Cons-Sainte-Colombe');
      
      $this->_setCommunesEntetes($sheet23);
      
      // Appliquer un style aux titres des deux colonnes
      $style = $this->setStyle($sheet23, 'A1');
      $sheet23->duplicateStyle($style,'B1:S1');
      $this->setColumnWidth($sheet23,array('A'=>'28', 'B' => '30', 'C' => '30', 'D' => '30', 'E' => '30', 'F' => '30', 'G' => '30', 'H' => '30', 'I' => '30', 'J' => '30', 'K' => '30', 'L' => '30', 'M' => '30', 'N' => '30', 'O' => '30', 'P' => '30', 'Q' => '30', 'R' => '30', 'S' => '30'));
      
      $this->setBackgroundColor($sheet23, array('A1','B1','C1','D1','E1','F1','G1','H1','I1','J1','K1','L1','M1','N1','O1','P1','Q1','R1','S1'), '017DC5');
      
      $stats_cons_herbertypes = $model->getConsStats();
      
      if ( !empty($stats_cons_herbertypes) ) {      
        $i = 2;
        foreach($stats_cons_herbertypes as $tauxocc_hebertype) {        
          $sheet23->setCellValue('A'.$i, $tauxocc_hebertype->hosting_type_name); 
          $sheet23->setCellValue('B'.$i, $tauxocc_hebertype->owner_lastname.' '.$tauxocc_hebertype->owner_name);
          $sheet23->setCellValue('C'.$i, $tauxocc_hebertype->hostingname); 
          $sheet23->setCellValue('D'.$i, $tauxocc_hebertype->adress_owner);
          $sheet23->setCellValue('E'.$i, $tauxocc_hebertype->cp_owner);
          $sheet23->setCellValue('F'.$i, $tauxocc_hebertype->ville_owner);
          $sheet23->setCellValue('G'.$i, $tauxocc_hebertype->adress);
          $sheet23->setCellValue('H'.$i, $tauxocc_hebertype->phone);
          $sheet23->setCellValue('I'.$i, $tauxocc_hebertype->email);
          $sheet23->setCellValue('J'.$i, $tauxocc_hebertype->desc_classement);
          $sheet23->setCellValue('K'.$i, $tauxocc_hebertype->nom_label);
          $sheet23->setCellValue('L'.$i, $tauxocc_hebertype->numero_classement);
          $sheet23->setCellValue('M'.$i, $tauxocc_hebertype->numero_classement);
          $sheet23->setCellValue('N'.$i, $tauxocc_hebertype->numero_classement); 
          if ( $tauxocc_hebertype->pers_occup_total > '0' ) {
            $sheet23->setCellValue('O'.$i, ($tauxoc_communes->nb_total_personnes/$tauxoc_communes->pers_occup_total)*100);
          }
          $sheet23->setCellValue('P'.$i, $tauxocc_hebertype->capacite_chambres);
          $sheet23->setCellValue('Q'.$i, $tauxocc_hebertype->nb_total_personnes);
          $sheet23->setCellValue('R'.$i, $tauxocc_hebertype->total_nuitee);
          $sheet23->setCellValue('S'.$i, $tauxocc_hebertype->total_taux_occupation);  
          $i++;                
        }
      }
      
      $cons_types = $model->getTotalByHeberType('Cons-Sainte-Colombe');
      $nb_item_cons = count($stats_cons_herbertypes);
      $nb_item_cons = $nb_item_cons+3;
            
      foreach($cons_types as $type) {              
        $sheet23->setCellValue('B'.$nb_item_cons, 'Total '.$type->name);
        $sheet23->setCellValue('C'.$nb_item_cons, $type->total_type);
        $nb_item_cons++; 
      }
      
      // Stats pour Doussard
      $sheet24 = $workbook->createSheet();
      
      $sheet24->setTitle('Doussard');
      
      $this->_setCommunesEntetes($sheet24);
      
      // Appliquer un style aux titres des deux colonnes
      $style = $this->setStyle($sheet24, 'A1');
      $sheet24->duplicateStyle($style,'B1:S1');
      $this->setColumnWidth($sheet24,array('A'=>'28', 'B' => '30', 'C' => '30', 'D' => '30', 'E' => '30', 'F' => '30', 'G' => '30', 'H' => '30', 'I' => '30', 'J' => '30', 'K' => '30', 'L' => '30', 'M' => '30', 'N' => '30', 'O' => '30', 'P' => '30', 'Q' => '30', 'R' => '30', 'S' => '30'));
      
      $this->setBackgroundColor($sheet24, array('A1','B1','C1','D1','E1','F1','G1','H1','I1','J1','K1','L1','M1','N1','O1','P1','Q1','R1','S1'), '017DC5');
      
      $stats_doussard_herbertypes = $model->getDoussardStats();
      
      if ( !empty($stats_doussard_herbertypes) ) {      
        $i = 2;
        foreach($stats_doussard_herbertypes as $tauxocc_hebertype) {        
          $sheet24->setCellValue('A'.$i, $tauxocc_hebertype->hosting_type_name); 
          $sheet24->setCellValue('B'.$i, $tauxocc_hebertype->owner_lastname.' '.$tauxocc_hebertype->owner_name);
          $sheet24->setCellValue('C'.$i, $tauxocc_hebertype->hostingname); 
          $sheet24->setCellValue('D'.$i, $tauxocc_hebertype->adress_owner);
          $sheet24->setCellValue('E'.$i, $tauxocc_hebertype->cp_owner);
          $sheet24->setCellValue('F'.$i, $tauxocc_hebertype->ville_owner);
          $sheet24->setCellValue('G'.$i, $tauxocc_hebertype->adress);
          $sheet24->setCellValue('H'.$i, $tauxocc_hebertype->phone);
          $sheet24->setCellValue('I'.$i, $tauxocc_hebertype->email);
          $sheet24->setCellValue('J'.$i, $tauxocc_hebertype->desc_classement);
          $sheet24->setCellValue('K'.$i, $tauxocc_hebertype->nom_label);
          $sheet24->setCellValue('L'.$i, $tauxocc_hebertype->numero_classement);
          $sheet24->setCellValue('M'.$i, $tauxocc_hebertype->numero_classement);
          $sheet24->setCellValue('N'.$i, $tauxocc_hebertype->numero_classement); 
          if ( $tauxocc_hebertype->pers_occup_total > '0' ) {
            $sheet24->setCellValue('O'.$i, ($tauxoc_communes->nb_total_personnes/$tauxoc_communes->pers_occup_total)*100);
          }
          $sheet24->setCellValue('P'.$i, $tauxocc_hebertype->capacite_chambres);
          $sheet24->setCellValue('Q'.$i, $tauxocc_hebertype->nb_total_personnes);
          $sheet24->setCellValue('R'.$i, $tauxocc_hebertype->total_nuitee);
          $sheet24->setCellValue('S'.$i, $tauxocc_hebertype->total_taux_occupation);  
          $i++;                
        }
      }
      
      $doussard_types = $model->getTotalByHeberType('Doussard');
      $nb_item_doussard = count($stats_doussard_herbertypes);
      $nb_item_doussard = $nb_item_doussard+3;
            
      foreach($doussard_types as $type) {              
        $sheet24->setCellValue('B'.$nb_item_doussard, 'Total '.$type->name);
        $sheet24->setCellValue('C'.$nb_item_doussard, $type->total_type);
        $nb_item_doussard++; 
      }
      
      // Stats pour Faverges
      $sheet25 = $workbook->createSheet();
      
      $sheet25->setTitle('Faverges');
      
      $this->_setCommunesEntetes($sheet25);
      
      // Appliquer un style aux titres des deux colonnes
      $style = $this->setStyle($sheet25, 'A1');
      $sheet25->duplicateStyle($style,'B1:S1');
      $this->setColumnWidth($sheet25,array('A'=>'28', 'B' => '30', 'C' => '30', 'D' => '30', 'E' => '30', 'F' => '30', 'G' => '30', 'H' => '30', 'I' => '30', 'J' => '30', 'K' => '30', 'L' => '30', 'M' => '30', 'N' => '30', 'O' => '30', 'P' => '30', 'Q' => '30', 'R' => '30', 'S' => '30'));
      
      $this->setBackgroundColor($sheet25, array('A1','B1','C1','D1','E1','F1','G1','H1','I1','J1','K1','L1','M1','N1','O1','P1','Q1','R1','S1'), '017DC5');
      
      $stats_faverges_herbertypes = $model->getFavergesStats();
      
      if ( !empty($stats_faverges_herbertypes) ) {
        $i = 2;
        foreach($stats_faverges_herbertypes as $tauxocc_hebertype) {                 
          $sheet25->setCellValue('A'.$i, $tauxocc_hebertype->hosting_type_name); 
          $sheet25->setCellValue('B'.$i, $tauxocc_hebertype->owner_lastname.' '.$tauxocc_hebertype->owner_name);
          $sheet25->setCellValue('C'.$i, $tauxocc_hebertype->hostingname); 
          $sheet25->setCellValue('D'.$i, $tauxocc_hebertype->adress_owner);
          $sheet25->setCellValue('E'.$i, $tauxocc_hebertype->cp_owner);
          $sheet25->setCellValue('F'.$i, $tauxocc_hebertype->ville_owner);
          $sheet25->setCellValue('G'.$i, $tauxocc_hebertype->adress);
          $sheet25->setCellValue('H'.$i, $tauxocc_hebertype->phone);
          $sheet25->setCellValue('I'.$i, $tauxocc_hebertype->email);
          $sheet25->setCellValue('J'.$i, $tauxocc_hebertype->desc_classement);
          $sheet25->setCellValue('K'.$i, $tauxocc_hebertype->nom_label);
          $sheet25->setCellValue('L'.$i, $tauxocc_hebertype->numero_classement);
          $sheet25->setCellValue('M'.$i, $tauxocc_hebertype->numero_classement);
          $sheet25->setCellValue('N'.$i, $tauxocc_hebertype->numero_classement); 
          if ( $tauxocc_hebertype->pers_occup_total > '0' ) {
            $sheet25->setCellValue('O'.$i, ($tauxoc_communes->nb_total_personnes/$tauxoc_communes->pers_occup_total)*100);
          }
          $sheet25->setCellValue('P'.$i, $tauxocc_hebertype->capacite_chambres);
          $sheet25->setCellValue('Q'.$i, $tauxocc_hebertype->nb_total_personnes);
          $sheet25->setCellValue('R'.$i, $tauxocc_hebertype->total_nuitee);
          $sheet25->setCellValue('S'.$i, $tauxocc_hebertype->total_taux_occupation);  
          $i++;                
        }
      } 
      
      $faverges_types = $model->getTotalByHeberType('Faverges');
      $nb_item_faverges = count($stats_faverges_herbertypes);
      $nb_item_faverges = $nb_item_faverges+3;
            
      foreach($faverges_types as $type) {              
        $sheet25->setCellValue('B'.$nb_item_faverges, 'Total '.$type->name);
        $sheet25->setCellValue('C'.$nb_item_faverges, $type->total_type);
        $nb_item_faverges++; 
      }    
       
      // Stats pour Giez
      $sheet26 = $workbook->createSheet();
      
      $sheet26->setTitle('Giez');
      
      $this->_setCommunesEntetes($sheet26);
      
      // Appliquer un style aux titres des deux colonnes
      $style = $this->setStyle($sheet26, 'A1');
      $sheet26->duplicateStyle($style,'B1:S1');
      $this->setColumnWidth($sheet26,array('A'=>'28', 'B' => '30', 'C' => '30', 'D' => '30', 'E' => '30', 'F' => '30', 'G' => '30', 'H' => '30', 'I' => '30', 'J' => '30', 'K' => '30', 'L' => '30', 'M' => '30', 'N' => '30', 'O' => '30', 'P' => '30', 'Q' => '30', 'R' => '30', 'S' => '30'));
      
      $this->setBackgroundColor($sheet26, array('A1','B1','C1','D1','E1','F1','G1','H1','I1','J1','K1','L1','M1','N1','O1','P1','Q1','R1','S1'), '017DC5');
      
      $stats_giez_herbertypes = $model->getGiezStats();
      
      if ( !empty($stats_giez_herbertypes) ) {      
        $i = 2;
        foreach($stats_giez_herbertypes as $tauxocc_hebertype) {        
          $sheet26->setCellValue('A'.$i, $tauxocc_hebertype->hosting_type_name); 
          $sheet26->setCellValue('B'.$i, $tauxocc_hebertype->owner_lastname.' '.$tauxocc_hebertype->owner_name);
          $sheet26->setCellValue('C'.$i, $tauxocc_hebertype->hostingname); 
          $sheet26->setCellValue('D'.$i, $tauxocc_hebertype->adress_owner);
          $sheet26->setCellValue('E'.$i, $tauxocc_hebertype->cp_owner);
          $sheet26->setCellValue('F'.$i, $tauxocc_hebertype->ville_owner);
          $sheet26->setCellValue('G'.$i, $tauxocc_hebertype->adress);
          $sheet26->setCellValue('H'.$i, $tauxocc_hebertype->phone);
          $sheet26->setCellValue('I'.$i, $tauxocc_hebertype->email);
          $sheet26->setCellValue('J'.$i, $tauxocc_hebertype->desc_classement);
          $sheet26->setCellValue('K'.$i, $tauxocc_hebertype->nom_label);
          $sheet26->setCellValue('L'.$i, $tauxocc_hebertype->numero_classement);
          $sheet26->setCellValue('M'.$i, $tauxocc_hebertype->numero_classement);
          $sheet26->setCellValue('N'.$i, $tauxocc_hebertype->numero_classement); 
          if ( $tauxocc_hebertype->pers_occup_total > '0' ) {
            $sheet22->setCellValue('O'.$i, ($tauxoc_communes->nb_total_personnes/$tauxoc_communes->pers_occup_total)*100);
          }
          $sheet26->setCellValue('P'.$i, $tauxocc_hebertype->capacite_chambres);
          $sheet26->setCellValue('Q'.$i, $tauxocc_hebertype->nb_total_personnes);
          $sheet26->setCellValue('R'.$i, $tauxocc_hebertype->total_nuitee);
          $sheet26->setCellValue('S'.$i, $tauxocc_hebertype->total_taux_occupation);  
          $i++;                
        }
      }
      
      $giez_types = $model->getTotalByHeberType('Giez');
      $nb_item_giez = count($stats_giez_herbertypes);
      $nb_item_giez = $nb_item_giez+3;
            
      foreach($giez_types as $type) {              
        $sheet26->setCellValue('B'.$nb_item_giez, 'Total '.$type->name);
        $sheet26->setCellValue('C'.$nb_item_giez, $type->total_type);
        $nb_item_giez++; 
      }
      
      // Stats pour lathuile
      $sheet27 = $workbook->createSheet();
      
      $sheet27->setTitle('Lathuile');
      
      $this->_setCommunesEntetes($sheet27);
      
      // Appliquer un style aux titres des deux colonnes
      $style = $this->setStyle($sheet27, 'A1');
      $sheet27->duplicateStyle($style,'B1:S1');
      $this->setColumnWidth($sheet27,array('A'=>'28', 'B' => '30', 'C' => '30', 'D' => '30', 'E' => '30', 'F' => '30', 'G' => '30', 'H' => '30', 'I' => '30', 'J' => '30', 'K' => '30', 'L' => '30', 'M' => '30', 'N' => '30', 'O' => '30', 'P' => '30', 'Q' => '30', 'R' => '30', 'S' => '30'));
      
      $this->setBackgroundColor($sheet27, array('A1','B1','C1','D1','E1','F1','G1','H1','I1','J1','K1','L1','M1','N1','O1','P1','Q1','R1','S1'), '017DC5');
      
      $stats_lathuile_herbertypes = $model->getLathuileStats();
      
      if ( !empty($stats_lathuile_herbertypes) ) {      
        $i = 2;
        foreach($stats_lathuile_herbertypes as $tauxocc_hebertype) {        
          $sheet27->setCellValue('A'.$i, $tauxocc_hebertype->hosting_type_name); 
          $sheet27->setCellValue('B'.$i, $tauxocc_hebertype->owner_lastname.' '.$tauxocc_hebertype->owner_name);
          $sheet27->setCellValue('C'.$i, $tauxocc_hebertype->hostingname); 
          $sheet27->setCellValue('D'.$i, $tauxocc_hebertype->adress_owner);
          $sheet27->setCellValue('E'.$i, $tauxocc_hebertype->cp_owner);
          $sheet27->setCellValue('F'.$i, $tauxocc_hebertype->ville_owner);
          $sheet27->setCellValue('G'.$i, $tauxocc_hebertype->adress);
          $sheet27->setCellValue('H'.$i, $tauxocc_hebertype->phone);
          $sheet27->setCellValue('I'.$i, $tauxocc_hebertype->email);
          $sheet27->setCellValue('J'.$i, $tauxocc_hebertype->desc_classement);
          $sheet27->setCellValue('K'.$i, $tauxocc_hebertype->nom_label);
          $sheet27->setCellValue('L'.$i, $tauxocc_hebertype->numero_classement);
          $sheet27->setCellValue('M'.$i, $tauxocc_hebertype->numero_classement);
          $sheet27->setCellValue('N'.$i, $tauxocc_hebertype->numero_classement); 
          if ( $tauxocc_hebertype->pers_occup_total > '0' ) {
            $sheet27->setCellValue('O'.$i, ($tauxoc_communes->nb_total_personnes/$tauxoc_communes->pers_occup_total)*100);
          }
          $sheet27->setCellValue('P'.$i, $tauxocc_hebertype->capacite_chambres);
          $sheet27->setCellValue('Q'.$i, $tauxocc_hebertype->nb_total_personnes);
          $sheet27->setCellValue('R'.$i, $tauxocc_hebertype->total_nuitee);
          $sheet27->setCellValue('S'.$i, $tauxocc_hebertype->total_taux_occupation);  
          $i++;                
        }
      }
      
      $lathuile_types = $model->getTotalByHeberType('Lathuile');
      $nb_item_lathuile = count($stats_lathuile_herbertypes);
      $nb_item_lathuile = $nb_item_lathuile+3;
            
      foreach($lathuile_types as $type) {              
        $sheet26->setCellValue('B'.$nb_item_lathuile, 'Total '.$type->name);
        $sheet26->setCellValue('C'.$nb_item_lathuile, $type->total_type);
        $nb_item_lathuile++; 
      }
      
      // Stats pour Marlens
      $sheet28 = $workbook->createSheet();
      
      $sheet28->setTitle('Marlens');
      
      $this->_setCommunesEntetes($sheet28);
      
      // Appliquer un style aux titres des deux colonnes
      $style = $this->setStyle($sheet28, 'A1');
      $sheet28->duplicateStyle($style,'B1:S1');
      $this->setColumnWidth($sheet28,array('A'=>'28', 'B' => '30', 'C' => '30', 'D' => '30', 'E' => '30', 'F' => '30', 'G' => '30', 'H' => '30', 'I' => '30', 'J' => '30', 'K' => '30', 'L' => '30', 'M' => '30', 'N' => '30', 'O' => '30', 'P' => '30', 'Q' => '30', 'R' => '30', 'S' => '30'));
      
      $this->setBackgroundColor($sheet28, array('A1','B1','C1','D1','E1','F1','G1','H1','I1','J1','K1','L1','M1','N1','O1','P1','Q1','R1','S1'), '017DC5');
      
      $stats_marlens_herbertypes = $model->getMarlensStats();
      
      if ( !empty($stats_marlens_herbertypes) ) {      
        $i = 2;
        foreach($stats_marlens_herbertypes as $tauxocc_hebertype) {        
          $sheet28->setCellValue('A'.$i, $tauxocc_hebertype->hosting_type_name); 
          $sheet28->setCellValue('B'.$i, $tauxocc_hebertype->owner_lastname.' '.$tauxocc_hebertype->owner_name);
          $sheet28->setCellValue('C'.$i, $tauxocc_hebertype->hostingname); 
          $sheet28->setCellValue('D'.$i, $tauxocc_hebertype->adress_owner);
          $sheet28->setCellValue('E'.$i, $tauxocc_hebertype->cp_owner);
          $sheet28->setCellValue('F'.$i, $tauxocc_hebertype->ville_owner);
          $sheet28->setCellValue('G'.$i, $tauxocc_hebertype->adress);
          $sheet28->setCellValue('H'.$i, $tauxocc_hebertype->phone);
          $sheet28->setCellValue('I'.$i, $tauxocc_hebertype->email);
          $sheet28->setCellValue('J'.$i, $tauxocc_hebertype->desc_classement);
          $sheet28->setCellValue('K'.$i, $tauxocc_hebertype->nom_label);
          $sheet28->setCellValue('L'.$i, $tauxocc_hebertype->numero_classement);
          $sheet28->setCellValue('M'.$i, $tauxocc_hebertype->numero_classement);
          $sheet28->setCellValue('N'.$i, $tauxocc_hebertype->numero_classement); 
          if ( $tauxocc_hebertype->pers_occup_total > '0' ) {
            $sheet28->setCellValue('O'.$i, ($tauxoc_communes->nb_total_personnes/$tauxoc_communes->pers_occup_total)*100);
          }
          $sheet28->setCellValue('P'.$i, $tauxocc_hebertype->capacite_chambres);
          $sheet28->setCellValue('Q'.$i, $tauxocc_hebertype->nb_total_personnes);
          $sheet28->setCellValue('R'.$i, $tauxocc_hebertype->total_nuitee);
          $sheet28->setCellValue('S'.$i, $tauxocc_hebertype->total_taux_occupation);  
          $i++;                
        }
      }
      
      $marlens_types = $model->getTotalByHeberType('Marlens');
      $nb_item_marlens = count($stats_marlens_herbertypes);
      $nb_item_marlens = $nb_item_marlens+3;
            
      foreach($marlens_types as $type) {              
        $sheet29->setCellValue('B'.$nb_item_marlens, 'Total '.$type->name);
        $sheet29->setCellValue('C'.$nb_item_marlens, $type->total_type);
        $nb_item_marlens++; 
      }
      
      // Stats pour Montmin
      $sheet29 = $workbook->createSheet();
      
      $sheet29->setTitle('Montmin');
      
      $this->_setCommunesEntetes($sheet29);
      
      // Appliquer un style aux titres des deux colonnes
      $style = $this->setStyle($sheet29, 'A1');
      $sheet29->duplicateStyle($style,'B1:S1');
      $this->setColumnWidth($sheet29,array('A'=>'28', 'B' => '30', 'C' => '30', 'D' => '30', 'E' => '30', 'F' => '30', 'G' => '30', 'H' => '30', 'I' => '30', 'J' => '30', 'K' => '30', 'L' => '30', 'M' => '30', 'N' => '30', 'O' => '30', 'P' => '30', 'Q' => '30', 'R' => '30', 'S' => '30'));
      
      $this->setBackgroundColor($sheet29, array('A1','B1','C1','D1','E1','F1','G1','H1','I1','J1','K1','L1','M1','N1','O1','P1','Q1','R1','S1'), '017DC5');
      
      $stats_montmin_herbertypes = $model->getMontminStats();
      
      if ( !empty($stats_montmin_herbertypes) ) {      
        $i = 2;
        foreach($stats_montmin_herbertypes as $tauxocc_hebertype) {        
          $sheet29->setCellValue('A'.$i, $tauxocc_hebertype->hosting_type_name); 
          $sheet29->setCellValue('B'.$i, $tauxocc_hebertype->owner_lastname.' '.$tauxocc_hebertype->owner_name);
          $sheet29->setCellValue('C'.$i, $tauxocc_hebertype->hostingname); 
          $sheet29->setCellValue('D'.$i, $tauxocc_hebertype->adress_owner);
          $sheet29->setCellValue('E'.$i, $tauxocc_hebertype->cp_owner);
          $sheet29->setCellValue('F'.$i, $tauxocc_hebertype->ville_owner);
          $sheet29->setCellValue('G'.$i, $tauxocc_hebertype->adress);
          $sheet29->setCellValue('H'.$i, $tauxocc_hebertype->phone);
          $sheet29->setCellValue('I'.$i, $tauxocc_hebertype->email);
          $sheet29->setCellValue('J'.$i, $tauxocc_hebertype->desc_classement);
          $sheet29->setCellValue('K'.$i, $tauxocc_hebertype->nom_label);
          $sheet29->setCellValue('L'.$i, $tauxocc_hebertype->numero_classement);
          $sheet29->setCellValue('M'.$i, $tauxocc_hebertype->numero_classement);
          $sheet29->setCellValue('N'.$i, $tauxocc_hebertype->numero_classement); 
          if ( $tauxocc_hebertype->pers_occup_total > '0' ) {
            $sheet22->setCellValue('O'.$i, ($tauxoc_communes->nb_total_personnes/$tauxoc_communes->pers_occup_total)*100);
          }
          $sheet29->setCellValue('P'.$i, $tauxocc_hebertype->capacite_chambres);
          $sheet29->setCellValue('Q'.$i, $tauxocc_hebertype->nb_total_personnes);
          $sheet29->setCellValue('R'.$i, $tauxocc_hebertype->total_nuitee);
          $sheet29->setCellValue('S'.$i, $tauxocc_hebertype->total_taux_occupation);  
          $i++;                
        }
      }
      
      $montmin_types = $model->getTotalByHeberType('Montmin');
      $nb_item_montmin = count($stats_montmin_herbertypes);
      $nb_item_montmin = $nb_item_montmin+3;
            
      foreach($montmin_types as $type) {              
        $sheet29->setCellValue('B'.$nb_item_montmin, 'Total '.$type->name);
        $sheet29->setCellValue('C'.$nb_item_montmin, $type->total_type);
        $nb_item_montmin++; 
      }
      
      // Stats pour Saint-ferreol
      $sheet30 = $workbook->createSheet();
      
      $sheet30->setTitle('Saint-ferreol');
      
      $this->_setCommunesEntetes($sheet30);
      
      // Appliquer un style aux titres des deux colonnes
      $style = $this->setStyle($sheet30, 'A1');
      $sheet30->duplicateStyle($style,'B1:S1');
      $this->setColumnWidth($sheet30,array('A'=>'28', 'B' => '30', 'C' => '30', 'D' => '30', 'E' => '30', 'F' => '30', 'G' => '30', 'H' => '30', 'I' => '30', 'J' => '30', 'K' => '30', 'L' => '30', 'M' => '30', 'N' => '30', 'O' => '30', 'P' => '30', 'Q' => '30', 'R' => '30', 'S' => '30'));
      
      $this->setBackgroundColor($sheet30, array('A1','B1','C1','D1','E1','F1','G1','H1','I1','J1','K1','L1','M1','N1','O1','P1','Q1','R1','S1'), '017DC5');
      
      $stats_saintferreol_herbertypes = $model->getSaintferreolStats();
      
      if ( !empty($stats_saintferreol_herbertypes) ) {      
        $i = 2;
        foreach($stats_saintferreol_herbertypes as $tauxocc_hebertype) {        
          $sheet30->setCellValue('A'.$i, $tauxocc_hebertype->hosting_type_name); 
          $sheet30->setCellValue('B'.$i, $tauxocc_hebertype->owner_lastname.' '.$tauxocc_hebertype->owner_name);
          $sheet30->setCellValue('C'.$i, $tauxocc_hebertype->hostingname); 
          $sheet30->setCellValue('D'.$i, $tauxocc_hebertype->adress_owner);
          $sheet30->setCellValue('E'.$i, $tauxocc_hebertype->cp_owner);
          $sheet30->setCellValue('F'.$i, $tauxocc_hebertype->ville_owner);
          $sheet30->setCellValue('G'.$i, $tauxocc_hebertype->adress);
          $sheet30->setCellValue('H'.$i, $tauxocc_hebertype->phone);
          $sheet30->setCellValue('I'.$i, $tauxocc_hebertype->email);
          $sheet30->setCellValue('J'.$i, $tauxocc_hebertype->desc_classement);
          $sheet30->setCellValue('K'.$i, $tauxocc_hebertype->nom_label);
          $sheet30->setCellValue('L'.$i, $tauxocc_hebertype->numero_classement);
          $sheet30->setCellValue('M'.$i, $tauxocc_hebertype->numero_classement);
          $sheet30->setCellValue('N'.$i, $tauxocc_hebertype->numero_classement); 
          if ( $tauxocc_hebertype->pers_occup_total > '0' ) {
            $sheet30->setCellValue('O'.$i, ($tauxoc_communes->nb_total_personnes/$tauxoc_communes->pers_occup_total)*100);
          }
          $sheet30->setCellValue('P'.$i, $tauxocc_hebertype->capacite_chambres);
          $sheet30->setCellValue('Q'.$i, $tauxocc_hebertype->nb_total_personnes);
          $sheet30->setCellValue('R'.$i, $tauxocc_hebertype->total_nuitee);
          $sheet30->setCellValue('S'.$i, $tauxocc_hebertype->total_taux_occupation);  
          $i++;                
        }
      }
      
      $saintferreol_types = $model->getTotalByHeberType('Saint-Ferréol');
      $nb_item_saintferreol = count($stats_saintferreol_herbertypes);
      $nb_item_saintferreol = $nb_item_saintferreol+3;
            
      foreach($saintferreol_types as $type) {              
        $sheet30->setCellValue('B'.$nb_item_saintferreol, 'Total '.$type->name);
        $sheet30->setCellValue('C'.$nb_item_saintferreol, $type->total_type);
        $nb_item_saintferreol++; 
      }
      
      // Stats pour Seythenex
      $sheet31 = $workbook->createSheet();
      
      $sheet31->setTitle('Seythenex');
      
      $this->_setCommunesEntetes($sheet31);
      
      // Appliquer un style aux titres des deux colonnes
      $style = $this->setStyle($sheet31, 'A1');
      $sheet31->duplicateStyle($style,'B1:S1');
      $this->setColumnWidth($sheet31,array('A'=>'28', 'B' => '30', 'C' => '30', 'D' => '30', 'E' => '30', 'F' => '30', 'G' => '30', 'H' => '30', 'I' => '30', 'J' => '30', 'K' => '30', 'L' => '30', 'M' => '30', 'N' => '30', 'O' => '30', 'P' => '30', 'Q' => '30', 'R' => '30', 'S' => '30'));
      
      $this->setBackgroundColor($sheet31, array('A1','B1','C1','D1','E1','F1','G1','H1','I1','J1','K1','L1','M1','N1','O1','P1','Q1','R1','S1'), '017DC5');
      
      $stats_seythenex_herbertypes = $model->getSeythenexStats();
      
      if ( !empty($stats_seythenex_herbertypes) ) {      
        $i = 2;
        foreach($stats_seythenex_herbertypes as $tauxocc_hebertype) {        
          $sheet31->setCellValue('A'.$i, $tauxocc_hebertype->hosting_type_name); 
          $sheet31->setCellValue('B'.$i, $tauxocc_hebertype->owner_lastname.' '.$tauxocc_hebertype->owner_name);
          $sheet31->setCellValue('C'.$i, $tauxocc_hebertype->hostingname); 
          $sheet31->setCellValue('D'.$i, $tauxocc_hebertype->adress_owner);
          $sheet31->setCellValue('E'.$i, $tauxocc_hebertype->cp_owner);
          $sheet31->setCellValue('F'.$i, $tauxocc_hebertype->ville_owner);
          $sheet31->setCellValue('G'.$i, $tauxocc_hebertype->adress);
          $sheet31->setCellValue('H'.$i, $tauxocc_hebertype->phone);
          $sheet31->setCellValue('I'.$i, $tauxocc_hebertype->email);
          $sheet31->setCellValue('J'.$i, $tauxocc_hebertype->desc_classement);
          $sheet31->setCellValue('K'.$i, $tauxocc_hebertype->nom_label);
          $sheet31->setCellValue('L'.$i, $tauxocc_hebertype->numero_classement);
          $sheet31->setCellValue('M'.$i, $tauxocc_hebertype->numero_classement);
          $sheet31->setCellValue('N'.$i, $tauxocc_hebertype->numero_classement); 
          if ( $tauxocc_hebertype->pers_occup_total > '0' ) {
            $sheet31->setCellValue('O'.$i, ($tauxoc_communes->nb_total_personnes/$tauxoc_communes->pers_occup_total)*100);
          }
          $sheet31->setCellValue('P'.$i, $tauxocc_hebertype->capacite_chambres);
          $sheet31->setCellValue('Q'.$i, $tauxocc_hebertype->nb_total_personnes);
          $sheet31->setCellValue('R'.$i, $tauxocc_hebertype->total_nuitee);
          $sheet31->setCellValue('S'.$i, $tauxocc_hebertype->total_taux_occupation);  
          $i++;                
        }
      }
      
      $seythenex_types = $model->getTotalByHeberType('Seythenex');
      $nb_item_seythenex = count($stats_seythenex_herbertypes);
      $nb_item_seythenex = $nb_item_seythenex+3;
            
      foreach($seythenex_types as $type) {              
        $sheet30->setCellValue('B'.$nb_item_seythenex, 'Total '.$type->name);
        $sheet30->setCellValue('C'.$nb_item_seythenex, $type->total_type);
        $nb_item_seythenex++; 
      }
      
      $sheet2 = $workbook->createSheet();
      //JText::_('COM_GESTTAXESEJOUR_STATS_TAUX_OCCUPATION_PAR_TYPE_HEBERGEMENT_TYPE')
      $sheet2->setTitle('Stats par type d\'hébergement');
      
      $sheet2->setCellValue('A1',JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_HEBERGEMENT_TYPE'));
      $sheet2->setCellValue('B1',JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_TAUX_OCCUPATION'));
      $sheet2->setCellValue('C1',JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_TOTAL_CAPACITE_CHAMBRES'));
      $sheet2->setCellValue('D1',JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_TOTAL_CAPACITE_PERSONNES'));
      
      // Appliquer un style aux titres des deux colonnes
      $style = $this->setStyle($sheet2, 'A1');
      $sheet2->duplicateStyle($style,'B1:D1');
      $this->setColumnWidth($sheet2,array('A'=>'28', 'B' => '30', 'C' => '30', 'D' => '30'));
      
      $this->setBackgroundColor($sheet2, array('A1','B1','C1','D1'), '017DC5');
      
      // Taux d'occupation par type d'hébergement
      $tauxoccupationherbertypes = $model->getTauxOccupationStatsHeberTypes();
            
      $i = 2;
      foreach($tauxoccupationherbertypes as $tauxocc_hebertype) {        
        $sheet2->setCellValue('A'.$i, $tauxocc_hebertype->hosting_type_name); 
        if ( $tauxocc_hebertype->pers_occup_total > '0' ) {
          $sheet2->setCellValue('B'.$i, ($tauxoc_communes->nb_total_personnes/$tauxoc_communes->pers_occup_total)*100);
        }
        $sheet2->setCellValue('C'.$i, $tauxocc_hebertype->nb_total_personnes); 
        $sheet2->setCellValue('D'.$i, $tauxocc_hebertype->pers_occup_total);                 
      } 
      
      $taxesejourstats = $model->getTaxeSejourStats();
      
      $sheet3 = $workbook->createSheet();
      //JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_PAR_COMMUNES')
      $sheet3->setTitle('Stats par globales par commune');
      
      $sheet3->setCellValue('A1',JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_NOM_COMMUNE'));
      $sheet3->setCellValue('B1',JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_DUREE_SEJOUR'));
      $sheet3->setCellValue('C1',JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_NB_PERSONNES_ASSUJETTIES'));
      $sheet3->setCellValue('D1',JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_MONTANT_ENCAISSE_PAR_SEJOUR'));
      
      // Appliquer un style aux titres des deux colonnes
      $style = $this->setStyle($sheet3, 'A1');
      $sheet3->duplicateStyle($style,'B1:D1');             
      $this->setColumnWidth($sheet3,array('A'=>'28', 'B' => '30', 'C' => '30', 'D' => '30'));
      
      $this->setBackgroundColor($sheet3, array('A1','B1','C1','D1'), '017DC5');
      
      $i = 2;
      foreach($taxesejourstats as $taxesejour) {
        $sheet3->setCellValue('A'.$i, $taxesejour->city);
        $sheet3->setCellValue('B'.$i, $taxesejour->duree_sejour_total);
        $sheet3->setCellValue('C'.$i, $taxesejour->nb_pers_assujetties_total);
        $sheet3->setCellValue('D'.$i, $taxesejour->montant_enc_sejour_total);
        $i++; 
      }
      
      // Récupération des données de statistiques globales
      $taxesejourstatsglobal = $model->getTaxeSejourGlobalStats(); 
      
      $sheet4 = $workbook->createSheet();
      //JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_GLOBAL')
      $sheet4->setTitle('Stats par globales');
      
      $sheet4->setCellValue('A1',JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_DUREE_SEJOUR'));
      $sheet4->setCellValue('B1',JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_NB_PERSONNES_ASSUJETTIES'));
      $sheet4->setCellValue('C1',JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_MONTANT_ENCAISSE_PAR_SEJOUR'));      
      
      // Appliquer un style aux titres des deux colonnes
      $style = $this->setStyle($sheet4, 'A1');
      $sheet4->duplicateStyle($style,'B1:C1');                   
      $this->setColumnWidth($sheet4,array('A'=>'28', 'B' => '30', 'C' => '30'));
      
      $this->setBackgroundColor($sheet4, array('A1','B1','C1'), '017DC5');
      
      $i = 2;
      foreach($taxesejourstatsglobal as $taxesejour) {        
        $sheet4->setCellValue('A'.$i, $taxesejour->duree_sejour_total);
        $sheet4->setCellValue('B'.$i, $taxesejour->nb_pers_assujetties_total);
        $sheet4->setCellValue('C'.$i, $taxesejour->montant_enc_sejour_total);
        $i++;                 
      }
      
      // Enregistrement du fichier
      $writer = new PHPExcel_Writer_Excel2007($workbook);      
      $records = JPATH_ADMINISTRATOR.'/components/com_gesttaxesejour/TDS_Stats/statistiques_taxe_sejour.xlsx';
      $writer->save($records);
      
      $this->app->enqueueMessage ( JText::sprintf('COM_GESTTAXESEJOUR_STATS_EXPORT_DONE','<a style="color:red;" href="'.JURI::root().'/administrator/components/com_gesttaxesejour/TDS_Stats/statistiques_taxe_sejour.xlsx">téléchargez le fichier</a>') );       
      $this->app->redirect($this->baseurl);      
    }      
  }
  
  protected function _setCommunesEntetes($sheet) {
    $sheet->setCellValue('A1',JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_HEBERGEMENT_TYPE'));
    $sheet->setCellValue('B1',JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_OWNER_NAME'));
    $sheet->setCellValue('C1',JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_ETABLISSEMENT_NAME'));
    $sheet->setCellValue('D1',JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_ADRESS_OWNER'));
    $sheet->setCellValue('E1',JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_CP_OWNER'));
    $sheet->setCellValue('F1',JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_VILLE_OWNER'));
    $sheet->setCellValue('G1',JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_ADRESS_ETABLISSEMENT'));
    $sheet->setCellValue('H1',JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_TEL_ETABLISSEMENT'));
    $sheet->setCellValue('I1',JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_MAIL_ETABLISSEMENT'));
    $sheet->setCellValue('J1',JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_CLASSEMENT'));
    $sheet->setCellValue('K1',JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_LABEL'));
    $sheet->setCellValue('L1',JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_NUMERO_CLASSEMENT'));
    $sheet->setCellValue('M1',JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_TOTAL_NUITEE'));
    $sheet->setCellValue('N1',JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_MONTANT_TOTAL_ENCAISSE'));
    $sheet->setCellValue('O1',JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_TAUX_OCCUPATION'));
    $sheet->setCellValue('P1',JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_TOTAL_CAPACITE_CHAMBRES'));
    $sheet->setCellValue('Q1',JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_TOTAL_CAPACITE_PERSONNES'));
    $sheet->setCellValue('R1',JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_TOTAL_NUITEE'));
    $sheet->setCellValue('S1',JText::_('COM_GESTTAXESEJOUR_STATS_TAXE_SEJOUR_TOTAL_TAUX_OCCUPATION'));
  }
  
  protected function setColumnWidth($sheet,$dimensions) {  
    foreach($dimensions as $col=>$width) {
      $sheet->getColumnDimension($col)->setWidth($width);
    }
  }
  
  protected function setStyle($sheet, $case) {
      $style = $sheet->getStyle($case);
      $style->applyFromArray(array(
        'font'=>array(
        'bold'=>true,
        'size'=>13,
        'name'=>'Arial' )
      ));
      
      return $style;
  }
  
  protected function setBackgroundColor($sheet, $colonum, $color) {
    if ( is_array($colonum) ) {
      foreach($colonum as $col) {
        $sheet->getStyle($col)->applyFromArray(array( 
            'fill'=>array(
                'type'=>PHPExcel_Style_Fill::FILL_SOLID,
                'color'=>array(
                    'argb'=>$color))));
      }
    } else {
      $sheet->getStyle($colonum)->applyFromArray(array( 
            'fill'=>array(
                'type'=>PHPExcel_Style_Fill::FILL_SOLID,
                'color'=>array(
                    'argb'=>$color))));
    }     
  }
}