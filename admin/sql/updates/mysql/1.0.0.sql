--
-- Structure de la table `swbkc_gesttaxesejour_alertes`
--

CREATE TABLE IF NOT EXISTS `#__gesttaxesejour_alertes` (
  `date_envoi` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `declaration_id` int(11) NOT NULL,
  `reglement_id` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `swbkc_gesttaxesejour_attachments`
--

CREATE TABLE IF NOT EXISTS `#__gesttaxesejour_attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `size` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Structure de la table `swbkc_gesttaxesejour_classements`
--

CREATE TABLE IF NOT EXISTS `#__gesttaxesejour_classements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `state` int(7) NOT NULL DEFAULT '0',
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;


-- --------------------------------------------------------

--
-- Structure de la table `swbkc_gesttaxesejour_declarations`
--

CREATE TABLE IF NOT EXISTS `#__gesttaxesejour_declarations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_date` date NOT NULL DEFAULT '0000-00-00',
  `end_date` date NOT NULL DEFAULT '0000-00-00',
  `mois` tinyint(4) NOT NULL,
  `hebergement_id` int(11) NOT NULL,
  `nb_personnes_plein_tarif` int(11) NOT NULL,
  `tarif_nuit_par_personne` float(7,2) NOT NULL,
  `nb_nuitees_duree_sejour` int(11) NOT NULL,
  `sous_total` float(7,3) NOT NULL,
  `nb_personnes_reduction_30` int(11) NOT NULL,
  `nb_personnes_reduction_40` int(11) NOT NULL,
  `nb_personnes_reduction_50` int(11) NOT NULL,
  `nb_personnes_reduction_75` int(11) NOT NULL,
  `nb_nuitees_30` int(11) NOT NULL,
  `nb_nuitees_40` int(11) NOT NULL,
  `nb_nuitees_50` int(11) NOT NULL,
  `nb_nuitees_75` int(11) NOT NULL,
  `nb_personnes_exonerees` int(11) NOT NULL,
  `sous_total2` float(7,4) NOT NULL,
  `montant_total` float(7,4) NOT NULL,
  `date_declarer` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `swbkc_gesttaxesejour_dispos`
--

CREATE TABLE IF NOT EXISTS `#__gesttaxesejour_dispos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `startdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `enddate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `id_hebergement` int(11) NOT NULL,
  `chambres_selected` int(11) NOT NULL,
  `chambres_max` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Structure de la table `swbkc_gesttaxesejour_hebergclass`
--

CREATE TABLE IF NOT EXISTS `#__gesttaxesejour_hebergclass` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_hebergement` int(11) NOT NULL,
  `id_classement` int(11) NOT NULL,
  `tarif` float(7,2) NOT NULL,
  `userid` int(11) NOT NULL,
  `id_hebergement_type` int(11) NOT NULL,
  `id_hebergement_label` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=222 ;


-- --------------------------------------------------------

--
-- Structure de la table `swbkc_gesttaxesejour_hebergements`
--

CREATE TABLE IF NOT EXISTS `#__gesttaxesejour_hebergements` (
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
  `numero_agrement` varchar(28) NOT NULL DEFAULT '0',
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=220 ;


-- --------------------------------------------------------

--
-- Structure de la table `swbkc_gesttaxesejour_hebergements_label`
--

CREATE TABLE IF NOT EXISTS `#__gesttaxesejour_hebergements_label` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;


-- --------------------------------------------------------

--
-- Structure de la table `swbkc_gesttaxesejour_hebergements_type`
--

CREATE TABLE IF NOT EXISTS `#__gesttaxesejour_hebergements_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL,
  `state` int(7) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;


-- --------------------------------------------------------

--
-- Structure de la table `swbkc_gesttaxesejour_methods_paiement`
--

CREATE TABLE IF NOT EXISTS `#__gesttaxesejour_methods_paiement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `state` int(11) NOT NULL,
  `alias` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;


-- --------------------------------------------------------

--
-- Structure de la table `swbkc_gesttaxesejour_paiement_done`
--

CREATE TABLE IF NOT EXISTS `#__gesttaxesejour_paiement_done` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `decl_id` int(7) NOT NULL,
  `paiement_type` int(6) NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `swbkc_gesttaxesejour_periode_ouverture`
--

CREATE TABLE IF NOT EXISTS `#__gesttaxesejour_periode_ouverture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_fermeture` date NOT NULL,
  `date_ouverture` date NOT NULL,
  `motif` varchar(255) NOT NULL,
  `id_hebergement` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;


-- --------------------------------------------------------

--
-- Structure de la table `swbkc_gesttaxesejour_reglements`
--

CREATE TABLE IF NOT EXISTS `#__gesttaxesejour_reglements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_regler` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `montant` decimal(5,2) DEFAULT NULL,
  `type_reglement` varchar(255) NOT NULL,
  `declaration_id` int(11) NOT NULL,
  `finaliser` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;


-- --------------------------------------------------------

--
-- Structure de la table `swbkc_gesttaxesejour_tarif_nuit`
--

CREATE TABLE IF NOT EXISTS `#__gesttaxesejour_tarif_nuit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tarif` float(7,2) NOT NULL,
  `id_classement` int(11) NOT NULL DEFAULT '0',
  `id_hebergement_type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

-- --------------------------------------------------------

--
-- Structure de la table `swbkc_gesttaxesejour_users`
--

CREATE TABLE IF NOT EXISTS `#__gesttaxesejour_users` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=220 ;
