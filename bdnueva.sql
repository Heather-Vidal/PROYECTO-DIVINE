 -- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-09-2026 a las 18:08:18
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `divine`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `PRODUCTO_codigo` int(11) NOT NULL,
  `PEDIDOS_ID` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `costototal` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`PRODUCTO_codigo`, `PEDIDOS_ID`, `cantidad`, `costototal`) VALUES
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `CI` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `direccion` varchar(45) DEFAULT NULL,
  `celular` int(11) DEFAULT NULL,
  `rol` varchar(45) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`CI`, `nombre`, `direccion`, `celular`, `rol`, `estado`) VALUES
(707070, 'aileen ', 'america', 7895643, 'administrador', 'ACTIVO'),
(1234567, 'lore', 'america', 78945612, 'administrador', 'ACTIVO'),
(9494473, 'paola', 'circunvalación ', 78945612, 'administrador', 'ACTIVO'),
(13748717, 'lesly', 'america', 78945611, 'administrador', 'ACTIVO'),
(14444790, 'heather', 'circunvalacion', 7894561, 'administrador', 'ACTIVO'),
(987654321, 'maria', 'av bejin', 78945612, 'vendedor', 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `ID` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `nombrevendedor` varchar(45) DEFAULT NULL,
  `telefono` int(11) DEFAULT NULL,
  `direccion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`ID`, `nombre`, `fecha`, `estado`, `nombrevendedor`, `telefono`, `direccion`) VALUES
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `precio` int(11) DEFAULT NULL,
  `costo` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `categoria` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`codigo`, `nombre`, `descripcion`, `precio`, `costo`, `stock`, `categoria`) VALUES
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `metodo` varchar(45) DEFAULT NULL,
  `costototal` double DEFAULT NULL,
  `PEDIDOS_ID` int(11) NOT NULL,
  `fecha` DATE NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `estado`, `metodo`, `costototal`, `PEDIDOS_ID`, `fecha`) VALUES
(1, 'En proceso', 'Efectivo', 264, 7, NULL),
(2, 'En proceso', 'QR', 156, 8, NULL),
(3, 'En proceso', 'Tarjeta', 156, 8, NULL);

-- --------------------------------------------------------

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
ADD PRIMARY KEY (`PRODUCTO_codigo`, `PEDIDOS_ID`),
ADD KEY `fk_PRODUCTO_has_PEDIDOS_PEDIDOS1_idx` (`PEDIDOS_ID`),
ADD KEY `fk_PRODUCTO_has_PEDIDOS_PRODUCTO_idx` (`PRODUCTO_codigo`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
ADD PRIMARY KEY (`CI`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
ADD PRIMARY KEY (`id`),
ADD KEY `fk_VENTAS_PEDIDOS1_idx` (`PEDIDOS_ID`);

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
ADD CONSTRAINT `fk_PRODUCTO_has_PEDIDOS_PEDIDOS1`
FOREIGN KEY (`PEDIDOS_ID`) REFERENCES `pedidos` (`ID`)
ON DELETE NO ACTION ON UPDATE NO ACTION,

ADD CONSTRAINT `fk_PRODUCTO_has_PEDIDOS_PRODUCTO`
FOREIGN KEY (`PRODUCTO_codigo`) REFERENCES `producto` (`codigo`)
ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
ADD CONSTRAINT `fk_VENTAS_PEDIDOS1`
FOREIGN KEY (`PEDIDOS_ID`) REFERENCES `pedidos` (`ID`)
ON DELETE NO ACTION ON UPDATE NO ACTION;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;