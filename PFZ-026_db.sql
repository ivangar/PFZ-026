# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.29)
# Database: dxlink_local_db
# Generation Time: 2017-02-08 19:30:34 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

# Dump of table doctors
# ------------------------------------------------------------

DROP TABLE IF EXISTS `doctors`;

CREATE TABLE `doctors` (
  `doctor_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL DEFAULT '',
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(250) NOT NULL DEFAULT '',
  `password` varchar(52) NOT NULL DEFAULT '',
  `hash_salt` varchar(52) NOT NULL,
  `country` varchar(25) DEFAULT NULL,
  `province` varchar(50) DEFAULT NULL,
  `postal_code` varchar(6) DEFAULT NULL,
  `profession` varchar(50) DEFAULT NULL,
  `specialty` varchar(50) DEFAULT NULL,
  `language` varchar(12) DEFAULT NULL,
  `active` tinyint(4) DEFAULT '0',
  `registration_date` datetime DEFAULT NULL,
  `last_visit` datetime DEFAULT NULL,
  `matricule` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`doctor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `doctors` WRITE;
/*!40000 ALTER TABLE `doctors` DISABLE KEYS */;

INSERT INTO `doctors` (`doctor_id`, `first_name`, `last_name`, `email`, `password`, `hash_salt`, `country`, `province`, `postal_code`, `profession`, `specialty`, `language`, `active`, `registration_date`, `last_visit`, `matricule`)
VALUES
	(233,'anonymous','unknown','dxlink@sta.ca','vHjrftLRexi+e/SKsF4gBn25e5LZBOqG','7ec5YOBgtkVE7fHEFtqZhDl99FIWy2N/','Canada','Quebec','H9R0A2','Other','','English',1,'2017-02-07 14:22:28','2017-02-07 16:32:31',NULL);

/*!40000 ALTER TABLE `doctors` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table program_sections
# ------------------------------------------------------------

DROP TABLE IF EXISTS `program_sections`;

CREATE TABLE `program_sections` (
  `program_section_id` varchar(20) NOT NULL DEFAULT '',
  `program_id` varchar(20) NOT NULL DEFAULT '',
  `program_section_name` varchar(150) DEFAULT NULL,
  `program_section_type` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`program_section_id`),
  KEY `programs_program_sections_CON` (`program_id`),
  CONSTRAINT `programs_program_sections_CON` FOREIGN KEY (`program_id`) REFERENCES `programs` (`program_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `program_sections` WRITE;
/*!40000 ALTER TABLE `program_sections` DISABLE KEYS */;

INSERT INTO `program_sections` (`program_section_id`, `program_id`, `program_section_name`, `program_section_type`)
VALUES
	('PFZ_026_Eval_01','PFZ_026','PFZ 026 Evaluation','Evaluation Form');

/*!40000 ALTER TABLE `program_sections` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table programs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `programs`;

CREATE TABLE `programs` (
  `program_id` varchar(20) NOT NULL DEFAULT '',
  `area_id` varchar(20) DEFAULT NULL,
  `sponsor` varchar(200) DEFAULT NULL,
  `program_type` varchar(200) DEFAULT NULL,
  `program_title` varchar(200) DEFAULT NULL,
  `program_subtitle` varchar(200) DEFAULT NULL,
  `program_description` varchar(1000) DEFAULT NULL,
  `image` longblob,
  `language` varchar(15) DEFAULT NULL,
  `authors` varchar(400) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `launch_date` date DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  PRIMARY KEY (`program_id`),
  KEY `therapeutic_areas_programs_con` (`area_id`),
  CONSTRAINT `therapeutic_areas_programs_con` FOREIGN KEY (`area_id`) REFERENCES `therapeutic_areas` (`area_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `programs` WRITE;
/*!40000 ALTER TABLE `programs` DISABLE KEYS */;

INSERT INTO `programs` (`program_id`, `area_id`, `sponsor`, `program_type`, `program_title`, `program_subtitle`, `program_description`, `image`, `language`, `authors`, `url`, `launch_date`, `expiration_date`)
VALUES
	('PFZ_026','other','PFZ','non-accredited','Smoking Cessations','Smoking is bad',NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `programs` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table questions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `questions`;

CREATE TABLE `questions` (
  `question_id` varchar(20) NOT NULL DEFAULT '',
  `question` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;

INSERT INTO `questions` (`question_id`, `question`, `type`)
VALUES
	('PFZ_E_01','Describe two positive features of this program','open'),
	('PFZ_E_02','Would you change anything about the program?','open'),
	('PFZ_E_03','What did you learn from this program that you plan to use in your practice?','open'),
	('PFZ_E_04','What other educational needs would you like to have addressed regarding smoking-cessation therapy?','open'),
	('PFZ_E_05','Did you perceive any degree of commercial bias in any part of the program?','open'),
	('PFZ_E_06','General comments and suggestions','open');

/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
