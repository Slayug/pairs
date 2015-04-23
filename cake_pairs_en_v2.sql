-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 22 Avril 2015 à 18:13
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `cake_pairs`
--

-- --------------------------------------------------------

--
-- Structure de la table `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `value` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `answers_questionnaire_users`
--

CREATE TABLE IF NOT EXISTS `answers_questionnaire_users` (
  `question_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `answer_id` int(10) unsigned NOT NULL,
  `questionnaire_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`question_id`,`user_id`,`answer_id`,`questionnaire_id`),
  KEY `answers_users_user` (`user_id`),
  KEY `answers_users_reponse` (`answer_id`),
  KEY `answers_users_questionnaire` (`questionnaire_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `answers_questionnaire_users_partials`
--

CREATE TABLE IF NOT EXISTS `answers_questionnaire_users_partials` (
  `question_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `answer_id` int(10) unsigned NOT NULL,
  `questionnaire_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`question_id`,`user_id`,`answer_id`,`questionnaire_id`),
  KEY `answers_users_user` (`user_id`),
  KEY `answers_users_reponse` (`answer_id`),
  KEY `answers_users_questionnaire` (`questionnaire_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `answers_questions`
--

CREATE TABLE IF NOT EXISTS `answers_questions` (
  `question_id` int(10) unsigned NOT NULL,
  `answer_id` int(10) unsigned NOT NULL,
  `position` int(10) unsigned NOT NULL,
  PRIMARY KEY (`question_id`,`answer_id`,`position`),
  KEY `fk_reponse` (`answer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `description` varchar(500) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Contenu de la table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(2, 'test', 'coucou'),
(4, 'hunger games', 'Alerte aux gogoles !'),
(5, 'hunger games', 'Alerte aux gogoles !'),
(6, 'hunger games', 'Alerte aux gogoles !'),
(7, 'hunger games', 'Alerte aux gogoles !'),
(8, 'hunger games', 'Alerte aux gogoles !'),
(10, 'hunger games', 'Alerte aux gogoles !'),
(11, 'Mon groupe !', 'Coucou c''est moi le chef'),
(12, 'Groupe X', 'coucou'),
(15, 'Groupe Y', 'coucou j''aime les patates');

-- --------------------------------------------------------

--
-- Structure de la table `groups_users`
--

CREATE TABLE IF NOT EXISTS `groups_users` (
  `user_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  `owner` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`group_id`),
  KEY `groups_users_group_key` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `groups_users`
--

INSERT INTO `groups_users` (`user_id`, `group_id`, `owner`) VALUES
(2, 2, 0),
(2, 4, 0),
(2, 5, 0),
(2, 6, 0),
(2, 7, 0),
(2, 8, 0),
(2, 10, 0),
(3, 2, 0),
(3, 6, 0),
(3, 7, 0),
(3, 8, 0),
(3, 10, 0),
(4, 11, 1),
(4, 12, 1),
(4, 15, 0);

-- --------------------------------------------------------

--
-- Structure de la table `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=12 ;

--
-- Contenu de la table `modules`
--

INSERT INTO `modules` (`id`, `name`, `description`) VALUES
(1, 'BD-L2', 'toast'),
(2, 'L2-Reseau', 'tto'),
(3, 'BD-fraise', 'frais'),
(7, 'toast', 'toto');

-- --------------------------------------------------------

--
-- Structure de la table `modules_groups`
--

CREATE TABLE IF NOT EXISTS `modules_groups` (
  `module_id` int(11) unsigned NOT NULL,
  `group_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`module_id`,`group_id`),
  KEY `fk_modules_groups_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `modules_groups`
--

INSERT INTO `modules_groups` (`module_id`, `group_id`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `modules_users`
--

CREATE TABLE IF NOT EXISTS `modules_users` (
  `user_id` int(11) unsigned NOT NULL,
  `module_id` int(11) unsigned NOT NULL,
  `owner` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`module_id`),
  KEY `fk_modules_midu_id` (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `questionnaires`
--

CREATE TABLE IF NOT EXISTS `questionnaires` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `description` varchar(535) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_limit` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `questionnaires`
--

INSERT INTO `questionnaires` (`id`, `title`, `description`, `date_creation`, `date_limit`) VALUES
(1, 'Je suis un questionnaire', 'coucou', '2015-04-12 19:23:00', '2016-04-12 19:23:00');

-- --------------------------------------------------------

--
-- Structure de la table `questionnaires_groups`
--

CREATE TABLE IF NOT EXISTS `questionnaires_groups` (
  `group_id` int(10) unsigned NOT NULL,
  `questionnaire_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`group_id`,`questionnaire_id`),
  KEY `questionnaires_groups_questionnaire` (`questionnaire_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `questionnaires_groups`
--

INSERT INTO `questionnaires_groups` (`group_id`, `questionnaire_id`) VALUES
(11, 1);

-- --------------------------------------------------------

--
-- Structure de la table `questionnaires_questions`
--

CREATE TABLE IF NOT EXISTS `questionnaires_questions` (
  `question_id` int(10) unsigned NOT NULL,
  `questionnaire_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`question_id`,`questionnaire_id`),
  KEY `questionnaires_questions_questionnaire` (`questionnaire_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(255) NOT NULL,
  `type` tinyint(2) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designation` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `roles`
--

INSERT INTO `roles` (`id`, `designation`) VALUES
(1, 'Admin'),
(2, 'Professeur'),
(3, 'Etudiant');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_role` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `role_id`, `email`, `first_name`, `last_name`, `password`) VALUES
(1, 1, 'alexis.puret@etu.univ-tours.fr', 'Alexis', 'PURET', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(2, 1, 'toast@gmail.com', 'Auto', 'Route', '$2y$10$wIOv6m2XqZeE9X/gT2gNfuotsAFMDuny4gK2AX/rY8jauufqOQx4K'),
(3, 3, 'etudiant@toast.com', 'auto', 'route', '$2y$10$G4cmuh5MoI7j/kgUaS.J1e3TiOfnHlSYNFiphoS5B.Ri8wuUwlnoq'),
(4, 2, 'professeur@toast.com', 'prof', 'to', '$2y$10$7PIe37gUdDlU/lLd/HRL1u2e.XSx9bblyE6Fr8YoEPWmu49Y7Kqui');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `answers_questionnaire_users`
--
ALTER TABLE `answers_questionnaire_users`
  ADD CONSTRAINT `answers_questionnaire_users_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `answers_questionnaire_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `answers_questionnaire_users_ibfk_3` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`id`),
  ADD CONSTRAINT `answers_questionnaire_users_ibfk_4` FOREIGN KEY (`questionnaire_id`) REFERENCES `questionnaires` (`id`);

--
-- Contraintes pour la table `answers_questionnaire_users_partials`
--
ALTER TABLE `answers_questionnaire_users_partials`
  ADD CONSTRAINT `answers_questionnaire_users_partials_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `answers_questionnaire_users_partials_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `answers_questionnaire_users_partials_ibfk_3` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`id`),
  ADD CONSTRAINT `answers_questionnaire_users_partials_ibfk_4` FOREIGN KEY (`questionnaire_id`) REFERENCES `questionnaires` (`id`);

--
-- Contraintes pour la table `answers_questions`
--
ALTER TABLE `answers_questions`
  ADD CONSTRAINT `answers_questions_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `answers_questions_ibfk_2` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`id`);

--
-- Contraintes pour la table `groups_users`
--
ALTER TABLE `groups_users`
  ADD CONSTRAINT `groups_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `groups_users_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

--
-- Contraintes pour la table `modules_groups`
--
ALTER TABLE `modules_groups`
  ADD CONSTRAINT `fk_modules_groups_id` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  ADD CONSTRAINT `fk_modules_mod_id` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`);

--
-- Contraintes pour la table `modules_users`
--
ALTER TABLE `modules_users`
  ADD CONSTRAINT `fk_modules_midu_id` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`),
  ADD CONSTRAINT `fk_modules_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `questionnaires_groups`
--
ALTER TABLE `questionnaires_groups`
  ADD CONSTRAINT `questionnaires_groups_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  ADD CONSTRAINT `questionnaires_groups_ibfk_2` FOREIGN KEY (`questionnaire_id`) REFERENCES `questionnaires` (`id`);

--
-- Contraintes pour la table `questionnaires_questions`
--
ALTER TABLE `questionnaires_questions`
  ADD CONSTRAINT `questionnaires_questions_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `questionnaires_questions_ibfk_2` FOREIGN KEY (`questionnaire_id`) REFERENCES `questionnaires` (`id`);

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
