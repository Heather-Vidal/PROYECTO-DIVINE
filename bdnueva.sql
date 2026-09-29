-- ============================================================
-- BASE DE DATOS DIVINE
-- ============================================================

CREATE DATABASE IF NOT EXISTS `divine`
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE `divine`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET FOREIGN_KEY_CHECKS = 0;
START TRANSACTION;

-- ============================================================
-- ELIMINAR TABLAS SI YA EXISTEN
-- ============================================================

DROP TABLE IF EXISTS `ventas`;
DROP TABLE IF EXISTS `carrito`;
DROP TABLE IF EXISTS `pedidos`;
DROP TABLE IF EXISTS `producto`;
DROP TABLE IF EXISTS `cliente`;

-- ============================================================
-- TABLA CLIENTE
-- ============================================================

CREATE TABLE `cliente` (
  `CI` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `direccion` varchar(45) DEFAULT NULL,
  `celular` int(11) DEFAULT NULL,
  `rol` varchar(45) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`CI`)
) ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_general_ci;

-- ============================================================
-- DATOS CLIENTE
-- ============================================================

INSERT INTO `cliente`
(`CI`, `nombre`, `direccion`, `celular`, `rol`, `estado`)
VALUES
(707070, 'aileen ', 'america', 7895643, 'administrador', 'ACTIVO'),
(1234567, 'lore', 'america', 78945612, 'administrador', 'ACTIVO'),
(9494473, 'paola', 'circunvalación ', 78945612, 'administrador', 'ACTIVO'),
(13748717, 'lesly', 'america', 78945611, 'administrador', 'ACTIVO'),
(14444790, 'heather', 'circunvalacion', 7894561, 'administrador', 'ACTIVO'),
(987654321, 'maria', 'av bejin', 78945612, 'vendedor', 'ACTIVO');

-- ============================================================
-- TABLA PRODUCTO
-- ============================================================

CREATE TABLE `producto` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `precio` int(11) DEFAULT NULL,
  `costo` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `categoria` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_general_ci;

-- ============================================================
-- DATOS PRODUCTO
-- ============================================================

INSERT INTO `producto`
(`codigo`, `nombre`, `descripcion`, `precio`, `costo`, `stock`, `categoria`)
VALUES
(21, 'Aceite de semilla de uva', 'Aceite ligero nutritivo ', 56, 45, 33, 'SkinHair'),
(25, 'Aceite de almendras ', 'Nutre, suaviza y protege la piel naturalmente', 100, 80, 78, 'SkinHair'),
(32, 'Esencia de Coco', 'Aroma dulce y tropical que evoca el coco', 78, 70, 96, 'SkinHair'),
(34, 'Aceite de palta ', 'Nutre, hidrata y suaviza la piel profundament', 90, 69, 150, 'SkinHair'),
(53, 'Aceite Multivitamínico Capilar', 'Nutre, fortalece y revitaliza el cabello', 80, 70, 55, 'SkinHair'),
(83, 'manteca de cacao', 'Hidrata, nutre y suaviza la piel naturalmente', 75, 60, 80, 'SkinCare'),
(87, 'crema de pepino', 'Hidrata y refresca tu piel', 54, 25, 84, 'SkinCare'),
(96, 'aceite de argán ', 'Nutre y da brillo', 56, 45, 61, 'SkinHair'),
(565, 'sabia clara', 'Nutre y suaviza la piel', 67, 55, 89, 'SkinCare'),
(741, 'Miel & Hoja', 'Cuidado natural para tu piel.', 70, 67, 88, 'SkinCare'),
(852, 'agua de rosas ', 'Refresca, tonifica y suaviza la piel.', 70, 56, 89, 'SkinCare'),
(987, 'aceite de jojoba', 'Hidrata y nutre la piel.', 75, 67, 23, 'SkinCare');

-- ============================================================
-- TABLA PEDIDOS
-- ============================================================

