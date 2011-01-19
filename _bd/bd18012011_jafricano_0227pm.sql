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
CREATE DATABASE /*!32312 IF NOT EXISTS*/`coddeedms` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `coddeedms`;

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(45) NOT NULL,
  `description` varchar(500) default NULL,
  `deletedAt` datetime default NULL,
  `createdAt` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `categories` */

insert  into `categories`(`id`,`name`,`description`,`deletedAt`,`createdAt`) values (1,'Productos de Aseo de Ropa','Diferentes productos de aseo para la ropa',NULL,'0000-00-00 00:00:00'),(2,'comida','comida',NULL,'0000-00-00 00:00:00');

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
  PRIMARY KEY  (`id`),
  KEY `fk_distributions_companies1` (`companies_id`),
  KEY `fk_distributions_warehouses1` (`warehouses_id`),
  CONSTRAINT `fk_distributions_warehouses1` FOREIGN KEY (`warehouses_id`) REFERENCES `warehouses` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*Data for the table `distributions` */

insert  into `distributions`(`id`,`deliveryDate`,`state`,`companies_id`,`warehouses_id`,`createdAt`,`deletedAt`) values (1,'2011-01-11',1,555555,3,'0000-00-00 00:00:00',NULL),(2,'2011-01-11',1,555555,3,'0000-00-00 00:00:00',NULL),(3,'2011-01-11',1,555555,3,'0000-00-00 00:00:00',NULL),(4,'2011-01-11',1,555555,3,'0000-00-00 00:00:00',NULL),(5,'2011-01-11',1,555555,3,'0000-00-00 00:00:00',NULL),(6,'2011-01-11',1,555555,3,'0000-00-00 00:00:00',NULL),(7,'2011-01-11',1,555555,3,'0000-00-00 00:00:00',NULL),(8,'2011-01-11',1,555555,3,'0000-00-00 00:00:00',NULL),(9,'2011-01-12',1,555555,3,'0000-00-00 00:00:00',NULL),(10,'2011-01-11',1,555555,3,'0000-00-00 00:00:00',NULL),(11,'2011-01-12',1,555555,3,'0000-00-00 00:00:00',NULL),(12,'2011-01-13',1,555555,3,'0000-00-00 00:00:00',NULL),(13,'2011-01-12',1,555555,3,'0000-00-00 00:00:00',NULL),(14,'2011-01-12',1,555555,3,'0000-00-00 00:00:00',NULL);

/*Table structure for table `donations` */

DROP TABLE IF EXISTS `donations`;

