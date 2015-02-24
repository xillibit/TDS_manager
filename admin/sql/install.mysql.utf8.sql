--
-- Structure de la table `#__tdsmanager_alertes`
--

CREATE TABLE IF NOT EXISTS `#__tdsmanager_alertes` (
  `date_envoi` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `declaration_id` int(11) NOT NULL,
  `reglement_id` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `#__tdsmanager_attachments`
--

CREATE TABLE IF NOT EXISTS `#__tdsmanager_attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `size` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `#__tdsmanager_classements`
--

CREATE TABLE IF NOT EXISTS `#__tdsmanager_classements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `state` int(7) NOT NULL DEFAULT '0',
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Structure de la table `#__tdsmanager_declarations`
--

CREATE TABLE IF NOT EXISTS `#__tdsmanager_declarations` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`trimestre` char(15) NOT NULL,
	`mois` char(10) NOT NULL,
	`hebergement_id` int(11) NOT NULL,
	`nb_personnes_par_nuite` int(11) NOT NULL,
	`nb_personnes_exonerees` int(11) NOT NULL,
	`total_declare` float(7,4) NOT NULL,
	`date_declaration` date NOT NULL DEFAULT '0000-00-00',
	`exactitude` int(4),
	`user_id` int(11), 
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `#__tdsmanager_dispos`
--

CREATE TABLE IF NOT EXISTS `#__tdsmanager_dispos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `startdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `enddate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `id_hebergement` int(11) NOT NULL,
  `chambres_selected` int(11) NOT NULL,
  `chambres_max` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `#__tdsmanager_hebergclass`
--

CREATE TABLE IF NOT EXISTS `#__tdsmanager_hebergclass` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_hebergement` int(11) NOT NULL,
  `id_classement` int(11) NOT NULL,
  `tarif` float(7,2) NOT NULL,
  `userid` int(11) NOT NULL,
  `id_hebergement_type` int(11) NOT NULL,
  `id_hebergement_label` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Structure de la table `#__tdsmanager_hebergements`
--

CREATE TABLE IF NOT EXISTS `#__tdsmanager_hebergements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL DEFAULT '',
  `adress` varchar(255) NOT NULL DEFAULT '',
  `complement_adress` varchar(255) NOT NULL DEFAULT '',
  `postalcode` int(7) unsigned NOT NULL DEFAULT '0',
  `latitude` decimal(5,2) DEFAULT NULL,
  `longitude` decimal(5,2) DEFAULT NULL,
  `owner_lastname` char(255) NOT NULL,
  `id_classement` tinyint(7) unsigned NOT NULL DEFAULT '0',
  `date_classement` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `numero_classement` varchar(28) NOT NULL DEFAULT '0',
  `city` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `owner_name` varchar(255) NOT NULL,
  `hostingname` varchar(255) NOT NULL,
  `capacite_chambres` int(11) NOT NULL DEFAULT '0',
  `capacite_personnes` int(11) NOT NULL DEFAULT '0',
  `id_hebergement_type` int(11) NOT NULL,
  `id_hebergement_label` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `date_enregistre` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `nb_chambres_max` int(11) NOT NULL,
  `date_visite` int(5) NOT NULL,
  `date_expiration` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Structure de la table `#__tdsmanager_hebergements_label`
--

CREATE TABLE IF NOT EXISTS `#__tdsmanager_hebergements_label` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Structure de la table `#__tdsmanager_hebergements_type`
--

CREATE TABLE IF NOT EXISTS `#__tdsmanager_hebergements_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL,
  `state` int(7) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Structure de la table `#__tdsmanager_methods_paiement`
--

CREATE TABLE IF NOT EXISTS `#__tdsmanager_methods_paiement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `state` int(11) NOT NULL,
  `alias` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Structure de la table `#__tdsmanager_paiement_done`
--

CREATE TABLE IF NOT EXISTS `#__tdsmanager_paiement_done` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `decl_id` int(7) NOT NULL,
  `paiement_type` int(6) NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `#__tdsmanager_periode_ouverture`
--

CREATE TABLE IF NOT EXISTS `#__tdsmanager_periode_ouverture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_fermeture` date NOT NULL,
  `date_ouverture` date NOT NULL,
  `motif` varchar(255) NOT NULL,
  `id_hebergement` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Structure de la table `#__tdsmanager_reglements`
--

CREATE TABLE IF NOT EXISTS `#__tdsmanager_reglements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_regler` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `montant` decimal(5,2) DEFAULT NULL,
  `type_reglement` varchar(255) NOT NULL,
  `declaration_id` int(11) NOT NULL,
  `finaliser` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Structure de la table `#__tdsmanager_tarif_nuit`
--

CREATE TABLE IF NOT EXISTS `#__tdsmanager_tarif_nuit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tarif` float(7,2) NOT NULL,
  `id_classement` int(11) NOT NULL DEFAULT '0',
  `id_hebergement_type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `#__tdsmanager_users`
--

CREATE TABLE IF NOT EXISTS `#__tdsmanager_users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `adress` varchar(255) NOT NULL DEFAULT '',
  `complement_adress` varchar(255) NOT NULL DEFAULT '',
  `postalcode` int(11) unsigned NOT NULL DEFAULT '0',
  `ville` varchar(255) NOT NULL,
  `telephone` char(11) NOT NULL,
  `portable` char(13) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
-- --------------------------------------------------------

--
-- Structure de la table `#__tdsmanager_users_hosting_owned`
--

CREATE TABLE IF NOT EXISTS `#__tdsmanager_users_hosting_owned` (
	`hosting_id` int(11),
	`user_id` int(11)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;