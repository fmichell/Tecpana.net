/*
SQLyog Enterprise - MySQL GUI v8.05 
MySQL - 5.5.8-log : Database - siencrm
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`siencrm` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `siencrm`;

/*Table structure for table `asistencia` */

DROP TABLE IF EXISTS `asistencia`;

CREATE TABLE `asistencia` (
  `evento_id` varchar(15) NOT NULL,
  `comprador_id` varchar(15) NOT NULL,
  `personaCompradora_id` varchar(15) NOT NULL,
  `asistencia` tinyint(1) DEFAULT NULL COMMENT '0 = no; 1 = si',
  PRIMARY KEY (`evento_id`,`comprador_id`,`personaCompradora_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `asistencia` */

/*Table structure for table `categorias` */

DROP TABLE IF EXISTS `categorias`;

CREATE TABLE `categorias` (
  `categoria_id` char(3) NOT NULL,
  `categoria_padre` char(3) DEFAULT NULL,
  `nombre` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`categoria_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `categorias` */

insert  into `categorias`(`categoria_id`,`categoria_padre`,`nombre`) values ('01','01','CONSEJO METAL MECANICO'),('101','01','FUNDIDORES DE PARTES'),('102','01','FUNDIDORES DE ALUMINIO'),('103','01','FABRICANTES DE REFACCIONES INDUSTRIALES'),('104','01','TALLERES MECANICOS INDUSTRIALES'),('105','01','FABRICANTES DE MOLDES Y MODELOS INDUSTRIALES'),('106','01','FABRICANTES DE ESTRUCTURAS METALICAS, PAILERIA Y MONTAJE'),('107','01','RECUBRIMIENTOS METALICOS'),('108','01','FABRICANTES DE APARATOS DE AIRE ACONDICIONADO, REFRIGERACION Y V'),('109','01','FABRICANTES DE PRODUCTOS DE ALAMBRE'),('110','01','FABRICANTES DE ARTICULOS DE LAMINA'),('111','01','TALLERES DE SOLDADURA'),('112','01','FORJADOS, TROQUELADOS, EMBUTIDOS Y ESTAMPADOS'),('113','01','FABRICANTES DE HERRAMIENTAS'),('02','02','CONSEJO DE BIENES DE CAPITAL'),('201','02','FABRICANTES DE RECIPIENTES A PRESION'),('202','02','FABRICANTES DE BOMBAS Y COMPRESORES'),('203','02','FABRICANTES DE EQUIPOS DE PROCESO'),('204','02','MAQUINARIA Y EQUIPO INDUSTRIAL'),('205','02','FABRICANTES DE MAQUINAS HERRAMIENTAS'),('206','02','FABRICANTES DE EQUIPO ELECTRICO'),('207','02','FABRICANTES DE MAQUINARIA E IMPLEMENTOS AGRICOLAS'),('208','02','CALDERAS E INTERCAMBIADORES'),('03','03','CONSEJO AUTOMOTRIZ'),('301','03','FABRICANTES DE AUTOPARTES'),('302','03','REPARACION Y SERVICIO AUTOMOTRIZ'),('303','03','REPARACION DE MOTORES DE COMBUSTION INTERNA DIESEL'),('304','03','TALLERES DE RECTIFICACION Y RECONSTRUCCION AUTOMOTRIZ'),('305','03','TRACTOCAMIONES Y CARROCERIAS'),('306','03','TALLER DE ENDEREZADO Y PINTURA'),('307','03','TAPICERIA DE AUTO'),('04','04','CONSEJO DEL PLASTICO Y HUL'),('401','04','INDUSTRIA DEL PLASTICO'),('402','04','INDUSTRIA DEL HULE'),('05','05','CONSEJO QUIMICO '),('501','05','FABRICANTES DE LUBRICANTES Y GRASAS'),('502','05','FABRICANTES DE SOLVENTE'),('503','05','FABRICANTES DE FOSFATOS'),('505','05','FABRICANTES DE PRODUCTOS PARA TRATAMIENTO DE AGUAS'),('506','05','FABRICANTES DE RESINAS SINTETICAS Y POLIMERICAS'),('507','05','FABRICANTES DE FIBRAS QUIMICAS'),('508','05','FABRICANTES DE PRODUCTOS FARMACEUTICOS'),('509','05','FABRICANTES DE COLORANTES, PIGMENTOS, PINTURAS, BARNICES Y LACAS'),('510','05','FABRICANTES DE PRODUCTOS DE BELLEZA'),('511','05','FABRICANTES DE JABONES, DETERGENTES, LIMPIADORES Y AROMATIZANTES'),('512','05','FABRICANTES DE VELAS Y VELADORAS'),('513','05','FABRICANTES DE GASES INDUSTRIALES'),('514','05','FABRICANTES DE ADHESIVOS'),('515','05','FABRICANTES DE PRODUCTOS QUIMICOS INORGANICOS'),('06','06','CONSEJO ALIMENTICIO'),('601','06','MATANZA DE GANADO Y EMPACADO DE CARNE FRESCA'),('602','06','EMPACADORES DE CARNES FRIAS Y EMBUTIDOS'),('603','06','FABRICANTES DE CHORIZO'),('604','06','EMPACADORES DE GRANOS ALIMENTICIOS'),('605','06','PREPARACION Y ENVASADO DE FRUTAS Y LEGUMBRES'),('606','06','FABRICANTES DE CONCENTRADOS, JUGOS, JARABES Y COLORANTES PARA AL'),('607','06','FABRICANTES DE GALLETAS, PASTAS Y HARINAS ALIMENTICIAS'),('608','06','PANADERIA Y REPOSTERIA'),('609','06','FABRICANTES DE ACEITES Y GRASAS COMESTIBLES'),('610','06','ALIMENTOS BALANCEADOS'),('611','06','INDUSTRIALIZADORES DEL CAFE'),('612','06','2 FABRICANTES DE ALIMENTOS HELADO'),('613','06','INDUSTRIA LACTEA'),('614','06','INDUSTRIA DE LA BEBIDA'),('615','06','FABRICANTES DE CONDIMENTOS'),('616','06','AGUA PURIFICADA'),('617','06','FABRICANTES DE HIELO'),('618','06','FABRICANTES DE DULCES'),('619','06','FABRICANTES DE BOTANAS Y FRITURAS'),('620','06','PRODUCTOS ALIMENTICIOS DIVERSOS'),('07','07','CONSEJO MUEBLERO'),('702','07','INDUSTRIA DEL MUEBL'),('703','07','FABRICANTES DE COCINAS INTEGRALES'),('704','07','TALLERES DE CARPINTERIA'),('705','07','TALLERES DE TAPICERIA DE MUEBLES'),('706','07','FABRICANTES DE COLCHONES'),('08','08','CONSEJO DE CONSTRUCCION'),('801','08','EXPLOTACION DE MINERALES NO METALICOS'),('802','08','FABRICANTES DE CEMENTO, CONCRETO Y PRODUCTOS DE ASBESTO'),('803','08','FABRICANTES DE CAL, YESO Y SUS PRODUCTOS'),('804','08','INDUSTRIA CERAMICA Y ALFARERA'),('805','08','FABRICANTES DE BLOCK'),('806','08','FABRICANTES DE LADRILLOS Y TEJAS'),('807','08','FABRICANTES DE MOSAICOS, TUBOS, POSTES Y SIMILARES'),('808','08','FABRICANTES DE PRODUCTOS DE MARMOL'),('809','08','ACARREO DE MATERIALES Y SERVICIOS DE LA CONSTRUCCION'),('810','08','ACCESORIOS PARA CONSTRUCCION'),('09','09',' CONSEJO DE INDUSTRIAS DIVERSAS '),('901','09','INDUSTRIA ELECTRONIC'),('902','09','APARATOS Y ARTICULOS ELECTRICOS'),('903','09','INDUSTRIA DEL CALZADO'),('904','09','INDUSTRIA DEL VESTIDO'),('905','09','INDUSTRIA DE LA PIEL Y EL CUERO'),('906','09','INDUSTRIAS DEL PAPEL Y CARTON'),('907','09','SERVICIOS DE REPARACION DE APARATOS ELECTRICOS'),('908','09','FABRICANTES DE ESCOBAS Y CEPILLOS'),('909','09','INDUSTRIAS VARIAS'),('910','09','SERVICIOS EN GENERAL'),('911','09','ANTEOJOS, PROTESIS Y ARTICULOS MEDICOS'),('912','09','FABRICANTES DE ARTICULOS DEPORTIVOS'),('913','09','ARTES GRAFICAS'),('914','09','ESTUDIOS FOTOGRAFICOS'),('915','09','SERVICIOS DE TRANSPORTE'),('916','09','SERVICIOS DE MANTENIMIENTO E INSTALACIONES INDUSTRIALES'),('917','09','FABRICANTES DE JOYAS Y ARTICULOS SIMILARES'),('918','09','FABRICANTES DE FIBRA DE VIDRIO Y SUS PRODUCTOS'),('919','09','INDUSTRIA DEL VIDRIO');

/*Table structure for table `citas` */

DROP TABLE IF EXISTS `citas`;

CREATE TABLE `citas` (
  `cuenta_id` char(15) DEFAULT NULL,
  `evento_id` char(15) DEFAULT NULL,
  `cita_id` char(15) NOT NULL,
  `tipo` tinyint(1) DEFAULT '1' COMMENT '1 Cita; 2 Almuerzo; 3 Refrigerio',
  `comprador_id` char(15) DEFAULT NULL,
  `proveedor_id` char(15) DEFAULT NULL,
  `requerimiento_id` char(15) DEFAULT NULL,
  `fecha_cita` datetime DEFAULT NULL,
  `comentario` text,
  `confirmada` tinyint(1) DEFAULT '0' COMMENT '1 Confirmada; 0 No confirmada',
  `fecha_confirmacion` datetime DEFAULT NULL,
  `estado` tinyint(1) DEFAULT '1' COMMENT '1 Activas; 0 Eliminadas; 2 Eliminadas desde el cron por vencimiento',
  `asistencia` tinyint(1) DEFAULT '0' COMMENT '0 No definido; 1 Asistira; 2 No asistira',
  `estado_en_evento` tinyint(1) DEFAULT '0' COMMENT '0 Ninguno; 1 In; 2 Out',
  `origen` tinyint(1) DEFAULT '1' COMMENT '1 Intranet; 2 Widget 2; 3 Widget 3',
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `fecha_eliminacion_cron` datetime DEFAULT NULL,
  PRIMARY KEY (`cita_id`),
  UNIQUE KEY `codigo` (`codigo`),
  KEY `evento_id` (`evento_id`,`comprador_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `citas` */

/*Table structure for table `comentarios` */

DROP TABLE IF EXISTS `comentarios`;

CREATE TABLE `comentarios` (
  `cuenta_id` varchar(15) NOT NULL,
  `comentario_id` varchar(15) NOT NULL,
  `referencia_id` varchar(15) NOT NULL,
  `posteado_por` varchar(15) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  PRIMARY KEY (`comentario_id`),
  KEY `por_referencia` (`cuenta_id`,`referencia_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*Data for the table `comentarios` */

/*Table structure for table `contactos` */

DROP TABLE IF EXISTS `contactos`;

CREATE TABLE `contactos` (
  `cuenta_id` char(15) NOT NULL,
  `contacto_id` char(15) NOT NULL,
  `rfc` varchar(32) DEFAULT NULL,
  `razon_social` varchar(70) DEFAULT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  `apellido_paterno` varchar(32) DEFAULT NULL,
  `apellido_materno` varchar(32) DEFAULT NULL,
  `titulo` varchar(50) DEFAULT NULL,
  `empresa_id` char(15) DEFAULT NULL,
  `usuario` char(64) DEFAULT NULL,
  `contrasena` char(32) DEFAULT NULL,
  `zonatiempo` varchar(40) DEFAULT 'America/Mexico_City',
  `tipo` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '0 es empresa, 1 es persona, 2 es usuario, 3 es admin y 4 es dueño de cuenta',
  `status_empresa` tinyint(1) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT '1' COMMENT '0 eliminado; 1 activo',
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL,
  `fecha_acceso` datetime DEFAULT NULL,
  PRIMARY KEY (`cuenta_id`,`contacto_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='Aqui guardamos todos los contactos y usuarios del sistema.';

/*Data for the table `contactos` */

insert  into `contactos`(`cuenta_id`,`contacto_id`,`rfc`,`razon_social`,`nombre`,`apellido_paterno`,`apellido_materno`,`titulo`,`empresa_id`,`usuario`,`contrasena`,`zonatiempo`,`tipo`,`status_empresa`,`estado`,`fecha_creacion`,`fecha_actualizacion`,`fecha_acceso`) values ('cu4f43d8bc2ba97','ct4f4e5f7c38525','123456789','Empresa de prueba 1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'America/Mexico_City',0,1,1,'2012-02-29 11:25:16','2012-02-29 11:25:16','2012-02-29 11:25:16'),('cu4f43d8bc2ba97','ct4f4e5f7c390ec',NULL,NULL,'Juan Manuel','Gonzalez','Navas','Representante Legal','ct4f4e5f7c38525',NULL,NULL,'America/Mexico_City',1,0,1,'2012-02-29 11:25:16','2012-02-29 11:25:16','2012-02-29 11:25:16'),('cu4f43d8bc2ba97','ct4f4e5f7c39efa',NULL,NULL,'Nestor','Picado','Rivera','Programador','ct4f4e5f7c38525',NULL,NULL,'America/Mexico_City',1,0,1,'2012-02-29 11:25:16','2012-02-29 11:25:16','2012-02-29 11:25:16'),('cu4f43d8bc2ba97','ct4f4ff617abdbb','0123456789','Razon Social',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'America/Mexico_City',0,1,1,'2012-03-01 16:20:07','2012-03-01 16:20:07','2012-03-01 16:20:07'),('cu4f43d8bc2ba97','ct4f4ff617b5bd0',NULL,NULL,'Juan Manuel','Gonzalez','Navas','Representante Legal','ct4f4ff617abdbb',NULL,NULL,'America/Mexico_City',1,0,1,'2012-03-01 16:20:07','2012-03-01 16:20:07','2012-03-01 16:20:07'),('cu4f43d8bc2ba97','ct4f4ff617b6aef',NULL,NULL,'Nombres','Apellido paterno','Apellido materno','Cargo','ct4f4ff617abdbb',NULL,NULL,'America/Mexico_City',1,0,1,'2012-03-01 16:20:07','2012-03-01 16:20:07','2012-03-01 16:20:07'),('cu4f43d8bc2ba97','ct4f4ff617b6e22',NULL,NULL,'Ejecutivo nombre 1','Paterno 1','Materno 1','cargo1','ct4f4ff617abdbb',NULL,NULL,'America/Mexico_City',1,0,1,'2012-03-01 16:20:07','2012-03-01 16:20:07','2012-03-01 16:20:07'),('cu4f43d8bc2ba97','ct4f4ff617b7195',NULL,NULL,'Ejecutivo nombre 2','Paterno 2','Materno 2','cargo2','ct4f4ff617abdbb',NULL,NULL,'America/Mexico_City',1,0,1,'2012-03-01 16:20:07','2012-03-01 16:20:07','2012-03-01 16:20:07'),('cu4f43d8bc2ba97','ct4fdfb0114c07d','123','Razon Social Nueva',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'America/Mexico_City',0,1,1,'2012-06-18 17:47:45','2012-06-18 17:47:45','2012-06-18 17:47:45'),('cu4f43d8bc2ba97','ct4fdfb0114ca74',NULL,NULL,'Federico','Michell','Vijil','Representante Legal','ct4fdfb0114c07d',NULL,NULL,'America/Mexico_City',1,0,1,'2012-06-18 17:47:45','2012-06-18 17:47:45','2012-06-18 17:47:45'),('cu4f43d8bc2ba97','ct4fdfb0114d8e2',NULL,NULL,'Nombres','Apellido paterno','Apellido materno','Cargo','ct4fdfb0114c07d',NULL,NULL,'America/Mexico_City',1,0,1,'2012-06-18 17:47:45','2012-06-18 17:47:45','2012-06-18 17:47:45'),('cu4f43d8bc2ba97','ct4fdfb0114dc87',NULL,NULL,'Ejecutivo 1','Apellido E1','Apellido E1','Cargo E1','ct4fdfb0114c07d',NULL,NULL,'America/Mexico_City',1,0,1,'2012-06-18 17:47:45','2012-06-18 17:47:45','2012-06-18 17:47:45'),('cu4f43d8bc2ba97','ct4fdfb0114dfaa',NULL,NULL,'Ejecutivo 2','Apellido E2','Apellido E2','Cargo E2','ct4fdfb0114c07d',NULL,NULL,'America/Mexico_City',1,0,1,'2012-06-18 17:47:45','2012-06-18 17:47:45','2012-06-18 17:47:45'),('cu4f43d8bc2ba97','ct4fdfbcfa08dd9',NULL,NULL,'Nombres','Apellido paterno','Apellido materno','Representante Legal','ct4fdfbcfa086f1',NULL,NULL,'America/Mexico_City',1,0,1,'2012-06-18 18:42:50','2012-06-18 18:42:50','2012-06-18 18:42:50'),('cu4f43d8bc2ba97','ct4fdfbcfa09609',NULL,NULL,'Nombres','Apellido paterno','Apellido materno','Cargo','ct4fdfbcfa086f1',NULL,NULL,'America/Mexico_City',1,0,1,'2012-06-18 18:42:50','2012-06-18 18:42:50','2012-06-18 18:42:50'),('cu4f43d8bc2ba97','ct4fdfbcfa0991b',NULL,NULL,'Nombres','Apellido paterno','Apellido materno','Cargo','ct4fdfbcfa086f1',NULL,NULL,'America/Mexico_City',1,0,1,'2012-06-18 18:42:50','2012-06-18 18:42:50','2012-06-18 18:42:50');

/*Table structure for table `contactos_info` */

DROP TABLE IF EXISTS `contactos_info`;

CREATE TABLE `contactos_info` (
  `cuenta_id` char(15) NOT NULL,
  `contacto_id` char(15) NOT NULL COMMENT 'persona_id o empresa_id',
  `info_id` char(15) NOT NULL,
  `tipo` int(10) unsigned NOT NULL COMMENT '1 es telefono, 2 es correo, 3 es IM, 4 es sitio web, 5 es twitter, 6 direccion, 7 facebook',
  `valor` varchar(250) DEFAULT NULL,
  `valor_text` text,
  `modo` tinyint(3) unsigned DEFAULT '1',
  `servicio` tinyint(3) unsigned DEFAULT '1',
  `ciudad` varchar(100) DEFAULT NULL,
  `estado` varchar(100) DEFAULT NULL,
  `pais` varchar(32) DEFAULT NULL,
  `cpostal` varchar(16) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL,
  PRIMARY KEY (`info_id`),
  KEY `por_contacto` (`cuenta_id`,`contacto_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*Data for the table `contactos_info` */

insert  into `contactos_info`(`cuenta_id`,`contacto_id`,`info_id`,`tipo`,`valor`,`valor_text`,`modo`,`servicio`,`ciudad`,`estado`,`pais`,`cpostal`,`fecha_creacion`,`fecha_actualizacion`) values ('cu4f43d8bc2ba97','ct4f4e5f7c38525','if4f4e5f7c38771',10,NULL,'Empresa de Software',0,0,NULL,NULL,NULL,NULL,'2012-02-29 11:25:16','2012-02-29 11:25:16'),('cu4f43d8bc2ba97','ct4f4e5f7c38525','if4f4e5f7c38ac0',11,NULL,'Desarrollo de sitios web y aplicaciones',0,0,NULL,NULL,NULL,NULL,'2012-02-29 11:25:16','2012-02-29 11:25:16'),('cu4f43d8bc2ba97','ct4f4e5f7c38525','if4f4e5f7c38c1d',23,'1',NULL,0,0,NULL,NULL,NULL,NULL,'2012-02-29 11:25:16','2012-02-29 11:25:16'),('cu4f43d8bc2ba97','ct4f4e5f7c38525','if4f4e5f7c38d5c',21,'2',NULL,0,0,NULL,NULL,NULL,NULL,'2012-02-29 11:25:16','2012-02-29 11:25:16'),('cu4f43d8bc2ba97','ct4f4e5f7c38525','if4f4e5f7c38e88',22,'2',NULL,0,0,NULL,NULL,NULL,NULL,'2012-02-29 11:25:16','2012-02-29 11:25:16'),('cu4f43d8bc2ba97','ct4f4e5f7c38525','if4f4e5f7c38fb5',13,'2',NULL,0,0,NULL,NULL,NULL,NULL,'2012-02-29 11:25:16','2012-02-29 11:25:16'),('cu4f43d8bc2ba97','ct4f4e5f7c38525','if4f4e5f7c39235',6,NULL,'Km 15.5 Carretera sur, Quinta Marianita',1,0,'MÃ©xico','505',NULL,NULL,'2012-02-29 11:25:16','2012-02-29 11:25:16'),('cu4f43d8bc2ba97','ct4f4e5f7c38525','if4f4e5f7c39397',20,'Gabriela Sabrina Jara',NULL,0,0,NULL,NULL,NULL,NULL,'2012-02-29 11:25:16','2012-02-29 11:25:16'),('cu4f43d8bc2ba97','ct4f4e5f7c38525','if4f4e5f7c394c6',1,'22657879',NULL,1,0,NULL,NULL,NULL,NULL,'2012-02-29 11:25:16','2012-02-29 11:25:16'),('cu4f43d8bc2ba97','ct4f4e5f7c38525','if4f4e5f7c395eb',9,'88733432',NULL,0,1,NULL,NULL,NULL,NULL,'2012-02-29 11:25:16','2012-02-29 11:25:16'),('cu4f43d8bc2ba97','ct4f4e5f7c38525','if4f4e5f7c3970d',2,'federico_michell@gmail.com',NULL,1,0,NULL,NULL,NULL,NULL,'2012-02-29 11:25:16','2012-02-29 11:25:16'),('cu4f43d8bc2ba97','ct4f4e5f7c38525','if4f4e5f7c3982b',4,'www.federicomichell.com',NULL,1,0,NULL,NULL,NULL,NULL,'2012-02-29 11:25:16','2012-02-29 11:25:16'),('cu4f43d8bc2ba97','ct4f4e5f7c38525','if4f4e5f7c39947',12,'1 de enero de 2000',NULL,0,0,NULL,NULL,NULL,NULL,'2012-02-29 11:25:16','2012-02-29 11:25:16'),('cu4f43d8bc2ba97','ct4f4e5f7c38525','if4f4e5f7c39a61',18,'50000',NULL,0,0,NULL,NULL,NULL,NULL,'2012-02-29 11:25:16','2012-02-29 11:25:16'),('cu4f43d8bc2ba97','ct4f4e5f7c38525','if4f4e5f7c39b81',19,NULL,'[\"101\",\"102\",\"103\"]',0,0,NULL,NULL,NULL,NULL,'2012-02-29 11:25:16','2012-02-29 11:25:16'),('cu4f43d8bc2ba97','ct4f4e5f7c38525','if4f4e5f7c39ca2',14,'1','{\"1\":\"China\"}',0,0,NULL,NULL,NULL,NULL,'2012-02-29 11:25:16','2012-02-29 11:25:16'),('cu4f43d8bc2ba97','ct4f4e5f7c38525','if4f4e5f7c39dcd',16,'1','{\"1\":\"ISO 9000\"}',0,0,NULL,NULL,NULL,NULL,'2012-02-29 11:25:16','2012-02-29 11:25:16'),('cu4f43d8bc2ba97','ct4f4e5f7c39efa','if4f4e5f7c3a03e',2,'info@nestorpicado.com',NULL,1,0,NULL,NULL,NULL,NULL,'2012-02-29 11:25:16','2012-02-29 11:25:16'),('cu4f43d8bc2ba97','ct4f4e5f7c39efa','if4f4e5f7c3a177',1,'22557410',NULL,1,0,NULL,NULL,NULL,NULL,'2012-02-29 11:25:16','2012-02-29 11:25:16'),('cu4f43d8bc2ba97','ct4f4e5f7c38525','if4f4e5f7c3a2e8',8,NULL,'{\"1\":\"Iliux SA de CV\"}',0,0,NULL,NULL,NULL,NULL,'2012-02-29 11:25:16','2012-02-29 11:25:16'),('cu4f43d8bc2ba97','ct4f4ff617abdbb','if4f4ff617b507a',10,NULL,'Giro de la empresa',0,0,NULL,NULL,NULL,NULL,'2012-03-01 16:20:07','2012-03-01 16:20:07'),('cu4f43d8bc2ba97','ct4f4ff617abdbb','if4f4ff617b54a7',11,NULL,'Productos y/o servicios',0,0,NULL,NULL,NULL,NULL,'2012-03-01 16:20:07','2012-03-01 16:20:07'),('cu4f43d8bc2ba97','ct4f4ff617abdbb','if4f4ff617b5612',23,'1',NULL,0,0,NULL,NULL,NULL,NULL,'2012-03-01 16:20:07','2012-03-01 16:20:07'),('cu4f43d8bc2ba97','ct4f4ff617abdbb','if4f4ff617b5778',21,'2',NULL,0,0,NULL,NULL,NULL,NULL,'2012-03-01 16:20:07','2012-03-01 16:20:07'),('cu4f43d8bc2ba97','ct4f4ff617abdbb','if4f4ff617b5904',22,'2',NULL,0,0,NULL,NULL,NULL,NULL,'2012-03-01 16:20:07','2012-03-01 16:20:07'),('cu4f43d8bc2ba97','ct4f4ff617abdbb','if4f4ff617b5a6a',13,'2',NULL,0,0,NULL,NULL,NULL,NULL,'2012-03-01 16:20:07','2012-03-01 16:20:07'),('cu4f43d8bc2ba97','ct4f4ff617abdbb','if4f4ff617b5da0',6,NULL,'Direccion',0,0,'Monterrey','NL','MÃ©xico','505','2012-03-01 16:20:07','2012-03-01 16:20:07'),('cu4f43d8bc2ba97','ct4f4ff617abdbb','if4f4ff617b5f45',20,'Farah Prado Cantillo',NULL,0,0,NULL,NULL,NULL,NULL,'2012-03-01 16:20:07','2012-03-01 16:20:07'),('cu4f43d8bc2ba97','ct4f4ff617abdbb','if4f4ff617b60ab',1,'22657879',NULL,1,0,NULL,NULL,NULL,NULL,'2012-03-01 16:20:07','2012-03-01 16:20:07'),('cu4f43d8bc2ba97','ct4f4ff617abdbb','if4f4ff617b61f9',9,'88733432',NULL,0,1,NULL,NULL,NULL,NULL,'2012-03-01 16:20:07','2012-03-01 16:20:07'),('cu4f43d8bc2ba97','ct4f4ff617abdbb','if4f4ff617b6336',2,'federico_michell@gmail.com',NULL,1,0,NULL,NULL,NULL,NULL,'2012-03-01 16:20:07','2012-03-01 16:20:07'),('cu4f43d8bc2ba97','ct4f4ff617abdbb','if4f4ff617b6451',4,'www.federicomichell.com',NULL,1,0,NULL,NULL,NULL,NULL,'2012-03-01 16:20:07','2012-03-01 16:20:07'),('cu4f43d8bc2ba97','ct4f4ff617abdbb','if4f4ff617b6565',12,'1 de enero 2005',NULL,0,0,NULL,NULL,NULL,NULL,'2012-03-01 16:20:07','2012-03-01 16:20:07'),('cu4f43d8bc2ba97','ct4f4ff617abdbb','if4f4ff617b6676',18,'50,000 dÃ³lares',NULL,0,0,NULL,NULL,NULL,NULL,'2012-03-01 16:20:07','2012-03-01 16:20:07'),('cu4f43d8bc2ba97','ct4f4ff617abdbb','if4f4ff617b678c',19,NULL,'[\"101\",\"102\",\"103\"]',0,0,NULL,NULL,NULL,NULL,'2012-03-01 16:20:07','2012-03-01 16:20:07'),('cu4f43d8bc2ba97','ct4f4ff617abdbb','if4f4ff617b68c4',14,'1','{\"1\":\"China\",\"2\":\"Dinamarca\",\"3\":\"Cuba\"}',0,0,NULL,NULL,NULL,NULL,'2012-03-01 16:20:07','2012-03-01 16:20:07'),('cu4f43d8bc2ba97','ct4f4ff617abdbb','if4f4ff617b69d8',16,'1','{\"1\":\"ISO 9000\",\"2\":\"ISO 9001\"}',0,0,NULL,NULL,NULL,NULL,'2012-03-01 16:20:07','2012-03-01 16:20:07'),('cu4f43d8bc2ba97','ct4f4ff617b6aef','if4f4ff617b6c00',2,'Correo',NULL,1,0,NULL,NULL,NULL,NULL,'2012-03-01 16:20:07','2012-03-01 16:20:07'),('cu4f43d8bc2ba97','ct4f4ff617b6aef','if4f4ff617b6d08',1,'TelÃ©fono',NULL,1,0,NULL,NULL,NULL,NULL,'2012-03-01 16:20:07','2012-03-01 16:20:07'),('cu4f43d8bc2ba97','ct4f4ff617b6e22','if4f4ff617b6f45',2,'correo 1',NULL,1,0,NULL,NULL,NULL,NULL,'2012-03-01 16:20:07','2012-03-01 16:20:07'),('cu4f43d8bc2ba97','ct4f4ff617b6e22','if4f4ff617b707d',1,'telefono 1',NULL,1,0,NULL,NULL,NULL,NULL,'2012-03-01 16:20:07','2012-03-01 16:20:07'),('cu4f43d8bc2ba97','ct4f4ff617b7195','if4f4ff617b72e0',2,'correo 2',NULL,1,0,NULL,NULL,NULL,NULL,'2012-03-01 16:20:07','2012-03-01 16:20:07'),('cu4f43d8bc2ba97','ct4f4ff617b7195','if4f4ff617b7419',1,'telefono 2',NULL,1,0,NULL,NULL,NULL,NULL,'2012-03-01 16:20:07','2012-03-01 16:20:07'),('cu4f43d8bc2ba97','ct4f4ff617abdbb','if4f4ff617b751c',8,NULL,'{\"1\":\"Microsoft\",\"2\":\"Google\",\"3\":\"Facebook\"}',0,0,NULL,NULL,NULL,NULL,'2012-03-01 16:20:07','2012-03-01 16:20:07'),('cu4f43d8bc2ba97','ct4fdfb0114c07d','if4fdfb0114c277',10,NULL,'Giro de la empresa',0,0,NULL,NULL,NULL,NULL,'2012-06-18 17:47:45','2012-06-18 17:47:45'),('cu4f43d8bc2ba97','ct4fdfb0114c07d','if4fdfb0114c43b',11,NULL,'Productos y o servicios',0,0,NULL,NULL,NULL,NULL,'2012-06-18 17:47:45','2012-06-18 17:47:45'),('cu4f43d8bc2ba97','ct4fdfb0114c07d','if4fdfb0114c59e',23,'2',NULL,0,0,NULL,NULL,NULL,NULL,'2012-06-18 17:47:45','2012-06-18 17:47:45'),('cu4f43d8bc2ba97','ct4fdfb0114c07d','if4fdfb0114c6d9',21,'2',NULL,0,0,NULL,NULL,NULL,NULL,'2012-06-18 17:47:45','2012-06-18 17:47:45'),('cu4f43d8bc2ba97','ct4fdfb0114c07d','if4fdfb0114c80d',22,'2',NULL,0,0,NULL,NULL,NULL,NULL,'2012-06-18 17:47:45','2012-06-18 17:47:45'),('cu4f43d8bc2ba97','ct4fdfb0114c07d','if4fdfb0114c943',13,'3',NULL,0,0,NULL,NULL,NULL,NULL,'2012-06-18 17:47:45','2012-06-18 17:47:45'),('cu4f43d8bc2ba97','ct4fdfb0114c07d','if4fdfb0114cbb2',6,NULL,'DirecciÃ³n',1,0,'Ciud','Est','MÃ©xico','Codigo','2012-06-18 17:47:45','2012-06-18 17:47:45'),('cu4f43d8bc2ba97','ct4fdfb0114c07d','if4fdfb0114cd23',20,'Nombre del contacto',NULL,0,0,NULL,NULL,NULL,NULL,'2012-06-18 17:47:45','2012-06-18 17:47:45'),('cu4f43d8bc2ba97','ct4fdfb0114c07d','if4fdfb0114ce62',1,'22657879',NULL,1,0,NULL,NULL,NULL,NULL,'2012-06-18 17:47:45','2012-06-18 17:47:45'),('cu4f43d8bc2ba97','ct4fdfb0114c07d','if4fdfb0114cfac',9,'88733432',NULL,0,1,NULL,NULL,NULL,NULL,'2012-06-18 17:47:45','2012-06-18 17:47:45'),('cu4f43d8bc2ba97','ct4fdfb0114c07d','if4fdfb0114d0ea',2,'federico_michell@fmv.com',NULL,1,0,NULL,NULL,NULL,NULL,'2012-06-18 17:47:45','2012-06-18 17:47:45'),('cu4f43d8bc2ba97','ct4fdfb0114c07d','if4fdfb0114d1fe',4,'www.sitio.com',NULL,1,0,NULL,NULL,NULL,NULL,'2012-06-18 17:47:45','2012-06-18 17:47:45'),('cu4f43d8bc2ba97','ct4fdfb0114c07d','if4fdfb0114d311',12,'25 de marzo',NULL,0,0,NULL,NULL,NULL,NULL,'2012-06-18 17:47:45','2012-06-18 17:47:45'),('cu4f43d8bc2ba97','ct4fdfb0114c07d','if4fdfb0114d42b',18,'50000',NULL,0,0,NULL,NULL,NULL,NULL,'2012-06-18 17:47:45','2012-06-18 17:47:45'),('cu4f43d8bc2ba97','ct4fdfb0114c07d','if4fdfb0114d556',19,NULL,'[\"101\",\"102\",\"206\"]',0,0,NULL,NULL,NULL,NULL,'2012-06-18 17:47:45','2012-06-18 17:47:45'),('cu4f43d8bc2ba97','ct4fdfb0114c07d','if4fdfb0114d674',14,'1','{\"1\":\"China\",\"2\":\"Japon\"}',0,0,NULL,NULL,NULL,NULL,'2012-06-18 17:47:45','2012-06-18 17:47:45'),('cu4f43d8bc2ba97','ct4fdfb0114c07d','if4fdfb0114d791',16,'1','{\"1\":\"ISO 1\",\"2\":\"ISO 2\"}',0,0,NULL,NULL,NULL,NULL,'2012-06-18 17:47:45','2012-06-18 17:47:45'),('cu4f43d8bc2ba97','ct4fdfb0114d8e2','if4fdfb0114da22',2,'Correo',NULL,1,0,NULL,NULL,NULL,NULL,'2012-06-18 17:47:45','2012-06-18 17:47:45'),('cu4f43d8bc2ba97','ct4fdfb0114d8e2','if4fdfb0114db59',1,'TelÃ©fono',NULL,1,0,NULL,NULL,NULL,NULL,'2012-06-18 17:47:45','2012-06-18 17:47:45'),('cu4f43d8bc2ba97','ct4fdfb0114dc87','if4fdfb0114ddb5',2,'Corre E1',NULL,1,0,NULL,NULL,NULL,NULL,'2012-06-18 17:47:45','2012-06-18 17:47:45'),('cu4f43d8bc2ba97','ct4fdfb0114dc87','if4fdfb0114deb2',1,'Telefono E1',NULL,1,0,NULL,NULL,NULL,NULL,'2012-06-18 17:47:45','2012-06-18 17:47:45'),('cu4f43d8bc2ba97','ct4fdfb0114dfaa','if4fdfb0114e0a4',2,'Correo E2',NULL,1,0,NULL,NULL,NULL,NULL,'2012-06-18 17:47:45','2012-06-18 17:47:45'),('cu4f43d8bc2ba97','ct4fdfb0114dfaa','if4fdfb0114e1c6',1,'Telefono E2',NULL,1,0,NULL,NULL,NULL,NULL,'2012-06-18 17:47:45','2012-06-18 17:47:45'),('cu4f43d8bc2ba97','ct4fdfb0114c07d','if4fdfb0114e2e0',8,NULL,'{\"1\":\"Cliente 1\",\"2\":\"Cliente 2\"}',0,0,NULL,NULL,NULL,NULL,'2012-06-18 17:47:45','2012-06-18 17:47:45'),('cu4f43d8bc2ba97','ct4fdfbcfa09609','if4fdfbcfa0970b',2,'Correo',NULL,1,0,NULL,NULL,NULL,NULL,'2012-06-18 18:42:50','2012-06-18 18:42:50'),('cu4f43d8bc2ba97','ct4fdfbcfa09609','if4fdfbcfa09801',1,'TelÃ©fono',NULL,1,0,NULL,NULL,NULL,NULL,'2012-06-18 18:42:50','2012-06-18 18:42:50'),('cu4f43d8bc2ba97','ct4fdfbcfa0991b','if4fdfbcfa09a56',2,'Correo',NULL,1,0,NULL,NULL,NULL,NULL,'2012-06-18 18:42:50','2012-06-18 18:42:50'),('cu4f43d8bc2ba97','ct4fdfbcfa0991b','if4fdfbcfa09b4f',1,'TelÃ©fono',NULL,1,0,NULL,NULL,NULL,NULL,'2012-06-18 18:42:50','2012-06-18 18:42:50');

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

insert  into `contactos_info_catalogo`(`tipo_id`,`nombre`,`etiqueta`,`valores`,`valores_modo`,`valores_servicio`,`elemento`,`opciones`,`visible`,`fecha_creacion`,`fecha_modificacion`) values (1,'telefono','TelÃ©fono',NULL,'{\"1\":\"Trabajo\",\"2\":\"Casa\",\"3\":\"Fax\",\"4\":\"Otro\"}',NULL,'text','{\"css\":\"tam30\",\"obligado\":\"no\"}',1,'2012-01-25 17:55:00','2012-01-25 17:55:00'),(2,'email','Correo ElectrÃ³nico',NULL,'{\"1\":\"Trabajo\",\"2\":\"Personal\",\"3\":\"Otro\"}',NULL,'text','{\"css\":\"tam70\",\"obligado\":\"no\"}',1,'2012-01-25 17:55:00','2012-01-25 17:55:00'),(3,'mensajeria','Mensajeria',NULL,'{\"1\":\"Trabajo\",\"2\":\"Personal\",\"3\":\"Otro\"}','{\"1\":\"AIM\",\"2\":\"MSN\",\"3\":\"ICQ\",\"4\":\"Jabber\",\"5\":\"Yahoo\",\"6\":\"Skype\",\"7\":\"QQ\",\"8\":\"Sametime\",\"9\":\"Gadu-Gadu\",\"10\":\"GoogleTalk\",\"11\":\"Otro\"}','text','{\"css\":\"tam30\",\"obligado\":\"no\"}',1,'2012-01-25 17:55:00','2012-01-25 17:55:00'),(4,'web','Sitio web',NULL,'{\"1\":\"Trabajo\",\"2\":\"Personal\",\"3\":\"Otro\"}',NULL,'text','{\"css\":\"tam70\",\"obligado\":\"no\"}',1,'2012-01-25 17:55:00','2012-01-25 17:55:00'),(5,'twitter','Twitter',NULL,'{\"1\":\"Personal\",\"2\":\"Negocio\",\"3\":\"Otro\"}',NULL,'text','{\"css\":\"tam30\",\"obligado\":\"no\"}',1,'2012-01-25 17:55:00','2012-01-25 17:55:00'),(6,'direccion','DirecciÃ³n',NULL,'{\"1\":\"Trabajo\",\"2\":\"Casa\",\"3\":\"Otro\"}',NULL,'direccion','{\"css\":\"tam30\",\"obligado\":\"no\"}',1,'2012-01-25 17:55:00','2012-01-25 17:55:00'),(7,'facebook','Facebook',NULL,'{\"1\":\"Personal\",\"2\":\"Negocio\",\"3\":\"Otro\"}',NULL,'text','{\"css\":\"tam30\",\"obligado\":\"no\"}',1,'2012-01-25 17:55:00','2012-01-25 17:55:00'),(8,'principales_clientes','Principales clientes',NULL,NULL,NULL,'dinamico2','{\"css\":\"tam70\",\"obligado\":\"no\"}',1,'2012-01-25 17:55:00','2012-01-25 17:55:00'),(9,'celular','Celular',NULL,NULL,'{\"1\":\"Telcel\",\"2\":\"Movistar\",\"3\":\"Unefon\",\"4\":\"IUSACELL\",\"5\":\"Nextel\"}','text','{\"css\":\"tam30\",\"obligado\":\"no\"}',1,'2012-01-25 17:55:00','2012-01-25 17:55:00'),(10,'giro_empresa','Giro de la empresa',NULL,NULL,NULL,'textarea','{\"css\":\"tam70\",\"obligado\":\"si\"}',1,'2012-01-25 17:55:00','2012-01-25 17:55:00'),(11,'productos_servicios','Productos y/o Servicios',NULL,NULL,NULL,'textarea','{\"css\":\"tam70\",\"obligado\":\"no\"}',1,'2012-01-25 17:55:00','2012-01-25 17:55:00'),(12,'fecha_fundacion','Fecha de fundaciÃ³n',NULL,NULL,NULL,'text','{\"css\":\"tam30\",\"obligado\":\"no\"}',1,'2012-01-25 17:55:00','2012-01-25 17:55:00'),(13,'tamano_empresa','TamaÃ±o de la empresa','{\"1\":\"Micro (1-10)\",\"2\":\"Pequena (11-50)\",\"3\":\"Mediana (51-250)\",\"4\":\"Grande (250+)\"}',NULL,NULL,'select','{\"css\":\"tam30\",\"obligado\":\"no\"}',1,'2012-01-25 17:55:00','2012-01-25 17:55:00'),(14,'exporta','Exporta','{\"2\":\"No\",\"1\":\"Si\"}',NULL,NULL,'dinamico1','{\"css\":\"tam30 dinamico1selector\",\"obligado\":\"no\",\"helper\":\"Donde?\"}',1,'2012-01-25 17:55:00','2012-01-25 17:55:00'),(16,'certificaciones','Certificaciones','{\"2\":\"No\",\"1\":\"Si\"}',NULL,NULL,'dinamico1','{\"css\":\"tam30 dinamico1selector\",\"obligado\":\"no\",\"helper\":\"Cuales?\"}',1,'2012-01-25 17:55:00','2012-01-25 17:55:00'),(18,'ventas_anuales','Ventas anuales',NULL,NULL,NULL,'text','{\"css\":\"tam30\",\"obligado\":\"no\"}',1,'2012-01-25 17:55:00','2012-01-25 17:55:00'),(19,'categorias','Categorias',NULL,NULL,NULL,'categorias','{\"css\":\"tam30\",\"obligado\":\"no\"}',1,'2012-01-25 17:55:00','2012-01-25 17:55:00'),(20,'contacto','Nombre del contacto',NULL,NULL,NULL,'text','{\"css\":\"tam70\",\"obligado\":\"no\"}',1,'2012-01-25 17:55:00','2012-01-25 17:55:00'),(21,'sector_productivo','Sector productivo','{\"1\":\"AERONAUTICA\",\"2\":\"CONSTRUCCION\",\"3\":\"QUIMICO\",\"4\":\"AGRICULTURA\",\"5\":\"COMERCIO\",\"6\":\"SOFTWARE\",\"7\":\"AUTOMOTRIZ\",\"8\":\"ELECTRONICA\",\"9\":\"TEXTIL-CONFECCION\",\"10\":\"CUERO-CALZADO\",\"11\":\"MAQUILADORAS\",\"12\":\"TURISMO\",\"13\":\"OTRO\"}',NULL,NULL,'select','{\"css\":\"tam30\",\"obligado\":\"no\"}',1,'2012-01-25 17:55:00','2012-01-25 17:55:00'),(22,'sector','Sector','{\"1\":\"INDUSTRIA\",\"2\":\"COMERCIO\",\"3\":\"SERVICIOS\"}',NULL,NULL,'select','{\"css\":\"tam30\",\"obligado\":\"no\"}',1,'2012-01-25 17:55:00','2012-01-25 17:55:00'),(23,'sexo_propietario','Indique si el propietario es hombre o mujer','{\"1\":\"Hombre\",\"2\":\"Mujer\"}',NULL,NULL,'select','{\"css\":\"tam30\",\"obligado\":\"no\"}',1,'2012-01-25 17:55:00','2012-01-25 17:55:00'),(24,'como_se_entero','CÃ³mo se entero',NULL,NULL,NULL,'text','{\"css\":\"tam30\",\"obligado\":\"no\"}',1,'2012-01-25 17:55:00','2012-01-25 17:55:00'),(25,'representante_legal','Representante legal',NULL,NULL,NULL,'representante_le','{\"css\":\"tam70\",\"obligado\":\"no\"}',1,'2012-02-23 13:26:00','2012-02-23 13:26:00'),(27,'ejecutivos_claves','Ejecutivos claves',NULL,NULL,NULL,'ejecutivos_clave','{\"css\":\"tam70\",\"obligado\":\"no\"}',1,'2012-02-23 13:31:00','2012-02-23 13:31:00');

/*Table structure for table `cuentas` */

DROP TABLE IF EXISTS `cuentas`;

CREATE TABLE `cuentas` (
  `cuenta_id` char(15) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `subdominio` varchar(20) NOT NULL,
  `color` varchar(10) DEFAULT 'azul',
  `estado` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1 es activo, 2 es suspendido, 3 es vencido',
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_vence` datetime NOT NULL,
  PRIMARY KEY (`cuenta_id`),
  UNIQUE KEY `subdominio` (`subdominio`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*Data for the table `cuentas` */

insert  into `cuentas`(`cuenta_id`,`nombre`,`subdominio`,`color`,`estado`,`fecha_creacion`,`fecha_actualizacion`,`fecha_inicio`,`fecha_vence`) values ('cu4f43d8bc2ba97','CAINTRA','caintra','azul',1,'2012-02-21 11:48:00','2012-02-21 11:48:00','2012-02-21 11:48:00','2020-02-21 11:48:00');

/*Table structure for table `eventos` */

DROP TABLE IF EXISTS `eventos`;

CREATE TABLE `eventos` (
  `cuenta_id` char(15) DEFAULT NULL,
  `evento_id` char(15) NOT NULL,
  `nombre` varchar(128) DEFAULT NULL,
  `nombre_corto` varchar(128) DEFAULT NULL,
  `tipo_cita` tinyint(1) DEFAULT NULL COMMENT '1 = citas sin horario; 2 = 2 citas por hora; 3 = 3 citas por hora',
  `status` tinyint(1) DEFAULT '1' COMMENT '1 activo; 2 inactivo',
  `estado` varchar(100) DEFAULT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `descripcion` text,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_fin` datetime DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  PRIMARY KEY (`evento_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `eventos` */

insert  into `eventos`(`cuenta_id`,`evento_id`,`nombre`,`nombre_corto`,`tipo_cita`,`status`,`estado`,`ciudad`,`descripcion`,`fecha_inicio`,`fecha_fin`,`fecha_creacion`,`fecha_modificacion`) values ('cu4f43d8bc2ba97','ev4f44135abbc9d','Evento de prueba','EdP',2,2,'Nuevo Leon','Monterrey','Esta es una prueba','2012-02-22 09:00:00','2012-02-26 16:30:00','2012-02-21 15:57:46','2012-02-21 15:57:46'),('cu4f43d8bc2ba97','ev4f4413af40f83','Evento de prueba','EdP',2,2,'Nuevo Leon','Monterrey','Esta es una prueba','2012-02-22 09:00:00','2012-02-26 16:30:00','2012-02-21 15:59:11','2012-02-21 15:59:11'),('cu4f43d8bc2ba97','ev4f44141584e4b','Evento de prueba editado','EdPE',3,1,'Nuevo Leon','Monterrey','Esta es una prueba editada','2012-02-23 02:00:00','2012-02-29 23:00:00','2012-02-21 16:00:53','2012-02-21 18:44:23'),('cu4f43d8bc2ba97','ev4f44141a07a92','Evento de prueba','EdP',2,1,'Nuevo Leon','Monterrey','Esta es una prueba','2012-02-22 09:00:00','2012-02-26 16:30:00','2012-02-21 16:00:58','2012-06-18 17:37:44'),('cu4f43d8bc2ba97','ev4f441443c6b5f','Evento de prueba','EdP',2,1,'Nuevo Leon','Monterrey','Esta es una prueba','2012-02-22 09:00:00','2012-02-26 16:30:00','2012-02-21 16:01:39','2012-02-21 16:01:39'),('cu4f43d8bc2ba97','ev4f44148c8a83e','Evento de prueba','EdP',2,1,'Nuevo Leon','Monterrey','Esta es una prueba','2012-02-22 09:00:00','2012-02-26 16:30:00','2012-02-21 16:02:52','2012-02-21 16:02:52');

/*Table structure for table `perfil_evento` */

DROP TABLE IF EXISTS `perfil_evento`;

CREATE TABLE `perfil_evento` (
  `cuenta_id` char(15) NOT NULL,
  `evento_id` char(15) DEFAULT NULL,
  `contacto_id` char(15) DEFAULT NULL,
  `perfil` tinyint(4) DEFAULT NULL COMMENT '1 Comprador; 2 Proveedor',
  `fecha_creacion` datetime DEFAULT NULL,
  PRIMARY KEY (`cuenta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `perfil_evento` */

/*Table structure for table `recuperar_contrasena` */

DROP TABLE IF EXISTS `recuperar_contrasena`;

CREATE TABLE `recuperar_contrasena` (
  `solicitud_id` char(15) NOT NULL,
  `contacto_id` char(15) DEFAULT NULL,
  `disponible_hasta` datetime DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  PRIMARY KEY (`solicitud_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `recuperar_contrasena` */

/*Table structure for table `requerimientos` */

DROP TABLE IF EXISTS `requerimientos`;

CREATE TABLE `requerimientos` (
  `cuenta_id` char(15) DEFAULT NULL,
  `evento_id` char(15) DEFAULT NULL,
  `requerimiento_id` char(15) NOT NULL,
  `contacto_id` char(15) DEFAULT NULL COMMENT 'Empresa compradora',
  `contacto_comprador_id` char(15) DEFAULT NULL COMMENT 'Persona compradora',
  `titulo` text,
  `descripcion` text,
  `requisitos_deseados` text,
  `requisitos_indispensables` text,
  `fecha_esperada` datetime DEFAULT NULL,
  `lugar` varchar(64) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1 activo 2 en trámite 3 suspendido 4 eliminado',
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  PRIMARY KEY (`requerimiento_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `requerimientos` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
