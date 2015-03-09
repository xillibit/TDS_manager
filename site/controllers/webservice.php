<?php
/**
 * @package		Tdsmanager.Site
 * @subpackage	Tdsmanager
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

class TdsmanagerControllerWebservice extends JControllerLegacy {
	/**
	 * Méthode appelé par le logiciel en cas de mise à jour ou d'ajout d'éléments
	 */
	public function update() {
		$jinput = JFactory::getApplication()->input;

		$data = $jinput->get('data', null, 'string');

		if ( !empty($data) )
		{
			jimport('joomla.log.log');

			// On crée un nouveau fichier de log avec une date pour trier les précédents
			JLog::addLogger(
				array(
					'text_file' => 'com_tdsmanager.' . date('Y-m-d') . 'log.php'
				),
				JLog::ALL,
				'com_tdsmanager'
			);

			$data = json_decode($data);

			$values = new stdClass();
			$values->id = '';
			$values->classement = '';
			$values->label = '';
			$values->adress = '';
			$values->complement_adress = '';
			$values->postalcode = '';
			$values->ville = '';
			$values->pays = '';
			$values->telephone = '';
			$values->portable = '';
			$values->name = '';
			$values->lastname = '';
			$values->courriel = '';
			$values->agrement = '';
			$values->date_visite = '';
			$values->date_expiration  = '';
			$values->libelle_activite = '';
			$values->non_classe = '';
			$values->categorie_1 = '';
			$values->categorie_2 = '';
			$values->categorie_3 = '';
			$values->categorie_4 = '';
			$values->categorie_5 = '';

			$type = $data[0]->type;
			$mise_a_jour = $data[0]->mise_a_jour;

			if ($type=='hebergeur')
			{
				if ( !empty($data[0]->id) ) $values->id = $data[0]->id;
				if ( !empty($data[0]->rue) ) $values->adress = $data[0]->rue;
				if ( !empty($data[0]->lieudit) ) $values->complement_adress  = $data[0]->lieudit;
				if ( !empty($data[0]->code_postal) )  $values->postalcode = $data[0]->code_postal;
				if ( !empty($data[0]->ville) ) $values->ville = $data[0]->ville;
				if ( !empty($data[0]->pays) ) $values->pays = $data[0]->pays;
				if ( !empty($data[0]->telephone) ) $values->telephone = $data[0]->telephone;
				if ( !empty($data[0]->nom) ) $values->name = $data[0]->nom;
				if ( !empty($data[0]->courriel) )  $values->courriel = $data[0]->courriel;

				if ($mise_a_jour)
				{
					$this->updateHerbergeur($values);
				}
				else
				{
					$this->addHerbergeur($values);
				}
			}
			else if ($type=='hebergement')
			{
				if ( !empty($data[0]->id) ) $values->id = $data[0]->id;
				if ( !empty($data[0]->nom) ) $values->name = $data[0]->nom;
				if ( !empty($data[0]->libelle_activite) ) $values->libelle_activite = $data[0]->libelle_activite;
				if ( !empty($data[0]->classement) ) $values->classement = $data[0]->classement;
				if ( !empty($data[0]->nom_rue) ) $values->adress = $data[0]->nom_rue;
				if ( !empty($data[0]->complement) ) $values->complement_adress = $data[0]->complement;
				if ( !empty($data[0]->code_postal) ) $values->postalcode = $data[0]->code_postal;
				if ( !empty($data[0]->ville) ) $values->ville = $data[0]->ville;
				if ( !empty($data[0]->label) ) $values->label = $data[0]->label;
				if ( !empty($data[0]->agrement) ) $values->agrement = $data[0]->agrement;
				if ( !empty($data[0]->date_visite) ) $values->date_visite = $data[0]->date_visite;
				if ( !empty($data[0]->date_expiration) ) $values->date_expiration = $data[0]->date_expiration;

				if ($mise_a_jour)
				{
					$this->updateHerbergement($values);
				}
				else
				{
					$this->addHerbergement($values);
				}
			}
			else if ($type=='classement')
			{
				if ( !empty($data[0]->id) ) $values->id = $data[0]->id;
				if ( !empty($data[0]->nom) ) $values->nom = $data[0]->nom;

				if ($mise_a_jour)
				{
					$this->updateClassement($values);
				}
				else
				{
					$this->addClassement($values);
				}
			}
			else if ($type=='type_hebergement')
			{
				if ( !empty($data[0]->id) ) $values->id = $data[0]->id;
				if ( !empty($data[0]->libelle_activite) ) $values->libelle_activite = $data[0]->libelle_activite;
				if ( !empty($data[0]->non_classe) ) $values->non_classe = $data[0]->non_classe;
				if ( !empty($data[0]->categorie_1) ) $values->categorie_1 = $data[0]->categorie_1;
				if ( !empty($data[0]->categorie_2) ) $values->categorie_2 = $data[0]->categorie_2;
				if ( !empty($data[0]->categorie_3) ) $values->categorie_3 = $data[0]->categorie_3;
				if ( !empty($data[0]->categorie_4) ) $values->categorie_4 = $data[0]->categorie_4;
				if ( !empty($data[0]->categorie_5) ) $values->categorie_5 = $data[0]->categorie_5;

				if ($mise_a_jour)
				{
					$tarifs = new stdClass();
					$tarifs->non_classe = $values->non_classe;
					$tarifs->categorie_1 = $values->categorie_1;
					$tarifs->categorie_2 = $values->categorie_2;
					$tarifs->categorie_3 = $values->categorie_3;
					$tarifs->categorie_4 = $values->categorie_4;
					$tarifs->categorie_5 = $values->categorie_5;

					$this->updateTypehebergement($values, $tarifs);
				}
				else
				{
					$this->addTypehebergement($values);
				}
			}
		}
	}

	/**
	 * Ajout d'un nouvel hébergeur hébergeur
	 */
	protected function addHerbergeur($values)
	{
		$db = JFactory::getDbo();

		$query = "INSERT INTO #__tdsmanager_users (adress,complement_adress,postalcode,ville,telephone,portable,name,lastname,mail)
					VALUES({$db->quote($values->adress)}, {$db->quote($values->complement_adress)}, {$db->quote($values->postalcode)}, {$db->quote($values->ville)}, {$db->quote($values->telephone)}, {$db->quote($values->portable)}, {$db->quote($values->name)}, {$db->quote($values->lastname)}, {$db->quote($values->courriel)})";
		$db->setQuery($query);

		try
		{
			//$db->query();
		}
		catch (Exception $e)
		{
			JLog::add($e->getMessage(), JLog::ERROR, 'com_tdsmanager');
			return false;
		}

		JLog::add(
			"Le nouvel hébergeur ".$values->name." a bien été enregistré", JLog::INFO, 'com_tdsmanager'
		);

		return true;
	}

	/**
	 * Mis à jour d'un hébergeur existant
	 */
	protected function updateHerbergeur($values)
	{
		$db = JFactory::getDbo();

		$query = "UPDATE #__tdsmanager_users SET adress={$db->quote($values->adress)}, complement_adress={$db->quote($values->complement_adress)}, postalcode={$db->quote($values->postalcode)}, ville={$db->quote($values->ville)}, telephone={$db->quote($values->telephone)}, portable={$db->quote($values->portable)}, name={$db->quote($values->name)}, lastname={$db->quote($values->lastname)}, mail={$db->quote($values->courriel)} WHERE id=".$values->id;
		$db->setQuery($query);

		try
		{
			//$db->query();
		}
		catch (Exception $e)
		{
			JLog::add($e->getMessage(), JLog::ERROR, 'com_tdsmanager');
			return false;
		}

		JLog::add(
			"La mise à jour de l'hébergeur avec l'id ".$values->id." a bien été effectué", JLog::INFO, 'com_tdsmanager'
		);

		return true;
	}

	/**
	 * Récupére l'id du classement en fonction du nom du classement donné par le logiciel
	 */
	protected function getHebergementClassement($nom_classement)
	{
		$db = JFactory::getDbo();

		$query = "SELECT id FROM #__tdsmanager_classements WHERE description=" . $db->quote($nom_classement);
		$db->setQuery($query);

		try
		{
			$id_classement = $db->loadResult();
		}
		catch (Exception $e)
		{
			JLog::add($e->getMessage(), JLog::ERROR, 'com_tdsmanager');
			return false;
		}

		return $id_classement;
	}

	/**
	 * Ajout d'un nouvel hébergement
	 */
	protected function addHerbergement($values)
	{
		$db = JFactory::getDbo();

		$id_classement = $this->getHebergementClassement($values->classement);

		$query = "INSERT INTO #__tdsmanager_hebergements (description,adress,complement_adress,postalcode,id_classement,city,date_visite,date_expiration)
					VALUES({$db->quote($values->name)},{$db->quote($values->adress)},{$db->quote($values->complement_adress)},{$db->quote($values->postalcode)},$id_classement,{$db->quote($values->ville)},{$db->quote($values->date_visite)},{$db->quote($values->date_expiration)})";
		$db->setQuery($query);

		try
		{
			//$db->query();
		}
		catch (Exception $e)
		{
			JLog::add($e->getMessage(), JLog::ERROR, 'com_tdsmanager');
			return false;
		}

		JLog::add(
			"Le nouvel hébergement " . $values->name . " a bien été enregistré", JLog::INFO, 'com_tdsmanager'
		);

		return true;
	}

	/**
	 * Mise à jour d'un hébergement éxistant
	 */
	protected function updateHerbergement($values)
	{
		$db = JFactory::getDbo();

		$id_classement = $this->getHebergementClassement($values->classement);

		$query = "UPDATE #__tdsmanager_hebergements SET description={$db->quote($values->name)},adress={$db->quote($values->nom_rue)},complement_adress={$db->quote($values->complement)},postalcode={$db->quote($values->code_postal)},id_classement=$id_classement,city={$db->quote($values->ville)},date_visite={$db->quote($values->date_visite)},date_expiration={$db->quote($values->date_expiration)} WHERE id=".$values->id;
		$db->setQuery($query);

		try
		{
			//$db->query();
		}
		catch (Exception $e)
		{
			JLog::add($e->getMessage(), JLog::ERROR, 'com_tdsmanager');
			return false;
		}

		JLog::add(
			"La mise à jour de l'hébergement avec l'id " . $values->id . " a bien été effectué", JLog::INFO, 'com_tdsmanager'
		);

		return true;
	}

	/**
	 * Ajout d'un nouveau classement
	 */
	protected function addClassement($values)
	{
		$db = JFactory::getDbo();

		$query = "INSERT INTO #__tdsmanager_classements (description, state) VALUES({$db->quote($values->nom)},1)";
		$db->setQuery($query);

		try
		{
			//$db->query();
		}
		catch (Exception $e)
		{
			JLog::add($e->getMessage(), JLog::ERROR, 'com_tdsmanager');
			return false;
		}

		JLog::add(
			"Le nouvel classement nommé " . $values->nom . " a bien été enregistré", JLog::INFO, 'com_tdsmanager'
		);

		return true;
	}

	/**
	 * Mise à jour d'un classement éxistant
	 */
	protected function updateClassement($values)
	{
		$db = JFactory::getDbo();

		$query = "UPDATE #__tdsmanager_classements SET description={$db->quote($values->nom)} WHERE id=".$db->quote($values->id);
		$db->setQuery($query);

		try
		{
			//$db->query();
		}
		catch (Exception $e)
		{
			JLog::add($e->getMessage(), JLog::ERROR, 'com_tdsmanager');
			return false;
		}

		JLog::add(
			"Le classement avec l'id " . $values->id . " a bien été mis à jour", JLog::INFO, 'com_tdsmanager'
		);

		return true;
	}

	/**
	 * Ajout d'un nouveau type d'hébergement
	*/
	protected function addTypehebergement($values)
	{
		$db = JFactory::getDbo();

		$id_classement = $this->getHebergementClassement($values->libelle_activite);
		//$id_hebergement_type = ;

		$query = "INSERT INTO #__tdsmanager_tarif_nuit (tarif,id_classement,id_hebergement_type)
				VALUES({$db->quote($values->nom_classe)}, {$id_classement}),
				({$db->quote($values->categorie_1)}, {$id_classement}),
				({$db->quote($values->categorie_2)}, {$id_classement}),
				({$db->quote($values->categorie_3)}, {$id_classement}),
				({$db->quote($values->categorie_3)}, {$id_classement}),
				({$db->quote($values->categorie_4)}, {$id_classement}),
				({$db->quote($values->categorie_5)}, {$id_classement})";

		$db->setQuery($query);

		try
		{
			//$db->query();
		}
		catch (Exception $e)
		{
			JLog::add($e->getMessage(), JLog::ERROR, 'com_tdsmanager');
			return false;
		}

		JLog::add(
			"Les détials du type d'hébergement nommé " . $values->libelle_activite . " ont bien été enregistrés", JLog::INFO, 'com_tdsmanager'
		);

		return true;
	}

	/**
	 * Mise à jour d'un type d'hébergement existant
	*/
	protected function updateTypehebergement($values, $tarifs)
	{
		$db = JFactory::getDbo();

		foreach($tarifs as $tarif)
		{
			$query = "UPDATE #__tdsmanager_tarif_nuit SET tarif={$db->quote($tarif)} WHERE id=".$values->id;
			$db->setQuery($query);

			try
			{
				//$db->query();
			}
			catch (Exception $e)
			{
				JLog::add($e->getMessage(), JLog::ERROR, 'com_tdsmanager');
				return false;
			}
		}

		JLog::add(
			"Le type d'hébergement avec l'id " . $values->id . " a bien été mis à jour", JLog::INFO, 'com_tdsmanager'
		);

		return true;
	}
}