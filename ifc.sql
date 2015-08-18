-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-06-2014 a las 21:52:58
-- Versión del servidor: 5.6.16
-- Versión de PHP: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `ifc`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cesta`
--

CREATE TABLE IF NOT EXISTS `cesta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `fecha` datetime NOT NULL,
  `total` double NOT NULL,
  `clientes_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cestas_guardadas_clientes1_idx` (`clientes_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario`
--

CREATE TABLE IF NOT EXISTS `comentario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comentario` varchar(255) NOT NULL,
  `votos_positivos` int(11) NOT NULL DEFAULT '0',
  `votos_negativos` int(11) NOT NULL DEFAULT '0',
  `clientes_id` int(11) NOT NULL,
  `productos_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_comentario_clientes1_idx` (`clientes_id`),
  KEY `fk_comentario_productos1_idx` (`productos_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descuento`
--

CREATE TABLE IF NOT EXISTS `descuento` (
  `id` int(11) NOT NULL,
  `descuento` double NOT NULL,
  `fidelidades_id` int(11) NOT NULL,
  `productos_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_descuentos_fidelidades1_idx` (`fidelidades_id`),
  KEY `fk_descuentos_productos1_idx` (`productos_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_cesta`
--

CREATE TABLE IF NOT EXISTS `detalle_cesta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad` int(11) NOT NULL DEFAULT '1',
  `precio` int(11) NOT NULL DEFAULT '0',
  `productos_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_detalle_cestas_guardadas_productos1_idx` (`productos_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `detalle_cesta`
--

INSERT INTO `detalle_cesta` (`id`, `cantidad`, `precio`, `productos_id`) VALUES
(1, 3, 329, 17),
(2, 1, 449, 1),
(3, 1, 645, 21),
(4, 1, 479, 19),
(5, 2, 375, 3),
(6, 1, 259, 22),
(7, 2, 1219, 2),
(8, 1, 279, 18),
(9, 1, 1125, 20),
(10, 1, 829, 23),
(11, 1, 387, 24),
(12, 1, 385, 25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_cesta_has_cesta`
--

CREATE TABLE IF NOT EXISTS `detalle_cesta_has_cesta` (
  `detalle_cestas_id` int(11) NOT NULL,
  `cestas_id` int(11) NOT NULL,
  PRIMARY KEY (`detalle_cestas_id`,`cestas_id`),
  KEY `fk_detalle_cestas_has_cestas_cestas1_idx` (`cestas_id`),
  KEY `fk_detalle_cestas_has_cestas_detalle_cestas1_idx` (`detalle_cestas_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE IF NOT EXISTS `detalle_pedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad` int(11) NOT NULL,
  `precio` float NOT NULL,
  `productos_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_detalle_pedidos_productos1_idx` (`productos_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

--
-- Volcado de datos para la tabla `detalle_pedido`
--

INSERT INTO `detalle_pedido` (`id`, `cantidad`, `precio`, `productos_id`) VALUES
(38, 3, 1219, 2),
(39, 3, 449, 1),
(40, 1, 375, 3),
(41, 4, 819, 16),
(42, 1, 279, 18),
(43, 1, 329, 17),
(44, 1, 479, 19),
(45, 2, 259, 22),
(46, 1, 829, 23),
(47, 1, 387, 24),
(48, 1, 385, 25),
(49, 1, 449, 1),
(50, 1, 1219, 2),
(51, 1, 819, 16),
(52, 2, 1219, 2),
(53, 2, 829, 23),
(54, 2, 279, 18),
(55, 2, 449, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido_has_pedido`
--

CREATE TABLE IF NOT EXISTS `detalle_pedido_has_pedido` (
  `detalle_pedidos_id` int(11) NOT NULL,
  `pedidos_id` int(11) NOT NULL,
  PRIMARY KEY (`detalle_pedidos_id`,`pedidos_id`),
  KEY `fk_detalle_pedidos_has_pedidos_pedidos1_idx` (`pedidos_id`),
  KEY `fk_detalle_pedidos_has_pedidos_detalle_pedidos1_idx` (`detalle_pedidos_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `detalle_pedido_has_pedido`
--

INSERT INTO `detalle_pedido_has_pedido` (`detalle_pedidos_id`, `pedidos_id`) VALUES
(45, 88),
(46, 88),
(47, 88),
(48, 88),
(40, 101),
(42, 101),
(43, 101),
(49, 101),
(50, 101),
(51, 101),
(50, 103),
(50, 104),
(50, 105),
(50, 106),
(50, 107),
(50, 108),
(50, 109),
(39, 111),
(53, 111),
(39, 112),
(50, 112),
(53, 112),
(39, 113),
(50, 113),
(53, 113),
(51, 117),
(54, 117),
(40, 118),
(49, 118),
(51, 118),
(54, 118),
(49, 133),
(50, 133);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa_transporte`
--

CREATE TABLE IF NOT EXISTS `empresa_transporte` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `empresa_transporte`
--

INSERT INTO `empresa_transporte` (`id`, `nombre`) VALUES
(9, 'ASM'),
(3, 'Correos'),
(1, 'SEUR'),
(12, 'TourlineExpress'),
(8, 'Zeleris');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envio`
--

CREATE TABLE IF NOT EXISTS `envio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(255) NOT NULL,
  `coste` double NOT NULL,
  `tiempo` varchar(255) NOT NULL,
  `empresas_transporte_id` int(11) NOT NULL,
  `peso` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_envios_empresas_transporte1_idx` (`empresas_transporte_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

--
-- Volcado de datos para la tabla `envio`
--

INSERT INTO `envio` (`id`, `tipo`, `coste`, `tiempo`, `empresas_transporte_id`, `peso`) VALUES
(5, 'Estandard', 3.95, '3-5 días', 1, 10),
(6, 'Express', 5.95, '24 horas', 1, 10),
(7, 'Express', 6.95, '24 horas ', 1, 15),
(8, 'Express', 9.95, '24 horas ', 1, 20),
(22, 'Estandard', 4.95, '3-5 dias', 1, 15),
(23, 'Estandard', 7.95, '3-5 dias', 1, 20),
(24, 'Estandard', 3.85, '3-5 días', 12, 10),
(25, 'Express', 5.85, '24 horas', 12, 10),
(26, 'Express', 6.85, '24 horas ', 12, 15),
(27, 'Express', 9.85, '24 horas ', 12, 20),
(28, 'Estandard', 4.85, '3-5 dias', 12, 15),
(29, 'Estandard', 7.85, '3-5 dias', 12, 20),
(30, 'Estandard', 4.7, '3-5 dias', 9, 15),
(31, 'Estandard', 7.7, '3-5 dias', 9, 20),
(32, 'Express', 9.7, '24 horas ', 9, 20),
(33, 'Express', 6.7, '24 horas ', 9, 15),
(34, 'Express', 5.7, '24 horas', 9, 10),
(35, 'Estandard', 3.7, '3-5 días', 9, 10),
(36, 'Estandard', 3.5, '3-5 días', 3, 10),
(37, 'Express', 5.5, '24 horas', 3, 10),
(38, 'Express', 6.5, '24 horas ', 3, 15),
(39, 'Express', 9.5, '24 horas ', 3, 20),
(40, 'Estandard', 4.5, '3-5 dias', 3, 15),
(42, 'Estandard', 7.5, '3-5 dias', 3, 20),
(43, 'Estandard', 3.2, '3-5 días', 8, 10),
(44, 'Express', 5.2, '24 horas', 8, 10),
(45, 'Express', 6.2, '24 horas ', 8, 15),
(46, 'Express', 9.2, '24 horas ', 8, 20),
(47, 'Estandard', 4.2, '3-5 dias', 8, 15),
(48, 'Estandard', 7.2, '3-5 dias', 8, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fidelidad`
--

CREATE TABLE IF NOT EXISTS `fidelidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `fidelidad`
--

INSERT INTO `fidelidad` (`id`, `nombre`) VALUES
(1, 'cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE IF NOT EXISTS `pago` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pago` varchar(255) NOT NULL,
  `incremento` float NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pago_UNIQUE` (`pago`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `pago`
--

INSERT INTO `pago` (`id`, `pago`, `incremento`) VALUES
(1, 'Transferencia bancaria', 0),
(2, 'Contrarembolso', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE IF NOT EXISTS `pedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `total` double NOT NULL,
  `pagado` tinyint(1) NOT NULL DEFAULT '0',
  `enviado` tinyint(1) NOT NULL DEFAULT '0',
  `clientes_id` int(11) DEFAULT NULL,
  `envios_id` int(11) NOT NULL,
  `pagos_id` int(11) NOT NULL,
  `comentario_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `comentario_id_UNIQUE` (`comentario_id`),
  KEY `fk_pedidos_envios1_idx` (`envios_id`),
  KEY `fk_pedidos_pagos1_idx` (`pagos_id`),
  KEY `fk_pedidos_comentario1_idx` (`comentario_id`),
  KEY `fk_pedidos_clientes1_idx` (`clientes_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=134 ;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`id`, `fecha`, `total`, `pagado`, `enviado`, `clientes_id`, `envios_id`, `pagos_id`, `comentario_id`) VALUES
(88, '2014-06-22 19:26:12', 2128.7, 0, 0, NULL, 32, 1, NULL),
(101, '2014-06-23 00:12:44', 3582.1855, 0, 0, NULL, 29, 2, NULL),
(103, '2014-06-23 00:17:25', 1261.441, 0, 0, 51, 34, 2, NULL),
(104, '2014-06-23 00:17:31', 1261.441, 0, 0, 51, 34, 2, NULL),
(105, '2014-06-23 00:17:36', 1261.441, 0, 0, 51, 34, 2, NULL),
(106, '2014-06-23 00:18:28', 1261.441, 0, 0, 51, 34, 2, NULL),
(107, '2014-06-23 00:19:48', 1224.5, 0, 0, 51, 37, 1, NULL),
(108, '2014-06-23 00:20:37', 1261.235, 0, 0, 51, 37, 2, NULL),
(109, '2014-06-23 00:21:01', 1224.2, 0, 0, 51, 44, 1, NULL),
(111, '2014-06-23 13:00:57', 3104.935, 0, 0, NULL, 39, 2, NULL),
(112, '2014-06-23 13:05:21', 4231.95, 0, 0, NULL, 23, 1, NULL),
(113, '2014-06-23 13:07:34', 4358.9085, 0, 0, NULL, 23, 2, NULL),
(117, '2014-06-24 16:59:40', 1384.2, 0, 0, 59, 48, 1, NULL),
(118, '2014-06-24 17:00:20', 2208.2, 1, 1, 59, 48, 1, NULL),
(133, '2014-06-24 21:11:05', 1728.1855, 0, 1, 60, 27, 2, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE IF NOT EXISTS `producto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET latin1 NOT NULL,
  `descripcion` longtext COLLATE utf8_spanish_ci NOT NULL,
  `imagen` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `precio` float NOT NULL DEFAULT '0',
  `oferta` tinyint(1) NOT NULL DEFAULT '0',
  `peso` float NOT NULL DEFAULT '0',
  `stock` bigint(20) NOT NULL DEFAULT '0',
  `servicio` tinyint(1) NOT NULL DEFAULT '0',
  `garantia` int(11) DEFAULT '2',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=41 ;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `nombre`, `descripcion`, `imagen`, `precio`, `oferta`, `peso`, `stock`, `servicio`, `garantia`) VALUES
(1, 'PcCom Gaming Battle A10-5800K', 'Una vez más Pc Componentes sorprende a la industria de la informática con el lanzamiento de los nuevos PcCom, la nueva línea de Pcs de sobremesa para juegos creada tras un amplio trabajo de investigación para ofrecer el mayor rendimiento y optimización en el juego para nuestros clientes. Ensamblados por nuestros expertos de montaje, los nuevos PcCom ofrecen un rendimiento increíble, con máxima velocidad, capacidad de ampliación y un amplio abanico de posibilidades dentro de la gama, en la que podrá elegir el producto óptimo según las necesidades y el tipo de Pc que está buscando.', 'ordenador1.jpg', 449, 0, 11.5, 30, 0, 2),
(2, 'PcCom Apocalypse', 'La bestia de todas las bestias. Una máquina indomable que te brindará una sensación de potencia descomunal a la hora de jugar. Creada y ensamblada con la mayor precisión y los mejores componentes del momento, el PcCom Apocalypse posee unas condiciones inigualables para el juego, superando ampliamente los requisitos técnicos requeridos por los juegos que actualmente van apareciendo en el mercado.', 'ordenador2.jpg', 1219, 0, 10, 50, 0, 2),
(3, 'PcCom Basic Enterprise', 'Excelente relación calidad-precio para este PC con componentes de primeras marcas, la máxima garantía y gran rendimiento, ideal para usuarios que buscan hacer "de todo un poco".\nPensado para un uso general en el hogar o en la oficina, el PcCom Enterprise se presenta como un equipo equilibrado en el que su procesador i5, sus 4GB de RAM y el generoso disco duro de 1TB permiten trabajar de forma holgada en muy diferentes tareas, lo que lo hace ideal para entornos domésticos o de oficina.', 'PcComBasicEnterprise.jpg', 375, 0, 13.4, 0, 0, 2),
(16, 'PcCom Gaming Revolution Ultra', 'Una vez más Pc Componentes sorprende a la industria de la informática con el lanzamiento de los nuevos PcCom, la nueva línea de Pcs de sobremesa para juegos creada tras un amplio trabajo de investigación para ofrecer el mayor rendimiento y optimización en el juego para nuestros clientes. Ensamblados por nuestros expertos de montaje, los nuevos PcCom ofrecen un rendimiento increíble, con máxima velocidad, capacidad de ampliación y un amplio abanico de posibilidades dentro de la gama, en la que podrás elegir el producto óptimo según las necesidades y el tipo de Pc que estas buscando.', 'PcComGamingRevolutionUltra.jpg', 819, 0, 18, 12, 0, 2),
(17, 'PcCom Basic Media Center', 'Excelente relación calidad/precio para este PC con componentes de primeras marcas, la máxima garantía y gran rendimiento, ideal para usuarios que buscan hacer "de todo un poco".\r\nEl PcCom Basic Media Center está pensado para ofrecer el máximo entretenimiento multimedia en el salón de casa. Destaca por tener todo lo que debe tener un buen ordenador de salón, sin dejar ningún aspecto sin cubrir.', 'PcComBasicMediaCenter.jpg', 329, 0, 12.5, 0, 0, 2),
(18, 'HP CompaQ', 'Te presentamos el HP Compaq 100-200ES, un PC con procesador AMD E1-2500, 4GB de RAM y 500GB de disco duro.', 'HPCompaQ.jpg', 279, 0, 14.8, 0, 0, 2),
(19, 'HP Pro 3500', 'Sistema operativo Windows® 8 Professional de 64 bits\r\nProcesador Intel® Core™ i3-3240 con Intel HD Graphics 2500 (3,40GHz, 3 MB de caché, 2 núcleos)\r\nChipset Procesador Intel® H61 Express\r\nFormato Microtorre', 'HPPro3500.jpg', 479, 0, 16.3, 0, 0, 2),
(20, 'PcCom Arts Video', 'Una vez más Pc Componentes sorprende a la industria de la informática con el lanzamiento de los nuevos PcCom, la nueva línea de Pcs de sobremesa para trabajos audiovisuales, creado tras un amplio trabajo de investigación para ofrecer el mayor rendimiento y optimización para nuestros clientes. Ensamblados por nuestros expertos de montaje, los nuevos PcCom ofrecen un rendimiento increíble, con máxima velocidad, capacidad de ampliación y un amplio abanico de posibilidades dentro de la gama, en la que podrás elegir el producto óptimo según las necesidades y el tipo de Pc que estas buscando.\r\n\r\nTe ofrecemos la posibilidad de disfrutar de un completo ordenador, a un precio excepcional. PcCom Arts Video posee una combinación de excelentes componentes de alta calidad y una serie de características prácticas para satisfacer tus necesidades informáticas y de entretenimiento diarias. Con una optimización máxima, te ofrecemos una máquina excelente para tus trabajos audiovisuales a un precio increible.', 'PcComArtsVideo.jpg', 1125, 0, 21, 0, 0, 2),
(21, 'HP ProLiant ML310e', 'El servidor HP ProLiant ML310e Gen8, una torre de 4 unidades con toma única, ofrece la capacidad de ampliación y disponibilidad esenciales que son precisas para adaptarse a las necesidades cambiantes del negocio. Es ideal para emplazamientos remotos y sucursales corporativas que ejecuten archivos/impresiones, mensajería de Web y bases de datos o aplicaciones verticales pequeñas.', 'HPProLiantML310e.jpg ', 645, 0, 17.8, 0, 0, 2),
(22, 'PcCom Basic Small Size', 'Excelente relación calidad/precio para este PC ,ideal para usuarios que buscan hacer "de todo un poco" con un ordenador elegante de tamaño muy reducido.\r\n\r\nEl PcCom Basic Small Size está pensado para ofrecer el máximo entretenimiento multimedia en el salón de casa. Destaca por tener todo lo que debe tener un buen ordenador de salón, sin dejar ningún aspecto sin cubrir.', 'PcComBasicSmallSize.jpg', 259, 0, 6.8, 0, 0, 2),
(23, 'PcCom Gaming Templarius', 'Una vez más Pc Componentes sorprende a la industria de la informática con el lanzamiento de los nuevos PcCom, la nueva línea de Pcs de sobremesa para juegos creada tras un amplio trabajo de investigación para ofrecer el mayor rendimiento y optimización en el juego para nuestros clientes. Ensamblados por nuestros expertos de montaje, los nuevos PcCom ofrecen un rendimiento increíble, con máxima velocidad, capacidad de ampliación y un amplio abanico de posibilidades dentro de la gama, en la que podrás elegir el producto óptimo según las necesidades y el tipo de Pc que estas buscando.', 'PcComGamingTemplarius.jpg', 829, 0, 8.9, 0, 0, 2),
(24, 'HP ProLiant ML110 G7 XE E3-1220', 'El HP ProLiant ML110 G7 es perfecto como primer servidor para los negocios en crecimiento. Proporciona una solución asequible y funcional a pymes preocupadas por el presupuesto y que cuentan con recursos internos en TI escasos o nulos. Con la fiabilidad probada de ProLiant y equipado con los últimos procesadores Intel,el ML110 G7 proporciona la solución ideal para empresas en crecimiento. La combinación de ranuras PCI-Express,ranuras DIMM,bahías para \r\nunidades y opciones de servidor ofrece la capacidad de ampliación necesaria. Las unidades de gestión remota iLO3 integradas reducen los costes operativos reduciendo el número de visitas físicas. La fuente de alimentación estándar y el RPS son ahora más eficaces y reducen aún más el consumo de energía. El servidor HP ProLiant ML110 G7 es más eficiente y proporciona un gran valor para negocios en crecimiento.', 'HPProLiantML110G7XEE3-1220.jpg', 387, 0, 17.4, 0, 0, 2),
(25, 'Acer Aspire M1470 A4-3420', 'PROCESADOR\r\nAMD Dual Core A4-3420 2.8GHz\r\n\r\nMEMORIA RAM\r\nInstalada: 4GB\r\nMaxima: 16GB\r\nTecnología: DIMM DDR3', 'AcerAspireM1470A4-3420.jpg', 385, 0, 16.2, 0, 0, 2),
(26, 'Instalacion de sistema operativo y programas', 'Nos ocuparemos de recuperar su datos de su PC, formatearlo y de instalarle el sistema operativo con un paquete de programas basicos para uso de su PC.', 'servicio_basico.jpg', 20, 0, 0, 0, 1, NULL),
(27, 'Instalacion de programas', 'Instalacion de programas de primera utilidad (Open Office, Adobe Reader, WinRar, Photoscape,Avast, Antivir etc.)', 'instalacion_software.jpg', 5, 0, 0, 0, 1, NULL),
(31, 'Montaje de piezas', 'Montaje de componentes como: memorias RAM, disco duro, tarjetas graficas, procesadores, etc.', 'f_37961398_3.jpeg', 5, 0, 0, 0, 1, NULL),
(32, 'Limpieza fisica de ordenador fijo ', 'Nuestros especialistas se encargaran de dejar a punto su ordenador.', 'aparato-soplador-para-limpieza-del-pc-54.jpg', 5, 0, 0, 0, 1, NULL),
(33, 'Limpieza fisica de ordenador fijo con pasta termica. ', 'Nuestros profesionales se encargaran de dejar a punto su ordenador de sobremesa con el añadido de la pasta termica.', 'pastatermica1.jpg', 6.5, 0, 0, 0, 1, NULL),
(34, 'Limpieza fisica de ordenador portatil ', 'Nuestros profesionales dejaran listo su ordenador portatil en un breve espacio de tiempo', 'descarga.jpg', 10, 0, 0, 0, 1, NULL),
(35, 'Limpieza de smartphone y configuracion ', 'Nuestros profesionales se encargan de limpiar su smartphone ademas de configurarlo inicialmente.', 'consejos-smartphone.jpg', 5, 0, 0, 0, 1, NULL),
(36, 'Recomendaciones y compraventa de componentes', 'Nuestros profesionales estaran a su disposicion para ayudarle a escoger la mejor opcion en la medida de sus posibilidades.', 'icon-41335_640-240x300.png', 0, 0, 0, 0, 1, NULL),
(37, 'Liberacion de moviles', 'Nuestros profesionales se encargaran de liberar moviles de cualquier marca comercial.', 'liberar.jpeg', 6, 0, 0, 0, 1, 2),
(38, 'Cambio de pantalla', 'Nuestros profesionales se encargaran del cambio de pantalla de su smartphone.\r\nNota: el cliente ha de comprar la pantalla del modelo correspondiente a su movil por separado.', 'ficha_como-nuevo-cambio-de-pantalla-completa-de-iphone-desde-19.jpg', 20, 0, 0, 0, 1, NULL),
(39, 'PcCom Gaming Battle A10-5800K_oferta', '', 'Ordenador oferta especial.png', 0, 1, 0, 0, 0, 2),
(40, 'PcCom Apocalypse_oferta', '', 'oferta del mes.png', 0, 1, 0, 0, 0, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `correo` varchar(255) NOT NULL,
  `password` longtext NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellidos` varchar(255) DEFAULT NULL,
  `dni` varchar(9) DEFAULT NULL,
  `codigo_postal` int(5) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono_fijo` int(11) DEFAULT NULL,
  `telefono_movil` int(11) DEFAULT NULL,
  `administrador` tinyint(1) NOT NULL DEFAULT '0',
  `boletin` tinyint(1) NOT NULL,
  `fidelidades_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `correo_UNIQUE` (`correo`),
  UNIQUE KEY `dni_UNIQUE` (`dni`),
  KEY `fk_clientes_fidelidades1_idx` (`fidelidades_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `correo`, `password`, `nombre`, `apellidos`, `dni`, `codigo_postal`, `direccion`, `telefono_fijo`, `telefono_movil`, `administrador`, `boletin`, `fidelidades_id`) VALUES
(51, 'inopiam@gmail.com', '$2y$10$tyRLGnEID452eTnkfGMrzO50toy20/XpijceVRQwTzcQyxHXZojNO', 'Marta', 'jota hache', '35487159S', 46019, 'Calle Falsa 1 23', 963668354, 667092335, 0, 1, 1),
(59, 'girtazo@gmail.com', '$2y$10$W4xf4O8Tuurr3ONpLYilDewMPhRtX6Goqocd/sYZJjIDrdbhQzt3u', 'David', 'Navarro Navarro', '35594135W', 46131, 'Pintor Lluch 8 5', 961855475, 697438748, 0, 0, 1),
(60, 'adminifc@gmail.com', '$2y$10$N23KO8DJ74b6iWzLdbAaH.YIcbPhaqQyosvNHugcO2KoOJxAfTX0K', 'David', 'Navarro Navarro', '35594136W', 46131, 'Pintor Lluch 8 5', 961855475, 697438748, 1, 0, 1),
(61, 'adminifc2@gmail.com', '$2y$10$5NRsyz8yGRuv6nkCfzt3pO7z3UL1rmDCbK/9P8H0wj/cHOYwXZYHi', 'David', 'Navarro Navarro', '35594137W', 46131, 'Calle Pintor Lluch 8 5', 961855475, 697438748, 1, 1, 1);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cesta`
--
ALTER TABLE `cesta`
  ADD CONSTRAINT `fk_cestas_guardadas_clientes1` FOREIGN KEY (`clientes_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD CONSTRAINT `fk_comentario_clientes1` FOREIGN KEY (`clientes_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_comentario_productos1` FOREIGN KEY (`productos_id`) REFERENCES `producto` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `descuento`
--
ALTER TABLE `descuento`
  ADD CONSTRAINT `fk_descuentos_fidelidades1` FOREIGN KEY (`fidelidades_id`) REFERENCES `fidelidad` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_descuentos_productos1` FOREIGN KEY (`productos_id`) REFERENCES `producto` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `detalle_cesta`
--
ALTER TABLE `detalle_cesta`
  ADD CONSTRAINT `fk_detalle_cestas_guardadas_productos1` FOREIGN KEY (`productos_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_cesta_has_cesta`
--
ALTER TABLE `detalle_cesta_has_cesta`
  ADD CONSTRAINT `fk_detalle_cestas_has_cestas_cestas1` FOREIGN KEY (`cestas_id`) REFERENCES `cesta` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_detalle_cestas_has_cestas_detalle_cestas1` FOREIGN KEY (`detalle_cestas_id`) REFERENCES `detalle_cesta` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `fk_detalle_pedidos_productos1` FOREIGN KEY (`productos_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_pedido_has_pedido`
--
ALTER TABLE `detalle_pedido_has_pedido`
  ADD CONSTRAINT `fk_detalle_pedidos_has_pedidos_detalle_pedidos1` FOREIGN KEY (`detalle_pedidos_id`) REFERENCES `detalle_pedido` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_detalle_pedidos_has_pedidos_pedidos1` FOREIGN KEY (`pedidos_id`) REFERENCES `pedido` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `envio`
--
ALTER TABLE `envio`
  ADD CONSTRAINT `fk_envios_empresas_transporte1` FOREIGN KEY (`empresas_transporte_id`) REFERENCES `empresa_transporte` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `fk_pedidos_clientes1` FOREIGN KEY (`clientes_id`) REFERENCES `usuario` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_pedidos_comentario1` FOREIGN KEY (`comentario_id`) REFERENCES `comentario` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pedidos_envios1` FOREIGN KEY (`envios_id`) REFERENCES `envio` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pedidos_pagos1` FOREIGN KEY (`pagos_id`) REFERENCES `pago` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_clientes_fidelidades1` FOREIGN KEY (`fidelidades_id`) REFERENCES `fidelidad` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
