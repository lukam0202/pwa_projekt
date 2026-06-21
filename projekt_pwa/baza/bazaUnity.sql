-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2026 at 03:32 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bazaunity`
--
CREATE DATABASE IF NOT EXISTS `bazaunity` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bazaunity`;

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE `korisnik` (
  `id` int(11) NOT NULL,
  `ime` varchar(32) NOT NULL,
  `prezime` varchar(32) NOT NULL,
  `korisnicko_ime` varchar(32) NOT NULL,
  `lozinka` varchar(255) NOT NULL,
  `razina` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`id`, `ime`, `prezime`, `korisnicko_ime`, `lozinka`, `razina`) VALUES
(0, 'Admin', 'Admin', 'admin', '$2y$10$RMZ38mRuxWFK6WnwplhjWuK/rpxRGLdTImVDAOk7nLDos0eKt97oW', 1),
(1, 'Korisnik', 'Korisnik', 'korisnik', '$2y$10$SETqKRzqVdw6Vdt09cDKge78buPICaohy.eu8tK6tn3mGhAweQqOm', 0);

-- --------------------------------------------------------

--
-- Table structure for table `vijesti`
--

CREATE TABLE `vijesti` (
  `id` int(11) NOT NULL,
  `datum` varchar(32) NOT NULL,
  `naslov` varchar(64) NOT NULL,
  `sazetak` text NOT NULL,
  `tekst` text NOT NULL,
  `slika` varchar(64) NOT NULL,
  `kategorija` varchar(64) NOT NULL,
  `arhiva` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vijesti`
--

INSERT INTO `vijesti` (`id`, `datum`, `naslov`, `sazetak`, `tekst`, `slika`, `kategorija`, `arhiva`) VALUES
(1, '20.06.2026.', 'Hollow Knight', '2D akcijski Metroidvania', 'Hollow Knight je prodao više od milijun primjeraka na PC-u.', 'Hollow_Knight.jpg', 'Igre', 0),
(2, '20.06.2026.', 'Cuphead', 'Developeri Cupheada već pripremaju svoju sljedeću igru', 'Studio je naveo kako bi igra mogla, kad je u pitanju težina ponuditi nešto drugačije iskustvo od Cupheada.', 'Cuphead.png', 'Igre', 1),
(3, '21.06.2026.', 'Hollow Knight Silksong', 'Hollow Knight: Silksong prodao se u 7 milijuna primjeraka, ekspanzija će biti besplatna', 'Hollow Knight: Silksong će u 2026. dobiti ekspanziju zvanu Sea of Sorrow. U njoj ćemo vidjeti nova područja, boss protivnike, alate i još mnogo toga. Bit će to ekspanzija podvodne tematike, a fanove će razveseliti i informacija da će ju svi vlasnici igre dobiti besplatno.', 'Silksong.jpg', 'Igre', 0),
(4, '20.06.2026.', 'Ori and the Blind Forest', 'U planu je treća igra iz platformerskog serijala Ori', 'Voditelj studija, Thomas Mahler, za Game Informer je izjavio kako u planu ima barem još jednu Ori igru.', 'Ori.jpg', 'Igre', 0),
(5, '20.06.2026.', 'Unity x Epic Games', 'Udružili se Epic Games i Unity', 'Došla najava da su te dvije tvrtke dogovorile suradnju te da će Unity “na stražnja vrata” ući na Epicovu platformu.', 'unityEpic.png', 'Ucenje', 0),
(6, '20.06.2026.', 'New to Unity?', 'Pokrenite Unityjev ugrađeni početnički projekt, dovršite interaktivni vodič i podijelite svoju prvu igru.', 'Vodič za početak rada s Unityjem vodi vas na kratki obilazak Unityja, završavajući stvaranjem vaše prve 3D scene, sve unutar samog Unity Editora.', 'unity.png', 'Ucenje', 0),
(7, '20.06.2026.', 'Tečajevi', 'Pogledajte naše nove tečajeve!', 'Istražite naše najnovije tečajeve. Tečajevi detaljno istražuju teme kroz kombinaciju detaljnih vodiča i projekata.', 'course.png', 'Ucenje', 0),
(8, '21.06.2026.', 'Uvoz web nacrta', 'Iz Unity Studija u Unity Editor: Uvoz web nacrta', 'Dizajniran je za timove koji brzo počinju s Unity Studiovim 3D tijekom rada u pregledniku, a zatim trebaju skalirati svoj rad u Unity Editoru. Nakon uvoza, Studio Logic skripte postaju C# skripte koje se mogu uređivati, dajući programerima fleksibilnost dodavanja prilagođene fizike, integracije analitike, konfiguriranja Cinemachine kamera, nadogradnje shadera i otklanjanja pogrešaka u performansama bez ponovne izgradnje projekta od nule.', 'template.png', 'Ucenje', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vijesti`
--
ALTER TABLE `vijesti`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `korisnik`
--
ALTER TABLE `korisnik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vijesti`
--
ALTER TABLE `vijesti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
