/*
SQLyog Enterprise - MySQL GUI v8.05 
MySQL - 5.1.36-community-log : Database - tuplan
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

USE `tuplan`;

/*Table structure for table `contactos` */

DROP TABLE IF EXISTS `contactos`;

CREATE TABLE `contactos` (
  `cuenta_id` int(11) NOT NULL,
  `contacto_id` char(15) NOT NULL,
  `tipo` tinyint(1) DEFAULT NULL COMMENT '1 = persona; 2 = empresa',
  `razon_social` varchar(128) DEFAULT NULL,
  `nombre` varchar(128) DEFAULT NULL,
  `apellidos` varchar(64) DEFAULT NULL,
  `sexo` tinyint(1) DEFAULT NULL COMMENT '1 = masculino; 2 = femenino',
  `titulo` varchar(8) DEFAULT NULL,
  `descripcion` text,
  `empresa_id` char(15) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL,
  PRIMARY KEY (`contacto_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `contactos` */

insert  into `contactos`(`cuenta_id`,`contacto_id`,`tipo`,`razon_social`,`nombre`,`apellidos`,`sexo`,`titulo`,`descripcion`,`empresa_id`,`fecha_creacion`,`fecha_actualizacion`) values (1,'1',1,NULL,'Federico','Michell Vijil',1,'Ing.','Ingeniero web',NULL,'2011-06-29 00:00:00','2011-06-29 00:00:00'),(1,'2',1,NULL,'Ferah','Prado Cantillo',2,'Lic.','Abogada y Notario',NULL,'2011-06-29 00:00:00','2011-06-29 00:00:00');

/*Table structure for table `contactos_info` */

DROP TABLE IF EXISTS `contactos_info`;

CREATE TABLE `contactos_info` (
  `cuenta_id` int(11) NOT NULL,
  `info_id` int(11) NOT NULL AUTO_INCREMENT,
  `contacto_id` char(15) NOT NULL,
  `tipo` tinyint(1) DEFAULT NULL COMMENT '1 = telefono; 2 = email; 3 = direccion; 4 = mensajeria; 5 = web',
  `valor_1` varchar(128) DEFAULT NULL,
  `valor_2` varchar(128) DEFAULT NULL,
  `modo` tinyint(1) DEFAULT NULL,
  `proveedor` tinyint(1) DEFAULT NULL,
  `ciudad` varchar(32) DEFAULT NULL,
  `estado` varchar(32) DEFAULT NULL,
  `pais_id` tinyint(3) DEFAULT NULL,
  `cpostal` varchar(8) DEFAULT NULL,
  `principal` tinyint(1) DEFAULT '0' COMMENT '1 = principal; 0 = secundario',
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  PRIMARY KEY (`info_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `contactos_info` */

insert  into `contactos_info`(`cuenta_id`,`info_id`,`contacto_id`,`tipo`,`valor_1`,`valor_2`,`modo`,`proveedor`,`ciudad`,`estado`,`pais_id`,`cpostal`,`principal`,`fecha_creacion`,`fecha_modificacion`) values (1,1,'1',1,'22657879',NULL,1,NULL,NULL,NULL,NULL,NULL,1,'2011-06-29 00:00:00','2011-06-29 00:00:00'),(1,2,'2',1,'22657879',NULL,1,NULL,NULL,NULL,NULL,NULL,1,'2011-06-29 00:00:00','2011-06-29 00:00:00'),(1,3,'1',2,'88733432',NULL,1,NULL,NULL,NULL,NULL,NULL,0,'2011-06-29 00:00:00','2011-06-29 00:00:00');

/*Table structure for table `cuentas` */

DROP TABLE IF EXISTS `cuentas`;

CREATE TABLE `cuentas` (
  `cuenta_id` int(11) NOT NULL,
  `nombre` varchar(32) DEFAULT NULL,
  `subdominio` varchar(16) NOT NULL,
  `estado` tinyint(1) DEFAULT '1' COMMENT '0 = inactiva; 1 = activa;',
  `zona_tiempo` varchar(40) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_vence` datetime DEFAULT NULL,
  PRIMARY KEY (`cuenta_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `cuentas` */

/*Table structure for table `usuarios` */

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `cuenta_id` int(11) NOT NULL,
  `usuario_id` char(15) NOT NULL,
  `usuario` varchar(64) DEFAULT NULL,
  `contrasena` char(32) DEFAULT NULL,
  `perfil_id` tinyint(4) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT '1' COMMENT '0 = inactivo; 1 = activo',
  `zona_tiempo` varchar(40) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL,
  PRIMARY KEY (`usuario_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `usuarios` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