CREATE TABLE `pedidos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `nombrevendedor` varchar(45) DEFAULT NULL,
  `telefono` int(11) DEFAULT NULL,
  `direccion` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB
AUTO_INCREMENT=14
DEFAULT CHARSET=utf8
COLLATE=utf8_general_ci;

-- ============================================================
-- DATOS PEDIDOS
-- ============================================================

INSERT INTO `pedidos`
(`ID`, `nombre`, `fecha`, `estado`, `nombrevendedor`, `telefono`, `direccion`)
VALUES
(1, 'diarrea ', '2026-09-05', 'En proceso', 'roberto', 75768766, 'sacaba'),
(2, 'malaga', '2026-09-13', 'Pendiente', 'maria', 74185292, 'sacaba'),
(3, 'malaga', '2026-09-11', 'Pendiente', 'maria', 74185292, 'blanco galindo'),
(4, 'fabricio', '2026-09-26', 'Pendiente', 'DIVINE', 48451881, 'america'),
(5, 'malaga', '2026-09-10', 'Pendiente', 'DIVINE', 88798513, 'sacaba'),
(6, 'malaga', '2026-09-17', 'Pendiente', 'DIVINE', 98458655, 'blanco galindo'),
(7, 'fabricio', '2026-09-12', 'En proceso', 'mario', 65498723, 'aniceto arce'),
(8, 'lukas', '2026-09-19', 'En proceso', 'mario', 78965432, 'sacaba'),
(9, 'jhana', '2026-09-12', 'Pendiente', 'roberto', 894562352, 'circunvalacion'),
(10, 'britany', '2026-09-17', 'Pendiente', 'DIVINE', 74185299, 'america'),
(11, 'jessica', '2026-09-17', 'Pendiente', 'DIVINE', 78845621, 'america'),
(12, 'camila', '2026-09-13', 'Pendiente', 'DIVINE', 675823641, 'circunvalacion'),
(13, 'lesly', '2026-09-10', 'Pendiente', 'DIVINE', 74185292, 'america');

-- ============================================================
-- TABLA CARRITO
-- ============================================================

CREATE TABLE `carrito` (
  `PRODUCTO_codigo` int(11) NOT NULL,
  `PEDIDOS_ID` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `costototal` double DEFAULT NULL,
  PRIMARY KEY (`PRODUCTO_codigo`, `PEDIDOS_ID`),
  KEY `fk_PRODUCTO_has_PEDIDOS_PEDIDOS1_idx` (`PEDIDOS_ID`),
  KEY `fk_PRODUCTO_has_PEDIDOS_PRODUCTO_idx` (`PRODUCTO_codigo`),
  CONSTRAINT `fk_PRODUCTO_has_PEDIDOS_PEDIDOS1`
    FOREIGN KEY (`PEDIDOS_ID`)
    REFERENCES `pedidos` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_PRODUCTO_has_PEDIDOS_PRODUCTO`
    FOREIGN KEY (`PRODUCTO_codigo`)
    REFERENCES `producto` (`codigo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_general_ci;

-- ============================================================
-- DATOS CARRITO
-- ============================================================

INSERT INTO `carrito`
(`PRODUCTO_codigo`, `PEDIDOS_ID`, `cantidad`, `costototal`)
VALUES
(32, 12, 1, 78),
(83, 4, 2, 156),
(83, 6, 4, 312),
(83, 7, 2, 156),
(83, 8, 2, 156),
(83, 11, 1, 75),
(87, 2, 1, 270),
(87, 5, 4, 216),
(87, 7, 2, 108),
(96, 11, 1, 56),
(741, 12, 1, 70),
(852, 12, 1, 70),
(852, 13, 3, 210),
(987, 11, 1, 75);

-- ============================================================
-- TABLA VENTAS
-- ============================================================

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(45) DEFAULT NULL,
  `metodo` varchar(45) DEFAULT NULL,
  `costototal` double DEFAULT NULL,
  `PEDIDOS_ID` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY (`id`),

  KEY `fk_VENTAS_PEDIDOS1_idx` (`PEDIDOS_ID`),

  CONSTRAINT `fk_VENTAS_PEDIDOS1`
    FOREIGN KEY (`PEDIDOS_ID`)
    REFERENCES `pedidos` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION

) ENGINE=InnoDB
AUTO_INCREMENT=4
DEFAULT CHARSET=utf8
COLLATE=utf8_general_ci;

-- ============================================================
-- DATOS VENTAS
-- ============================================================

INSERT INTO `ventas`
(`id`, `estado`, `metodo`, `costototal`, `PEDIDOS_ID`)
VALUES
(1, 'En proceso', 'Efectivo', 264, 7),
(2, 'En proceso', 'QR', 156, 8),
(3, 'En proceso', 'Tarjeta', 156, 8);

-- ============================================================
-- FINALIZAR
-- ============================================================

SET FOREIGN_KEY_CHECKS = 1;

COMMIT;