-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Lun 25 Mai 2015 à 23:20
-- Version du serveur :  5.6.21
-- Version de PHP :  5.6.3

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
`id` int(10) unsigned NOT NULL,
  `value` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `answers`
--

INSERT INTO `answers` (`id`, `value`) VALUES
(12, 'Beaucoup plus que normal'),
(7, 'Je ne sais pas'),
(1, 'Je suis un chat'),
(3, 'Je suis un cheval'),
(2, 'Je suis un chien'),
(4, 'Je suis une patate'),
(6, 'Non'),
(10, 'Normal'),
(5, 'Oui'),
(8, 'Un peu'),
(9, 'Un peu plus'),
(11, 'Un peu plus que normal');

-- --------------------------------------------------------

--
-- Structure de la table `answers_questionnaires_users`
--

CREATE TABLE IF NOT EXISTS `answers_questionnaires_users` (
  `question_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `answer_id` int(10) unsigned NOT NULL,
  `questionnaire_id` int(10) unsigned NOT NULL,
  `for_who` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `answers_questionnaires_users_partials`
--

CREATE TABLE IF NOT EXISTS `answers_questionnaires_users_partials` (
  `question_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `answer_id` int(10) unsigned NOT NULL,
  `questionnaire_id` int(10) unsigned NOT NULL,
  `for_who` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `answers_questions_questionnaires`
--

CREATE TABLE IF NOT EXISTS `answers_questions_questionnaires` (
  `question_id` int(10) unsigned NOT NULL,
  `answer_id` int(10) unsigned NOT NULL,
  `questionnaire_id` int(10) unsigned NOT NULL,
  `position` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `description` varchar(500) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `groups_owners`
--

CREATE TABLE IF NOT EXISTS `groups_owners` (
  `group_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `groups_users`
--

CREATE TABLE IF NOT EXISTS `groups_users` (
  `user_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
`id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` varchar(255) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `modules_groups`
--

CREATE TABLE IF NOT EXISTS `modules_groups` (
  `module_id` int(11) unsigned NOT NULL,
  `group_id` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `modules_owners`
--

CREATE TABLE IF NOT EXISTS `modules_owners` (
  `module_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `modules_users`
--

CREATE TABLE IF NOT EXISTS `modules_users` (
  `user_id` int(11) unsigned NOT NULL,
  `module_id` int(11) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `owners`
--

CREATE TABLE IF NOT EXISTS `owners` (
`id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `questionnaires`
--

CREATE TABLE IF NOT EXISTS `questionnaires` (
`id` int(10) unsigned NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `description` varchar(535) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_limit` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `questionnaires_groups`
--

CREATE TABLE IF NOT EXISTS `questionnaires_groups` (
  `group_id` int(10) unsigned NOT NULL,
  `questionnaire_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `questionnaires_owners`
--

CREATE TABLE IF NOT EXISTS `questionnaires_owners` (
  `questionnaire_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
`id` int(10) unsigned NOT NULL,
  `content` varchar(255) NOT NULL,
  `type` tinyint(2) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `questions`
--

INSERT INTO `questions` (`id`, `content`, `type`) VALUES
(1, 'Tu es un poisson ?', 0),
(2, 'Qui es tu ?', 0),
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
`id` int(10) unsigned NOT NULL,
  `designation` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

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
`id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `first_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `role_id`, `email`, `first_name`, `last_name`, `password`) VALUES
(1, 3, 'alexis.puret@etu.univ-tours.fr', 'Alexis', 'PURET', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(2, 1, 'toast@gmail.com', 'Auto', 'Route', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(3, 3, 'etudiant@toast.com', 'auto', 'route', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(4, 2, 'professeur@toast.com', 'professeur', 'test', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(5, 2, 'prof@toast.com', 'Machin', 'Chose', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(6, 3, 'Monsieur.Dupont@etu.univ-tours.fr', 'Monsieur', 'Dupont', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(8, 3, 'manon.dupuet@etu.univ-tours.fr', 'manon', 'dupuet', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(9, 3, 'Alexandre.Astier@etu.univ-tours.fr', 'Alexandre', 'Astier', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(10, 1, 'coucou@tofkl.com', 'coucou', 'toto', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(11, 3, 'jean.jardin@etu.univ-tours.fr', 'Jean', 'Jardin', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(12, 3, 'slim.shady@etu.univ-tours.fr', 'Slim', 'Shady', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(13, 3, 'jim.warrior@etu.univ-tours.fr', 'Jim', 'Warrior', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(14, 3, 'alexandre.astier@etu.univ-tours.fr', 'Alexandre', 'Astier', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(15, 3, 'jim.roux@etu.univ-tours.fr', 'jim', 'roux', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(16, 3, 'jim.toast@etu.univ-tours.fr', 'jim', 'toast', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(17, 3, 'paul.dupont@etu.univ-tours.fr', 'paul', 'dupont', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(18, 3, 'marie.dupont@etu.univ-tours.fr', 'marie', 'dupont', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(19, 3, 'jim.dupont@etu.univ-tours.fr', 'jim', 'dupont', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(20, 3, 'manon.dupont@etu.univ-tours.fr', 'manon', 'dupont', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(21, 3, 'jimmy.neutron@etu.univ-tours.fr', 'jimmy', 'neutron', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(22, 3, 'elon.musk@etu.univ-tours.fr', 'elon', 'musk', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(23, 3, 'aaron.swartz@etu.univ-tours.fr', 'aaron', 'swartz', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(24, 3, 'mark.zuckerberg@etu.univ-tours.fr', 'mark', 'zuckerberg', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(25, 3, 'chuck.norris@etu.univ-tours.fr', 'chuck', 'norris', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(26, 3, 'chuck.bartowski@etu.univ-tours.fr', 'chuck', 'bartowski', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(27, 3, 'truc.much@etu.univ-tours.fr', 'truc', 'much', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(28, 3, 'car.resse@etu.univ-tours.fr', 'car', 'resse', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(29, 3, 'aloe.vera@etu.univ-tours.fr', 'aloe', 'vera', '$2y$10$vu2vKuRWVYEsEwVLtQr9oe6XWxvjvXwDMgla0blNpgFYOKOonpYwa'),
(30, 3, 'route.auto@etu.univ-tours.fr', 'route', 'auto', '$2y$10$MUCZNv.LT0s4RWei7vt7bOLlMbEAVYxwvdG1eDU1YveJ/97NcPQEW');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `answers`
--
ALTER TABLE `answers`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `value` (`value`);

--
-- Index pour la table `answers_questionnaires_users`
--
ALTER TABLE `answers_questionnaires_users`
 ADD PRIMARY KEY (`question_id`,`user_id`,`questionnaire_id`,`for_who`), ADD KEY `answers_users_user` (`user_id`), ADD KEY `answers_users_reponse` (`answer_id`), ADD KEY `answers_users_questionnaire` (`questionnaire_id`), ADD KEY `fk_q_u_f` (`for_who`);

--
-- Index pour la table `answers_questionnaires_users_partials`
--
ALTER TABLE `answers_questionnaires_users_partials`
 ADD PRIMARY KEY (`question_id`,`user_id`,`questionnaire_id`,`for_who`), ADD KEY `answers_users_user` (`user_id`), ADD KEY `answers_users_reponse` (`answer_id`), ADD KEY `answers_users_questionnaire` (`questionnaire_id`), ADD KEY `fk_q_u_p_f` (`for_who`);

--
-- Index pour la table `answers_questions_questionnaires`
--
ALTER TABLE `answers_questions_questionnaires`
 ADD PRIMARY KEY (`question_id`,`answer_id`,`questionnaire_id`), ADD KEY `fk_answers_q_a` (`answer_id`), ADD KEY `fk_answers_q_qu` (`questionnaire_id`);

--
-- Index pour la table `groups`
--
ALTER TABLE `groups`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `groups_owners`
--
ALTER TABLE `groups_owners`
 ADD PRIMARY KEY (`group_id`,`user_id`), ADD KEY `groups_owners_users` (`user_id`);

--
-- Index pour la table `groups_users`
--
ALTER TABLE `groups_users`
 ADD PRIMARY KEY (`user_id`,`group_id`), ADD KEY `groups_users_group_key` (`group_id`);

--
-- Index pour la table `modules`
--
ALTER TABLE `modules`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `modules_groups`
--
ALTER TABLE `modules_groups`
 ADD PRIMARY KEY (`module_id`,`group_id`), ADD KEY `fk_modules_groups_id` (`group_id`);

--
-- Index pour la table `modules_owners`
--
ALTER TABLE `modules_owners`
 ADD PRIMARY KEY (`module_id`,`user_id`), ADD KEY `modules_owners_users` (`user_id`);

--
-- Index pour la table `modules_users`
--
ALTER TABLE `modules_users`
 ADD PRIMARY KEY (`user_id`,`module_id`), ADD KEY `fk_modules_midu_id` (`module_id`);

--
-- Index pour la table `owners`
--
ALTER TABLE `owners`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `questionnaires`
--
ALTER TABLE `questionnaires`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `questionnaires_groups`
--
ALTER TABLE `questionnaires_groups`
 ADD PRIMARY KEY (`group_id`,`questionnaire_id`), ADD KEY `questionnaires_groups_questionnaire` (`questionnaire_id`);

--
-- Index pour la table `questionnaires_owners`
--
ALTER TABLE `questionnaires_owners`
 ADD PRIMARY KEY (`questionnaire_id`,`user_id`), ADD KEY `questionnaires_owners_users` (`user_id`);

--
-- Index pour la table `questions`
--
ALTER TABLE `questions`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `email` (`email`), ADD KEY `user_role` (`role_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `answers`
--
ALTER TABLE `answers`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `groups`
--
ALTER TABLE `groups`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `modules`
--
ALTER TABLE `modules`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `owners`
--
ALTER TABLE `owners`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `questionnaires`
--
ALTER TABLE `questionnaires`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `questions`
--
ALTER TABLE `questions`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
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
