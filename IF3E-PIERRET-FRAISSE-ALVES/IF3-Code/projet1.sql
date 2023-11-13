-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 12 nov. 2023 à 11:08
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet1`
--

-- --------------------------------------------------------

--
-- Structure de la table `equipe_personnage`
--

CREATE TABLE `equipe_personnage` (
  `id_user` int(11) NOT NULL,
  `id_personnage` int(11) NOT NULL,
  `id_skill` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `equipe_personnage`
--

INSERT INTO `equipe_personnage` (`id_user`, `id_personnage`, `id_skill`) VALUES
(2, 2, 3);

-- --------------------------------------------------------

--
-- Structure de la table `equipe_vaisseau`
--

CREATE TABLE `equipe_vaisseau` (
  `id_user` int(11) NOT NULL,
  `id_vaisseau` int(11) NOT NULL,
  `fuel` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `equipe_vaisseau`
--

INSERT INTO `equipe_vaisseau` (`id_user`, `id_vaisseau`, `fuel`) VALUES
(2, 3, 270);

-- --------------------------------------------------------

--
-- Structure de la table `login`
--

CREATE TABLE `login` (
  `id_user` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `name` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `birth` date NOT NULL,
  `role` varchar(255) NOT NULL,
  `avatar` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `login`
--

INSERT INTO `login` (`id_user`, `username`, `password`, `name`, `mail`, `first_name`, `birth`, `role`, `avatar`) VALUES
(1, 'cqptomii', '397118fdac8d83ad98813c50759c85b8c47565d8268bf10da483153b747a74743a58a90e85aa9f705ce6984ffc128db567489817e4092d050d8a1cc596ddc119', 'Fraisse', 'tom@gmail.com', 'Tom', '0000-00-00', 'mineur', 'avatarbase'),
(2, 'julesprrt', '3627909a29c31381a071ec27f7c9ca97726182aed29a7ddd2e54353322cfb30abb9e3a6df2ac2c20fe23436311d678564d0c8d305930575f60e2d3d048184d79', 'PIERRET', 'jules@gmail.com', 'Jules', '0000-00-00', 'soigneur', 'avatarbase');

-- --------------------------------------------------------

--
-- Structure de la table `mission`
--

CREATE TABLE `mission` (
  `id_mission` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `id_vaisseau` int(11) NOT NULL,
  `id_skill` int(11) NOT NULL,
  `id_planete` int(11) NOT NULL,
  `commu` tinyint(1) NOT NULL DEFAULT 0,
  `creator` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `mission`
--

INSERT INTO `mission` (`id_mission`, `name`, `description`, `id_vaisseau`, `id_skill`, `id_planete`, `commu`, `creator`) VALUES
(1, 'Shopkeepers\' plundering', 'The shopkeepers are easy targets with a big loot. Perfect to start off!', 1, 1, 1, 0, ''),
(2, 'Death row inmates', 'Innocent people were captured and sentenced by Jabba the hutt. Help them to retore justice.', 1, 2, 1, 0, ''),
(3, 'Gold mines', 'This desert planet remains unexplored, so set off on an adventure to discover its hidden treasures.', 1, 3, 1, 0, ''),
(4, 'Gold hunt', 'Special animals full of gold are hiding on this planet. To find them, you\'ll need infrared goggles!', 2, 1, 2, 0, ''),
(5, 'Friend in danger', 'Your childhood friend finds himself kidnapped by a gang of armed mercenaries... Save him!!!', 2, 2, 2, 0, ''),
(6, 'The floor is lava', 'A remplir', 2, 3, 2, 0, ''),
(7, 'A special ore ', 'Set off in search of Unobtanium, a unique mineral that could save your planet! ', 3, 1, 3, 0, ''),
(8, 'Risky rescue', 'Your friend is lost in the jungle. Watch out for the wild beasts and come to the rescue!  ', 3, 2, 3, 0, ''),
(9, 'Floating islands', 'These islands defy the laws of gravity, so why not explore them and find out more.', 3, 3, 3, 0, ''),
(10, 'Destruction', 'Destroy the Death Star to fight against the Empire', 3, 1, 4, 0, '');

-- --------------------------------------------------------

--
-- Structure de la table `personnage`
--

CREATE TABLE `personnage` (
  `id_personnage` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `id_skill` int(11) NOT NULL,
  `nameperso` varchar(255) NOT NULL,
  `price` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `personnage`
--

INSERT INTO `personnage` (`id_personnage`, `name`, `id_skill`, `nameperso`, `price`) VALUES
(1, 'Miner', 1, 'mineuravatar.jpg', 500),
(2, 'healer', 2, 'healeuravatar.jpg', 500),
(3, 'explorer', 3, 'exploreravatar.jpg', 500);

-- --------------------------------------------------------

--
-- Structure de la table `planete`
--

CREATE TABLE `planete` (
  `id_planete` int(11) NOT NULL,
  `planete` varchar(10) NOT NULL,
  `fuel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `planete`
--

INSERT INTO `planete` (`id_planete`, `planete`, `fuel`) VALUES
(1, 'Tatoine', 50),
(2, 'Kamino', 100),
(3, 'Pandora', 250),
(4, 'Death Star', 500);

-- --------------------------------------------------------

--
-- Structure de la table `profile`
--

