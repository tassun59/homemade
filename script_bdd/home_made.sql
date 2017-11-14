-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Client :  localhost
-- Généré le :  Mar 14 Novembre 2017 à 22:08
-- Version du serveur :  5.5.54-MariaDB
-- Version de PHP :  5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `home_made`
--

-- --------------------------------------------------------

--
-- Structure de la table `T_BUDGET`
--

CREATE TABLE `T_BUDGET` (
  `BUD_ID` int(5) NOT NULL,
  `BUD_LIBELLE` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `T_BUDGET`
--

INSERT INTO `T_BUDGET` (`BUD_ID`, `BUD_LIBELLE`) VALUES
(1, 'Bon marché'),
(2, 'Budget moyen'),
(3, 'Budget élevé');

-- --------------------------------------------------------

--
-- Structure de la table `T_CATEGORIE`
--

CREATE TABLE `T_CATEGORIE` (
  `CAT_ID` int(5) NOT NULL,
  `CAT_TITRE` varchar(250) NOT NULL,
  `CAT_ORDRE_AFF` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Contenu de la table `T_CATEGORIE`
--

INSERT INTO `T_CATEGORIE` (`CAT_ID`, `CAT_TITRE`, `CAT_ORDRE_AFF`) VALUES
(1, 'Techniques de base', 1),
(2, 'Apéritifs', 2),
(3, 'Autres plats', 7),
(4, 'Boissons', 3),
(5, 'Desserts', 11),
(6, 'Entrées', 4),
(7, 'Pains', 10),
(8, 'Poissons et crustacés', 6),
(9, 'Sauces, beurres et condiments', 9),
(10, 'Viandes', 5),
(11, 'Restauration rapide', 8);

-- --------------------------------------------------------

--
-- Structure de la table `T_EVENEMENT`
--

CREATE TABLE `T_EVENEMENT` (
  `EVE_ID` int(5) NOT NULL,
  `EVE_TITRE` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `T_EVENEMENT`
--

INSERT INTO `T_EVENEMENT` (`EVE_ID`, `EVE_TITRE`) VALUES
(1, 'Chandeleur'),
(2, 'Fêtes des mères'),
(3, 'Galette des roi/Epiphanie'),
(4, 'Halloween'),
(5, 'Saint-Patrick'),
(6, 'Mardi-Gras'),
(7, 'Nôel & fêtes de fin d\'années'),
(8, 'Nouvel an chinois'),
(9, 'Pâques'),
(10, 'Réveillon nouvel an'),
(11, 'Saint Nicolas'),
(12, 'Saint Valentin');

-- --------------------------------------------------------

--
-- Structure de la table `T_INGREDIENT`
--

CREATE TABLE `T_INGREDIENT` (
  `ING_ID` int(9) NOT NULL,
  `ING_LIBELLE` varchar(250) DEFAULT NULL,
  `TIN_ID` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `T_INGREDIENT`
--

INSERT INTO `T_INGREDIENT` (`ING_ID`, `ING_LIBELLE`, `TIN_ID`) VALUES
(1, 'Gianduja', 9),
(2, 'Grué de cacao (fèves de cacao concassées)', 9),
(3, 'Riz soufflé', 11),
(4, 'Feuillantine (crêpes dentelles séchées concassées)', 12),
(5, 'Spéculoos', 12),
(6, 'Fleur de sel', 10),
(7, 'Crème liquide', 8),
(8, 'Glucose', 13),
(9, 'Chocolat noir Manjari 62%', 9),
(10, 'Purée de framboise', 6),
(11, 'Purée de mûres', 6),
(12, 'Eau de vie de framboise', 14),
(13, 'Crème montée', 8),
(14, 'Framboises', 6),
(15, 'Mûres', 6),
(16, 'Poudre dorée', 13),
(17, 'Kirsch', 14);

-- --------------------------------------------------------

--
-- Structure de la table `T_MATERIEL`
--

CREATE TABLE `T_MATERIEL` (
  `MAT_ID` int(5) NOT NULL,
  `MAT_LIBELLE` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `T_MATERIEL`
--

INSERT INTO `T_MATERIEL` (`MAT_ID`, `MAT_LIBELLE`) VALUES
(1, 'Cul de poule'),
(2, 'Couteau d\'office'),
(3, 'Maryse'),
(4, 'Fouet'),
(5, 'Bol'),
(6, 'Ecumoir'),
(7, 'Silpat'),
(8, 'Plaque cuisson'),
(9, 'Papier cuisson'),
(10, 'Poche à douille'),
(12, 'douille');

-- --------------------------------------------------------

--
-- Structure de la table `T_NIVEAU`
--

CREATE TABLE `T_NIVEAU` (
  `NIV_ID` int(5) NOT NULL,
  `NIV_LIBELLE` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `T_NIVEAU`
--

INSERT INTO `T_NIVEAU` (`NIV_ID`, `NIV_LIBELLE`) VALUES
(1, 'Facile'),
(2, 'Moyen'),
(3, 'Difficle'),
(4, 'Très difficile');

-- --------------------------------------------------------

--
-- Structure de la table `T_RECETTE`
--

CREATE TABLE `T_RECETTE` (
  `REC_ID` int(5) NOT NULL,
  `REC_TITRE` varchar(250) DEFAULT NULL,
  `REC_CATEGORIE` int(5) DEFAULT NULL,
  `REC_SOUS_CATEGORIE` int(5) DEFAULT NULL,
  `REC_NIVEAU` int(1) DEFAULT NULL,
  `REC_BUDGET` int(1) DEFAULT NULL,
  `REC_TPS_PREPA` int(5) DEFAULT NULL,
  `REC_TPS_REPOS` int(5) DEFAULT NULL,
  `REC_TPS_CUISSON` int(5) DEFAULT NULL,
  `REC_NB_CONVIVES` int(5) DEFAULT NULL,
  `REC_UNI_FAB_ID` int(5) DEFAULT NULL,
  `REC_NB_REALISATIONS` int(5) DEFAULT NULL,
  `REC_DATE_CREATION` date DEFAULT NULL,
  `REC_DATE_MODIF` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `REC_ID_EVENEMENT` int(5) DEFAULT NULL,
  `REC_ID_LIEU` int(5) DEFAULT NULL,
  `REC_TAG` varchar(250) DEFAULT NULL,
  `REC_ID_SOURCE` int(5) DEFAULT NULL,
  `REC_LIEN_SOURCE` varchar(250) DEFAULT NULL,
  `REC_FAVORI` int(1) DEFAULT NULL,
  `REC_IMG_PRINC` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `T_RECETTE`
--

INSERT INTO `T_RECETTE` (`REC_ID`, `REC_TITRE`, `REC_CATEGORIE`, `REC_SOUS_CATEGORIE`, `REC_NIVEAU`, `REC_BUDGET`, `REC_TPS_PREPA`, `REC_TPS_REPOS`, `REC_TPS_CUISSON`, `REC_NB_CONVIVES`, `REC_UNI_FAB_ID`, `REC_NB_REALISATIONS`, `REC_DATE_CREATION`, `REC_DATE_MODIF`, `REC_ID_EVENEMENT`, `REC_ID_LIEU`, `REC_TAG`, `REC_ID_SOURCE`, `REC_LIEN_SOURCE`, `REC_FAVORI`, `REC_IMG_PRINC`) VALUES
(1, 'Fantastik au chocolat, mûres et framboises par Christophe Michalak dddddssss', 4, 13, 3, 1, 50, 15, 10, 6, 2, 2, NULL, '2017-10-19 20:46:30', NULL, NULL, 'chocolat', 2, 'http://www.france2.fr/emissions/dans-la-peau-d-un-chef/recettes/fantastik-au-chocolat-mures-et-framboises-par-christophe-michalak', 1, './ressources/1/20150517_212944.jpg'),
(2, 'Test recette N°2', 4, 13, 1, 2, 12, 24, 48, 2, 2, NULL, NULL, '2017-10-17 18:19:01', 1, 2, 'test', NULL, NULL, 1, NULL),
(3, 'Recette N°4', 4, 13, 2, 2, 4, 0, 10, 3, 2, 1, NULL, '2017-10-17 18:19:22', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'recette 3', 4, 13, 1, 1, 10, 10, 12, 3, 1, 2, NULL, '2017-08-17 16:18:27', NULL, NULL, NULL, NULL, NULL, 1, NULL),
(5, NULL, 4, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-09-06 11:57:56', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, NULL, 4, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-09-06 11:57:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, NULL, 4, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-09-06 11:58:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, NULL, 4, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-09-06 11:58:02', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, NULL, 4, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-09-06 11:58:03', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, NULL, 5, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-09-06 11:58:05', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, NULL, 2, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-09-06 11:58:13', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-09-06 11:58:17', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, NULL, 8, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-09-06 11:58:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, NULL, 4, 13, 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-09-06 12:37:40', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 'Test 15', 6, 30, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-09-06 13:00:54', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, NULL, 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-10-17 18:44:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'Test nouvelle recette', 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-10-17 18:46:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `T_RECETTE_ASTUCES`
--

CREATE TABLE `T_RECETTE_ASTUCES` (
  `RAS_ID` int(5) NOT NULL,
  `REC_ID` int(5) NOT NULL,
  `RAS_DESCRIPTION` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Contenu de la table `T_RECETTE_ASTUCES`
--

INSERT INTO `T_RECETTE_ASTUCES` (`RAS_ID`, `REC_ID`, `RAS_DESCRIPTION`) VALUES
(1, 1, 'astuce 1 dddsdsdsqdsq'),
(2, 1, 'Asctuce 2'),
(3, 2, 'Astuce 4'),
(4, 1, 'Astuce test RRRRRRRRR'),
(10, 1, ''),
(11, 1, '');

-- --------------------------------------------------------

--
-- Structure de la table `T_RECETTE_ETAPES`
--

CREATE TABLE `T_RECETTE_ETAPES` (
  `REC_ID` int(5) NOT NULL,
  `ETA_ID` int(5) NOT NULL,
  `ETA_DESCRIPTION` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `T_RECETTE_ETAPES`
--

INSERT INTO `T_RECETTE_ETAPES` (`REC_ID`, `ETA_ID`, `ETA_DESCRIPTION`) VALUES
(1, 1, 'Fondre le gianduja à petite flamme à la casserole. Dans un saladier, rassembler le riz soufflé, la feuillantine, le spéculoos émietté, une pincée de fleur de sel et le grué de cacao. Couler le sablé en cadre carré de 18 cm de côté, sur environ 3 centimètres, sur une plaque avec une feuille de papier sulfurisé, puis placer le tout au frais. dsq fds fgfgddf ffdfdf\n\n\ncx\ncx'),
(1, 2, 'Fondre le chocolat émincé à toute petite flamme, sans jamais dépasser 31°C. Verser le chocolat dans un cornet, puis faire un quadrillage de chocolat sur une feuille de plastique alimentaire. Lorsque le chocolat commence à figer, détailler un cadre de la même taille que celui qui a servi pour la base de biscuit. Retourner ensuite la feuille plastique sur une feuille de papier sulfurisé, et laisser la feuille plastique au-dessus. Mettre au frais pour figer le chocolat. fdfffffff'),
(1, 3, 'Dans une casserole, ajouter le glucose, et les purées de mûre et de framboise, ainsi que la crème liquide. Chauffer le mélange pour bien dissoudre le glucose. Dans un mixer, mixer le chocolat, et ajouter le contenu de la casserole dessus, puis mixer, pour rendre le mélange lisse et homogène. Ajouter la liqueur de framboise. Bien mélanger le tout. Récupérer la crème montée, et mélanger à la ganache lorsqu’elle a refroidi. Débarrasser en poche avec une douille unie moyenne au bout.'),
(1, 4, 'Récupérer le cadre de biscuit chocolat, et le retirer. Dresser des boules de crème chocolat bien régulières. Couper en deux quelques framboises et quelques mûres, puis en parsemer le gâteau harmonieusement.vvv'),
(1, 5, 'Récupérer le décor chocolat, tirer un trait au pinceau de poudre or mélangée à du kirsch, puis déposer le décor sur les boules de ganache du gâteau, sans trop les aplatir. Décorer sur la bande or de quelques fruits.'),
(1, 9, NULL),
(1, 11, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `T_RECETTE_INGREDIENTS`
--

CREATE TABLE `T_RECETTE_INGREDIENTS` (
  `RIN_ID` int(9) NOT NULL,
  `REC_ID` int(5) NOT NULL,
  `RIE_ID` int(5) NOT NULL,
  `ING_ID` int(9) NOT NULL,
  `RIN_COMMENTAIRE` varchar(150) DEFAULT NULL,
  `RIN_QTE` decimal(9,2) DEFAULT NULL,
  `UNI_ID` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Contenu de la table `T_RECETTE_INGREDIENTS`
--

INSERT INTO `T_RECETTE_INGREDIENTS` (`RIN_ID`, `REC_ID`, `RIE_ID`, `ING_ID`, `RIN_COMMENTAIRE`, `RIN_QTE`, `UNI_ID`) VALUES
(3, 1, 1, 3, NULL, '30.00', 1),
(4, 1, 1, 4, NULL, '30.00', 1),
(5, 1, 1, 5, NULL, '30.00', 1),
(6, 1, 1, 6, NULL, '1.00', 2),
(7, 1, 2, 7, NULL, '50.00', 1),
(8, 1, 2, 8, NULL, '40.00', 1),
(9, 1, 2, 9, NULL, '180.00', 1),
(10, 1, 2, 10, NULL, '40.00', 1),
(14, 1, 3, 9, 'émincé finement', '180.00', 1),
(15, 1, 3, 14, NULL, NULL, NULL),
(16, 1, 3, 15, NULL, NULL, NULL),
(34, 1, 4, 17, NULL, NULL, NULL),
(35, 1, 5, 10, NULL, NULL, NULL),
(55, 1, 2, 10, NULL, NULL, NULL),
(56, 1, 1, 10, NULL, '1.00', NULL),
(67, 1, 1, 17, NULL, NULL, NULL),
(68, 1, 1, 17, NULL, '2.00', NULL),
(69, 1, 1, 17, NULL, NULL, NULL),
(71, 1, 1, 17, NULL, NULL, NULL),
(72, 1, 1, 17, NULL, '4.00', NULL),
(73, 1, 1, 17, NULL, '15.00', 1),
(74, 1, 1, 10, NULL, '17.00', 2),
(75, 1, 1, 10, NULL, NULL, NULL),
(85, 1, 1, 12, NULL, NULL, NULL),
(86, 1, 1, 14, NULL, '13.00', 2),
(87, 1, 1, 10, NULL, '11.00', 2),
(88, 1, 1, 10, NULL, '112.00', 2),
(89, 1, 1, 12, NULL, '12.00', 2),
(90, 14, 6, 10, NULL, NULL, NULL),
(91, 1, 1, 10, NULL, NULL, NULL),
(92, 1, 1, 10, NULL, NULL, NULL),
(93, 2, 7, 6, NULL, '10.00', 1),
(94, 3, 9, 6, NULL, '12.00', 2);

-- --------------------------------------------------------

--
-- Structure de la table `T_RECETTE_INGREDIENTS_ENTETE`
--

CREATE TABLE `T_RECETTE_INGREDIENTS_ENTETE` (
  `RIE_ID` int(5) NOT NULL,
  `REC_ID` int(5) NOT NULL,
  `RIE_LIBELLE` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Contenu de la table `T_RECETTE_INGREDIENTS_ENTETE`
--

INSERT INTO `T_RECETTE_INGREDIENTS_ENTETE` (`RIE_ID`, `REC_ID`, `RIE_LIBELLE`) VALUES
(1, 1, 'Sablé minute SSS'),
(2, 1, 'Crémeux chocolat'),
(3, 1, 'Divers'),
(4, 1, NULL),
(5, 1, NULL),
(6, 14, NULL),
(7, 2, NULL),
(8, 2, NULL),
(9, 3, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `T_RECETTE_MATERIEL`
--

CREATE TABLE `T_RECETTE_MATERIEL` (
  `MAT_ID` int(5) NOT NULL,
  `REC_ID` int(5) NOT NULL,
  `RMA_QUANTITE` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Contenu de la table `T_RECETTE_MATERIEL`
--

INSERT INTO `T_RECETTE_MATERIEL` (`MAT_ID`, `REC_ID`, `RMA_QUANTITE`) VALUES
(1, 1, 2),
(2, 1, 4),
(3, 1, 15),
(4, 1, 1),
(5, 1, 3),
(6, 1, 1),
(7, 1, 4),
(8, 1, 2),
(10, 1, 10);

-- --------------------------------------------------------

--
-- Structure de la table `T_SOURCE`
--

CREATE TABLE `T_SOURCE` (
  `SRC_ID` int(5) NOT NULL,
  `SRC_LIBELLE` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `T_SOURCE`
--

INSERT INTO `T_SOURCE` (`SRC_ID`, `SRC_LIBELLE`) VALUES
(1, 'France 2'),
(2, 'Top Chef'),
(3, 'Le meilleur patissier'),
(4, 'Le livre du patissier'),
(5, 'Je prépare mon CAP patissier'),
(6, '750g'),
(7, 'Marmitton'),
(8, 'Ô Délices'),
(9, 'Blog de Mercotte'),
(10, 'TEST'),
(12, 'TEST 3'),
(13, 'TEST 4'),
(14, 'TEST 53'),
(15, 'TEST 6'),
(16, 'TEST 6'),
(17, 'TEST 7'),
(18, 'TEST 8'),
(19, 'TET 9'),
(26, 'TEST 25');

-- --------------------------------------------------------

--
-- Structure de la table `T_SOUS_CATEGORIE`
--

CREATE TABLE `T_SOUS_CATEGORIE` (
  `SCA_ID` int(5) NOT NULL,
  `CAT_ID` int(5) NOT NULL,
  `SCA_TITRE` varchar(250) NOT NULL,
  `SCA_IMAGE` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Contenu de la table `T_SOUS_CATEGORIE`
--

INSERT INTO `T_SOUS_CATEGORIE` (`SCA_ID`, `CAT_ID`, `SCA_TITRE`, `SCA_IMAGE`) VALUES
(1, 2, 'Autres apéritifs', 'images/sous_categories/autres-aperitifs.jpg'),
(2, 2, 'Bouchées', 'images/sous_categories/bouchees.jpg'),
(3, 2, 'Feuilletés', 'images/sous_categories/feuilletes.jpg'),
(4, 2, 'Muffins salés', 'images/sous_categories/muffins.jpg'),
(5, 2, 'Tapas', 'images/sous_categories/tapas.jpg'),
(6, 2, 'Tartines', 'images/sous_categories/tartines.jpg'),
(7, 3, 'Féculents', NULL),
(8, 3, 'Légumes', NULL),
(9, 3, 'Oeufs', 'images/sous_categories/oeufs.jpg'),
(10, 3, 'Pâtes', NULL),
(11, 3, 'Riz', NULL),
(12, 4, 'Boissons sans alcool', 'images/sous_categories/boissons-sans-alcool.jpg'),
(13, 4, 'Cocktails avec alcool', 'images/sous_categories/cocktail-sans-alcool.jpg'),
(14, 4, 'Smoothie', 'images/sous_categories/smoothies.jpg'),
(15, 5, 'Biscuits', 'images/sous_categories/biscuits.jpg'),
(16, 5, 'Cakes sucrés', 'images/sous_categories/cakes-sucres.jpg'),
(17, 5, 'Confitures et gelées', 'images/sous_categories/confitures.jpg'),
(18, 5, 'Crèmes, flans et entremets', 'images/sous_categories/cremes.jpg'),
(19, 5, 'Crêpes, Beignets, Gaufres', 'images/sous_categories/crepes.jpg'),
(20, 5, 'Crumbles et Clafoutis', 'images/sous_categories/crumbles.jpg'),
(21, 5, 'Cupcakes et Muffins', 'images/sous_categories/cupcakes.jpg'),
(22, 5, 'Douceurs', 'images/sous_categories/douceurs.jpg'),
(23, 5, 'Gâteaux', 'images/sous_categories/gateaux.jpg'),
(24, 5, 'Gâteaux de fêtes', 'images/sous_categories/gateaux-fete.jpg'),
(25, 5, 'Glaces et Sorbets', 'images/sous_categories/glaces.jpg'),
(26, 5, 'Macarons', 'images/sous_categories/macarons.jpg'),
(27, 5, 'Tartes sucrées', 'images/sous_categories/tartes-sucrees.jpg'),
(28, 5, 'Verrines sucrées', 'images/sous_categories/verrines-sucrees.jpg'),
(29, 6, 'Cakes', 'images/sous_categories/cake.jpg'),
(30, 6, 'Entrées chaudes', 'images/sous_categories/entrees-chaudes.jpg'),
(31, 6, 'Entrées froides', 'images/sous_categories/entrees_froides.jpg'),
(32, 11, 'Pizzas', 'images/sous_categories/pizza.jpg'),
(33, 11, 'Quiches et Tartes', '	\nimages/sous_categories/tartes-quiches.jpg'),
(34, 11, 'Salades', 'images/sous_categories/salade.jpg'),
(35, 11, 'Sandwichs', 'images/sous_categories/sandwich.jpg'),
(36, 6, 'Soupes', 'images/sous_categories/soupes.jpg'),
(37, 6, 'Terrines', 'images/sous_categories/terrines.jpg'),
(38, 6, 'Verrines salées', '	\nimages/sous_categories/verrines-salees.jpg'),
(39, 7, 'Brioches et Viennoiseries', 'images/sous_categories/brioche.jpg'),
(40, 7, 'Pains salés', 'images/sous_categories/pains-sales.jpg'),
(41, 8, 'Autres poissons', 'images/sous_categories/autre_poisson.jpg'),
(42, 8, 'Cabillaud', NULL),
(43, 8, 'Coquillages', '\nimages/sous_categories/coquillages.jpg'),
(44, 8, 'Crevettes', 'images/sous_categories/crevettes.jpg'),
(45, 8, 'Rougets', 'images/sous_categories/rougets.jpg'),
(46, 8, 'Saumon', NULL),
(47, 9, 'Autres sauces', 'images/sous_categories/autres-sauces.jpg'),
(48, 9, 'Beurre composé', 'images/sous_categories/beurre_d_herbes.jpg'),
(49, 9, 'Condiments', 'images/sous_categories/condiments.jpg'),
(50, 9, 'Sauces à base de légumes', 'images/sous_categories/sauce-legumes.jpg'),
(51, 9, 'Sauce à base de vin', 'images/sous_categories/sauce-vin.jpg'),
(52, 9, 'Sauces blanches', 'images/sous_categories/sauce-blanche.jpg'),
(53, 10, 'Agneau', NULL),
(54, 10, 'Boeuf', NULL),
(55, 10, 'Canard', NULL),
(56, 10, 'Gibier', 'images/sous_categories/gibier.jpg'),
(57, 10, 'Lapin', '	\nimages/sous_categories/lapin.jpg'),
(58, 10, 'Porc', NULL),
(59, 10, 'Veau', '	\nimages/sous_categories/veau.jpg'),
(60, 10, 'Volaille', 'images/sous_categories/poulet.jpg'),
(61, 11, 'Burger', NULL),
(62, 1, 'Technique de base', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `T_THEME`
--

CREATE TABLE `T_THEME` (
  `THE_ID` int(5) NOT NULL,
  `THE_TITRE` varchar(250) NOT NULL,
  `THE_ORDRE_AFF` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Contenu de la table `T_THEME`
--

INSERT INTO `T_THEME` (`THE_ID`, `THE_TITRE`, `THE_ORDRE_AFF`) VALUES
(1, 'Chandeleur', 1),
(2, 'Fête des mères', 2),
(3, 'Epiphanie', 3),
(4, 'Halloween', 4),
(5, 'Saint Patrick', 5),
(6, 'Mardi-Gras', 6),
(7, 'Noël et nouvel an', 7),
(8, 'Nouvel an chinois', 8),
(9, 'Pâques', 9),
(10, 'Saint Nicolas', 10),
(11, 'Saint Valentin', 11);

-- --------------------------------------------------------

--
-- Structure de la table `T_TYPE_INGREDIENT`
--

CREATE TABLE `T_TYPE_INGREDIENT` (
  `TIN_ID` int(9) NOT NULL,
  `TIN_LIBELLE` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `T_TYPE_INGREDIENT`
--

INSERT INTO `T_TYPE_INGREDIENT` (`TIN_ID`, `TIN_LIBELLE`) VALUES
(1, 'Viandes'),
(2, 'Volailles'),
(3, 'Poissons'),
(4, 'Oeufs'),
(5, 'Légumes'),
(6, 'Fruits'),
(7, 'Féculents'),
(8, 'Produits laitiers'),
(9, 'Chocolat'),
(10, 'Epices'),
(11, 'Céréales'),
(12, 'Biscuits'),
(13, 'Autres'),
(14, 'Alcools'),
(16, 'TEST FFFF'),
(17, 'TESSSSSST'),
(18, 'EEE');

-- --------------------------------------------------------

--
-- Structure de la table `T_UNITE`
--

CREATE TABLE `T_UNITE` (
  `UNI_ID` int(5) NOT NULL,
  `UNI_LIBELLE` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `T_UNITE`
--

INSERT INTO `T_UNITE` (`UNI_ID`, `UNI_LIBELLE`) VALUES
(1, 'g'),
(2, 'pincée');

-- --------------------------------------------------------

--
-- Structure de la table `T_UNITE_FAB`
--

CREATE TABLE `T_UNITE_FAB` (
  `FAB_ID` int(5) NOT NULL,
  `FAB_LIBELLE` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `T_UNITE_FAB`
--

INSERT INTO `T_UNITE_FAB` (`FAB_ID`, `FAB_LIBELLE`) VALUES
(1, 'personne(s)'),
(2, 'pièce(s)');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `T_BUDGET`
--
ALTER TABLE `T_BUDGET`
  ADD PRIMARY KEY (`BUD_ID`);

--
-- Index pour la table `T_CATEGORIE`
--
ALTER TABLE `T_CATEGORIE`
  ADD PRIMARY KEY (`CAT_ID`);

--
-- Index pour la table `T_EVENEMENT`
--
ALTER TABLE `T_EVENEMENT`
  ADD PRIMARY KEY (`EVE_ID`);

--
-- Index pour la table `T_INGREDIENT`
--
ALTER TABLE `T_INGREDIENT`
  ADD PRIMARY KEY (`ING_ID`);

--
-- Index pour la table `T_MATERIEL`
--
ALTER TABLE `T_MATERIEL`
  ADD PRIMARY KEY (`MAT_ID`);

--
-- Index pour la table `T_NIVEAU`
--
ALTER TABLE `T_NIVEAU`
  ADD PRIMARY KEY (`NIV_ID`);

--
-- Index pour la table `T_RECETTE`
--
ALTER TABLE `T_RECETTE`
  ADD PRIMARY KEY (`REC_ID`);

--
-- Index pour la table `T_RECETTE_ASTUCES`
--
ALTER TABLE `T_RECETTE_ASTUCES`
  ADD PRIMARY KEY (`RAS_ID`);

--
-- Index pour la table `T_RECETTE_ETAPES`
--
ALTER TABLE `T_RECETTE_ETAPES`
  ADD PRIMARY KEY (`REC_ID`,`ETA_ID`);

--
-- Index pour la table `T_RECETTE_INGREDIENTS`
--
ALTER TABLE `T_RECETTE_INGREDIENTS`
  ADD PRIMARY KEY (`RIN_ID`);

--
-- Index pour la table `T_RECETTE_INGREDIENTS_ENTETE`
--
ALTER TABLE `T_RECETTE_INGREDIENTS_ENTETE`
  ADD PRIMARY KEY (`RIE_ID`);

--
-- Index pour la table `T_RECETTE_MATERIEL`
--
ALTER TABLE `T_RECETTE_MATERIEL`
  ADD PRIMARY KEY (`MAT_ID`,`REC_ID`);

--
-- Index pour la table `T_SOURCE`
--
ALTER TABLE `T_SOURCE`
  ADD PRIMARY KEY (`SRC_ID`);

--
-- Index pour la table `T_SOUS_CATEGORIE`
--
ALTER TABLE `T_SOUS_CATEGORIE`
  ADD PRIMARY KEY (`SCA_ID`);

--
-- Index pour la table `T_THEME`
--
ALTER TABLE `T_THEME`
  ADD PRIMARY KEY (`THE_ID`);

--
-- Index pour la table `T_TYPE_INGREDIENT`
--
ALTER TABLE `T_TYPE_INGREDIENT`
  ADD PRIMARY KEY (`TIN_ID`);

--
-- Index pour la table `T_UNITE`
--
ALTER TABLE `T_UNITE`
  ADD PRIMARY KEY (`UNI_ID`);

--
-- Index pour la table `T_UNITE_FAB`
--
ALTER TABLE `T_UNITE_FAB`
  ADD PRIMARY KEY (`FAB_ID`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `T_BUDGET`
--
ALTER TABLE `T_BUDGET`
  MODIFY `BUD_ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `T_CATEGORIE`
--
ALTER TABLE `T_CATEGORIE`
  MODIFY `CAT_ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT pour la table `T_EVENEMENT`
--
ALTER TABLE `T_EVENEMENT`
  MODIFY `EVE_ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `T_INGREDIENT`
--
ALTER TABLE `T_INGREDIENT`
  MODIFY `ING_ID` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT pour la table `T_MATERIEL`
--
ALTER TABLE `T_MATERIEL`
  MODIFY `MAT_ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `T_NIVEAU`
--
ALTER TABLE `T_NIVEAU`
  MODIFY `NIV_ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `T_RECETTE`
--
ALTER TABLE `T_RECETTE`
  MODIFY `REC_ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT pour la table `T_RECETTE_ASTUCES`
--
ALTER TABLE `T_RECETTE_ASTUCES`
  MODIFY `RAS_ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT pour la table `T_RECETTE_INGREDIENTS`
--
ALTER TABLE `T_RECETTE_INGREDIENTS`
  MODIFY `RIN_ID` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;
--
-- AUTO_INCREMENT pour la table `T_RECETTE_INGREDIENTS_ENTETE`
--
ALTER TABLE `T_RECETTE_INGREDIENTS_ENTETE`
  MODIFY `RIE_ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `T_RECETTE_MATERIEL`
--
ALTER TABLE `T_RECETTE_MATERIEL`
  MODIFY `MAT_ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `T_SOURCE`
--
ALTER TABLE `T_SOURCE`
  MODIFY `SRC_ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT pour la table `T_SOUS_CATEGORIE`
--
ALTER TABLE `T_SOUS_CATEGORIE`
  MODIFY `SCA_ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT pour la table `T_THEME`
--
ALTER TABLE `T_THEME`
  MODIFY `THE_ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT pour la table `T_TYPE_INGREDIENT`
--
ALTER TABLE `T_TYPE_INGREDIENT`
  MODIFY `TIN_ID` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT pour la table `T_UNITE`
--
ALTER TABLE `T_UNITE`
  MODIFY `UNI_ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `T_UNITE_FAB`
--
ALTER TABLE `T_UNITE_FAB`
  MODIFY `FAB_ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
