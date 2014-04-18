-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Ven 18 Avril 2014 à 16:54
-- Version du serveur: 5.6.12-log
-- Version de PHP: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `candidtc`
--

-- --------------------------------------------------------

--
-- Structure de la table `conditions`
--

CREATE TABLE IF NOT EXISTS `candid_conditions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rank` varchar(255) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `conditions`
--

INSERT INTO `candid_conditions` (`id`, `rank`, `content`) VALUES
(1, 'Dev', 'Pas de conditions'),
(2, 'Builder', 'Pas de conditions'),
(4, 'Redstonneur', 'Pas de conditions'),
(5, 'Graphiste', 'Pas de conditions'),
(6, 'Scenariste', 'Pas de conditions');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
