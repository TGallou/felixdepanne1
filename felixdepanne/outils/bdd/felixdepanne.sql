-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 10 mai 2019 à 15:28
-- Version du serveur :  5.7.24
-- Version de PHP :  5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `felixdepanne`
--

-- --------------------------------------------------------

--
-- Structure de la table `id_temp_tab`
--

DROP TABLE IF EXISTS `id_temp_tab`;
CREATE TABLE IF NOT EXISTS `id_temp_tab` (
  `id_temp` int(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `id_temp_tab`
--

INSERT INTO `id_temp_tab` (`id_temp`) VALUES
(1);

-- --------------------------------------------------------

--
-- Structure de la table `intervention`
--

DROP TABLE IF EXISTS `intervention`;
CREATE TABLE IF NOT EXISTS `intervention` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `laDate` varchar(255) DEFAULT NULL,
  `duree` time NOT NULL,
  `salle` varchar(255) NOT NULL,
  `numeroPoste` int(255) NOT NULL,
  `typeIntervention` varchar(255) NOT NULL,
  `coutIntervention` decimal(65,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `pannes`
--

DROP TABLE IF EXISTS `pannes`;
CREATE TABLE IF NOT EXISTS `pannes` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `numPoste` int(255) NOT NULL,
  `numSalle` varchar(255) NOT NULL,
  `objetPanne` varchar(255) NOT NULL,
  `typePanne` varchar(255) NOT NULL,
  `descriptif` varchar(255) DEFAULT NULL COMMENT 'Seulement pour "Autre"',
  `datePanne` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `droit` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  `identifiant` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `droit`, `identifiant`, `nom`, `prenom`, `email`, `password`) VALUES
(1, 'admin', 'tgallou', 'GALLOU', 'Thomas', 'thomas.gallou22@gmail.com', '$2a$10$1qAz2wSx3eDc4rFv5tGb5e9/d3RpVZLJj7oRVzR/cHeI.k6qRNUjq'),
(2, 'user', 'ghamon', 'HAMON', 'Gregoire', 'felixdepanne@gmail.com', '$2a$10$1qAz2wSx3eDc4rFv5tGb5e9/d3RpVZLJj7oRVzR/cHeI.k6qRNUjq');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
