-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.27-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.3.0.6589
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for baza
DROP DATABASE IF EXISTS `baza`;
CREATE DATABASE IF NOT EXISTS `baza` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin */;
USE `baza`;

-- Dumping structure for table baza.administrator
DROP TABLE IF EXISTS `administrator`;
CREATE TABLE IF NOT EXISTS `administrator` (
  `administrator_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `korisnik_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`administrator_id`),
  KEY `fk_administrator_korisnik_id` (`korisnik_id`),
  CONSTRAINT `fk_administrator_korisnik_id` FOREIGN KEY (`korisnik_id`) REFERENCES `korisnik` (`korisnik_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Dumping data for table baza.administrator: ~0 rows (approximately)

-- Dumping structure for table baza.gost
DROP TABLE IF EXISTS `gost`;
CREATE TABLE IF NOT EXISTS `gost` (
  `gost_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_korisnik` int(10) unsigned NOT NULL,
  PRIMARY KEY (`gost_id`),
  KEY `fk_gost_id_korisnik` (`id_korisnik`),
  CONSTRAINT `fk_gost_id_korisnik` FOREIGN KEY (`id_korisnik`) REFERENCES `korisnik` (`korisnik_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Dumping data for table baza.gost: ~0 rows (approximately)

-- Dumping structure for table baza.korisnik
DROP TABLE IF EXISTS `korisnik`;
CREATE TABLE IF NOT EXISTS `korisnik` (
  `korisnik_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ime` varchar(32) NOT NULL,
  `prezime` varchar(32) NOT NULL,
  `korisnickoIme` varchar(128) NOT NULL,
  `lozinka` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `uloga` enum('gost','zaposleni','administrator') NOT NULL,
  `telefon` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`korisnik_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Dumping data for table baza.korisnik: ~5 rows (approximately)
INSERT INTO `korisnik` (`korisnik_id`, `ime`, `prezime`, `korisnickoIme`, `lozinka`, `email`, `uloga`, `telefon`) VALUES
	(1, 'Ana', 'Ogrizovic', 'ana11', 'ana123123', 'anaogrizovic11@gmail.com', 'administrator', '0658887202'),
	(2, 'Katarina', 'Marjanovic', 'kaca11', 'kaca123123', 'katarinamarjanovic@gmail.com', 'administrator', '0643540261'),
	(3, 'Milica', 'Milic', 'comi11', 'comi123123', 'milicamilic@gmail.com', 'gost', '0612667659'),
	(4, 'Momcilo ', 'Jankovic', 'moma123', 'moma12345', 'moma@gmail.com', 'zaposleni', '0623347882'),
	(17, 'Bojana', 'Marjanovic', 'bokizmaj66', 'boki66', 'bokizmaj66@gmail.com', 'gost', '0647762357');

-- Dumping structure for table baza.rezervacija
DROP TABLE IF EXISTS `rezervacija`;
CREATE TABLE IF NOT EXISTS `rezervacija` (
  `rezervacija_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `soba_id` int(10) unsigned NOT NULL,
  `korisnik_id` int(10) unsigned NOT NULL,
  `datum_dolaska` datetime NOT NULL,
  `datum_odlaska` datetime NOT NULL,
  PRIMARY KEY (`rezervacija_id`),
  KEY `fk_rezervacija_korisnik_id` (`korisnik_id`),
  KEY `fk_rezervacija_soba_id` (`soba_id`),
  CONSTRAINT `fk_rezervacija_korisnik_id` FOREIGN KEY (`korisnik_id`) REFERENCES `korisnik` (`korisnik_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_rezervacija_soba_id` FOREIGN KEY (`soba_id`) REFERENCES `soba` (`soba_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Dumping data for table baza.rezervacija: ~0 rows (approximately)

-- Dumping structure for table baza.soba
DROP TABLE IF EXISTS `soba`;
CREATE TABLE IF NOT EXISTS `soba` (
  `soba_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `broj_sobe` int(11) NOT NULL,
  `tip_sobe` enum('Standard Single','Standard Double','Premium Single','Silver Double','Premium Double') NOT NULL,
  `cena` decimal(20,6) unsigned NOT NULL,
  `raspolozivost` enum('jeste','nije') NOT NULL DEFAULT 'jeste',
  PRIMARY KEY (`soba_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Dumping data for table baza.soba: ~0 rows (approximately)

-- Dumping structure for table baza.zaposlen
DROP TABLE IF EXISTS `zaposlen`;
CREATE TABLE IF NOT EXISTS `zaposlen` (
  `zaposlen_id` int(10) unsigned NOT NULL,
  `id_korisnika` int(10) unsigned NOT NULL,
  PRIMARY KEY (`zaposlen_id`),
  KEY `fk_zaposlen_id_korisnika` (`id_korisnika`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- Dumping data for table baza.zaposlen: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
