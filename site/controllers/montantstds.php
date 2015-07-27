<?php
/**
 * @package		Tdsmanager.Site
 * @subpackage	Tdsmanager
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
*/

defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

class TdsmanagerControllerMontantstds extends JControllerLegacy {
	/**
	 * Ecriture des fichiers textes pour les montants de la taxe de séjour pour être intégré dans le logiciel mesbacs
	 * 
	 * @return void
	 */
	public function writefile()
	{
		jimport('joomla.log.log');
		
		// On crée un nouveau fichier de log avec une date pour trier les précédents
		JLog::addLogger(
			array(
				'text_file' => 'com_tdsmanager.montantstds.' . date('Y-m-d') . 'log.php'
			),
			JLog::ALL,
			'com_tdsmanager'
		);
		
		$path = JPATH_ROOT . '/tds_mesbacs';
		
		if (!JFolder::exists($path))
		{
			JFolder::create($path);
		}
		
		// On supprime les fichiers dat�s de plus de 7 jours
		if ($handle = opendir($path))
		{
			while (false !== ($file = readdir($handle)))
			{ 
				$filelastmodified = filemtime($path . '/' . $file);
				//24 hours in a day * 3600 seconds per hour
				if((time() - $filelastmodified) > 7*24*3600)
				{
					unlink($path . '/' . $file);
				}
			}

			closedir($handle); 
		}
		
		// Les fichiers contiennent des tabulations pour séparer les éléments de chaque colonne
		$date = JFactory::getDate();
		
		$hebergeurs = $path . '/hebergeurs' .$date->format('d-m-Y'). '.txt';
		$hebergements = $path . '/hebergements' .$date->format('d-m-Y'). '.txt';
	
		$dataHebergeurs = 'Id' . "\t" . 'Nom etablissement' . "\t" . 'Prenom' . "\t" . 'Enseigne' . "\t" . 'Num' . "\t" . 'Rue' . "\t" . 'Responsable' . "\t" . 'Nom mandataire' . "\t" . 'Lieu dit' . "\t" . 'Code postal' . "\t" . 'Ville' . "\t" . 'Pays' . "\t" . 'Tel1' . "\t" . 'Tel2' . "\t" . 'Courriel' . "\t" . 'SIRET';
		$writeHebergeurs = JFile::write($hebergeurs, $dataHebergeurs);
		
		if ($writeHebergeurs)
		{
			JLog::add(
				"Le fichier texte des hébergeurs a bien été enregistré", JLog::INFO, 'com_tdsmanager.montantstds'
			);
		}
		else
		{
			JLog::add(
				"Le fichier texte des hébergeurs n'a pas pu être enregistré", JLog::INFO, 'com_tdsmanager.montantstds'
			);
		}
		
		$dataHebergements = 'HEBERGEMENTS' . "\t" . 'HEBERGEURS' . "\t" . 'Nom' . "\t" . 'Type' . "\t" . 'Classement' . "\t" . 'Num' . "\t" . 'Nom rue' . "\t" . 'Complement' . "\t" . 'Code postal' . "\t" . 'Nom ville' . "\t" . 'Label' . "\t" . 'Numero' . "\t" . 'MNT01' . "\t" . 'MNT02' . "\t" . 'MNT03' . "\t" . 'MNT04';
		$writeHebergements = JFile::write($hebergements, $dataHebergements);
		
		if ($writeHebergements)
		{
			JLog::add(
				"Le fichier texte des hébergements a bien été enregistré", JLog::INFO, 'com_tdsmanager.montantstds'
			);
		}
		else 
		{
			JLog::add(
				"Le fichier texte des hébergements n'a pas pu être enregistré", JLog::INFO, 'com_tdsmanager.montantstds'
			);
		}
	}
}