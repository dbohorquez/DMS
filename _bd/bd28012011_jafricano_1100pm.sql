/*
SQLyog Community v8.53 
MySQL - 5.0.51b-community-nt-log : Database - coddeedms
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`coddeedms` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `coddeedms`;

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(45) NOT NULL,
  `description` varchar(500) default NULL,
  `deletedAt` datetime default NULL,
  `createdAt` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `quantity` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_categories` (`unit_id`),
  CONSTRAINT `FK_categories` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `categories` */

insert  into `categories`(`id`,`name`,`description`,`deletedAt`,`createdAt`,`quantity`,`unit_id`) values (1,'Productos de Aseo de Ropa','Diferentes productos de aseo para la ropa',NULL,'0000-00-00 00:00:00',500,1),(2,'comida','comida',NULL,'0000-00-00 00:00:00',100,1),(3,'prueba','Prueba',NULL,'2011-01-26 12:55:36',400,2);

/*Table structure for table `certificates` */

DROP TABLE IF EXISTS `certificates`;

CREATE TABLE `certificates` (
  `id` int(11) NOT NULL,
  `printDate` datetime default NULL,
  `users_id` int(11) NOT NULL,
  `donations_sequence` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `deletedAt` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_certificates_users1` (`users_id`),
  KEY `fk_certificates_donations1` (`donations_sequence`),
  CONSTRAINT `fk_certificates_donations1` FOREIGN KEY (`donations_sequence`) REFERENCES `donations` (`sequence`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_certificates_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*Data for the table `certificates` */

/*Table structure for table `companies` */

DROP TABLE IF EXISTS `companies`;

CREATE TABLE `companies` (
  `id` double NOT NULL,
  `name` varchar(45) NOT NULL,
  `contactName` varchar(45) default NULL,
  `phoneNumber` varchar(45) default NULL,
  `address` varchar(45) default NULL,
  `email` varchar(45) default NULL,
  `faxNumber` varchar(45) default NULL,
  `type` int(11) default NULL,
  `towns_id` int(11) NOT NULL,
  `createdA` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `deletedAt` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `companies` */

insert  into `companies`(`id`,`name`,`contactName`,`phoneNumber`,`address`,`email`,`faxNumber`,`type`,`towns_id`,`createdA`,`deletedAt`) values (111,'Entidad 1','a','5','Right there','mi@mail.com','5',1,1,'0000-00-00 00:00:00',NULL),(555555,'ent','a','8','a','a','8',2,6,'0000-00-00 00:00:00',NULL),(44444444,'dafdasd','sadasdas','231231','fsfada','','21312',1,0,'0000-00-00 00:00:00',NULL);

/*Table structure for table `distributions` */

DROP TABLE IF EXISTS `distributions`;

CREATE TABLE `distributions` (
  `id` int(11) NOT NULL auto_increment,
  `deliveryDate` date NOT NULL,
  `state` int(11) NOT NULL,
  `companies_id` double NOT NULL,
  `warehouses_id` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `deletedAt` datetime default NULL,
  `shelter_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_distributions_companies1` (`companies_id`),
  KEY `fk_distributions_warehouses1` (`warehouses_id`),
  KEY `FK_distributions` (`shelter_id`),
  CONSTRAINT `FK_distributions` FOREIGN KEY (`shelter_id`) REFERENCES `shelters` (`id`),
  CONSTRAINT `fk_distributions_warehouses1` FOREIGN KEY (`warehouses_id`) REFERENCES `warehouses` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*Data for the table `distributions` */

insert  into `distributions`(`id`,`deliveryDate`,`state`,`companies_id`,`warehouses_id`,`createdAt`,`deletedAt`,`shelter_id`) values (1,'2011-01-11',1,555555,1,'0000-00-00 00:00:00','2011-01-27 00:55:00',1),(2,'2011-01-11',1,555555,1,'0000-00-00 00:00:00','2011-01-27 00:55:00',1),(3,'2011-01-11',1,555555,1,'0000-00-00 00:00:00','2011-01-27 00:56:00',1),(4,'2011-01-11',1,555555,1,'0000-00-00 00:00:00','2011-01-27 00:56:00',1),(5,'2011-01-11',1,555555,1,'0000-00-00 00:00:00','2011-01-27 00:56:00',1),(6,'2011-01-11',1,555555,1,'0000-00-00 00:00:00','2011-01-27 00:56:00',1),(7,'2011-01-11',1,555555,1,'0000-00-00 00:00:00','2011-01-27 00:55:00',1),(8,'2011-01-11',1,555555,1,'0000-00-00 00:00:00','2011-01-27 00:55:00',1),(9,'2011-01-12',1,555555,1,'0000-00-00 00:00:00','2011-01-27 00:55:00',1),(10,'2011-01-11',1,555555,1,'0000-00-00 00:00:00','2011-01-27 00:55:00',1),(11,'2011-01-12',1,555555,1,'0000-00-00 00:00:00','2011-01-27 00:55:00',1),(12,'2011-01-13',1,555555,1,'0000-00-00 00:00:00','2011-01-27 00:55:00',1),(13,'2011-01-12',1,555555,1,'0000-00-00 00:00:00','2011-01-27 00:55:00',1),(14,'2011-01-12',1,555555,1,'0000-00-00 00:00:00','2011-01-27 00:55:00',1),(15,'2011-01-28',1,555555,2,'2011-01-27 01:00:21',NULL,1);

/*Table structure for table `donations` */

DROP TABLE IF EXISTS `donations`;

CREATE TABLE `donations` (
  `sequence` int(11) NOT NULL auto_increment,
  `detail` varchar(500) default NULL,
  `bill` decimal(10,0) default NULL,
  `users_id` int(11) NOT NULL,
  `donors_id` double NOT NULL,
  `warehouses_id` int(11) default NULL,
  `companies_id` double default NULL,
  `date` datetime NOT NULL,
  `createdAt` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `deletedAt` datetime default NULL,
  `type` int(1) NOT NULL,
  PRIMARY KEY  (`sequence`),
  KEY `fk_donations_users1` (`users_id`),
  KEY `fk_donations_donors1` (`donors_id`),
  KEY `fk_donations_warehouses1` (`warehouses_id`),
  KEY `fk_donations_companies1` (`companies_id`),
  CONSTRAINT `fk_donations_donors1` FOREIGN KEY (`donors_id`) REFERENCES `donors` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_donations_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_donations_warehouses1` FOREIGN KEY (`warehouses_id`) REFERENCES `warehouses` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*Data for the table `donations` */

insert  into `donations`(`sequence`,`detail`,`bill`,`users_id`,`donors_id`,`warehouses_id`,`companies_id`,`date`,`createdAt`,`deletedAt`,`type`) values (7,'','425874',1,111,1,NULL,'2011-01-11 00:00:00','0000-00-00 00:00:00',NULL,0),(8,'Se tranfirio de bodega de promesas por el usuario 1','0',1,111,2,0,'2011-01-23 15:50:00','2011-01-23 15:50:46',NULL,1),(9,'Se tranfirio de bodega de promesas por el usuario 1','0',1,1129574,2,0,'2011-01-23 16:07:00','2011-01-23 16:07:08',NULL,1),(10,'Se tranfirio de bodega de promesas por el usuario 1','0',1,1129574,2,0,'2011-01-23 16:45:00','2011-01-23 16:45:20',NULL,1),(11,'Se tranfirio de bodega de promesas por el usuario 1','8000',1,111,2,44444444,'2011-01-23 16:47:00','2011-01-23 16:47:12',NULL,1),(12,'',NULL,1,111,NULL,NULL,'2011-01-23 20:30:00','2011-01-23 20:30:29',NULL,3),(13,'','0',1,111,NULL,44444444,'2011-01-28 22:56:00','2011-01-28 22:56:38',NULL,2);

/*Table structure for table `donors` */

DROP TABLE IF EXISTS `donors`;

CREATE TABLE `donors` (
  `id` double NOT NULL,
  `name` varchar(45) NOT NULL,
  `type` int(11) NOT NULL,
  `address` varchar(45) default NULL,
  `email` varchar(45) default NULL,
  `phoneNumber` varchar(45) default NULL,
  `faxNumber` varchar(45) default NULL,
  `creationDate` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `towns_id` int(11) NOT NULL,
  `deletedAt` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_donors_towns1` (`towns_id`),
  CONSTRAINT `fk_donors_towns1` FOREIGN KEY (`towns_id`) REFERENCES `towns` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*Data for the table `donors` */

insert  into `donors`(`id`,`name`,`type`,`address`,`email`,`phoneNumber`,`faxNumber`,`creationDate`,`towns_id`,`deletedAt`) values (111,'David',1,'a','a','8','8','2011-01-10 00:00:00',2,NULL),(1114,'JORGE AFRICANO HAYDAR',1,'','jorge+1@hotmail.com','','','2011-01-27 22:14:00',1,NULL),(2233,'Daniel Herrera',1,'Calle falsa 123','ing.donovan.delvalle@gmail.com','322','132342','2011-01-10 00:00:00',3,NULL),(3434,'Bodega GobernaciÃ³n',1,'Calle falsa 123','ing.donovan.delvalle@gmail.com','324','23432','2011-01-10 00:00:00',2,NULL),(4444,'Daniel Herrera',1,'Calle falsa 123','ing.donovan.delvalle@gmail.com','555','333','2011-01-10 00:00:00',2,NULL),(23232,'Donovan Del Valle',1,'Calle falsa 123','ing.donovan.delvalle@gmail.com','4444','3432423','2011-01-10 00:00:00',10,NULL),(1129574,'JORGE AFRICANO HAYDAR',1,'Calle falsa 123','jax698@gmail.com','3521485','','2011-01-19 00:00:00',1,NULL);

/*Table structure for table `kits` */

DROP TABLE IF EXISTS `kits`;

CREATE TABLE `kits` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(45) default NULL,
  `createdAt` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `deletedAt` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*Data for the table `kits` */

insert  into `kits`(`id`,`name`,`createdAt`,`deletedAt`) values (2,'Kit 2','0000-00-00 00:00:00',NULL),(6,'PRueba','0000-00-00 00:00:00',NULL);

/*Table structure for table `kits_products` */

DROP TABLE IF EXISTS `kits_products`;

CREATE TABLE `kits_products` (
  `quantity` int(11) NOT NULL,
  `kits_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `deletedAt` datetime default NULL,
  KEY `fk_kits_products_kits1` (`kits_id`),
  KEY `fk_kits_products_products1` (`products_id`),
  CONSTRAINT `fk_kits_products_kits1` FOREIGN KEY (`kits_id`) REFERENCES `kits` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_kits_products_products1` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `kits_products` */

insert  into `kits_products`(`quantity`,`kits_id`,`products_id`,`createdAt`,`deletedAt`) values (1,2,2,'0000-00-00 00:00:00',NULL),(1,2,3,'0000-00-00 00:00:00',NULL),(1,2,4,'0000-00-00 00:00:00',NULL),(5,2,5,'0000-00-00 00:00:00',NULL),(1,2,2,'0000-00-00 00:00:00',NULL),(1,2,3,'0000-00-00 00:00:00',NULL),(1,2,4,'0000-00-00 00:00:00',NULL),(5,2,5,'0000-00-00 00:00:00',NULL),(0,6,5,'0000-00-00 00:00:00',NULL),(0,6,4,'0000-00-00 00:00:00',NULL);

/*Table structure for table `log` */

DROP TABLE IF EXISTS `log`;

CREATE TABLE `log` (
  `id` int(11) NOT NULL auto_increment,
  `action` varchar(45) NOT NULL,
  `date` varchar(45) NOT NULL,
  `tableName` varchar(45) NOT NULL,
  `tableId` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `deletedAt` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_log_users1` (`users_id`),
  CONSTRAINT `fk_log_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*Data for the table `log` */

/*Table structure for table `notifications` */

DROP TABLE IF EXISTS `notifications`;

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `subject` varchar(100) default NULL,
  `from` varchar(45) default NULL,
  `to` varchar(45) default NULL,
  `body` varchar(45) default NULL,
  `date` datetime default NULL,
  `type` varchar(45) default NULL,
  `users_id` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `deletedAt` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_notifications_users1` (`users_id`),
  CONSTRAINT `fk_notifications_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*Data for the table `notifications` */

/*Table structure for table `products` */

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(45) NOT NULL,
  `description` varchar(200) default NULL,
  `state` int(11) default '0',
  `productTypes_id` int(11) NOT NULL,
  `flagkit` tinyint(1) default '0',
  `createdAt` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `deletedAt` datetime default NULL,
  `quantity` float NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_products_productTypes1` (`productTypes_id`),
  CONSTRAINT `fk_products_productTypes1` FOREIGN KEY (`productTypes_id`) REFERENCES `producttypes` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `products` */

insert  into `products`(`id`,`name`,`description`,`state`,`productTypes_id`,`flagkit`,`createdAt`,`deletedAt`,`quantity`) values (2,'Aceite Vivi de 2 litros','',1,1,0,'2011-01-16 19:33:40',NULL,10),(3,'Colchon sencillo','',1,4,0,'2011-01-16 19:33:40',NULL,20),(4,'Mesa pequeÃ±a','',1,3,0,'2011-01-16 19:33:40',NULL,10),(5,'Aceite Girasol 1 litro','',1,1,0,'2011-01-16 19:33:40',NULL,20),(7,'werwer','',1,5,0,'2011-01-16 19:33:40',NULL,10),(8,'ALGO',NULL,1,5,0,'2011-01-16 19:22:14',NULL,10),(9,'Re Prueba',NULL,1,1,0,'2011-01-16 19:23:47',NULL,30),(10,'REPRUEBA','',1,5,0,'2011-01-16 19:24:38',NULL,10);

/*Table structure for table `products_checkpoint` */

DROP TABLE IF EXISTS `products_checkpoint`;

CREATE TABLE `products_checkpoint` (
  `id` int(11) NOT NULL auto_increment,
  `quantity` int(11) default NULL,
  `product_id` int(11) default NULL,
  `deletedAt` datetime default NULL,
  `createdAt` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `FK_products_checkpoint` (`product_id`),
  CONSTRAINT `FK_products_checkpoint` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `products_checkpoint` */

insert  into `products_checkpoint`(`id`,`quantity`,`product_id`,`deletedAt`,`createdAt`) values (1,5,2,NULL,'0000-00-00 00:00:00'),(2,434,3,NULL,'0000-00-00 00:00:00');

/*Table structure for table `products_donations` */

DROP TABLE IF EXISTS `products_donations`;

CREATE TABLE `products_donations` (
  `products_id` int(11) NOT NULL,
  `donations_id` int(11) NOT NULL,
  `expirationDate` date default NULL,
  `state` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `warehouses_id` int(11) default NULL,
  `createdAt` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `deletedAt` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `product` (`products_id`),
  KEY `donation` (`donations_id`),
  KEY `fk_products_donations_warehouses1` (`warehouses_id`),
  CONSTRAINT `fk_products_donations_warehouses1` FOREIGN KEY (`warehouses_id`) REFERENCES `warehouses` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*Data for the table `products_donations` */

insert  into `products_donations`(`products_id`,`donations_id`,`expirationDate`,`state`,`id`,`warehouses_id`,`createdAt`,`deletedAt`) values (5,1,'2011-01-05',7,2,2,'0000-00-00 00:00:00',NULL),(5,1,'2011-01-05',1,3,2,'0000-00-00 00:00:00',NULL),(5,1,'2011-01-05',1,4,2,'0000-00-00 00:00:00',NULL),(3,1,'2011-01-12',1,5,1,'0000-00-00 00:00:00',NULL),(2,1,'2011-01-25',4,6,2,'0000-00-00 00:00:00',NULL),(4,7,'2011-01-18',1,7,2,'0000-00-00 00:00:00',NULL),(4,8,'2011-01-18',3,8,2,'2011-01-23 15:50:55',NULL),(2,8,'2011-01-25',1,9,2,'2011-01-23 15:50:59',NULL),(4,8,'2011-01-18',1,10,2,'2011-01-23 15:56:58',NULL),(5,9,'2011-01-05',3,11,2,'2011-01-23 16:07:19',NULL),(5,9,'2011-01-05',3,12,2,'2011-01-23 16:07:19',NULL),(2,9,'2011-01-25',3,13,2,'2011-01-23 16:07:23',NULL),(9,9,'2011-01-26',3,14,2,'2011-01-23 16:07:28',NULL),(5,9,'2011-01-05',1,15,2,'2011-01-23 16:08:22',NULL),(5,9,'2011-01-05',1,16,2,'2011-01-23 16:08:22',NULL),(2,9,'2011-01-25',1,17,2,'2011-01-23 16:08:23',NULL),(9,9,'2011-01-26',1,18,2,'2011-01-23 16:08:23',NULL),(5,9,'2011-01-05',1,19,2,'2011-01-23 16:18:49',NULL),(5,9,'2011-01-05',1,20,2,'2011-01-23 16:18:49',NULL),(2,9,'2011-01-25',1,21,2,'2011-01-23 16:18:49',NULL),(9,9,'2011-01-26',1,22,2,'2011-01-23 16:18:49',NULL),(5,9,'2011-01-05',1,23,2,'2011-01-23 16:19:49',NULL),(5,9,'2011-01-05',1,24,2,'2011-01-23 16:19:49',NULL),(2,9,'2011-01-25',1,25,2,'2011-01-23 16:19:49',NULL),(9,9,'2011-01-26',1,26,2,'2011-01-23 16:19:50',NULL),(5,9,'2011-01-05',1,27,2,'2011-01-23 16:32:49',NULL),(5,9,'2011-01-05',1,28,2,'2011-01-23 16:32:49',NULL),(2,9,'2011-01-25',1,29,2,'2011-01-23 16:32:49',NULL),(9,9,'2011-01-26',1,30,2,'2011-01-23 16:32:50',NULL),(5,9,'2011-01-05',1,31,2,'2011-01-23 16:34:41',NULL),(5,9,'2011-01-05',7,32,2,'2011-01-23 16:34:41',NULL),(2,9,'2011-01-25',1,33,2,'2011-01-23 16:34:42',NULL),(9,9,'2011-01-26',1,34,2,'2011-01-23 16:34:42',NULL),(5,9,'2011-01-05',1,35,2,'2011-01-23 16:37:24',NULL),(5,9,'2011-01-05',1,36,2,'2011-01-23 16:37:24',NULL),(2,9,'2011-01-25',1,37,2,'2011-01-23 16:37:24',NULL),(9,9,'2011-01-26',1,38,2,'2011-01-23 16:37:25',NULL),(5,9,'2011-01-05',1,39,2,'2011-01-23 16:41:04',NULL),(5,9,'2011-01-05',1,40,2,'2011-01-23 16:41:04',NULL),(2,9,'2011-01-25',1,41,2,'2011-01-23 16:41:04',NULL),(9,9,'2011-01-26',1,42,2,'2011-01-23 16:41:04',NULL),(5,9,'2011-01-05',1,43,2,'2011-01-23 16:41:49',NULL),(5,9,'2011-01-05',1,44,2,'2011-01-23 16:41:49',NULL),(2,9,'2011-01-25',1,45,2,'2011-01-23 16:41:49',NULL),(9,9,'2011-01-26',1,46,2,'2011-01-23 16:41:49',NULL),(5,9,'2011-01-05',1,47,2,'2011-01-23 16:42:48',NULL),(5,9,'2011-01-05',1,48,2,'2011-01-23 16:42:48',NULL),(2,9,'2011-01-25',1,49,2,'2011-01-23 16:42:48',NULL),(9,9,'2011-01-26',1,50,2,'2011-01-23 16:42:49',NULL),(5,10,'2011-01-05',3,51,2,'2011-01-23 16:45:34',NULL),(5,10,'2011-01-05',3,52,2,'2011-01-23 16:45:34',NULL),(2,10,'2011-01-25',3,53,2,'2011-01-23 16:45:38',NULL),(5,11,'2011-01-05',3,54,2,'2011-01-23 16:47:19',NULL),(8,11,'2011-01-12',6,55,2,'2011-01-23 16:47:32','2011-01-23 16:53:00'),(8,11,'2011-01-12',3,56,2,'2011-01-23 16:47:32',NULL),(9,11,'2011-01-26',6,57,2,'2011-01-23 16:47:38','2011-01-23 16:52:00'),(9,11,'2011-01-26',6,58,2,'2011-01-23 16:47:38','2011-01-23 16:53:00'),(9,11,'2011-01-26',3,59,2,'2011-01-23 16:47:38',NULL),(8,11,'2011-01-12',1,60,2,'2011-01-23 16:48:22',NULL),(8,11,'2011-01-12',1,61,2,'2011-01-23 16:48:22',NULL),(5,12,NULL,3,62,NULL,'2011-01-23 20:30:40',NULL),(2,8,'2011-01-25',1,63,2,'2011-01-23 21:12:45',NULL),(5,13,'0000-00-00',1,64,2,'2011-01-28 22:56:52',NULL),(5,13,'0000-00-00',2,65,NULL,'2011-01-28 22:56:52',NULL),(5,13,'0000-00-00',2,66,NULL,'2011-01-28 22:56:52',NULL),(8,13,'2011-01-29',2,67,NULL,'2011-01-28 22:57:01',NULL);

/*Table structure for table `products_donations_distributions` */

DROP TABLE IF EXISTS `products_donations_distributions`;

CREATE TABLE `products_donations_distributions` (
  `distributions_id` int(11) NOT NULL,
  `products_donations_id` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `deletedAt` datetime default NULL,
  KEY `fk_products_distributions_distributions1` (`distributions_id`),
  KEY `fk_products_distributions_products_donations1` (`products_donations_id`),
  CONSTRAINT `fk_products_distributions_distributions1` FOREIGN KEY (`distributions_id`) REFERENCES `distributions` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_products_distributions_products_donations1` FOREIGN KEY (`products_donations_id`) REFERENCES `products_donations` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `products_donations_distributions` */

insert  into `products_donations_distributions`(`distributions_id`,`products_donations_id`,`createdAt`,`deletedAt`) values (9,2,'0000-00-00 00:00:00','2011-01-27 00:55:00'),(9,3,'0000-00-00 00:00:00','2011-01-27 00:55:00'),(10,2,'0000-00-00 00:00:00','2011-01-27 00:55:00'),(11,3,'0000-00-00 00:00:00','2011-01-27 00:55:00'),(12,2,'0000-00-00 00:00:00','2011-01-27 00:55:00'),(12,6,'0000-00-00 00:00:00','2011-01-27 00:55:00'),(15,2,'2011-01-27 01:00:21',NULL),(15,32,'2011-01-27 01:00:21',NULL);

/*Table structure for table `products_donations_tranfers` */

DROP TABLE IF EXISTS `products_donations_tranfers`;

CREATE TABLE `products_donations_tranfers` (
  `product_donation_id` int(11) default NULL,
  `tranfer_id` int(11) default NULL,
  `quantity` int(11) default NULL,
  `deletedAt` datetime default NULL,
  KEY `FK_products_donations_tranfers` (`tranfer_id`),
  KEY `FK_products_donations_tranfers2` (`product_donation_id`),
  CONSTRAINT `FK_products_donations_tranfers` FOREIGN KEY (`tranfer_id`) REFERENCES `transfers` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_products_donations_tranfers2` FOREIGN KEY (`product_donation_id`) REFERENCES `products_donations` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `products_donations_tranfers` */

/*Table structure for table `producttypes` */

DROP TABLE IF EXISTS `producttypes`;

CREATE TABLE `producttypes` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(45) NOT NULL,
  `description` varchar(200) default NULL,
  `createdAt` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `deletedAt` datetime default NULL,
  `categories_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_producttypes` (`categories_id`),
  CONSTRAINT `FK_producttypes` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `producttypes` */

insert  into `producttypes`(`id`,`name`,`description`,`createdAt`,`deletedAt`,`categories_id`) values (1,'Aceite','Aceite en sus diversas presentaciones','0000-00-00 00:00:00',NULL,2),(3,'Mesa','Todo tipo de mesas','0000-00-00 00:00:00',NULL,1),(4,'ColchÃ³n','Multiples variedades de colchones','0000-00-00 00:00:00',NULL,1),(5,'AtÃºn','Atunes en lata','0000-00-00 00:00:00',NULL,2);

/*Table structure for table `provinces` */

DROP TABLE IF EXISTS `provinces`;

CREATE TABLE `provinces` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(127) NOT NULL,
  `createdAt` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `deletedAt` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

/*Data for the table `provinces` */

insert  into `provinces`(`id`,`name`,`createdAt`,`deletedAt`) values (1,'Amazonas','0000-00-00 00:00:00',NULL),(2,'Antioquia','0000-00-00 00:00:00',NULL),(3,'Arauca','0000-00-00 00:00:00',NULL),(4,'Atlántico','0000-00-00 00:00:00',NULL),(5,'Bogotá','0000-00-00 00:00:00',NULL),(6,'Bolívar','0000-00-00 00:00:00',NULL),(7,'Boyacá','0000-00-00 00:00:00',NULL),(8,'Caldas','0000-00-00 00:00:00',NULL),(9,'Caquetá','0000-00-00 00:00:00',NULL),(10,'Casanare','0000-00-00 00:00:00',NULL),(11,'Cauca','0000-00-00 00:00:00',NULL),(12,'Cesar','0000-00-00 00:00:00',NULL),(13,'Chocó','0000-00-00 00:00:00',NULL),(14,'Córdoba','0000-00-00 00:00:00',NULL),(15,'Cundinamarca','0000-00-00 00:00:00',NULL),(16,'Guainía','0000-00-00 00:00:00',NULL),(17,'Guaviare','0000-00-00 00:00:00',NULL),(18,'Huila','0000-00-00 00:00:00',NULL),(19,'La Guajira','0000-00-00 00:00:00',NULL),(20,'Magdalena','0000-00-00 00:00:00',NULL),(21,'Meta','0000-00-00 00:00:00',NULL),(22,'Nariño','0000-00-00 00:00:00',NULL),(23,'Norte de Santander','0000-00-00 00:00:00',NULL),(24,'Putumayo','0000-00-00 00:00:00',NULL),(25,'Quindío','0000-00-00 00:00:00',NULL),(26,'Risaralda','0000-00-00 00:00:00',NULL),(27,'San Andrés y Providencia','0000-00-00 00:00:00',NULL),(28,'Santander','0000-00-00 00:00:00',NULL),(29,'Sucre','0000-00-00 00:00:00',NULL),(30,'Tolima','0000-00-00 00:00:00',NULL),(31,'Valle del Cauca','0000-00-00 00:00:00',NULL),(32,'Vaupés','0000-00-00 00:00:00',NULL),(33,'Vichada','0000-00-00 00:00:00',NULL);

/*Table structure for table `shelters` */

DROP TABLE IF EXISTS `shelters`;

CREATE TABLE `shelters` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(45) NOT NULL,
  `contactName` varchar(45) NOT NULL,
  `address` varchar(45) default NULL,
  `phoneNumber` varchar(45) default NULL,
  `cellphone` varchar(45) default NULL,
  `fax` varchar(45) default NULL,
  `email` varchar(45) default NULL,
  `town_id` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `deletedAt` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_shelters` (`town_id`),
  CONSTRAINT `FK_shelters` FOREIGN KEY (`town_id`) REFERENCES `towns` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `shelters` */

insert  into `shelters`(`id`,`name`,`contactName`,`address`,`phoneNumber`,`cellphone`,`fax`,`email`,`town_id`,`createdAt`,`deletedAt`) values (1,'hhhhh','hhhhhh','hjsfabhsbdhj|','324242',NULL,'324324','ing.donovan.delvalle@gmail.com',10,'2011-01-20 00:00:00',NULL);

/*Table structure for table `statechanges` */

DROP TABLE IF EXISTS `statechanges`;

CREATE TABLE `statechanges` (
  `reason` varchar(100) default NULL,
  `notes` varchar(500) default NULL,
  `previousState` int(11) NOT NULL default '0',
  `currentState` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `products_donations_id` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `deletedAt` datetime default NULL,
  `id` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id`),
  KEY `fk_statechanges_users1` (`users_id`),
  KEY `FK_statechanges_product_donation` (`products_donations_id`),
  CONSTRAINT `FK_statechanges` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_statechanges_product_donation` FOREIGN KEY (`products_donations_id`) REFERENCES `products_donations` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*Data for the table `statechanges` */

insert  into `statechanges`(`reason`,`notes`,`previousState`,`currentState`,`users_id`,`products_donations_id`,`createdAt`,`deletedAt`,`id`) values ('Ingreso a la bodega de promesas',NULL,0,3,1,8,'2011-01-23 15:50:55',NULL,1),('Ingreso a la bodega de promesas',NULL,0,3,1,9,'2011-01-23 15:50:59',NULL,2),('Se tranfirio a la bodega 2',NULL,4,1,1,2,'2011-01-23 15:56:58',NULL,3),('Se tranfirio a la bodega 2',NULL,2,1,1,4,'2011-01-23 15:56:58',NULL,4),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,10,'2011-01-23 15:56:58',NULL,5),('Ingreso a la bodega de promesas',NULL,0,3,1,11,'2011-01-23 16:07:19',NULL,6),('Ingreso a la bodega de promesas',NULL,0,3,1,12,'2011-01-23 16:07:19',NULL,7),('Ingreso a la bodega de promesas',NULL,0,3,1,13,'2011-01-23 16:07:23',NULL,8),('Ingreso a la bodega de promesas',NULL,0,3,1,14,'2011-01-23 16:07:28',NULL,9),('Se tranfirio a la bodega 2',NULL,2,1,1,5,'2011-01-23 16:08:22',NULL,10),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,15,'2011-01-23 16:08:22',NULL,11),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,16,'2011-01-23 16:08:22',NULL,12),('Se tranfirio a la bodega 2',NULL,1,1,1,2,'2011-01-23 16:08:23',NULL,13),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,17,'2011-01-23 16:08:23',NULL,14),('Se tranfirio a la bodega 2',NULL,3,1,1,9,'2011-01-23 16:08:23',NULL,15),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,18,'2011-01-23 16:08:23',NULL,16),('Se tranfirio a la bodega 2',NULL,1,1,1,5,'2011-01-23 16:18:49',NULL,17),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,19,'2011-01-23 16:18:49',NULL,18),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,20,'2011-01-23 16:18:49',NULL,19),('Se tranfirio a la bodega 2',NULL,1,1,1,2,'2011-01-23 16:18:49',NULL,20),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,21,'2011-01-23 16:18:49',NULL,21),('Se tranfirio a la bodega 2',NULL,1,1,1,9,'2011-01-23 16:18:49',NULL,22),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,22,'2011-01-23 16:18:49',NULL,23),('Se tranfirio a la bodega 2',NULL,1,1,1,5,'2011-01-23 16:19:49',NULL,24),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,23,'2011-01-23 16:19:49',NULL,25),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,24,'2011-01-23 16:19:49',NULL,26),('Se tranfirio a la bodega 2',NULL,1,1,1,2,'2011-01-23 16:19:49',NULL,27),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,25,'2011-01-23 16:19:49',NULL,28),('Se tranfirio a la bodega 2',NULL,1,1,1,9,'2011-01-23 16:19:50',NULL,29),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,26,'2011-01-23 16:19:50',NULL,30),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,27,'2011-01-23 16:32:49',NULL,31),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,28,'2011-01-23 16:32:49',NULL,32),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,29,'2011-01-23 16:32:49',NULL,33),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,30,'2011-01-23 16:32:50',NULL,34),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,31,'2011-01-23 16:34:41',NULL,35),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,32,'2011-01-23 16:34:42',NULL,36),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,33,'2011-01-23 16:34:42',NULL,37),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,34,'2011-01-23 16:34:42',NULL,38),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,35,'2011-01-23 16:37:24',NULL,39),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,36,'2011-01-23 16:37:24',NULL,40),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,37,'2011-01-23 16:37:24',NULL,41),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,38,'2011-01-23 16:37:25',NULL,42),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,39,'2011-01-23 16:41:04',NULL,43),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,40,'2011-01-23 16:41:04',NULL,44),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,41,'2011-01-23 16:41:04',NULL,45),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,42,'2011-01-23 16:41:04',NULL,46),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,43,'2011-01-23 16:41:49',NULL,47),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,44,'2011-01-23 16:41:49',NULL,48),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,45,'2011-01-23 16:41:49',NULL,49),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,46,'2011-01-23 16:41:49',NULL,50),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,47,'2011-01-23 16:42:48',NULL,51),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,48,'2011-01-23 16:42:48',NULL,52),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,49,'2011-01-23 16:42:48',NULL,53),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,50,'2011-01-23 16:42:49',NULL,54),('Ingreso a la bodega de promesas',NULL,0,3,1,51,'2011-01-23 16:45:34',NULL,55),('Ingreso a la bodega de promesas',NULL,0,3,1,52,'2011-01-23 16:45:34',NULL,56),('Ingreso a la bodega de promesas',NULL,0,3,1,53,'2011-01-23 16:45:38',NULL,57),('Ingreso a la bodega de promesas',NULL,0,3,1,54,'2011-01-23 16:47:19',NULL,58),('Ingreso a la bodega de promesas',NULL,0,3,1,55,'2011-01-23 16:47:32',NULL,59),('Ingreso a la bodega de promesas',NULL,0,3,1,56,'2011-01-23 16:47:32',NULL,60),('Ingreso a la bodega de promesas',NULL,0,3,1,57,'2011-01-23 16:47:38',NULL,61),('Ingreso a la bodega de promesas',NULL,0,3,1,58,'2011-01-23 16:47:38',NULL,62),('Ingreso a la bodega de promesas',NULL,0,3,1,59,'2011-01-23 16:47:38',NULL,63),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,60,'2011-01-23 16:48:22',NULL,64),('Se ingreso por una promesa a la bodega 2',NULL,0,1,1,61,'2011-01-23 16:48:22',NULL,65),('Eliminado por el usuario 1',NULL,3,6,1,57,'2011-01-23 16:52:43',NULL,66),('Eliminado por el usuario 1',NULL,3,6,1,55,'2011-01-23 16:53:06',NULL,67),('Eliminado por el usuario 1',NULL,3,6,1,58,'2011-01-23 16:53:10',NULL,68),('Ingreso a la bodega de promesas',NULL,0,3,1,62,'2011-01-23 20:30:40',NULL,69),('Ingreso a la bodega 2',NULL,0,1,1,63,'2011-01-23 21:12:45',NULL,70),('Se distribuyo desde la bodega 2',NULL,1,5,1,2,'2011-01-27 01:00:21',NULL,71),('Se envio desde el operador de distribucion 555555',NULL,5,7,1,2,'2011-01-27 01:00:21',NULL,72),('Se distribuyo desde la bodega 2',NULL,1,5,1,32,'2011-01-27 01:00:21',NULL,73),('Se envio desde el operador de distribucion 555555',NULL,5,7,1,32,'2011-01-27 01:00:21',NULL,74),('Tranferencia desde la bodega $data[warehouse]',NULL,2,1,1,3,'2011-01-28 22:46:58',NULL,75),('Ingreso a la bodega virtual',NULL,0,2,1,64,'2011-01-28 22:56:52',NULL,76),('Ingreso a la bodega virtual',NULL,0,2,1,65,'2011-01-28 22:56:52',NULL,77),('Ingreso a la bodega virtual',NULL,0,2,1,66,'2011-01-28 22:56:52',NULL,78),('Ingreso a la bodega virtual',NULL,0,2,1,67,'2011-01-28 22:57:01',NULL,79),('Tranferencia desde la bodega ',NULL,2,1,1,64,'2011-01-28 23:14:30',NULL,80);

/*Table structure for table `towns` */

DROP TABLE IF EXISTS `towns`;

CREATE TABLE `towns` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(127) NOT NULL,
  `provinces_id` int(10) unsigned NOT NULL,
  `createdAt` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `deletedAt` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_towns_provinces1` (`provinces_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

/*Data for the table `towns` */

insert  into `towns`(`id`,`name`,`provinces_id`,`createdAt`,`deletedAt`) values (1,'Barranquilla',4,'0000-00-00 00:00:00',NULL),(2,'Baranoa',4,'0000-00-00 00:00:00',NULL),(3,'Campo de la Cruz',4,'0000-00-00 00:00:00',NULL),(4,'Candelaria',4,'0000-00-00 00:00:00',NULL),(5,'Galapa',4,'0000-00-00 00:00:00',NULL),(6,'Juan de Acosta',4,'0000-00-00 00:00:00',NULL),(7,'Luruaco',4,'0000-00-00 00:00:00',NULL),(8,'Malambo',4,'0000-00-00 00:00:00',NULL),(9,'Manatí',4,'0000-00-00 00:00:00',NULL),(10,'Palmar de Varela',4,'0000-00-00 00:00:00',NULL),(11,'Piojó',4,'0000-00-00 00:00:00',NULL),(12,'Polonuevo',4,'0000-00-00 00:00:00',NULL),(13,'Ponedera',4,'0000-00-00 00:00:00',NULL),(14,'Puerto Colombia',4,'0000-00-00 00:00:00',NULL),(15,'Repelón',4,'0000-00-00 00:00:00',NULL),(16,'Sabanagrande',4,'0000-00-00 00:00:00',NULL),(17,'Sabanalarga',4,'0000-00-00 00:00:00',NULL),(18,'Santa Lucía',4,'0000-00-00 00:00:00',NULL),(19,'Santo Tomás',4,'0000-00-00 00:00:00',NULL),(20,'Soledad',4,'0000-00-00 00:00:00',NULL),(21,'Suán',4,'0000-00-00 00:00:00',NULL),(22,'Tubará',4,'0000-00-00 00:00:00',NULL),(23,'Usiacurí',4,'0000-00-00 00:00:00',NULL),(24,'gggg',4,'0000-00-00 00:00:00',NULL);

/*Table structure for table `transfers` */

DROP TABLE IF EXISTS `transfers`;

CREATE TABLE `transfers` (
  `id` int(11) NOT NULL auto_increment,
  `starting_warehouse` int(11) default NULL,
  `destination_warehouse` int(11) NOT NULL,
  `notes` varchar(127) default NULL,
  `shelter_id` int(11) default NULL,
  `createdAt` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `deletedAt` datetime default NULL,
  `state` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_transfers` (`destination_warehouse`),
  KEY `FK_transfers2` (`starting_warehouse`),
  KEY `FK_transfers3` (`shelter_id`),
  CONSTRAINT `FK_transfers` FOREIGN KEY (`destination_warehouse`) REFERENCES `warehouses` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_transfers2` FOREIGN KEY (`starting_warehouse`) REFERENCES `warehouses` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_transfers3` FOREIGN KEY (`shelter_id`) REFERENCES `shelters` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `transfers` */

insert  into `transfers`(`id`,`starting_warehouse`,`destination_warehouse`,`notes`,`shelter_id`,`createdAt`,`deletedAt`,`state`) values (1,NULL,2,'',1,'2011-01-28 23:14:30',NULL,1);

/*Table structure for table `units` */

DROP TABLE IF EXISTS `units`;

CREATE TABLE `units` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(45) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `units` */

insert  into `units`(`id`,`name`) values (1,'Kg'),(2,'Libra'),(3,'Litro'),(4,'Unidad');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `phoneNumber` varchar(45) default NULL,
  `profile` varchar(45) NOT NULL,
  `password` varchar(128) NOT NULL,
  `createdAt` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `deletedAt` datetime default NULL,
  `companies_id` double default NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_users` (`companies_id`),
  CONSTRAINT `FK_users` FOREIGN KEY (`companies_id`) REFERENCES `companies` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`phoneNumber`,`profile`,`password`,`createdAt`,`deletedAt`,`companies_id`) values (1,'Admin','support@coddeeweb.com',NULL,'Administrador','e11a8f5f22179a6485f5ef8d1fa59003','0000-00-00 00:00:00',NULL,NULL);

/*Table structure for table `vouchers` */

DROP TABLE IF EXISTS `vouchers`;

CREATE TABLE `vouchers` (
  `id` int(11) NOT NULL auto_increment,
  `bill` decimal(10,0) NOT NULL,
  `donors_id` double NOT NULL,
  `notes` varchar(511) default NULL,
  `createdAt` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `deletedAt` datetime default NULL,
  `state` int(11) NOT NULL default '0',
  `company_id` double NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_vouchers` (`donors_id`),
  KEY `FK_vouchers2` (`company_id`),
  CONSTRAINT `FK_vouchers` FOREIGN KEY (`donors_id`) REFERENCES `donors` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_vouchers2` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `vouchers` */

insert  into `vouchers`(`id`,`bill`,`donors_id`,`notes`,`createdAt`,`deletedAt`,`state`,`company_id`,`date`) values (1,'1111',111,NULL,'2011-01-25 00:41:25',NULL,0,44444444,'2011-01-18 00:00:00'),(2,'3242',111,NULL,'2011-01-25 00:42:52',NULL,0,44444444,'2011-01-20 00:00:00'),(3,'3242',111,NULL,'2011-01-25 00:43:33',NULL,0,44444444,'2011-01-20 00:00:00');

/*Table structure for table `warehouses` */

DROP TABLE IF EXISTS `warehouses`;

CREATE TABLE `warehouses` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(45) default NULL,
  `description` varchar(45) default NULL,
  `type` int(2) default '1',
  `occupation` int(11) default NULL,
  `contactName` varchar(45) default NULL,
  `address` varchar(45) default NULL,
  `phoneNumber` varchar(45) default NULL,
  `cellphone` varchar(45) default NULL,
  `faxNumber` varchar(45) default NULL,
  `towns_id` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `deletedAt` datetime default NULL,
  `email` varchar(45) default NULL,
  `companies_id` double default NULL,
  PRIMARY KEY  (`id`),
  KEY `fk_warehouses_towns1` (`towns_id`),
  KEY `companies` (`companies_id`),
  CONSTRAINT `FK_warehouses` FOREIGN KEY (`companies_id`) REFERENCES `companies` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_warehouses_towns1` FOREIGN KEY (`towns_id`) REFERENCES `towns` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*Data for the table `warehouses` */

insert  into `warehouses`(`id`,`name`,`description`,`type`,`occupation`,`contactName`,`address`,`phoneNumber`,`cellphone`,`faxNumber`,`towns_id`,`createdAt`,`deletedAt`,`email`,`companies_id`) values (1,'GobernaciÃ³n','bodega',1,20,'Jorge Arango','Calle falsa 123','43243','432332','3423432',1,'0000-00-00 00:00:00',NULL,NULL,NULL),(2,'Cruz Roja','ejempplo',1,20,'ns anmsd jsnda','sdsada','332432','324233','32432234',1,'0000-00-00 00:00:00',NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
