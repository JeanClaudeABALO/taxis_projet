-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : lun. 20 mai 2024 à 01:05
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `rapido`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin_table`
--

CREATE TABLE `admin_table` (
  `admin_id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenoms` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `sexe` varchar(5) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin_table`
--

INSERT INTO `admin_table` (`admin_id`, `nom`, `prenoms`, `email`, `telephone`, `sexe`, `mot_de_passe`, `createdAt`, `updatedAt`) VALUES
(1, 'ABALO', 'Jean-Claude', 'kotchikpa2000@gmail.com', '94739951', 'M', '04ca983d8267b7d7f1762437f7ab4a78', '2024-05-18 21:46:30', '2024-05-18 21:46:30'),
(2, 'ABALO', 'Jean-Claude', 'kotchikpa2000@gmail.com', '94739951', 'M', '04ca983d8267b7d7f1762437f7ab4a78', '2024-05-18 21:46:30', '2024-05-18 21:46:30');

-- --------------------------------------------------------

--
-- Structure de la table `chauffeurs`
--

CREATE TABLE `chauffeurs` (
  `chauffeur_id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenoms` varchar(100) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `sexe` varchar(5) NOT NULL,
  `disponible` int(11) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `admin_created_id` int(11) DEFAULT NULL,
  `admin_updated_id` int(11) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `chauffeurs`
--

INSERT INTO `chauffeurs` (`chauffeur_id`, `nom`, `prenoms`, `telephone`, `sexe`, `disponible`, `mot_de_passe`, `email`, `admin_created_id`, `admin_updated_id`, `createdAt`, `updatedAt`) VALUES
(1, 'ABALO', 'Kotchikpa Jean Claude', '94739951', 'M', 1, '17e9d44abaf7884705d7748a0bdd2d61', 'kotchikpa2000@gmail.com', 1, NULL, '2024-05-18 21:47:59', '2024-05-19 12:38:38'),
(2, 'ABALO', 'Constant', '69336688', 'M', 1, '0c4a5bbe2a2f565ba09d78a534208c34', 'constkeb@gmail.com', 1, NULL, '2024-05-18 21:48:39', '2024-05-19 11:02:23'),
(3, 'ABALO', 'Bill', '94204551', 'M', 1, '57d374728186e230422fb6d5124d77d1', 'bill@gmail.com', 1, NULL, '2024-05-18 21:49:05', '2024-05-19 12:39:00'),
(4, 'ABALO', 'Sandra', '87878788', 'F', 1, '1ead0108e124e6a76f7dede8388804e4', 'sandra@gmail.com', 1, NULL, '2024-05-18 21:49:45', '2024-05-19 12:39:06'),
(5, 'ABALO', 'Arielle', '87878975', 'F', 1, 'd1802aff8d82f6734ccfa755d587c685', 'arielle@gmail.com', 1, NULL, '2024-05-18 21:50:18', '2024-05-19 11:02:29');

-- --------------------------------------------------------

--
-- Structure de la table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `point_depart` varchar(255) NOT NULL,
  `point_arrivee` varchar(255) NOT NULL,
  `date_heure` datetime NOT NULL,
  `chauffeur_id` int(11) DEFAULT NULL,
  `operateur_id` int(11) DEFAULT NULL,
  `admin_created_id` int(11) DEFAULT NULL,
  `admin_updated_id` int(11) DEFAULT NULL,
  `statut` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `courses`
--

INSERT INTO `courses` (`course_id`, `point_depart`, `point_arrivee`, `date_heure`, `chauffeur_id`, `operateur_id`, `admin_created_id`, `admin_updated_id`, `statut`, `createdAt`, `updatedAt`) VALUES
(1, 'Porto', 'Cotonou', '2024-05-23 00:01:00', NULL, NULL, 1, NULL, 0, '2024-05-18 21:59:09', '2024-05-18 21:59:09'),
(2, 'Dangbo', 'Calavi', '2024-05-22 02:03:00', NULL, NULL, 1, NULL, 0, '2024-05-18 21:59:26', '2024-05-18 21:59:26'),
(3, 'Parakou', 'Natitingou', '2024-05-22 04:05:00', 3, NULL, 1, NULL, 1, '2024-05-18 21:59:52', '2024-05-19 12:39:12'),
(4, 'Benin', 'Togio', '2024-05-29 01:03:00', 4, NULL, 1, NULL, 1, '2024-05-18 22:00:23', '2024-05-19 12:39:06'),
(5, 'France', 'Italie', '2024-05-23 03:04:00', 3, NULL, 1, NULL, 1, '2024-05-18 22:00:47', '2024-05-19 12:39:00'),
(6, 'Porto', 'Ouidah', '2024-05-21 05:51:00', 1, 3, NULL, NULL, 2, '2024-05-19 02:51:48', '2024-05-19 12:41:08');

-- --------------------------------------------------------

--
-- Structure de la table `operateurs`
--

CREATE TABLE `operateurs` (
  `operateur_id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenoms` varchar(100) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `sexe` varchar(5) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `creator_id` int(11) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `operateurs`
--

INSERT INTO `operateurs` (`operateur_id`, `nom`, `prenoms`, `telephone`, `sexe`, `mot_de_passe`, `email`, `creator_id`, `createdAt`, `updatedAt`) VALUES
(1, 'OKERE', 'Rafiath', '69336688', 'F', '8334822519be4d0b4989ab8ad1c59d79', 'okere@gmail.com', 1, '2024-05-18 21:52:00', '2024-05-18 21:52:00'),
(2, 'AITONDJI', 'DIdier', '87878788', 'M', '1ead0108e124e6a76f7dede8388804e4', 'didier@gmail.com', 1, '2024-05-18 21:53:20', '2024-05-18 21:53:20'),
(3, 'ABALO', 'Kotchikpa Jean Claude', '94739951', 'M', '17e9d44abaf7884705d7748a0bdd2d61', 'jc.abalo@imsp-uac.org', 1, '2024-05-18 21:53:54', '2024-05-18 21:53:54'),
(4, 'MIKINHOUESSE', 'Chancelle', '87878975', 'F', 'a8b03f2836d2ac17596c7b3e83ae8a15', 'chancelle@gmail.com', 1, '2024-05-18 21:57:39', '2024-05-18 21:57:39');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin_table`
--
ALTER TABLE `admin_table`
  ADD PRIMARY KEY (`admin_id`);

--
-- Index pour la table `chauffeurs`
--
ALTER TABLE `chauffeurs`
  ADD PRIMARY KEY (`chauffeur_id`),
  ADD KEY `admin_created_id` (`admin_created_id`),
  ADD KEY `admin_updated_id` (`admin_updated_id`);

--
-- Index pour la table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `chauffeur_id` (`chauffeur_id`),
  ADD KEY `operateur_id` (`operateur_id`),
  ADD KEY `admin_created_id` (`admin_created_id`),
  ADD KEY `admin_updated_id` (`admin_updated_id`);

--
-- Index pour la table `operateurs`
--
ALTER TABLE `operateurs`
  ADD PRIMARY KEY (`operateur_id`),
  ADD KEY `creator_id` (`creator_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin_table`
--
ALTER TABLE `admin_table`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `chauffeurs`
--
ALTER TABLE `chauffeurs`
  MODIFY `chauffeur_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `operateurs`
--
ALTER TABLE `operateurs`
  MODIFY `operateur_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `chauffeurs`
--
ALTER TABLE `chauffeurs`
  ADD CONSTRAINT `chauffeurs_ibfk_1` FOREIGN KEY (`admin_created_id`) REFERENCES `admin_table` (`admin_id`),
  ADD CONSTRAINT `chauffeurs_ibfk_2` FOREIGN KEY (`admin_updated_id`) REFERENCES `admin_table` (`admin_id`);

--
-- Contraintes pour la table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`chauffeur_id`) REFERENCES `chauffeurs` (`chauffeur_id`),
  ADD CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`operateur_id`) REFERENCES `operateurs` (`operateur_id`),
  ADD CONSTRAINT `courses_ibfk_3` FOREIGN KEY (`admin_created_id`) REFERENCES `admin_table` (`admin_id`),
  ADD CONSTRAINT `courses_ibfk_4` FOREIGN KEY (`admin_updated_id`) REFERENCES `admin_table` (`admin_id`);

--
-- Contraintes pour la table `operateurs`
--
ALTER TABLE `operateurs`
  ADD CONSTRAINT `operateurs_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `admin_table` (`admin_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
