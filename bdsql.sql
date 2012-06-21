/*
SQLyog Enterprise - MySQL GUI v8.05 
MySQL - 5.1.36-community-log : Database - tecpananet
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

USE `tecpananet`;

/*Table structure for table `contactos` */

DROP TABLE IF EXISTS `contactos`;

CREATE TABLE `contactos` (
  `cuenta_id` int(11) NOT NULL,
  `contacto_id` char(15) NOT NULL,
  `tipo` tinyint(1) DEFAULT NULL COMMENT '1 = persona; 2 = empresa',
  `nombre` varchar(254) DEFAULT NULL COMMENT 'nombre para personas y razón social para empresas',
  `apellidos` varchar(128) DEFAULT NULL,
  `sexo` tinyint(1) DEFAULT NULL COMMENT '1 = masculino; 2 = femenino',
  `titulo` varchar(8) DEFAULT NULL,
  `descripcion` text,
  `empresa_id` char(15) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  PRIMARY KEY (`contacto_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `contactos` */

/*Table structure for table `contactos_info` */

DROP TABLE IF EXISTS `contactos_info`;

CREATE TABLE `contactos_info` (
  `cuenta_id` int(11) NOT NULL,
  `contacto_id` char(15) NOT NULL,
  `info_id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` tinyint(4) DEFAULT NULL COMMENT '1 = telefono; 2 = email; 3 = direccion; 4 = mensajeria; 5 = web',
  `valor` varchar(250) DEFAULT NULL,
  `valor_text` text,
  `modo` tinyint(4) DEFAULT NULL,
  `servicio` tinyint(4) DEFAULT NULL,
  `ciudad` varchar(32) DEFAULT NULL,
  `estado` varchar(32) DEFAULT NULL,
  `pais_id` tinyint(3) DEFAULT NULL,
  `cpostal` varchar(8) DEFAULT NULL,
  `principal` tinyint(1) DEFAULT '0' COMMENT '1 = principal; 0 = secundario',
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  PRIMARY KEY (`info_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `contactos_info` */

/*Table structure for table `contactos_info_catalogo` */

DROP TABLE IF EXISTS `contactos_info_catalogo`;

CREATE TABLE `contactos_info_catalogo` (
  `tipo_id` int(11) NOT NULL,
  `nombre` varchar(64) NOT NULL COMMENT 'Llave del campo',
  `etiqueta` varchar(128) DEFAULT NULL COMMENT 'Descripción del campo (nombre textual)',
  `valores` text COMMENT 'Posibles valores en formato Json, o null si el valor va a ser textual',
  `valores_modo` tinytext COMMENT 'En formato Json',
  `valores_servicio` tinytext COMMENT 'En formato Json',
  `elemento` varchar(16) DEFAULT 'text',
  `opciones` varchar(255) DEFAULT '{"css":"tam70","obligado":"no"}' COMMENT 'En formato Json',
  `visible` tinyint(1) DEFAULT '1' COMMENT '1 si; 0 no',
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  PRIMARY KEY (`tipo_id`,`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `contactos_info_catalogo` */

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
