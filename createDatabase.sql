-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 16 sep. 2021 à 15:19
-- Version du serveur :  5.7.31
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sortiedotcom`
--
DROP DATABASE IF EXISTS sortiedotcom;

CREATE DATABASE IF NOT EXISTS sortiedotcom;

-- --------------------------------------------------------

--
-- Structure de la table `annulation_sortie`
--
USE sortiedotcom;


--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
    `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
    `executed_at` datetime DEFAULT NULL,
    `execution_time` int(11) DEFAULT NULL,
    PRIMARY KEY (`version`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20210907100021', '2021-09-13 14:35:27', 568),
('DoctrineMigrations\\Version20210913071409', '2021-09-13 14:35:28', 68),
('DoctrineMigrations\\Version20210913143542', '2021-09-13 16:35:58', 90);


-- --------------------------------------------------------

--
-- Structure de la table `etat`
--

DROP TABLE IF EXISTS `etat`;
CREATE TABLE IF NOT EXISTS `etat` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `libelle` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `etat`
--

INSERT INTO `etat` (`id`, `libelle`) VALUES
(1, 'EN CREATION'),
(2, 'OUVERT'),
(3, 'COMPLET'),
(4, 'INSCRIPTION FINIE'),
(5, 'EN COURS'),
(6, 'TERMINEE'),
(7, 'ANNULEE'),
(8, 'SUPPRIMEE');

-- --------------------------------------------------------

--
-- Structure de la table `lieu`
--

DROP TABLE IF EXISTS `lieu`;
CREATE TABLE IF NOT EXISTS `lieu` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `ville_id` int(11) DEFAULT NULL,
    `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
    `rue` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
    `latitude` double NOT NULL,
    `longitude` double NOT NULL,
    PRIMARY KEY (`id`),
    KEY `IDX_2F577D59A73F0036` (`ville_id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `lieu`
--



-- --------------------------------------------------------

--
-- Structure de la table `participant`
--

DROP TABLE IF EXISTS `participant`;
CREATE TABLE IF NOT EXISTS `participant` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `site_id` int(11) NOT NULL,
    `pseudo` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
    `roles` json NOT NULL,
    `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `telephone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `administrateur` tinyint(1) NOT NULL,
    `actif` tinyint(1) NOT NULL,
    `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `id_photo` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `UNIQ_D79F6B1186CC499D` (`pseudo`),
    KEY `IDX_D79F6B11F6BD1646` (`site_id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `participant`
--


-- --------------------------------------------------------

--
-- Structure de la table `participant_sortie`
--

DROP TABLE IF EXISTS `participant_sortie`;
CREATE TABLE IF NOT EXISTS `participant_sortie` (
    `participant_id` int(11) NOT NULL,
    `sortie_id` int(11) NOT NULL,
    PRIMARY KEY (`participant_id`,`sortie_id`),
    KEY `IDX_8E436D739D1C3019` (`participant_id`),
    KEY `IDX_8E436D73CC72D953` (`sortie_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `participant_sortie`
--



-- --------------------------------------------------------

--
-- Structure de la table `site`
--

DROP TABLE IF EXISTS `site`;
CREATE TABLE IF NOT EXISTS `site` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nom` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `site`
--



-- --------------------------------------------------------

--
-- Structure de la table `sortie`
--

DROP TABLE IF EXISTS `sortie`;
CREATE TABLE IF NOT EXISTS `sortie` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `site_id` int(11) DEFAULT NULL,
    `lieu_id` int(11) DEFAULT NULL,
    `etat_id` int(11) NOT NULL,
    `organisateur_id` int(11) NOT NULL,
    `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
    `date_heure_debut` datetime NOT NULL,
    `duree` int(11) NOT NULL,
    `nb_inscription_max` int(11) NOT NULL,
    `infos_sortie` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `date_limite_inscription` datetime DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `IDX_3C3FD3F2F6BD1646` (`site_id`),
    KEY `IDX_3C3FD3F26AB213CC` (`lieu_id`),
    KEY `IDX_3C3FD3F2D5E86FF` (`etat_id`),
    KEY `IDX_3C3FD3F2D936B2FA` (`organisateur_id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sortie`
--


-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

DROP TABLE IF EXISTS `ville`;
CREATE TABLE IF NOT EXISTS `ville` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
    `code_postal` int(11) NOT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ville`
--




DROP TABLE IF EXISTS `annulation_sortie`;
CREATE TABLE IF NOT EXISTS `annulation_sortie` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `sortie_id` int(11) NOT NULL,
    `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `UNIQ_BF82CC98CC72D953` (`sortie_id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `annulation_sortie`
--

-- --------------------------------------------------------


--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `annulation_sortie`
--
ALTER TABLE `annulation_sortie`
    ADD CONSTRAINT `FK_BF82CC98CC72D953` FOREIGN KEY (`sortie_id`) REFERENCES `sortie` (`id`);

--
-- Contraintes pour la table `lieu`
--
ALTER TABLE `lieu`
    ADD CONSTRAINT `FK_2F577D59A73F0036` FOREIGN KEY (`ville_id`) REFERENCES `ville` (`id`);

--
-- Contraintes pour la table `participant`
--
ALTER TABLE `participant`
    ADD CONSTRAINT `FK_D79F6B11F6BD1646` FOREIGN KEY (`site_id`) REFERENCES `site` (`id`);

--
-- Contraintes pour la table `participant_sortie`
--
ALTER TABLE `participant_sortie`
    ADD CONSTRAINT `FK_8E436D739D1C3019` FOREIGN KEY (`participant_id`) REFERENCES `participant` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_8E436D73CC72D953` FOREIGN KEY (`sortie_id`) REFERENCES `sortie` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sortie`
--
ALTER TABLE `sortie`
    ADD CONSTRAINT `FK_3C3FD3F26AB213CC` FOREIGN KEY (`lieu_id`) REFERENCES `lieu` (`id`),
  ADD CONSTRAINT `FK_3C3FD3F2D5E86FF` FOREIGN KEY (`etat_id`) REFERENCES `etat` (`id`),
  ADD CONSTRAINT `FK_3C3FD3F2D936B2FA` FOREIGN KEY (`organisateur_id`) REFERENCES `participant` (`id`),
  ADD CONSTRAINT `FK_3C3FD3F2F6BD1646` FOREIGN KEY (`site_id`) REFERENCES `site` (`id`);
COMMIT;

INSERT INTO site VALUE (NULL, 'ENI QUIMPER');
INSERT INTO `participant`(`id`, `site_id`, `pseudo`, `roles`, `password`, `nom`, `prenom`, `telephone`, `administrateur`, `actif`, `email`, `id_photo`) VALUES (NULL,1,'admin','[]','$2y$13$I7S4NjeFfbroU5IW.NPETu7kx3KwblEziM9IK8CBslfEqyF.ZL6Zi','admin','admin','0000000000',false,true,'admin', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