CREATE TABLE `donations` (
  `sequence` int(11) NOT NULL auto_increment,
  `detail` varchar(500) default NULL,
  `bill` int(11) default NULL,
  `users_id` int(11) NOT NULL,
  `donors_id` double NOT NULL,
  `warehouses_id` int(11) NOT NULL,
  `companies_id` double default NULL,
  `date` datetime NOT NULL,
  `ceatedAt` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `deleteAt` datetime default NULL,
  PRIMARY KEY  (`sequence`),
  KEY `fk_donations_users1` (`users_id`),
  KEY `fk_donations_donors1` (`donors_id`),
  KEY `fk_donations_warehouses1` (`warehouses_id`),
  KEY `fk_donations_companies1` (`companies_id`),
  CONSTRAINT `fk_donations_donors1` FOREIGN KEY (`donors_id`) REFERENCES `donors` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_donations_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_donations_warehouses1` FOREIGN KEY (`warehouses_id`) REFERENCES `warehouses` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*Data for the table `donations` */

insert  into `donations`(`sequence`,`detail`,`bill`,`users_id`,`donors_id`,`warehouses_id`,`companies_id`,`date`,`ceatedAt`,`deleteAt`) values (7,'',425874,1,111,3,NULL,'2011-01-11 00:00:00','0000-00-00 00:00:00',NULL);

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

insert  into `donors`(`id`,`name`,`type`,`address`,`email`,`phoneNumber`,`faxNumber`,`creationDate`,`towns_id`,`deletedAt`) values (111,'David',1,'a','a','8','8','2011-01-10 00:00:00',2,NULL),(2233,'Daniel Herrera',1,'Calle falsa 123','ing.donovan.delvalle@gmail.com','322','132342','2011-01-10 00:00:00',3,NULL),(3434,'Bodega GobernaciÃ³n',1,'Calle falsa 123','ing.donovan.delvalle@gmail.com','324','23432','2011-01-10 00:00:00',2,NULL),(4444,'Daniel Herrera',1,'Calle falsa 123','ing.donovan.delvalle@gmail.com','555','333','2011-01-10 00:00:00',2,NULL),(23232,'Donovan Del Valle',1,'Calle falsa 123','ing.donovan.delvalle@gmail.com','4444','3432423','2011-01-10 00:00:00',10,NULL);

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
  `deleteAt` datetime default NULL,
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
  PRIMARY KEY  (`id`),
  KEY `fk_products_productTypes1` (`productTypes_id`),
  CONSTRAINT `fk_products_productTypes1` FOREIGN KEY (`productTypes_id`) REFERENCES `producttypes` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `products` */

insert  into `products`(`id`,`name`,`description`,`state`,`productTypes_id`,`flagkit`,`createdAt`,`deletedAt`) values (2,'Aceite Vivi de 2 litros','',1,1,0,'2011-01-16 19:33:40',NULL),(3,'Colchon sencillo','',1,4,0,'2011-01-16 19:33:40',NULL),(4,'Mesa pequeÃ±a','',1,3,0,'2011-01-16 19:33:40',NULL),(5,'Aceite Girasol 1 litro','',1,1,0,'2011-01-16 19:33:40',NULL),(7,'werwer','',1,5,0,'2011-01-16 19:33:40',NULL),(8,'ALGO',NULL,1,5,0,'2011-01-16 19:22:14',NULL),(9,'Re Prueba',NULL,1,1,0,'2011-01-16 19:23:47',NULL),(10,'REPRUEBA','',1,5,0,'2011-01-16 19:24:38',NULL);

/*Table structure for table `products_donations` */

DROP TABLE IF EXISTS `products_donations`;

CREATE TABLE `products_donations` (
  `products_id` int(11) NOT NULL,
  `donations_id` int(11) NOT NULL,
  `expirationDate` date NOT NULL,
  `state` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `warehouses_id` int(11) NOT NULL,
  `createdAt` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `deletedAt` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `product` (`products_id`),
  KEY `donation` (`donations_id`),
  KEY `fk_products_donations_warehouses1` (`warehouses_id`),
  CONSTRAINT `fk_products_donations_warehouses1` FOREIGN KEY (`warehouses_id`) REFERENCES `warehouses` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*Data for the table `products_donations` */

insert  into `products_donations`(`products_id`,`donations_id`,`expirationDate`,`state`,`id`,`warehouses_id`,`createdAt`,`deletedAt`) values (5,1,'2011-01-12',4,2,7,'0000-00-00 00:00:00',NULL),(5,1,'2011-01-12',2,3,3,'0000-00-00 00:00:00',NULL),(5,1,'2011-01-12',2,4,3,'0000-00-00 00:00:00',NULL),(3,1,'2011-01-12',2,5,3,'0000-00-00 00:00:00',NULL),(2,1,'2011-01-12',4,6,7,'0000-00-00 00:00:00',NULL),(4,7,'2011-01-25',1,7,3,'0000-00-00 00:00:00',NULL);

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

insert  into `products_donations_distributions`(`distributions_id`,`products_donations_id`,`createdAt`,`deletedAt`) values (9,2,'0000-00-00 00:00:00',NULL),(9,3,'0000-00-00 00:00:00',NULL),(10,2,'0000-00-00 00:00:00',NULL),(11,3,'0000-00-00 00:00:00',NULL),(12,2,'0000-00-00 00:00:00',NULL),(12,6,'0000-00-00 00:00:00',NULL);

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
  `deletedAt` datetime NOT NULL,
  `id` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id`),
  KEY `fk_statechanges_users1` (`users_id`),
  KEY `FK_statechanges_product_donation` (`products_donations_id`),
  CONSTRAINT `FK_statechanges` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_statechanges_product_donation` FOREIGN KEY (`products_donations_id`) REFERENCES `products_donations` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*Data for the table `statechanges` */

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

/*Table structure for table `warehouses` */

DROP TABLE IF EXISTS `warehouses`;

CREATE TABLE `warehouses` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(45) default NULL,
  `description` varchar(45) default NULL,
  `type` int(11) default NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*Data for the table `warehouses` */

insert  into `warehouses`(`id`,`name`,`description`,`type`,`occupation`,`contactName`,`address`,`phoneNumber`,`cellphone`,`faxNumber`,`towns_id`,`createdAt`,`deletedAt`,`email`,`companies_id`) values (3,'GobernaciÃ³n','bodega',2,20,'Jorge Arango','Calle falsa 123','43243','432332','3423432',1,'0000-00-00 00:00:00',NULL,NULL,NULL),(7,'kjdfasj','jsjdfaskjdnajdn',1,20,'ns anmsd jsnda','sdsada','332432','324233','32432234',1,'0000-00-00 00:00:00',NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
