-- phpMyAdmin SQL Dump
-- version 4.2.5
-- http://www.phpmyadmin.net
--
-- Client :  localhost:3306
-- Généré le :  Ven 08 Mai 2015 à 02:35
-- Version du serveur :  5.5.38
-- Version de PHP :  5.5.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `exo`
--

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
`id` int(10) unsigned NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` text NOT NULL,
  `signup_date` date NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `avatar`, `signup_date`) VALUES
(2, 'phrenel', 'phrenel', '', '0000-00-00'),
(1, 'phrenel', 'phrenel', '', '0000-00-00'),
(3, 'umut', 'hetic2015', '', '0000-00-00'),
(4, 'matthieu', 'hetic2015', '', '0000-00-00'),
(5, 'judith', 'judith', '', '2015-02-11'),
(6, 'johnfordman', 'hetic2', '', '2015-02-11'),
(7, 'jean', '8aa0dacb7bc543021866901bf539dc59076c8b091734d1997d838859c35703406c6f92e02df0fa2d15412a131dc6c67108f6a33d0011c424ca29b82cd089ae90', 'upload/', '2015-05-08'),
(8, 'u', 'b0412597dcea813655574dc54a5b74967cf85317f0332a2591be7953a016f8de56200eb37d5ba593b1e4aa27cea5ca27100f94dccd5b04bae5cadd4454dba67d', 'upload/', '2015-05-08');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;