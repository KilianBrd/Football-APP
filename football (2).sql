-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : ven. 09 août 2024 à 21:54
-- Version du serveur : 11.4.2-MariaDB
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `football`
--

-- --------------------------------------------------------

--
-- Structure de la table `club`
--

CREATE TABLE `club` (
  `id` int(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `pays` varchar(255) NOT NULL,
  `ligue` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `joueur`
--

CREATE TABLE `joueur` (
  `id` int(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `age` int(255) NOT NULL,
  `club` varchar(255) NOT NULL,
  `nation` varchar(255) NOT NULL,
  `poste` varchar(255) NOT NULL,
  `appreciation` varchar(255) DEFAULT NULL,
  `note` int(255) DEFAULT NULL,
  `tete` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `joueur`
--

INSERT INTO `joueur` (`id`, `nom`, `prenom`, `age`, `club`, `nation`, `poste`, `appreciation`, `note`, `tete`) VALUES
(7, 'Nanasi', 'Sebastian', 21, 'Malmo', 'Suède', 'MOC', 'Fort ce nanasi', NULL, 'uploads/nanasi.jpg'),
(8, 'Beraud', 'Erwan', 17, 'OL', 'Brésil', 'DD', 'adijzdoapfppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppppifhoiuezahfouahfeuieahfiuezahfiuezfiuezhf', NULL, 'uploads/img_7361__o7n92e.jpg'),
(9, 'Larsonneur', 'Gauthier', 27, 'ASSE', 'France', 'G', 'Bon joueur (le meilleur de sainté)', NULL, 'uploads/Larsonneur.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `joueur_id` int(11) NOT NULL,
  `note` int(11) NOT NULL CHECK (`note` >= 0 and `note` <= 10),
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `notes`
--

INSERT INTO `notes` (`id`, `joueur_id`, `note`, `created_at`) VALUES
(1, 8, 4, '2024-08-09 21:19:40'),
(2, 8, 4, '2024-08-09 21:19:59'),
(3, 8, 4, '2024-08-09 21:21:03'),
(4, 8, 4, '2024-08-09 21:32:57'),
(5, 8, 2, '2024-08-09 21:35:46'),
(6, 8, 1, '2024-08-09 21:52:53'),
(7, 8, 1, '2024-08-09 21:53:13'),
(8, 8, 1, '2024-08-09 21:53:21');

-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

CREATE TABLE `pays` (
  `PAYSID` int(11) NOT NULL,
  `PAYSNAME` varchar(80) NOT NULL,
  `PAYSCODE` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `pays`
--

INSERT INTO `pays` (`PAYSID`, `PAYSNAME`, `PAYSCODE`) VALUES
(1, 'France', 'fr'),
(2, 'Afghanistan', 'af'),
(3, 'Afrique du sud', 'za'),
(4, 'Albanie', 'al'),
(5, 'Algérie', 'dz'),
(6, 'Allemagne', 'de'),
(7, 'Arabie saoudite', 'sa'),
(8, 'Argentine', 'ar'),
(9, 'Australie', 'au'),
(10, 'Autriche', 'at'),
(11, 'Belgique', 'be'),
(12, 'Brésil', 'br'),
(13, 'Bulgarie', 'bg'),
(14, 'Canada', 'ca'),
(15, 'Chili', 'cl'),
(16, 'Chine (Rép. pop.)', 'cn'),
(17, 'Colombie', 'co'),
(18, 'Corée, Sud', 'kr'),
(19, 'Costa Rica', 'cr'),
(20, 'Croatie', 'hr'),
(21, 'Danemark', 'dk'),
(22, 'Egypte', 'eg'),
(23, 'Emirats arabes unis', 'ae'),
(24, 'Equateur', 'ec'),
(25, 'Etats-Unis', 'us'),
(26, 'El Salvador', 'sv'),
(27, 'Espagne', 'es'),
(28, 'Finlande', 'fi'),
(29, 'Grèce', 'gr'),
(30, 'Hong Kong', 'hk'),
(31, 'Hongrie', 'hu'),
(32, 'Inde', 'in'),
(33, 'Indonésie', 'id'),
(34, 'Irlande', 'ie'),
(35, 'Israël', 'il'),
(36, 'Italie', 'it'),
(37, 'Japon', 'jp'),
(38, 'Jordanie', 'jo'),
(39, 'Liban', 'lb'),
(40, 'Malaisie', 'my'),
(41, 'Maroc', 'ma'),
(42, 'Mexique', 'mx'),
(43, 'Norvège', 'no'),
(44, 'Nouvelle-Zélande', 'nz'),
(45, 'Pérou', 'pe'),
(46, 'Pakistan', 'pk'),
(47, 'Pays-Bas', 'nl'),
(48, 'Philippines', 'ph'),
(49, 'Pologne', 'pl'),
(50, 'Porto Rico', 'pr'),
(51, 'Portugal', 'pt'),
(52, 'République tchèque', 'cz'),
(53, 'Roumanie', 'ro'),
(54, 'Royaume-Uni', 'uk'),
(55, 'Russie', 'ru'),
(56, 'Singapour', 'sg'),
(57, 'Suède', 'se'),
(58, 'Suisse', 'ch'),
(59, 'Taiwan', 'tw'),
(60, 'Thailande', 'th'),
(61, 'Turquie', 'tr'),
(62, 'Ukraine', 'ua'),
(63, 'Venezuela', 've'),
(64, 'Yougoslavie', 'yu'),
(65, 'Samoa', 'as'),
(66, 'Andorre', 'ad'),
(67, 'Angola', 'ao'),
(68, 'Anguilla', 'ai'),
(69, 'Antarctique', 'aq'),
(70, 'Antigua et Barbuda', 'ag'),
(71, 'Arménie', 'am'),
(72, 'Aruba', 'aw'),
(73, 'Azerbaïdjan', 'az'),
(74, 'Bahamas', 'bs'),
(75, 'Bahrain', 'bh'),
(76, 'Bangladesh', 'bd'),
(77, 'Biélorussie', 'by'),
(78, 'Belize', 'bz'),
(79, 'Benin', 'bj'),
(80, 'Bermudes (Les)', 'bm'),
(81, 'Bhoutan', 'bt'),
(82, 'Bolivie', 'bo'),
(83, 'Bosnie-Herzégovine', 'ba'),
(84, 'Botswana', 'bw'),
(85, 'Bouvet (îles)', 'bv'),
(86, 'Territoire britannique de l\'océan Indien', 'io'),
(87, 'Vierges britanniques (îles)', 'vg'),
(88, 'Brunei', 'bn'),
(89, 'Burkina Faso', 'bf'),
(90, 'Burundi', 'bi'),
(91, 'Cambodge', 'kh'),
(92, 'Cameroun', 'cm'),
(93, 'Cap Vert', 'cv'),
(94, 'Cayman (îles)', 'ky'),
(95, 'République centrafricaine', 'cf'),
(96, 'Tchad', 'td'),
(97, 'Christmas (île)', 'cx'),
(98, 'Cocos (îles)', 'cc'),
(99, 'Comores', 'km'),
(100, 'Rép. Dém. du Congo', 'cg'),
(101, 'Cook (îles)', 'ck'),
(102, 'Cuba', 'cu'),
(103, 'Chypre', 'cy'),
(104, 'Djibouti', 'dj'),
(105, 'Dominique', 'dm'),
(106, 'République Dominicaine', 'do'),
(107, 'Timor', 'tp'),
(108, 'Guinée Equatoriale', 'gq'),
(109, 'Erythrée', 'er'),
(110, 'Estonie', 'ee'),
(111, 'Ethiopie', 'et'),
(112, 'Falkland (île)', 'fk'),
(113, 'Féroé (îles)', 'fo'),
(114, 'Fidji (République des)', 'fj'),
(115, 'Guyane franéaise', 'gf'),
(116, 'Polynésie française', 'pf'),
(117, 'Territoires français du sud', 'tf'),
(118, 'Gabon', 'ga'),
(119, 'Gambie', 'gm'),
(120, 'Géorgie', 'ge'),
(121, 'Ghana', 'gh'),
(122, 'Gibraltar', 'gi'),
(123, 'Groenland', 'gl'),
(124, 'Grenade', 'gd'),
(125, 'Guadeloupe', 'gp'),
(126, 'Guam', 'gu'),
(127, 'Guatemala', 'gt'),
(128, 'Guinée', 'gn'),
(129, 'Guinée-Bissau', 'gw'),
(130, 'Guyane', 'gy'),
(131, 'Haïti', 'ht'),
(132, 'Heard et McDonald (îles)', 'hm'),
(133, 'Honduras', 'hn'),
(134, 'Islande', 'is'),
(135, 'Iran', 'ir'),
(136, 'Irak', 'iq'),
(137, 'Côte d\'Ivoire', 'ci'),
(138, 'Jamaïque', 'jm'),
(139, 'Kazakhstan', 'kz'),
(140, 'Kenya', 'ke'),
(141, 'Kiribati', 'ki'),
(142, 'Corée du Nord', 'kp'),
(143, 'Koweit', 'kw'),
(144, 'Kirghizistan', 'kg'),
(145, 'Laos', 'la'),
(146, 'Lettonie', 'lv'),
(147, 'Lesotho', 'ls'),
(148, 'Libéria', 'lr'),
(149, 'Libye', 'ly'),
(150, 'Liechtenstein', 'li'),
(151, 'Lithuanie', 'lt'),
(152, 'Luxembourg', 'lu'),
(153, 'Macau', 'mo'),
(154, 'Macédoine', 'mk'),
(155, 'Madagascar', 'mg'),
(156, 'Malawi', 'mw'),
(157, 'Maldives (îles)', 'mv'),
(158, 'Mali', 'ml'),
(159, 'Malte', 'mt'),
(160, 'Marshall (îles)', 'mh'),
(161, 'Martinique', 'mq'),
(162, 'Mauritanie', 'mr'),
(163, 'Maurice', 'mu'),
(164, 'Mayotte', 'yt'),
(165, 'Micronésie (?tats f?d?r?s de)', 'fm'),
(166, 'Moldavie', 'md'),
(167, 'Monaco', 'mc'),
(168, 'Mongolie', 'mn'),
(169, 'Montserrat', 'ms'),
(170, 'Mozambique', 'mz'),
(171, 'Myanmar', 'mm'),
(172, 'Namibie', 'na'),
(173, 'Nauru', 'nr'),
(174, 'Nepal', 'np'),
(175, 'Antilles néerlandaises', 'an'),
(176, 'Nouvelle Calédonie', 'nc'),
(177, 'Nicaragua', 'ni'),
(178, 'Niger', 'ne'),
(179, 'Nigeria', 'ng'),
(180, 'Niue', 'nu'),
(181, 'Norfolk (îles)', 'nf'),
(182, 'Mariannes du Nord (îles)', 'mp'),
(183, 'Oman', 'om'),
(184, 'Palau', 'pw'),
(185, 'Panama', 'pa'),
(186, 'Papouasie-Nouvelle-Guinée', 'pg'),
(187, 'Paraguay', 'py'),
(188, 'Pitcairn (îles)', 'pn'),
(189, 'Qatar', 'qa'),
(190, 'Réunion (La)', 're'),
(191, 'Rwanda', 'rw'),
(192, 'Géorgie du Sud et Sandwich du Sud (îles)', 'gs'),
(193, 'Saint-Kitts et Nevis', 'kn'),
(194, 'Sainte Lucie', 'lc'),
(195, 'Saint Vincent et les Grenadines', 'vc'),
(196, 'Samoa', 'ws'),
(197, 'Saint-Marin (Rép. de)', 'sm'),
(198, 'Sao Toma et Principe (Rép.)', 'st'),
(199, 'Sénégal', 'sn'),
(200, 'Seychelles', 'sc'),
(201, 'Sierra Leone', 'sl'),
(202, 'Slovaquie', 'sk'),
(203, 'Slovénie', 'si'),
(204, 'Somalie', 'so'),
(205, 'Sri Lanka', 'lk'),
(206, 'Sainte Hélène', 'sh'),
(207, 'Saint Pierre et Miquelon', 'pm'),
(208, 'Soudan', 'sd'),
(209, 'Suriname', 'sr'),
(210, 'Svalbard et Jan Mayen (îles)', 'sj'),
(211, 'Swaziland', 'sz'),
(212, 'Syrie', 'sy'),
(213, 'Tadjikistan', 'tj'),
(214, 'Tanzanie', 'tz'),
(215, 'Togo', 'tg'),
(216, 'Tokelau', 'tk'),
(217, 'Tonga', 'to'),
(218, 'Trinité et Tobago', 'tt'),
(219, 'Tunisie', 'tn'),
(220, 'Turkménistan', 'tm'),
(221, 'Turks et Caques (îles)', 'tc'),
(222, 'Tuvalu', 'tv'),
(223, 'îles Mineures éloignées des Etats-Unis', 'um'),
(224, 'Ouganda', 'ug'),
(225, 'Uruguay', 'uy'),
(226, 'Ouzbékistan', 'uz'),
(227, 'Vanuatu', 'vu'),
(228, 'Vatican (Etat du)', 'va'),
(229, 'Vietnam', 'vn'),
(230, 'Vierges (îles)', 'vi'),
(231, 'Wallis et Futuna (îles)', 'wf'),
(232, 'Sahara Occidental', 'eh'),
(233, 'Yemen', 'ye'),
(234, 'Zaïre', 'zr'),
(235, 'Zambie', 'zm'),
(236, 'Zimbabwe', 'zw'),
(237, 'La Barbad', 'bb');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `club`
--
ALTER TABLE `club`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `joueur`
--
ALTER TABLE `joueur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `joueur_id` (`joueur_id`);

--
-- Index pour la table `pays`
--
ALTER TABLE `pays`
  ADD PRIMARY KEY (`PAYSID`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `club`
--
ALTER TABLE `club`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `joueur`
--
ALTER TABLE `joueur`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `pays`
--
ALTER TABLE `pays`
  MODIFY `PAYSID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=238;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`joueur_id`) REFERENCES `joueur` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
