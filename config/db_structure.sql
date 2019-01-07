-- Adminer 4.1.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `pass` varchar(40) NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `historique`;
CREATE TABLE `historique` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_login` varchar(70) NOT NULL,
  `partage_chemin` varchar(1000) NOT NULL,
  `date` datetime NOT NULL,
  `action` varchar(20) NOT NULL,
  `email` varchar(70) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `parametres`;
CREATE TABLE `parametres` (
  `id_params` int(11) NOT NULL AUTO_INCREMENT,
  `page_titre` varchar(50) NOT NULL,
  `accueil_texte` varchar(6000) NOT NULL,
  `email_expediteur` varchar(50) NOT NULL,
  `email_sujet` varchar(100) NOT NULL,
  `email_corps` varchar(2000) NOT NULL,
  `email_corps_2` varchar(2000) NOT NULL,
  `email_texte_bouton` varchar(50) NOT NULL,
  `email_footer` varchar(2000) NOT NULL,
  `couleur_fond` varchar(8) NOT NULL,
  `dossier_data` varchar(500) NOT NULL,
  `url_domaine` varchar(500) NOT NULL,
  `analytics` varchar(2000) NOT NULL,
  `partage_dossier` tinyint(4) NOT NULL,
  `net_iface` varchar(10) NOT NULL,
  PRIMARY KEY (`id_params`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `partage`;
CREATE TABLE `partage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chemin` varchar(1000) NOT NULL,
  `email` varchar(60) NOT NULL,
  `type_partage` varchar(20) NOT NULL,
  `cle` varchar(40) NOT NULL,
  `date` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `admin_login` varchar(50) NOT NULL,
  `np_post` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2019-01-07 07:36:06
