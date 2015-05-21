-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 21 Mai 2015 à 21:19
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `value` (`value`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `answers`
--

INSERT INTO `answers` (`id`, `value`) VALUES
(7, 'Je ne sais pas'),
(1, 'Je suis un chat'),
(3, 'Je suis un cheval'),
(2, 'Je suis un chien'),
(4, 'Je suis une patate'),
(6, 'Non'),
(5, 'Oui');

-- --------------------------------------------------------

--
-- Structure de la table `answers_questionnaires_users`
--

CREATE TABLE IF NOT EXISTS `answers_questionnaires_users` (
  `question_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `answer_id` int(10) unsigned NOT NULL,
  `questionnaire_id` int(10) unsigned NOT NULL,
  `for_who` int(10) unsigned NOT NULL,
  PRIMARY KEY (`question_id`,`user_id`,`questionnaire_id`,`for_who`),
  KEY `answers_users_user` (`user_id`),
  KEY `answers_users_reponse` (`answer_id`),
  KEY `answers_users_questionnaire` (`questionnaire_id`),
  KEY `fk_q_u_f` (`for_who`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `answers_questionnaires_users`
--

INSERT INTO `answers_questionnaires_users` (`question_id`, `user_id`, `answer_id`, `questionnaire_id`, `for_who`) VALUES
(5, 1, 5, 1, 1),
(5, 25, 5, 1, 25),
(6, 1, 5, 1, 1),
(6, 1, 5, 1, 25),
(6, 25, 5, 1, 25),
(7, 1, 5, 1, 1),
(7, 1, 5, 1, 25),
(7, 25, 5, 1, 25),
(8, 1, 5, 1, 1),
(5, 1, 6, 1, 25),
(5, 25, 6, 1, 1),
(6, 25, 6, 1, 1),
(8, 1, 6, 1, 25),
(7, 25, 7, 1, 1),
(8, 25, 7, 1, 1),
(8, 25, 7, 1, 25);

-- --------------------------------------------------------

--
-- Structure de la table `answers_questionnaires_users_partials`
--

CREATE TABLE IF NOT EXISTS `answers_questionnaires_users_partials` (
  `question_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `answer_id` int(10) unsigned NOT NULL,
  `questionnaire_id` int(10) unsigned NOT NULL,
  `for_who` int(10) unsigned NOT NULL,
  PRIMARY KEY (`question_id`,`user_id`,`questionnaire_id`,`for_who`),
  KEY `answers_users_user` (`user_id`),
  KEY `answers_users_reponse` (`answer_id`),
  KEY `answers_users_questionnaire` (`questionnaire_id`),
  KEY `fk_q_u_p_f` (`for_who`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `answers_questions_questionnaires`
--

CREATE TABLE IF NOT EXISTS `answers_questions_questionnaires` (
  `question_id` int(10) unsigned NOT NULL,
  `answer_id` int(10) unsigned NOT NULL,
  `questionnaire_id` int(10) unsigned NOT NULL,
  `position` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`question_id`,`answer_id`,`questionnaire_id`),
  KEY `fk_answers_q_a` (`answer_id`),
  KEY `fk_answers_q_qu` (`questionnaire_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `answers_questions_questionnaires`
--

INSERT INTO `answers_questions_questionnaires` (`question_id`, `answer_id`, `questionnaire_id`, `position`) VALUES
(1, 1, 3, 0),
(1, 1, 4, 0),
(1, 1, 20, 0),
(1, 1, 23, 1),
(1, 2, 2, 1),
(1, 2, 3, 2),
(1, 2, 20, 2),
(1, 2, 23, 2),
(1, 3, 2, 0),
(1, 3, 3, 1),
(1, 3, 4, 2),
(1, 3, 20, 1),
(1, 3, 23, 0),
(1, 7, 4, 1),
(2, 1, 3, 0),
(2, 1, 4, 1),
(2, 1, 20, 0),
(2, 1, 23, 0),
(2, 2, 23, 2),
(2, 3, 3, 1),
(2, 3, 4, 2),
(2, 3, 20, 1),
(2, 3, 23, 1),
(2, 7, 4, 0),
(3, 1, 2, 1),
(3, 2, 2, 3),
(3, 2, 10, 1),
(3, 3, 2, 2),
(3, 3, 10, 0),
(3, 4, 2, 4),
(3, 5, 2, 6),
(3, 6, 2, 5),
(3, 7, 2, 0),
(5, 1, 2, 1),
(5, 1, 23, 0),
(5, 2, 2, 3),
(5, 2, 23, 2),
(5, 3, 2, 2),
(5, 3, 23, 1),
(5, 4, 2, 4),
(5, 5, 1, 1),
(5, 5, 2, 6),
(5, 6, 1, 0),
(5, 6, 2, 5),
(5, 7, 2, 0),
(6, 5, 7, 0),
(6, 5, 21, 0),
(6, 5, 22, 0),
(6, 6, 7, 1),
(6, 6, 21, 1),
(6, 6, 22, 1),
(6, 7, 21, 2),
(6, 7, 22, 2),
(7, 5, 1, 2),
(7, 5, 7, 1),
(7, 5, 21, 0),
(7, 5, 22, 0),
(7, 6, 1, 1),
(7, 6, 7, 0),
(7, 7, 1, 0),
(7, 7, 21, 1),
(7, 7, 22, 1),
(8, 1, 23, 0),
(8, 2, 2, 2),
(8, 2, 23, 2),
(8, 3, 2, 0),
(8, 3, 23, 1),
(8, 5, 1, 2),
(8, 5, 2, 1),
(8, 5, 7, 1),
(8, 5, 21, 0),
(8, 5, 22, 0),
(8, 6, 1, 1),
(8, 6, 7, 0),
(8, 6, 21, 1),
(8, 6, 22, 1),
(8, 7, 1, 0),
(8, 7, 21, 2),
(8, 7, 22, 2);

-- --------------------------------------------------------

--
-- Structure de la table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `description` varchar(500) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

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
(23, 'Groupe 10', 'Coucou'),
(24, 'Groupe 1', 'Groupe 1'),
(25, 'Groupe 2', 'Groupe 2'),
(26, 'Groupe 20', 'Les plus nuls'),
(27, 'Groupe 1', 'Groupe 1'),
(28, 'Groupe 2', 'Groupe 2'),
(29, 'Groupe 3', 'Groupe 3'),
(30, 'Groupe 1', 'Groupe 1'),
(31, 'Groupe 2', 'Groupe 2'),
(32, 'Groupe 3', 'Groupe 3');

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
(24, 4),
(25, 4),
(26, 4),
(27, 4),
(28, 4),
(29, 4),
(6, 5),
(30, 5),
(31, 5),
(32, 5);

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
(13, 14),
(16, 14),
(1, 19),
(25, 19),
(13, 20),
(16, 20),
(26, 21),
(19, 22),
(20, 22),
(1, 24),
(13, 25),
(16, 25),
(8, 26),
(1, 27),
(8, 27),
(13, 28),
(16, 28),
(27, 29),
(28, 29),
(29, 29),
(1, 30),
(8, 30),
(13, 31),
(16, 31),
(27, 32),
(28, 32),
(29, 32);

-- --------------------------------------------------------

--
-- Structure de la table `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=7 ;

--
-- Contenu de la table `modules`
--

INSERT INTO `modules` (`id`, `name`, `description`) VALUES
(2, 'THE WORLD IS YOURS', 'YEAH BITCH'),
(3, 'L2-BD', 'Conception de Base de données'),
(4, 'L2-Maths', 'Groupe d''élèves travaillant sur les démonstrations'),
(5, 'Physique', 'C''est nul !'),
(6, 'L2-Algo', 'coucou');

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
(2, 23),
(4, 24),
(4, 25),
(4, 26),
(5, 27),
(5, 28),
(5, 29),
(6, 30),
(6, 31),
(6, 32);

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
(3, 4),
(4, 4),
(5, 4),
(6, 5);

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
  `date_limit` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Contenu de la table `questionnaires`
--

INSERT INTO `questionnaires` (`id`, `title`, `description`, `date_creation`, `date_limit`) VALUES
(1, 'Evaluation 2ND SEMESTRE', 'Rapide et efficace', '2015-05-20 14:55:00', '2015-05-30 14:50:00'),
(2, 'Toast', 'Coucou all', '2015-05-21 15:24:00', '2015-05-31 19:50:00'),
(3, 'TImmy', 'LOL', '2015-05-21 15:43:00', '2015-05-31 19:55:00'),
(4, 'CSS3 inset text-shadow trick', 'toast', '2015-05-21 15:56:00', '2015-05-23 15:55:00'),
(5, 'Position CHECK', 'CHECK CHECK', '2015-05-21 16:00:00', '2015-05-23 15:55:00'),
(6, 'Date CHECK', 'Alerte aux gogoles !', '2015-05-21 16:26:00', '2015-04-08 09:25:00'),
(7, 'CHECK POSIIIITION', 'POSITION DONE', '2015-05-21 16:41:00', '2015-06-04 10:50:00'),
(8, 'CSS3 inset text-shadow trick', 'Alerte aux gogoles !', '2015-05-21 16:50:00', '2015-09-03 06:30:00'),
(9, 'Evaluation 2ND SEMESTRE', 'Rapide et efficace', '2015-05-20 14:55:00', '2015-05-30 14:50:00'),
(10, 'Coucou and', 'and', '2015-05-21 19:05:00', '2015-07-16 10:50:00'),
(11, 'Coucou and', 'and', '2015-05-21 19:05:00', '2015-07-16 10:50:00'),
(12, 'Evaluation 2ND SEMESTRE', 'Rapide et efficace', '2015-05-20 14:55:00', '2015-05-30 14:50:00'),
(13, 'Evaluation 2ND SEMESTRE', 'Rapide et efficace', '2015-05-20 14:55:00', '2015-05-30 14:50:00'),
(20, 'TImmy', 'LOL', '2015-05-21 15:43:00', '2015-05-31 19:55:00'),
(21, 'Test', 'Test', '2015-05-20 19:55:00', '2015-05-31 23:00:00'),
(22, 'Test', 'Test', '2015-05-20 19:55:00', '2015-05-31 23:00:00'),
(23, 'tpti', 'gdf', '2015-05-21 21:15:00', '2015-07-16 10:50:00');

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
(19, 1),
(20, 1),
(23, 1),
(19, 2),
(20, 2),
(23, 2),
(24, 3),
(25, 3),
(26, 3),
(24, 4),
(25, 4),
(26, 4),
(24, 7),
(25, 7),
(26, 7),
(19, 8),
(20, 8),
(23, 8),
(30, 13),
(31, 13),
(32, 13),
(30, 20),
(31, 20),
(32, 20),
(27, 21),
(28, 21),
(29, 21),
(19, 22),
(20, 22),
(23, 22),
(21, 23),
(22, 23);

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
(1, 4),
(2, 4),
(3, 4),
(4, 4),
(7, 4),
(8, 4),
(21, 4),
(22, 4),
(23, 4),
(13, 5),
(20, 5);

-- --------------------------------------------------------

--
-- Structure de la table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(255) NOT NULL,
  `type` tinyint(2) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `questions`
--

INSERT INTO `questions` (`id`, `content`, `type`) VALUES
(1, 'Tu es un poisson ?', 0),
(2, 'Qui es tu ?', 0),
(3, 'cdcd', 0),
(4, 'Tu es chauve ?', 0),
(5, 'Aimes-tu cet élève', 0),
(6, 'A-t''il été performant ?', 0),
(7, 'Cet élève a-t''il respecté le but du module ?', 0),
(8, 'A-t''il respecté les consignes du groupe ?', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `role_id`, `email`, `first_name`, `last_name`, `password`) VALUES
(1, 3, 'alexis.puret@etu.univ-tours.fr', 'Alexis', 'PURET', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(2, 1, 'toast@gmail.com', 'Auto', 'Route', '$2y$10$wIOv6m2XqZeE9X/gT2gNfuotsAFMDuny4gK2AX/rY8jauufqOQx4K'),
(3, 3, 'etudiant@toast.com', 'auto', 'route', '$2y$10$G4cmuh5MoI7j/kgUaS.J1e3TiOfnHlSYNFiphoS5B.Ri8wuUwlnoq'),
(4, 2, 'professeur@toast.com', 'professeur', 'test', '$2y$10$7PIe37gUdDlU/lLd/HRL1u2e.XSx9bblyE6Fr8YoEPWmu49Y7Kqui'),
(5, 2, 'prof@toast.com', 'Machin', 'Chose', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(6, 3, 'Monsieur.Dupont@etu.univ-tours.fr', 'Monsieur', 'Dupont', '$2y$10$hQxHdvX83kw5ykpTGKHtuOYXlowu20ujKUcWw9mL4TjnC8qcGj1X2'),
(8, 3, 'manon.dupuet@etu.univ-tours.fr', 'manon', 'dupuet', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(9, 3, 'Alexandre.Astier@etu.univ-tours.fr', 'Alexandre', 'Astier', '$2y$10$bTo92JkNcMN.HN/v3VLdj.6jMUAXHixpTehW.ucIEsnFPTsf99XPK'),
(10, 1, 'coucou@tofkl.com', 'coucou', 'toto', '$2y$10$1KGfXtTmllUlnHACm.rFSuxHPLAIMojVCC0JvZUDlTZj5Kw7LHDA6'),
(11, 3, 'jean.jardin@etu.univ-tours.fr', 'Jean', 'Jardin', '$2y$10$vLsd2otwNo2UVSG30Cma7eWEikbVYlt5XtzeoS9Nh3kcZ/2tmn7bW'),
(12, 3, 'slim.shady@etu.univ-tours.fr', 'Slim', 'Shady', '$2y$10$xnbinPJYSGFh0HsnCyVM3OenAEOIBQBdVvuq/b5tRcXJ3eMPpgfRa'),
(13, 3, 'jim.warrior@etu.univ-tours.fr', 'Jim', 'Warrior', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(14, 3, 'alexandre.astier@etu.univ-tours.fr', 'Alexandre', 'Astier', '$2y$10$hzNPsMWdHnA50J.Dw.MK2uMpBSi9gafkwM3dw9zmPRZqvdnosMRNO'),
(15, 3, 'jim.roux@etu.univ-tours.fr', 'jim', 'roux', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(16, 3, 'jim.toast@etu.univ-tours.fr', 'jim', 'toast', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(17, 3, 'paul.dupont@etu.univ-tours.fr', 'paul', 'dupont', '$2y$10$Fmr3ois3yXAXUopN1ptSZuZw/DmVz/SRN9YA1QfbxiuF8VV.dDYVC'),
(18, 3, 'marie.dupont@etu.univ-tours.fr', 'marie', 'dupont', '$2y$10$9gb3ICBMhWZ5A/7.2A.86eHL6BDYFjlDJy.G/jkTnyxdGZFFlEy2a'),
(19, 3, 'jim.dupont@etu.univ-tours.fr', 'jim', 'dupont', '$2y$10$tVyfr8OHpSIE6N1Bo5Pa8u8WhTy.c0C0wjmdB19Ab2I6hT0SlQl6O'),
(20, 3, 'manon.dupont@etu.univ-tours.fr', 'manon', 'dupont', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(21, 3, 'jimmy.neutron@etu.univ-tours.fr', 'jimmy', 'neutron', '$2y$10$DKOtZJ.VZnHQ9BoeH.egxeNONWlHa1ZUJ/46gUgjlTKX9RDaNeSGS'),
(22, 3, 'elon.musk@etu.univ-tours.fr', 'elon', 'musk', '$2y$10$JZzCWR39n8hm9UMfYCWtY.ccw0IeE3l6ie71N5BGoK8Pg7or95AEK'),
(23, 3, 'aaron.swartz@etu.univ-tours.fr', 'aaron', 'swartz', '$2y$10$e652VNU2k8gwTOiRkVXMhuH01fm/H.HWzgZQciQ6BQhTyeal7dhlC'),
(24, 3, 'mark.zuckerberg@etu.univ-tours.fr', 'mark', 'zuckerberg', '$2y$10$CrZZIC./AkTE/f8o//9Rw.NHBB3oxwOoFchvo68eIsWuo5pjC5oTS'),
(25, 3, 'chuck.norris@etu.univ-tours.fr', 'chuck', 'norris', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(26, 3, 'chuck.bartowski@etu.univ-tours.fr', 'chuck', 'bartowski', '$2y$10$DX8.qSfoMd.qq8f40Q6vhO5mo6QgyTlaGVJ9JF0dIngkda/fp66yW'),
(27, 3, 'truc.much@etu.univ-tours.fr', 'truc', 'much', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(28, 3, 'car.resse@etu.univ-tours.fr', 'car', 'resse', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(29, 3, 'aloe.vera@etu.univ-tours.fr', 'aloe', 'vera', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `answers_questionnaires_users`
--
ALTER TABLE `answers_questionnaires_users`
  ADD CONSTRAINT `answers_questionnaires_users_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `answers_questionnaires_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `answers_questionnaires_users_ibfk_3` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`id`),
  ADD CONSTRAINT `answers_questionnaires_users_ibfk_4` FOREIGN KEY (`questionnaire_id`) REFERENCES `questionnaires` (`id`),
  ADD CONSTRAINT `fk_q_u_f` FOREIGN KEY (`for_who`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `answers_questionnaires_users_partials`
--
ALTER TABLE `answers_questionnaires_users_partials`
  ADD CONSTRAINT `answers_questionnaires_users_partials_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `answers_questionnaires_users_partials_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `answers_questionnaires_users_partials_ibfk_3` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`id`),
  ADD CONSTRAINT `answers_questionnaires_users_partials_ibfk_4` FOREIGN KEY (`questionnaire_id`) REFERENCES `questionnaires` (`id`),
  ADD CONSTRAINT `fk_q_u_p_f` FOREIGN KEY (`for_who`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `answers_questions_questionnaires`
--
ALTER TABLE `answers_questions_questionnaires`
  ADD CONSTRAINT `fk_answers_q_a` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`id`),
  ADD CONSTRAINT `fk_answers_q_q` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `fk_answers_q_qu` FOREIGN KEY (`questionnaire_id`) REFERENCES `questionnaires` (`id`);

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
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
