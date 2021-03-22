-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.17 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for canvasjs_db
CREATE DATABASE IF NOT EXISTS `canvasjs_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `canvasjs_db`;


-- Dumping structure for table canvasjs_db.datapoints
CREATE TABLE IF NOT EXISTS `datapoints` (
  `x` int(11) NOT NULL,
  `y` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table canvasjs_db.datapoints: ~0 rows (approximately)
/*!40000 ALTER TABLE `datapoints` DISABLE KEYS */;
INSERT INTO `datapoints` (`x`, `y`) VALUES
	(10, 71),
	(20, 55),
	(30, 50),
	(40, 65),
	(50, 95),
	(60, 68),
	(70, 28),
	(80, 34),
	(90, 50),
	(100, 65),
	(110, 45),
	(120, 30),
	(130, 45),
	(140, 85),
	(150, 14);
/*!40000 ALTER TABLE `datapoints` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
