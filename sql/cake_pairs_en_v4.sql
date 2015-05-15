-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 15 Mai 2015 à 11:59
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `answers`
--

INSERT INTO `answers` (`id`, `value`) VALUES
(1, 'Je suis un chat'),
(2, 'Je suis un chien'),
(3, 'Je suis un cheval'),
(4, 'Je suis une patate');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Contenu de la table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(5, 'Groupe 1', 'fzf'),
(6, 'Groupe 1', 'Coucou'),
(9, 'Groupe 1', 'Groupe 1'),
(10, 'Groupe 2', 'Groupe 2'),
(11, 'Groupe 1', 'Groupe 1'),
(12, 'Groupe 2', 'Groupe 2'),
(13, 'Groupe 1', 'Groupe 1'),
(14, 'Groupe 2', 'Groupe 2'),
(19, 'Groupe 1', 'Groupe 1'),
(20, 'Groupe 2', 'Groupe 2'),
(21, 'Groupe 1', 'Groupe 1'),
(22, 'Groupe 2', 'Groupe 2'),
(23, 'Groupe 10', 'Coucou');

-- --------------------------------------------------------

--
-- Structure de la table `groups_owners`
--

CREATE TABLE IF NOT EXISTS `groups_owners` (
  `group_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`group_id`,`user_id`),
  KEY `groups_owners_users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `groups_owners`
--

INSERT INTO `groups_owners` (`group_id`, `user_id`) VALUES
(5, 4),
(13, 4),
(14, 4),
(19, 4),
(20, 4),
(21, 4),
(22, 4),
(23, 4),
(6, 5);

-- --------------------------------------------------------

--
-- Structure de la table `groups_users`
--

CREATE TABLE IF NOT EXISTS `groups_users` (
  `user_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`),
  KEY `groups_users_group_key` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `groups_users`
--

INSERT INTO `groups_users` (`user_id`, `group_id`) VALUES
(3, 5),
(1, 13),
(8, 13),
(13, 14),
(16, 14),
(1, 19),
(8, 19),
(13, 20),
(16, 20),
(25, 21),
(26, 21),
(19, 22),
(20, 22);

-- --------------------------------------------------------

--
-- Structure de la table `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

--
-- Contenu de la table `modules`
--

INSERT INTO `modules` (`id`, `name`, `description`) VALUES
(2, 'THE WORLD IS YOURS', 'YEAH BITCH'),
(3, 'L2-BD', 'Conception de Base de données');

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
(2, 19),
(2, 20),
(3, 21),
(3, 22),
(2, 23);

-- --------------------------------------------------------

--
-- Structure de la table `modules_owners`
--

CREATE TABLE IF NOT EXISTS `modules_owners` (
  `module_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`module_id`,`user_id`),
  KEY `modules_owners_users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `modules_owners`
--

INSERT INTO `modules_owners` (`module_id`, `user_id`) VALUES
(2, 4),
(3, 4);

-- --------------------------------------------------------

--
-- Structure de la table `modules_users`
--

CREATE TABLE IF NOT EXISTS `modules_users` (
  `user_id` int(11) unsigned NOT NULL,
  `module_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`module_id`),
  KEY `fk_modules_midu_id` (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `owners`
--

CREATE TABLE IF NOT EXISTS `owners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `questionnaires`
--

INSERT INTO `questionnaires` (`id`, `title`, `description`, `date_creation`, `date_limit`) VALUES
(1, 'Je suis un questionnaire', 'coucou', '2015-04-12 19:23:00', '2016-04-12 19:23:00'),
(2, 'Other', 'Coucou c''est moi le chef', '2015-04-23 15:49:00', '2015-04-23 15:49:00');

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
(21, 1);

-- --------------------------------------------------------

--
-- Structure de la table `questionnaires_owners`
--

CREATE TABLE IF NOT EXISTS `questionnaires_owners` (
  `questionnaire_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`questionnaire_id`,`user_id`),
  KEY `questionnaires_owners_users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `questionnaires_owners`
--

INSERT INTO `questionnaires_owners` (`questionnaire_id`, `user_id`) VALUES
(1, 5);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `questions`
--

INSERT INTO `questions` (`id`, `content`, `type`) VALUES
(1, 'Tu es un poisson ?', 0),
(2, 'Qui es tu ?', 0);

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
  UNIQUE KEY `email` (`email`),
  KEY `user_role` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `role_id`, `email`, `first_name`, `last_name`, `password`) VALUES
(1, 1, 'alexis.puret@etu.univ-tours.fr', 'Alexis', 'PURET', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(2, 1, 'toast@gmail.com', 'Auto', 'Route', '$2y$10$wIOv6m2XqZeE9X/gT2gNfuotsAFMDuny4gK2AX/rY8jauufqOQx4K'),
(3, 3, 'etudiant@toast.com', 'auto', 'route', '$2y$10$G4cmuh5MoI7j/kgUaS.J1e3TiOfnHlSYNFiphoS5B.Ri8wuUwlnoq'),
(4, 2, 'professeur@toast.com', 'professeur', 'test', '$2y$10$7PIe37gUdDlU/lLd/HRL1u2e.XSx9bblyE6Fr8YoEPWmu49Y7Kqui'),
(5, 2, 'prof@toast.com', 'Machin', 'Chose', '$2y$10$G4cmuh5MoI7j/kgUaS.J1e3TiOfnHlSYNFiphoS5B.Ri8wuUwlnoq'),
(6, 3, 'Monsieur.Dupont@etu.univ-tours.fr', 'Monsieur', 'Dupont', '$2y$10$hQxHdvX83kw5ykpTGKHtuOYXlowu20ujKUcWw9mL4TjnC8qcGj1X2'),
(8, 3, 'manon.dupuet@etu.univ-tours.fr', 'Manon', 'dupuet', '$2y$10$7PIe37gUdDlU/lLd/HRL1u2e.XSx9bblyE6Fr8YoEPWmu49Y7Kqui'),
(9, 3, 'Alexandre.Astier@etu.univ-tours.fr', 'Alexandre', 'Astier', '$2y$10$bTo92JkNcMN.HN/v3VLdj.6jMUAXHixpTehW.ucIEsnFPTsf99XPK'),
(10, 1, 'coucou@tofkl.com', 'coucou', 'toto', '$2y$10$1KGfXtTmllUlnHACm.rFSuxHPLAIMojVCC0JvZUDlTZj5Kw7LHDA6'),
(11, 3, 'jean.jardin@etu.univ-tours.fr', 'Jean', 'Jardin', '$2y$10$vLsd2otwNo2UVSG30Cma7eWEikbVYlt5XtzeoS9Nh3kcZ/2tmn7bW'),
(12, 3, 'slim.shady@etu.univ-tours.fr', 'Slim', 'Shady', '$2y$10$xnbinPJYSGFh0HsnCyVM3OenAEOIBQBdVvuq/b5tRcXJ3eMPpgfRa'),
(13, 3, 'jim.warrior@etu.univ-tours.fr', 'Jim', 'Warrior', '$2y$10$ntaNeFGQ6JQAuHbJ6BYrxu4yYYZMYVwQ3FBIaAzF/rI01dMUEQWAy'),
(14, 3, 'alexandre.astier@etu.univ-tours.fr', 'Alexandre', 'Astier', '$2y$10$hzNPsMWdHnA50J.Dw.MK2uMpBSi9gafkwM3dw9zmPRZqvdnosMRNO'),
(15, 3, 'jim.roux@etu.univ-tours.fr', 'jim', 'roux', '$2y$10$hzNPsMWdHnA50J.Dw.MK2uMpBSi9gafkwM3dw9zmPRZqvdnosMRNO'),
(16, 3, 'jim.toast@etu.univ-tours.fr', 'jim', 'toast', '$2y$10$x2XrjSuY6wajD/Dw2L/.9.P/L7Fk7wflGPYYNIfJa5pfz/deS5RTG'),
(17, 3, 'paul.dupont@etu.univ-tours.fr', 'paul', 'dupont', '$2y$10$Fmr3ois3yXAXUopN1ptSZuZw/DmVz/SRN9YA1QfbxiuF8VV.dDYVC'),
(18, 3, 'marie.dupont@etu.univ-tours.fr', 'marie', 'dupont', '$2y$10$9gb3ICBMhWZ5A/7.2A.86eHL6BDYFjlDJy.G/jkTnyxdGZFFlEy2a'),
(19, 3, 'jim.dupont@etu.univ-tours.fr', 'jim', 'dupont', '$2y$10$tVyfr8OHpSIE6N1Bo5Pa8u8WhTy.c0C0wjmdB19Ab2I6hT0SlQl6O'),
(20, 3, 'manon.dupont@etu.univ-tours.fr', 'manon', 'dupont', '$2y$10$qzp3juYR1co6XGj8QU3F4uxlvEYc.72Wja78nYJFOHL.n22LwU8r2'),
(21, 3, 'jimmy.neutron@etu.univ-tours.fr', 'jimmy', 'neutron', '$2y$10$DKOtZJ.VZnHQ9BoeH.egxeNONWlHa1ZUJ/46gUgjlTKX9RDaNeSGS'),
(22, 3, 'elon.musk@etu.univ-tours.fr', 'elon', 'musk', '$2y$10$JZzCWR39n8hm9UMfYCWtY.ccw0IeE3l6ie71N5BGoK8Pg7or95AEK'),
(23, 3, 'aaron.swartz@etu.univ-tours.fr', 'aaron', 'swartz', '$2y$10$e652VNU2k8gwTOiRkVXMhuH01fm/H.HWzgZQciQ6BQhTyeal7dhlC'),
(24, 3, 'mark.zuckerberg@etu.univ-tours.fr', 'mark', 'zuckerberg', '$2y$10$CrZZIC./AkTE/f8o//9Rw.NHBB3oxwOoFchvo68eIsWuo5pjC5oTS'),
(25, 3, 'chuck.norris@etu.univ-tours.fr', 'chuck', 'norris', '$2y$10$7PIe37gUdDlU/lLd/HRL1u2e.XSx9bblyE6Fr8YoEPWmu49Y7Kqui'),
(26, 3, 'chuck.bartowski@etu.univ-tours.fr', 'chuck', 'bartowski', '$2y$10$DX8.qSfoMd.qq8f40Q6vhO5mo6QgyTlaGVJ9JF0dIngkda/fp66yW');

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
-- Contraintes pour la table `groups_owners`
--
ALTER TABLE `groups_owners`
  ADD CONSTRAINT `groups_owners_groups` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  ADD CONSTRAINT `groups_owners_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

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
-- Contraintes pour la table `modules_owners`
--
ALTER TABLE `modules_owners`
  ADD CONSTRAINT `modules_owners_modules` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`),
  ADD CONSTRAINT `modules_owners_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

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
-- Contraintes pour la table `questionnaires_owners`
--
ALTER TABLE `questionnaires_owners`
  ADD CONSTRAINT `questionnaires_owners_quest` FOREIGN KEY (`questionnaire_id`) REFERENCES `questionnaires` (`id`),
  ADD CONSTRAINT `questionnaires_owners_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

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
