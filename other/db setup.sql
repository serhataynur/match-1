CREATE DATABASE IF NOT EXISTS matching;
USE matching;

DROP TABLE IF EXISTS `_general`;
CREATE TABLE `_general` (
  `match_id` int(11) NOT NULL AUTO_INCREMENT,
  `match_title` varchar(200) DEFAULT NULL,
	`match_desc` varchar(5000) DEFAULT NULL,
  `admin_name` varchar(100) DEFAULT NULL,
  `admin_mail` varchar(320) DEFAULT NULL,
  `default_min` int(5) DEFAULT NULL,
  `default_max` int(5) DEFAULT NULL,
  `mode` int(2) DEFAULT NULL,
  `grouping` BOOLEAN DEFAULT NULL,
  PRIMARY KEY (`match_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;# MySQL lieferte ein leeres Resultat zurück (d.h. null Zeilen).

DROP TABLE IF EXISTS `_rating`;
DROP TABLE IF EXISTS `_user`;
DROP TABLE IF EXISTS `_group`;
DROP TABLE IF EXISTS `_slot`;
CREATE TABLE `_slot` (
  `slot_id` int(11) NOT NULL AUTO_INCREMENT,
  `match_id` int(11) NOT NULL DEFAULT '0',
  `slot_name` varchar(150) DEFAULT NULL,
  `slot_description` varchar(320) DEFAULT NULL,
  `slot_min` int(5) DEFAULT NULL,
  `slot_max` int(5) DEFAULT NULL,
  PRIMARY KEY (`slot_id`),
	FOREIGN KEY (`match_id`) REFERENCES `_general` (`match_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* ALTER TABLE `_user` DROP FOREIGN KEY `group_id`;*/


CREATE TABLE `_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
	`match_id` int(11) NOT NULL DEFAULT '0',
	`group_id` int(11) DEFAULT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `user_mail` varchar(320) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
	FOREIGN KEY (`group_id`) REFERENCES `_group` (`group_id`) ON DELETE CASCADE,
	FOREIGN KEY (`match_id`) REFERENCES `_general` (`match_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `_group` ADD FOREIGN KEY (admin_id) REFERENCES `_user` (`user_id`) ON DELETE CASCADE;

CREATE TABLE `_rating` (
	`rating_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `slot_id` int(11) DEFAULT NULL,
  `rating` int(1) DEFAULT NULL,
  PRIMARY KEY (`rating_id`),
  FOREIGN KEY (`slot_id`) REFERENCES `_slot` (`slot_id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `_user` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `_general`(`match_title`,`match_desc`,`admin_name`, `admin_mail`, `default_min`, `default_max`, `mode`, `grouping`) VALUES 
	("Testprojekt","Beschreibung des Testprojekts","Nico","ni-k@gmx.net",0,0,1,TRUE);

INSERT INTO `_slot`(`slot_id`, `match_id`, `slot_name`, `slot_description`, `slot_min`, `slot_max`) VALUES 
	(1,1,"EVENTually","An event notification/organization system with the following actors such as",0,0),
	(2,1,"Note - Sharing System","A course-note sharing system; with the help of this system any member of it can have the following opportunities",0,0),
	(3,1,"Book Sharing System","A  book-sharing  system  which  aims  to  share  books  especially  between  university students.  With  the  help  of  this  system  any  member  of  it  can  have  the  following opportunities",0,0),
	(4,1,"Doctor Information/Search System","With the help of this system any existing member of the system can",0,0);
	/*CONSTRAINT `admin_id` FOREIGN KEY (`admin_id`) REFERENCES `_user` (`user_id`) ON DELETE CASCADE*/