CREATE TABLE `profile` (
  `id_user` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `niveau` int(11) NOT NULL,
  `EXP` int(11) DEFAULT NULL,
  `gold` int(11) DEFAULT NULL,
  `metal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `profile`
--

INSERT INTO `profile` (`id_user`, `username`, `niveau`, `EXP`, `gold`, `metal`) VALUES
(1, 'cqptomii', 1, 10, 35, 10),
(2, 'julesprrt', 17, 98, 1227, 2975);

-- --------------------------------------------------------

--
-- Structure de la table `reward`
--

CREATE TABLE `reward` (
  `id_mission` int(11) NOT NULL,
  `gold` int(11) DEFAULT NULL,
  `EXP` int(11) DEFAULT NULL,
  `metal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reward`
--

INSERT INTO `reward` (`id_mission`, `gold`, `EXP`, `metal`) VALUES
(1, 35, 2, 10),
(2, 10, 2, 25),
(3, 10, 2, 25),
(4, 65, 2, 20),
(5, 20, 2, 50),
(6, 20, 2, 50),
(7, 120, 2, 50),
(8, 50, 2, 100),
(9, 50, 2, 100),
(10,100,4,100);

-- --------------------------------------------------------

--
-- Structure de la table `skill`
--

CREATE TABLE `skill` (
  `id_skill` int(11) NOT NULL,
  `skills` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `skill`
--

INSERT INTO `skill` (`id_skill`, `skills`) VALUES
(1, 'farming'),
(2, 'rescue'),
(3, 'exploration');

-- --------------------------------------------------------

--
-- Structure de la table `vaisseau`
--

CREATE TABLE `vaisseau` (
  `id_vaisseau` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `fuel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `vaisseau`
--

INSERT INTO `vaisseau` (`id_vaisseau`, `name`, `price`, `description`, `fuel`) VALUES
(1, 'A-Wing RZ-2', 100, '2 canons lasers pivotants  ; 2 lances-missiles', 100),
(2, 'X-Wing T-70', 500, '4 canons lasers  ; 2 lance-projectiles ; canon blaster pivotant', 250),
(3, 'Y-Wing BTL', 1000, '2 canons lasers; 2 canons à ions ; 2 tubes lance-torpilles ; des bombes à protons\r\n', 500);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `equipe_personnage`
--
ALTER TABLE `equipe_personnage`
  ADD KEY `id_skill` (`id_skill`),
  ADD KEY `equipToIDpersonnage` (`id_personnage`);

--
-- Index pour la table `equipe_vaisseau`
--
ALTER TABLE `equipe_vaisseau`
  ADD KEY `equipToIDVaisseau` (`id_vaisseau`);

--
-- Index pour la table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id_user`);

--
-- Index pour la table `mission`
--
ALTER TABLE `mission`
  ADD PRIMARY KEY (`id_mission`),
  ADD KEY `id_vaisseau` (`id_vaisseau`),
  ADD KEY `id_planete` (`id_planete`);

--
-- Index pour la table `personnage`
--
ALTER TABLE `personnage`
  ADD PRIMARY KEY (`id_personnage`),
  ADD KEY `id_skill` (`id_skill`);

--
-- Index pour la table `planete`
--
ALTER TABLE `planete`
  ADD PRIMARY KEY (`id_planete`);

--
-- Index pour la table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id_user`);

--
-- Index pour la table `reward`
--
ALTER TABLE `reward`
  ADD PRIMARY KEY (`id_mission`);

--
-- Index pour la table `skill`
--
ALTER TABLE `skill`
  ADD PRIMARY KEY (`id_skill`);

--
-- Index pour la table `vaisseau`
--
ALTER TABLE `vaisseau`
  ADD PRIMARY KEY (`id_vaisseau`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `login`
--
ALTER TABLE `login`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `mission`
--
ALTER TABLE `mission`
  MODIFY `id_mission` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `personnage`
--
ALTER TABLE `personnage`
  MODIFY `id_personnage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `planete`
--
ALTER TABLE `planete`
  MODIFY `id_planete` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `profile`
--
ALTER TABLE `profile`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `reward`
--
ALTER TABLE `reward`
  MODIFY `id_mission` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT pour la table `skill`
--
ALTER TABLE `skill`
  MODIFY `id_skill` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `vaisseau`
--
ALTER TABLE `vaisseau`
  MODIFY `id_vaisseau` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `equipe_personnage`
--
ALTER TABLE `equipe_personnage`
  ADD CONSTRAINT `equipToIDpersonnage` FOREIGN KEY (`id_personnage`) REFERENCES `personnage` (`id_personnage`),
  ADD CONSTRAINT `equipToIDskill` FOREIGN KEY (`id_skill`) REFERENCES `personnage` (`id_skill`),
  ADD CONSTRAINT `profileToEquipPerso` FOREIGN KEY (`id_user`) REFERENCES `profile` (`id_user`);

--
-- Contraintes pour la table `equipe_vaisseau`
--
ALTER TABLE `equipe_vaisseau`
  ADD CONSTRAINT `equipToIDVaisseau` FOREIGN KEY (`id_vaisseau`) REFERENCES `vaisseau` (`id_vaisseau`),
  ADD CONSTRAINT `profileToEquipVaisseau` FOREIGN KEY (`id_user`) REFERENCES `profile` (`id_user`);

--
-- Contraintes pour la table `personnage`
--
ALTER TABLE `personnage`
  ADD CONSTRAINT `idSkillToSkill` FOREIGN KEY (`id_skill`) REFERENCES `skill` (`id_skill`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
