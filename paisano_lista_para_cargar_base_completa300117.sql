-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-01-2017 a las 19:56:33
-- Versión del servidor: 5.6.21
-- Versión de PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `paisano`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accion`
--

CREATE TABLE IF NOT EXISTS `accion` (
`id` int(11) NOT NULL,
  `accion` varchar(255) DEFAULT NULL,
  `texto` varchar(255) DEFAULT NULL,
  `enlace` varchar(255) DEFAULT NULL,
  `pagina` varchar(255) DEFAULT NULL,
  `modulo_pertenece` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL,
  `nivel_menu_id` int(11) NOT NULL,
  `orden` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `accion`
--

INSERT INTO `accion` (`id`, `accion`, `texto`, `enlace`, `pagina`, `modulo_pertenece`, `activo`, `clave`, `nivel_menu_id`, `orden`) VALUES
(1, 'Módulo Atenciones', 'Atenciones', 'atenciones', '', '', 0, 'MA', 1, 1),
(2, 'Módulo Queja o Petición de Ayuda', 'Quejas y Peticiones de Ayuda', 'quejaypeticion', '', '', 1, 'MQP', 1, 2),
(3, 'Módulo Administrador', 'Administración', 'administracion', '', '', 1, 'MADM', 1, 3),
(4, 'Módulo Reportes', 'Reportes', 'reportes', '', '', 1, 'MR', 1, 4),
(5, 'Registrar Atención para Representante de E.U.', 'Registrar atención (representante)', 'atenciones', 'registroAtRep', 'MA', 1, 'AEU', 2, 1),
(6, 'Registrar Atención para Enlaces Nacionales', 'Registrar atención (enlace)', 'atenciones', 'registroAtEn', 'MA', 1, 'AEN', 2, 2),
(7, 'Búsqueda de Atenciones para Representante de E.U.', 'Búsqueda de atenciones (representante)', 'atenciones', 'busquedaAtRep', 'MA', 1, 'BUSAE', 2, 3),
(8, 'Búsqueda de Atenciones para Enlaces Nacionales', 'búsqueda de atenciones (enlace)', 'atenciones', 'busquedaAtEn', 'MA', 1, 'BUSAN', 2, 4),
(9, 'Editar Atención Representante E.U.', 'Editar atención', '', '', 'MA', 1, 'EEU', 3, 1),
(10, 'Editar Atención Enlaces Nacionales', 'Editar atención', '', '', 'MA', 1, 'EEN', 3, 1),
(11, 'Eliminar Atención Representante E.U.', 'Eliminar atención', '', '', 'MA', 1, 'ELEU', 3, 2),
(12, 'Eliminar Atención Enlaces Nacionales', 'Eliminar atención', '', '', 'MA', 1, 'ELEN', 3, 2),
(13, 'Registrar Queja o Petición de Ayuda', 'Registrar queja o petición de ayuda', 'quejaypeticion', 'QPregistro', 'MQP', 1, 'RQPA', 2, 1),
(14, 'Editar Queja o Petición de Ayuda', 'Editar', 'quejaypeticion', '', 'MQP', 1, 'EQPA', 3, 1),
(15, 'Eliminar Queja o Petición de Ayuda', 'Editar', 'quejaypeticion', '', 'MQP', 1, 'ELQPA', 3, 2),
(16, 'Seguimiento de quejas y Peticiones de Ayuda', 'Seguimiento de quejas y peticiones de ayuda', 'quejaypeticion', 'QPseguimiento', 'MQP', 1, 'SQPA', 2, 2),
(17, 'Búsqueda de Quejas y Peticiones de Ayuda', 'Búsqueda de quejas y peticiones de ayuda', 'quejaypeticion', 'QPbusqueda', 'MQP', 1, 'BUSQP', 2, 3),
(18, 'Módulo Usuarios', 'Usuarios', 'usuarios', '', 'MADM', 1, 'MU', 2, 1),
(19, 'Módulo Operativos', 'Operativos', 'operativos', '', 'MADM', 0, 'MO', 2, 3),
(20, 'Módulo Módulos', 'Módulos', 'modulos', '', 'MADM', 0, 'MM', 2, 4),
(21, 'Registrar Usuarios', 'Registrar Usuarios', '', '', 'MU', 1, 'MURU', 3, 4),
(22, 'Modificar Usuarios', 'Modificar Usuario', '', '', 'MU', 1, 'MUMU', 3, 1),
(23, 'Eliminar Usuarios', 'Eliminar Usuario', '', '', 'MU', 1, 'MUEU', 3, 2),
(24, 'Modificar Permisos', 'Modificar Permisos', '', '', 'MU', 1, 'MUMP', 3, 3),
(25, 'Reseteo de estatus', 'Cambio de estatus', 'quejaypeticion', 'QPreseteo', 'MQP', 1, 'REQP', 2, 4),
(26, 'Reporte mensual', 'Reporte mensual', 'reportes', 'Rmensual', 'MR', 1, 'RM', 2, 1),
(27, 'Reporte general', 'Reporte de quejas y peticiones', 'reportes', 'Rgeneral', 'MR', 1, 'RGQP', 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accion_por_rol`
--

CREATE TABLE IF NOT EXISTS `accion_por_rol` (
`id` int(11) NOT NULL,
  `accion_id` int(11) NOT NULL,
  `rol_usuario_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `accion_por_rol`
--

INSERT INTO `accion_por_rol` (`id`, `accion_id`, `rol_usuario_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1),
(7, 7, 1),
(8, 8, 1),
(9, 9, 1),
(10, 10, 1),
(11, 11, 1),
(12, 12, 1),
(13, 13, 1),
(14, 14, 1),
(15, 15, 1),
(16, 16, 1),
(17, 17, 1),
(18, 19, 1),
(19, 20, 1),
(20, 25, 1),
(21, 26, 1),
(22, 27, 1),
(23, 1, 2),
(24, 2, 2),
(25, 4, 2),
(26, 5, 2),
(27, 7, 2),
(28, 9, 2),
(29, 11, 2),
(30, 13, 2),
(31, 14, 2),
(32, 15, 2),
(33, 16, 2),
(34, 17, 2),
(35, 25, 2),
(36, 26, 2),
(37, 27, 2),
(38, 1, 3),
(39, 2, 3),
(40, 4, 3),
(41, 6, 3),
(42, 8, 3),
(43, 10, 3),
(44, 12, 3),
(45, 13, 3),
(46, 14, 3),
(47, 15, 3),
(48, 16, 3),
(49, 17, 3),
(50, 25, 3),
(51, 26, 3),
(52, 27, 3),
(53, 1, 5),
(54, 2, 5),
(55, 3, 5),
(56, 4, 5),
(57, 5, 5),
(58, 6, 5),
(59, 7, 5),
(60, 8, 5),
(61, 9, 5),
(62, 10, 5),
(63, 11, 5),
(64, 12, 5),
(65, 13, 5),
(66, 14, 5),
(67, 15, 5),
(68, 16, 5),
(69, 17, 5),
(70, 18, 5),
(71, 19, 5),
(72, 20, 5),
(73, 21, 5),
(74, 22, 5),
(75, 23, 5),
(76, 24, 5),
(77, 25, 5),
(78, 26, 5),
(79, 27, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actualizacion`
--

CREATE TABLE IF NOT EXISTS `actualizacion` (
`id` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `fecha` datetime NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `folio_operacion_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anio_operativo`
--

CREATE TABLE IF NOT EXISTS `anio_operativo` (
`id` int(11) NOT NULL,
  `anio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `atencion_enlace`
--

CREATE TABLE IF NOT EXISTS `atencion_enlace` (
`id` int(11) NOT NULL,
  `modulo_id` int(11) NOT NULL,
  `numero_atenciones` int(11) DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  `folio_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `atencion_representante`
--

CREATE TABLE IF NOT EXISTS `atencion_representante` (
`id` int(11) NOT NULL,
  `fecha_registro` date NOT NULL,
  `tipo_atencion_representante_id` int(11) NOT NULL,
  `tema_id` int(11) NOT NULL,
  `otro_tema` varchar(255) DEFAULT NULL,
  `persona_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `folio_id` int(11) NOT NULL,
  `sede_grupal` varchar(255) DEFAULT NULL,
  `no_personas_grupal` int(11) DEFAULT NULL,
  `aplica_estado_id` int(11) NOT NULL,
  `estatus_peticion_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `causa`
--

CREATE TABLE IF NOT EXISTS `causa` (
`id` int(11) NOT NULL,
  `causa` varchar(255) DEFAULT NULL,
  `quien_aplica` int(11) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `causa`
--

INSERT INTO `causa` (`id`, `causa`, `quien_aplica`, `activo`, `clave`) VALUES
(1, 'Abuso de autoridad', 1, 1, 'AB'),
(2, 'Cobro indebido', 1, 1, 'CI'),
(3, 'Extorsión', 1, 1, 'E'),
(4, 'Extravío de documento por parte del Servidor Público', 1, 1, 'ED'),
(5, 'Embargo precautorio de mercancía', 1, 1, 'EM'),
(6, 'Embargo precautorio de vehículo', 1, 1, 'EV'),
(7, 'Mal procedimiento', 1, 1, 'MP'),
(8, 'Mala atención y servicio', 1, 1, 'MAS'),
(9, 'Mala información', 1, 1, 'MI'),
(10, 'Maltrato y prepotencia', 1, 1, 'MP'),
(11, 'Robo', 1, 1, 'R'),
(12, 'Otro', 3, 1, 'O'),
(13, 'Actas nacimiento', 2, 1, 'ANAC'),
(14, 'Documentos de identidad', 2, 1, 'AOD'),
(15, 'Constancias de repatriación', 2, 1, 'CREP'),
(16, 'Descuento para obtener un servicio', 2, 1, 'DSERV'),
(17, 'Procedimiento en la aduana', 2, 1, 'IBE'),
(18, 'Localización de connacionales', 2, 1, 'LC'),
(19, 'Repatriación y/o traslado de cuerpos', 2, 1, 'RCU'),
(20, 'Casos MP', 2, 1, 'IC'),
(21, 'Servicio Nacional de Empleo', 2, 1, 'SEMP'),
(22, 'Apoyo económico', 2, 1, 'AECO'),
(23, 'Revalidación de estudios', 2, 1, 'RES');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudad`
--

CREATE TABLE IF NOT EXISTS `ciudad` (
`id` int(11) NOT NULL,
  `nombre_ciudad` varchar(255) NOT NULL,
  `estado_id` int(11) NOT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=401 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ciudad`
--

INSERT INTO `ciudad` (`id`, `nombre_ciudad`, `estado_id`, `activo`, `clave`) VALUES
(1, 'Saltillo', 7, 1, '0000001'),
(2, 'Guadalajara', 13, 1, '0000002'),
(3, 'Lagos de Moreno', 13, 1, '0000003'),
(4, 'Tlalnepantla', 14, 1, '0000004'),
(5, 'Arandas', 13, 1, '0000005'),
(6, 'Lerma', 14, 1, '0000006'),
(7, 'Toluca', 14, 1, '0000007'),
(8, 'Tepotzotlán', 14, 1, '0000008'),
(9, 'Atizapán de Zaragoza', 14, 1, '0000009'),
(10, 'Texcoco', 14, 1, '0000010'),
(11, 'Durango', 9, 1, '0000011'),
(12, 'Torreón', 7, 1, '0000012'),
(13, 'Cuatro Ciénegas', 7, 1, '0000013'),
(14, 'Monclova', 7, 1, '0000014'),
(15, 'Acuña', 7, 1, '0000015'),
(16, 'Zaragoza', 7, 1, '0000016'),
(17, 'Morelos', 7, 1, '0000017'),
(18, 'Jiménez', 7, 1, '0000018'),
(19, 'Piedras Negras', 7, 1, '0000019'),
(20, 'Tuxtla Gutierrez', 5, 1, '0000020'),
(21, 'San Cristóbal de las Casas', 5, 1, '0000021'),
(22, 'Chiapa de Corzo', 5, 1, '0000022'),
(23, 'Acapulco', 11, 1, '0000023'),
(24, 'Chilpancingo', 11, 1, '0000024'),
(25, 'Tijuana', 2, 1, '0000025'),
(26, 'Mérida', 30, 1, '0000026'),
(27, 'Magdalena', 25, 1, '0000027'),
(28, 'San Luis Rio Colorado', 25, 1, '0000028'),
(29, 'Agua Prieta', 25, 1, '0000029'),
(30, 'Guaymas Empalme', 25, 1, '0000030'),
(31, 'Hermosillo', 25, 1, '0000031'),
(32, 'Mexicali', 2, 1, '0000032'),
(33, 'Ensenada', 2, 1, '0000033'),
(34, 'Tepic', 17, 1, '0000034'),
(35, 'Jala', 17, 1, '0000035'),
(36, 'Ixtlán del Río', 17, 1, '0000036'),
(37, 'Compostela', 17, 1, '0000037'),
(38, 'San Blas', 17, 1, '0000038'),
(39, 'Tlaxcala', 28, 1, '0000039'),
(40, 'Apizaco', 28, 1, '0000040'),
(41, 'Calpulalpan', 28, 1, '0000041'),
(42, 'El Carmen Tequexquitla', 28, 1, '0000042'),
(43, 'Tlaxco', 28, 1, '0000043'),
(44, 'Zacatelco', 28, 1, '0000044'),
(45, 'Querétaro', 21, 1, '0000045'),
(46, 'Zacatecas', 31, 1, '0000046'),
(47, 'Calera de Víctor Rosales', 31, 1, '0000047'),
(48, 'Miguel Auza', 31, 1, '0000048'),
(49, 'Jerez de García Salinas', 31, 1, '0000049'),
(50, 'Jalpa', 31, 1, '0000050'),
(51, 'Cárdenas', 23, 1, '0000051'),
(52, 'Río Grande', 31, 1, '0000052'),
(53, 'Tlaltenango', 31, 1, '0000053'),
(54, 'Tabasco', 31, 1, '0000054'),
(55, 'Ciudad Valles', 23, 1, '0000055'),
(56, 'Guadalcazar', 23, 1, '0000056'),
(57, 'Matehuala', 23, 1, '0000057'),
(58, 'Real de Catorce', 23, 1, '0000058'),
(59, 'Río Verde', 23, 1, '0000059'),
(60, 'Soledad de Graciano Sánchez', 23, 1, '0000060'),
(61, 'Santa María del Río', 23, 1, '0000061'),
(62, 'Tamazunchale', 23, 1, '0000062'),
(63, 'Villa de Arista', 23, 1, '0000063'),
(64, 'Venado', 23, 1, '0000064'),
(65, 'Monterrey', 18, 1, '0000065'),
(66, 'Guadalupe', 18, 1, '0000066'),
(67, 'Apodaca', 18, 1, '0000067'),
(68, 'Anáhuac', 18, 1, '0000068'),
(69, 'Salinas de Hidalgo', 23, 1, '0000069'),
(70, 'Moctezuma', 23, 1, '0000070'),
(71, 'Silao', 10, 1, '0000071'),
(72, 'León de los Aldama', 10, 1, '0000072'),
(73, 'Irapuato', 10, 1, '0000073'),
(74, 'Celaya', 10, 1, '0000074'),
(75, 'San Luis de la Paz', 10, 1, '0000075'),
(76, 'Villa de Guadalupe', 23, 1, '0000076'),
(77, 'Ahualulco', 23, 1, '0000077'),
(78, 'Charcas', 23, 1, '0000078'),
(79, 'Mexquitic de Carmona', 23, 1, '0000079'),
(80, 'Colima', 8, 1, '0000080'),
(81, 'Villa de Álvarez', 8, 1, '0000081'),
(82, 'Comala', 8, 1, '0000082'),
(83, 'Tecoman', 8, 1, '0000083'),
(84, 'Manzanillo', 8, 1, '0000084'),
(85, 'Acatlán', 12, 1, '0000085'),
(86, 'Actopan', 12, 1, '0000086'),
(87, 'Alfajayucan', 12, 1, '0000087'),
(88, 'Cardonal', 12, 1, '0000088'),
(89, 'Chilcuautla', 12, 1, '0000089'),
(90, 'Epazoyucan', 12, 1, '0000090'),
(91, 'Huasca de Ocampo', 12, 1, '0000091'),
(92, 'Jacala de Ledezma', 12, 1, '0000092'),
(93, 'Mixquiahuala', 12, 1, '0000093'),
(94, 'Mineral del Monte', 12, 1, '0000094'),
(95, 'Singuilucan', 12, 1, '0000095'),
(96, 'Tula de Allende', 12, 1, '0000096'),
(97, 'Tulancingo de Bravo', 12, 1, '0000097'),
(98, 'Tecozautla', 12, 1, '0000098'),
(99, 'Tepeapulco', 12, 1, '0000099'),
(100, 'Zimapan', 12, 1, '0000100'),
(101, 'Villahermosa', 26, 1, '0000101'),
(102, 'Emiliano Zapata', 26, 1, '0000102'),
(103, 'Balancan', 26, 1, '0000103'),
(104, 'Tenosique', 26, 1, '0000104'),
(105, 'Cárdenas', 26, 1, '0000105'),
(106, 'Concepción del Oro', 31, 1, '0000106'),
(107, 'Nuevo Laredo', 27, 1, '0000107'),
(108, 'Miguel Alemán', 27, 1, '0000108'),
(109, 'Reynosa', 27, 1, '0000109'),
(110, 'Matamoros', 27, 1, '0000110'),
(111, 'Cd. Victoria', 27, 1, '0000111'),
(112, 'Tampico', 27, 1, '00000112'),
(113, 'Altamira', 27, 1, '0000113'),
(114, 'Morelia', 15, 1, '0000114'),
(115, 'Chihuahua', 6, 1, '0000115'),
(116, 'Janos', 6, 1, '0000116'),
(117, 'Ojinaga', 6, 1, '0000117'),
(118, 'Hidalgo del Parral', 6, 1, '0000118'),
(119, 'Camargo', 6, 1, '0000119'),
(120, 'Jiménez', 6, 1, '0000120'),
(121, 'Delicias', 6, 1, '0000121'),
(122, 'Juárez', 6, 1, '0000122'),
(123, 'Poza Rica', 29, 1, '0000123'),
(124, 'Veracruz', 29, 1, '0000124'),
(125, 'San Andrés Tuxtla', 29, 1, '0000125'),
(126, 'Tuxpan', 29, 1, '0000126'),
(127, 'Cerritos', 23, 1, '0000127'),
(128, 'Calvillo', 1, 1, '0000128'),
(129, 'Cosío', 1, 1, '0000129'),
(130, 'Aguascalientes', 1, 1, '0000130'),
(131, 'Tepatitlán', 13, 1, '0000131'),
(132, 'Puebla', 20, 1, '0000132'),
(133, 'Quecholac', 20, 1, '0000133'),
(134, 'Tehuacán', 20, 1, '0000134'),
(135, 'Teziutlán', 20, 1, '0000135'),
(136, 'Tehuitzingo', 20, 1, '0000136'),
(137, 'Izucar de Matamoros', 20, 1, '0000137'),
(138, 'Atlixco', 20, 1, '0000138'),
(139, 'San Pedro Cholula', 20, 1, '0000139'),
(140, 'Pantepec', 20, 1, '0000140'),
(141, 'Libres', 20, 1, '0000141'),
(142, 'Xicotepec', 20, 1, '0000142'),
(143, 'Ajalpan', 20, 1, '0000143'),
(144, 'Cuernavaca', 16, 1, '0000144'),
(145, 'Cuautla', 16, 1, '0000145'),
(146, 'Ciudad del Maíz', 23, 1, '0000146'),
(147, 'Pátzcuaro', 15, 1, '0000147'),
(148, 'Tacámbaro', 15, 1, '0000148'),
(149, 'Huandacareo', 15, 1, '0000149'),
(150, 'Zinapécuaro', 15, 1, '0000150'),
(151, 'La Piedad', 15, 1, '0000151'),
(152, 'Acuitzio del Canje', 15, 1, '0000152'),
(153, 'Lázaro Cárdenas', 15, 1, '0000153'),
(154, 'Arteaga', 15, 1, '0000154'),
(155, 'Aquila', 15, 1, '0000155'),
(156, 'Coahuayana', 15, 1, '0000156'),
(157, 'Oaxaca de Juárez', 19, 1, '0000157'),
(158, 'Santa Cruz Xoxocotlán', 19, 1, '0000158'),
(159, 'Santa María Huatulco ', 19, 1, '0000159'),
(160, 'San Pablo Huitzo', 19, 1, '0000160'),
(161, 'Tecate', 2, 1, '0000161'),
(162, 'Loreto', 3, 1, '0000162'),
(163, 'Tapachula', 5, 1, '0000163'),
(164, 'Comitán de Dominguez', 5, 1, '0000164'),
(165, 'Zaragoza', 6, 1, '0000165'),
(166, 'Gómez Palacio ', 9, 1, '0000166'),
(167, 'Atlacomulco', 14, 1, '0000167'),
(168, 'Valle de Bravo', 14, 1, '0000168'),
(169, 'Ixtapan de la Sal', 14, 1, '0000169'),
(170, 'Temascaltepec', 14, 1, '0000170'),
(171, 'Naucalpan ', 14, 1, '0000171'),
(172, 'Temascalcingo', 14, 1, '0000172'),
(173, 'Chalco', 14, 1, '0000173'),
(174, 'Guanajuato', 10, 1, '0000174'),
(175, 'León ', 10, 1, '0000175'),
(176, 'Romita', 10, 1, '0000176'),
(177, 'El Arenal', 12, 1, '0000177'),
(178, 'Huichapan ', 12, 1, '0000178'),
(179, 'Ixmiquilpan', 12, 1, '0000179'),
(180, 'Molango', 12, 1, '0000180'),
(181, 'Pachuca', 12, 1, '0000181'),
(182, 'Pacula', 12, 1, '0000182'),
(183, 'Tasquillo', 12, 1, '0000183'),
(184, 'Tulancingo', 12, 1, '0000184'),
(185, 'Cuautepec de Hinojosa', 12, 1, '0000185'),
(186, 'Zapopan', 13, 1, '0000186'),
(187, 'Uruapan', 15, 1, '0000187'),
(188, 'Apatzingán', 15, 1, '0000188'),
(189, 'Zitácuaro', 15, 1, '0000189'),
(190, 'Acaponeta', 17, 1, '0000190'),
(191, 'Santa Catarina ', 18, 1, '0000191'),
(192, 'Acatlán de Osorio', 20, 1, '0000192'),
(193, 'Huejotzingo', 20, 1, '0000193'),
(194, 'Zacatlan', 20, 1, '0000194'),
(195, 'Zapotitlan', 20, 1, '0000195'),
(196, 'Oriental', 20, 1, '0000196'),
(197, 'Cadereyta', 21, 1, '0000197'),
(198, 'Benito Juárez', 22, 1, '0000198'),
(199, 'San Nicolás Tolentino', 23, 1, '0000199'),
(200, 'Mazatlán', 24, 1, '0000200'),
(201, 'Yauhquemecan', 28, 1, '0000201'),
(202, 'Valladolid', 30, 1, '0000202'),
(203, 'Sombrerete ', 31, 1, '0000203'),
(204, 'Villa de Cos', 31, 1, '0000204'),
(205, 'Acambay', 14, 1, '0000205'),
(206, 'Nezahualcóyotl', 14, 1, '0000206'),
(207, 'Tenango de Doria Hgo.', 12, 1, '0000207'),
(208, 'Huamantla', 28, 1, '0000208'),
(209, 'La paz', 3, 1, '0000209'),
(210, 'Escobedo', 18, 1, '0000210'),
(211, 'San Nicolas de los Garza', 18, 1, '0000211'),
(212, 'San Pedro Garza Garcia', 18, 1, '0000212'),
(213, 'Fresnillo', 31, 1, '0000213'),
(214, 'Santa Ana Chiautempan', 28, 1, '0000214'),
(215, 'San Agustín Tlaxiaca', 12, 1, '0000215'),
(216, 'Guadalupe', 31, 1, '0000216'),
(217, 'Acayucan', 29, 1, '0000217'),
(218, 'San Diego', 13, 1, '0000218'),
(219, 'Altepexi', 20, 1, '0000219'),
(220, 'Tlacotepec de Benito Juárez', 20, 1, '0000220'),
(221, 'Chiautla de Tapia', 20, 1, '0000221'),
(222, 'Allende', 7, 1, '0000222'),
(223, 'Tlajomulco de Zuñiga', 13, 1, '0000223'),
(224, 'Chapala', 13, 1, '0000224'),
(225, 'Tlaquepaque', 13, 1, '0000225'),
(226, 'Xalisco', 17, 1, '0000226'),
(227, 'Cd. Mante', 27, 1, '0000227'),
(228, 'Peto', 30, 1, '0000228'),
(229, 'San Juan del Río', 21, 1, '0000229'),
(230, 'Corregidora', 21, 1, '0000230'),
(231, 'Tierra Nueva', 23, 1, '0000231'),
(232, 'Ixtacuixtla de Mariano Matamoros', 28, 1, '0000232'),
(233, 'Ixtapaluca', 14, 1, '0000233'),
(234, 'Atotonilco el Grande', 12, 1, '0000234'),
(235, 'Tezontepec de Aldama', 12, 1, '0000235'),
(236, 'Huetamo', 15, 1, '0000236'),
(237, 'Vista Hermosa', 15, 1, '0000237'),
(238, 'Jacona', 15, 1, '0000238'),
(239, 'Emiliano Zapata', 16, 1, '0000239'),
(240, 'Tepoztlán', 16, 1, '0000240'),
(241, 'Yautepec', 16, 1, '0000241'),
(242, 'Jiutepec', 16, 1, '0000242'),
(243, 'San Luis Potosí', 23, 1, '0000243'),
(244, 'Tonalá', 13, 1, '0000244'),
(245, 'Valparaiso', 31, 1, '0000245'),
(246, 'Puruandiro', 15, 1, '0000246'),
(247, 'Temixco', 16, 1, '0000247'),
(248, 'Axochiapan', 16, 1, '0000248'),
(249, 'La Antigua', 29, 1, '0000249'),
(250, 'San Francisco Tetlanohcan', 28, 1, '0000250'),
(251, 'Nanacamilpa', 28, 1, '0000251'),
(252, 'Trinidad de Viguera', 19, 1, '0000252'),
(253, 'Los Cabos', 3, 1, '0000253'),
(254, 'Mulegé', 3, 1, '0000254'),
(255, 'Ascensión', 6, 1, '0000255'),
(256, 'Nuevo Casas Grandes', 6, 1, '0000256'),
(257, 'Maguarichi', 6, 1, '0000257'),
(258, 'Cihuatlán', 13, 1, '0000258'),
(259, 'La Huerta', 13, 1, '0000259'),
(260, 'Zihuatanejo de Azueta', 11, 1, '0000260'),
(261, 'Nogales', 25, 1, '0000261'),
(262, 'General Plutarco Elías Calles', 25, 1, '0000262'),
(263, 'Ciudad de México', 32, 1, '0000263'),
(264, 'Madero', 15, 1, '0000264'),
(265, 'Othón P. Blanco', 22, 1, '0000265'),
(266, 'Ahome', 24, 1, '0000266'),
(267, 'Medellín', 29, 1, '0000267'),
(268, 'Teotihuacán', 14, 1, '0000268'),
(269, 'Cihuatlán', 8, 1, '0000269'),
(270, 'La Huerta', 8, 1, '0000270'),
(271, 'Tlacotepec de Porfirio Díaz', 20, 1, '0000271'),
(272, 'Acuña-Piedras Negras-Saltillo', 7, 1, '0000272'),
(273, 'Acapulco- Zihuatanejo', 11, 1, '0000273'),
(274, 'Tuxtla Gutierrez- Chapa de Corzo', 5, 1, '0000274'),
(275, 'Durango- Gómez Palacio', 9, 1, '0000275'),
(276, 'La Paz- Los Cabos', 3, 1, '0000276'),
(277, 'Ixtlahuaca', 14, 1, '0000277'),
(278, 'Tenango del Valle', 14, 1, '0000278'),
(279, 'Nochistlan', 31, 1, '0000279'),
(280, 'Huejutla', 12, 1, '0000280'),
(281, 'Huejutla de Reyes', 12, 1, '0000281'),
(282, 'Pachuca de Soto', 12, 1, '0000282'),
(283, 'Mérida', 30, 1, '0000283'),
(284, 'Boca del Río', 29, 1, '0000284'),
(285, 'Chignautla', 20, 1, '0000285'),
(286, 'Tepeyahualco de Hidalgo', 20, 1, '0000286'),
(287, 'Ixmiquilpan Ayuntamiento', 12, 1, '0000287'),
(288, 'Sectur Hidalgo', 12, 1, '0000288'),
(289, 'Plaza Patria', 1, 1, '0000289'),
(290, 'Benito Juarez y Othon P. Blanco', 22, 1, '0000290'),
(291, 'Tamaulipas', 27, 1, '0000291'),
(292, 'SECTUR', 27, 1, '0000292'),
(293, 'Campeche', 4, 1, '0000293'),
(294, 'Ciudad del Carmen', 4, 1, '0000294'),
(295, 'Rafael Lara Grajales', 20, 1, '0000295'),
(296, 'Chalchicomula de sesma', 20, 1, '0000296'),
(297, 'Canatlan', 9, 1, '0000297'),
(298, 'Cuencamé', 9, 1, '0000298'),
(299, 'Taxco de Alarcón', 11, 1, '0000299'),
(300, 'Buenavista de Cuéllar', 11, 1, '0000300'),
(301, 'Huitzuco de los Figueroa', 11, 1, '0000301'),
(302, 'Iguala de la Independencia', 11, 1, '0000302'),
(303, 'Oxkutzcab', 30, 1, '0000303'),
(304, 'Santo Domingo Tonala', 19, 1, '0000304'),
(305, 'Juxtlahuaca', 19, 1, '0000305'),
(306, 'San Francisco Ozolotepec', 19, 1, '0000306'),
(307, 'Palomas', 6, 1, '0000307'),
(308, 'Maxcanú- Punto de Descanso', 30, 1, '0000308'),
(309, 'Cenotillo', 30, 1, '0000309'),
(310, 'Galeana', 18, 1, '0000310'),
(311, 'Ciudad Cuahutemoc', 5, 1, '0000311'),
(312, 'Cd. Hidalgo', 5, 1, '0000312'),
(313, 'Talisman', 5, 1, '0000313'),
(314, 'Chachapa', 20, 1, '0000314'),
(315, 'Ocoyoacac', 14, 1, '0000315'),
(316, 'Tejupilco', 14, 1, '0000316'),
(317, 'Muna', 30, 1, '0000317'),
(318, 'Halacho - Punto de descanso', 30, 1, '0000318'),
(319, 'Lerdo', 9, 1, '0000319'),
(320, 'Canatlán', 9, 1, '0000320'),
(321, 'Nuevo Ideal', 9, 1, '0000321'),
(322, 'Santiago Papasquiaro', 9, 1, '0000322'),
(323, 'Molcaxac', 20, 1, '0000323'),
(324, 'Cruce Vehicular Chactemal', 22, 1, '0000324'),
(325, 'Villanueva', 31, 1, '0000325'),
(326, 'San Juan Mixtepec', 19, 1, '0000326'),
(327, 'Escarcega', 4, 1, '0000327'),
(328, 'Hueyotlipan', 28, 1, '0000328'),
(329, 'Salamanca', 10, 1, '0000329'),
(330, 'Almoloya de Juárez', 14, 1, '0000330'),
(331, 'La Paz', 14, 1, '0000331'),
(332, 'Papantla', 29, 1, '0000332'),
(333, 'Tianguistenco', 14, 1, '0000333'),
(334, 'Cuitzeo', 15, 1, '0000334'),
(335, 'Mascota', 13, 1, '0000335'),
(336, 'Sabinas', 7, 1, '0000336'),
(337, 'San Salvador', 12, 1, '0000337'),
(338, 'Pachuca Sur', 12, 1, '0000338'),
(339, 'Tepeji del Rio', 12, 1, '0000339'),
(340, 'Pedro Escobedo', 21, 1, '0000340'),
(341, 'Palenque', 5, 1, '0000341'),
(342, 'Tulum', 22, 1, '0000342'),
(343, 'Alto Lucero', 29, 1, '0000343'),
(344, 'Melaque', 13, 1, '0000344'),
(345, 'Apulco', 31, 1, '0000345'),
(346, 'Villa Union, Poanas', 9, 1, '0000346'),
(347, 'Guadalupe Victoria', 9, 1, '0000347'),
(348, 'Pueblo Nuevo', 9, 1, '0000348'),
(349, 'tepehuanes', 9, 1, '0000349'),
(350, 'Vicente Guerrero', 9, 1, '0000350'),
(351, 'General Pánfilo Natera', 31, 1, '0000351'),
(352, 'Pinos', 31, 1, '0000352'),
(353, 'Apulco 1', 31, 1, '0000353'),
(354, 'COMISARIAS', 30, 1, '0000354'),
(355, 'TEYA', 30, 1, '0000355'),
(356, 'Huitzilac', 16, 1, '0000356'),
(357, 'Villa de Ayala', 16, 1, '0000357'),
(358, 'Guadalupe1', 31, 1, '0000358'),
(359, 'Zihuatlán', 13, 1, '0000359'),
(360, 'Acatic', 13, 1, '0000360'),
(361, 'Cihuatlan1', 13, 1, '0000361'),
(362, 'Cozumel', 22, 1, '0000362'),
(363, 'Solidaridad', 22, 1, '0000363'),
(364, 'Cienega', 19, 1, '0000364'),
(365, 'San Juan Teitipac', 19, 1, '0000365'),
(366, 'Santa Maria Zacatepec', 19, 1, '0000366'),
(367, 'Villa Ahumada', 6, 1, '0000367'),
(368, 'Puerto Peñasco', 25, 1, '0000368'),
(369, 'Sonora', 25, 1, '0000369'),
(370, 'Guaymas', 25, 1, '0000370'),
(371, 'Tuxtla Chico', 5, 1, '0000371'),
(372, 'Ocozocoautla', 5, 1, '0000372'),
(373, 'Nopala de Villagrán', 12, 1, '0000373'),
(374, 'Metepec', 12, 1, '0000374'),
(375, 'Tizayuca', 12, 1, '0000375'),
(376, 'San Felipe Orizatlán', 12, 1, '0000376'),
(377, 'San Agustín Tlaxiaca', 12, 1, '0000377'),
(378, 'Catemaco', 29, 1, '0000378'),
(379, 'San Juan Guelavia', 19, 1, '0000379'),
(380, 'San Francisco Del Rincón', 10, 1, '0000380'),
(381, 'San José de Gracia', 1, 1, '0000381'),
(382, 'Asientos', 1, 1, '0000382'),
(383, 'Jesús María', 1, 1, '0000383'),
(384, 'Chimalhuacán', 14, 1, '0000384'),
(385, 'Azcapotzalco', 32, 1, '0000385'),
(386, 'Coyoacán', 32, 1, '0000386'),
(387, 'Cuajimalpa de Morelos', 32, 1, '0000387'),
(388, 'Gustavo A. Madero', 32, 1, '0000388'),
(389, 'Iztacalco', 32, 1, '0000389'),
(390, 'Iztapalapa', 32, 1, '0000390'),
(391, 'La Magdalena Contreras', 32, 1, '0000391'),
(392, 'Milpa Alta', 32, 1, '0000392'),
(393, 'Álvaro Obregón', 32, 1, '0000393'),
(394, 'Tláhuac', 32, 1, '0000394'),
(395, 'Tlalpan', 32, 1, '0000395'),
(396, 'Xochimilco', 32, 1, '0000396'),
(397, 'Benito Juárez', 32, 1, '0000397'),
(398, 'Cuauhtémoc', 32, 1, '0000398'),
(399, 'Miguel Hidalgo', 32, 1, '0000399'),
(400, 'Venustiano Carranza', 32, 1, '0000400');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dependencia`
--

CREATE TABLE IF NOT EXISTS `dependencia` (
`id` int(11) NOT NULL,
  `dependencia` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL,
  `quien_aplica` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `dependencia`
--

INSERT INTO `dependencia` (`id`, `dependencia`, `activo`, `clave`, `quien_aplica`) VALUES
(1, 'AGA', 1, 'AGA', 2),
(2, 'Ángeles Verdes', 1, 'AV', 3),
(3, 'BANJERCITO', 1, 'BJ', 3),
(4, 'INM', 1, 'INM', 3),
(5, 'INE', 1, 'INE', 2),
(6, 'ISSSTE', 1, 'SSS', 2),
(7, 'Ministerios Públicos', 1, 'MPU', 3),
(8, 'PGR/PFM', 1, 'PP', 2),
(9, 'Policía Estatal', 1, 'PE', 3),
(10, 'Policía Municipal', 1, 'PM', 3),
(11, 'Policía Federal', 1, 'PF', 3),
(12, 'Policía Ministerial', 1, 'PFM', 1),
(13, 'Presidencias Municipales', 1, 'PM', 2),
(14, 'SAGARPA', 1, 'SGR', 2),
(15, 'Secretaría Local de Admon. y Finanzas', 1, 'SADMON', 1),
(16, 'SEDENA', 1, 'SEDENA', 3),
(17, 'SENASICA', 1, 'SENASICA', 1),
(18, 'Protección Consular', 1, 'PROCON', 2),
(19, 'Aduana de México', 1, 'AAD', 1),
(20, 'Consulados', 1, 'CSLD', 3),
(21, 'PGR ', 1, 'PGR', 1),
(22, 'OFAMS ', 1, 'OFAMS', 2),
(23, 'Otro', 1, 'OT', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dependencia_contactada`
--

CREATE TABLE IF NOT EXISTS `dependencia_contactada` (
`id` int(11) NOT NULL,
  `peticion_id` int(11) NOT NULL,
  `dependencia_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE IF NOT EXISTS `estado` (
`id` int(11) NOT NULL,
  `nombre_estado` varchar(255) NOT NULL,
  `pais_id` int(11) NOT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL,
  `gmt` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`id`, `nombre_estado`, `pais_id`, `activo`, `clave`, `gmt`) VALUES
(1, 'Aguascalientes', 1, 1, 'AS', '-6'),
(2, 'Baja California', 1, 1, 'BC', '-8'),
(3, 'Baja California Sur', 1, 1, 'BCS', '-7'),
(4, 'Campeche', 1, 1, 'CC', '-6'),
(5, 'Chiapas', 1, 1, 'CS', '-6'),
(6, 'Chihuahua', 1, 1, 'CH', '-7'),
(7, 'Coahuila', 1, 1, 'CL', '-6'),
(8, 'Colima', 1, 1, 'CM', '-6'),
(9, 'Durango', 1, 1, 'DG', '-6'),
(10, 'Guanajuato', 1, 1, 'GT', '-6'),
(11, 'Guerrero', 1, 1, 'GR', '-6'),
(12, 'Hidalgo', 1, 1, 'HG', '-6'),
(13, 'Jalisco', 1, 1, 'JC', '-6'),
(14, 'Estado de México', 1, 1, 'MC', '-6'),
(15, 'Michoacán', 1, 1, 'MN', '-6'),
(16, 'Morelos', 1, 1, 'MS', '-6'),
(17, 'Nayarit', 1, 1, 'NT', '-7'),
(18, 'Nuevo León', 1, 1, 'NL', '-6'),
(19, 'Oaxaca', 1, 1, 'OC', '-6'),
(20, 'Puebla', 1, 1, 'PL', '-6'),
(21, 'Querétaro', 1, 1, 'QT', '-6'),
(22, 'Quintana Roo', 1, 1, 'QR', '-5'),
(23, 'San Luis Potosí', 1, 1, 'SP', '-6'),
(24, 'Sinaloa', 1, 1, 'SL', '-7'),
(25, 'Sonora', 1, 1, 'SR', '-7'),
(26, 'Tabasco', 1, 1, 'TC', '-6'),
(27, 'Tamaulipas', 1, 1, 'TS', '-6'),
(28, 'Tlaxcala', 1, 1, 'TL', '-6'),
(29, 'Veracruz', 1, 1, 'VZ', '-6'),
(30, 'Yucatán', 1, 1, 'YN', '-6'),
(31, 'Zacatecas', 1, 1, 'ZS', '-6'),
(32, 'Ciudad de México', 1, 1, 'CDMX', '-6'),
(33, 'Alabama', 2, 1, 'AL', '-6'),
(34, 'Alaska', 2, 1, 'AK', '-10'),
(35, 'Arizona', 2, 1, 'AZ', '-7'),
(36, 'Arkansas', 2, 1, 'AR', '-6'),
(37, 'California', 2, 1, 'CA', '-8'),
(38, 'North Carolina', 2, 1, 'NC', '-5'),
(39, 'South Carolina', 2, 1, 'SC', '-5'),
(40, 'Colorado', 2, 1, 'CO', '-7'),
(41, 'Connecticut', 2, 1, 'CT', '-5'),
(42, 'North Dakota', 2, 1, 'ND', '-6'),
(43, 'South dakota', 2, 1, 'SD', '-6'),
(44, 'Delaware', 2, 1, 'DE', '-5'),
(45, 'Florida', 2, 1, 'FL', '-5'),
(46, 'Georgia', 2, 1, 'GA', '-5'),
(47, 'Hawai', 2, 1, 'HI', '-10'),
(48, 'Idaho', 2, 1, 'ID', '-8'),
(49, 'Illinois', 2, 1, 'IL', '-6'),
(50, 'Indiana', 2, 1, 'IN', '-5'),
(51, 'Iowa', 2, 1, 'IA', '-6'),
(52, 'Kansas', 2, 1, 'KS', '-6'),
(53, 'Kentucky', 2, 1, 'KY', '-6'),
(54, 'Luisiana', 2, 1, 'LA', '-6'),
(55, 'Maine', 2, 1, 'ME', '-5'),
(56, 'Maryland', 2, 1, 'MD', '-5'),
(57, 'Massachusetts', 2, 1, 'MA', '-5'),
(58, 'Michigan', 2, 1, 'MI', '-5'),
(59, 'Minnesota', 2, 1, 'MN', '-6'),
(60, 'Mississippi', 2, 1, 'MSS', '-6'),
(61, 'Missouri', 2, 1, 'MO', '-6'),
(62, 'Montana', 2, 1, 'MT', '-7'),
(63, 'Nebraska', 2, 1, 'NE', '-6'),
(64, 'Nevada', 2, 1, 'NV', '-7'),
(65, 'New jersey', 2, 1, 'NJ', '-5'),
(66, 'New york', 2, 1, 'NY', '-5'),
(67, 'New hampshire', 2, 1, 'NH', '-5'),
(68, 'New mexico', 2, 1, 'NM', '-7'),
(69, 'Ohio', 2, 1, 'OH', '-5'),
(70, 'Oklahoma', 2, 1, 'OK', '-6'),
(71, 'Oregon', 2, 1, 'OR', '-8'),
(72, 'Pennsylvania', 2, 1, 'PA', '-5'),
(73, 'Rhode Island', 2, 1, 'RI', '-5'),
(74, 'Tennessee', 2, 1, 'TN', '-6'),
(75, 'Texas', 2, 1, 'TX', '-6'),
(76, 'Utah', 2, 1, 'UT', '-7'),
(77, 'Vermont', 2, 1, 'VT', '-5'),
(78, 'Virginia', 2, 1, 'VA', '-5'),
(79, 'West virginia', 2, 1, 'WA', '-5'),
(80, 'Washington', 2, 1, 'WV', '-8'),
(81, 'Wisconsin', 2, 1, 'WI', '-6'),
(82, 'Wyoming', 2, 1, 'WY', '-7'),
(83, 'Ciudad de México DNPP', 1, 0, 'CDMXDNPP', '-6');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estatus_peticion`
--

CREATE TABLE IF NOT EXISTS `estatus_peticion` (
`id` int(11) NOT NULL,
  `estatus_peticion` varchar(255) DEFAULT NULL,
  `aquien_aplica` int(11) NOT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `estatus_peticion`
--

INSERT INTO `estatus_peticion` (`id`, `estatus_peticion`, `aquien_aplica`, `activo`, `clave`) VALUES
(1, 'Nueva', 3, 1, 'NVA'),
(2, 'Eliminada', 3, 1, 'DEL'),
(3, 'Concluida', 3, 1, 'CD'),
(4, 'Turnada a OIC', 3, 1, 'OIC'),
(5, 'Turnada a DNPP', 3, 1, 'DNPP'),
(6, 'Rechazada', 3, 1, 'RZ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estatus_usuario`
--

CREATE TABLE IF NOT EXISTS `estatus_usuario` (
`id` int(11) NOT NULL,
  `estatus` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `estatus_usuario`
--

INSERT INTO `estatus_usuario` (`id`, `estatus`, `activo`, `clave`) VALUES
(1, 'Activo', 1, 'A'),
(2, 'Inactivo', 1, 'I'),
(3, 'Eliminado', 1, 'E');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evidencia`
--

CREATE TABLE IF NOT EXISTS `evidencia` (
`id` int(11) NOT NULL,
  `nombre_arch` varchar(255) NOT NULL,
  `ruta_arch` varchar(255) NOT NULL,
  `fecha_carga` date NOT NULL,
  `fecha_modificacion` date DEFAULT NULL,
  `tipo_evidencia_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evidencia_peticion`
--

CREATE TABLE IF NOT EXISTS `evidencia_peticion` (
`id` int(11) NOT NULL,
  `peticion_id` int(11) NOT NULL,
  `evidencia_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evidencia_queja`
--

CREATE TABLE IF NOT EXISTS `evidencia_queja` (
`id` int(11) NOT NULL,
  `evidencia_id` int(11) NOT NULL,
  `queja_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `folio_operacion`
--

CREATE TABLE IF NOT EXISTS `folio_operacion` (
`id` int(11) NOT NULL,
  `operacion_id` int(11) NOT NULL,
  `numero_folio` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_estatus`
--

CREATE TABLE IF NOT EXISTS `historial_estatus` (
`id` int(11) NOT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL,
  `solicitud_id` int(11) NOT NULL,
  `cve_estatus` int(11) NOT NULL,
  `usuario_modifico_id` int(11) NOT NULL,
  `asignado` int(11) NOT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `asigno` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informacion_peticion`
--

CREATE TABLE IF NOT EXISTS `informacion_peticion` (
`id` int(11) NOT NULL,
  `solicitud` varchar(255) NOT NULL,
  `observaciones` varchar(255) NOT NULL,
  `solicitud_id` int(11) NOT NULL,
  `otra_dependencia` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informacion_queja`
--

CREATE TABLE IF NOT EXISTS `informacion_queja` (
`id` int(11) NOT NULL,
  `hechos` varchar(400) DEFAULT NULL,
  `testigos` varchar(255) DEFAULT NULL,
  `solicitud_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='	';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informacion_vehiculo`
--

CREATE TABLE IF NOT EXISTS `informacion_vehiculo` (
`id` int(11) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `placas` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `involucrado`
--

CREATE TABLE IF NOT EXISTS `involucrado` (
`id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `sexo_id` int(11) NOT NULL,
  `tez` varchar(255) DEFAULT NULL,
  `complexion` varchar(255) DEFAULT NULL,
  `color_ojos` varchar(255) DEFAULT NULL,
  `edad_aprox` int(11) DEFAULT NULL,
  `estatura_aprox` double DEFAULT NULL,
  `cargo` varchar(255) DEFAULT NULL,
  `dependencia_id` int(11) NOT NULL,
  `otra_dependencia` varchar(255) DEFAULT NULL,
  `num_identificacion` varchar(255) DEFAULT NULL,
  `uniforme` varchar(255) DEFAULT NULL,
  `senias_particulares` varchar(255) DEFAULT NULL,
  `tenia_vehiculo` varchar(255) NOT NULL,
  `informacion_vehiculo_id` int(11) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `involucrados_queja`
--

CREATE TABLE IF NOT EXISTS `involucrados_queja` (
`id` int(11) NOT NULL,
  `informacion_queja_id` int(11) NOT NULL,
  `involucrado_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medio_recepcion`
--

CREATE TABLE IF NOT EXISTS `medio_recepcion` (
`id` int(11) NOT NULL,
  `medio_recepcion` varchar(255) NOT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `medio_recepcion`
--

INSERT INTO `medio_recepcion` (`id`, `medio_recepcion`, `activo`, `clave`) VALUES
(1, 'Atención personal', 1, 'AP'),
(2, 'Correo electrónico', 1, 'CE'),
(3, 'Correo postal', 1, 'CP'),
(4, 'Llamada telefónica', 1, 'LT'),
(5, 'Redes sociales', 1, 'RS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo`
--

CREATE TABLE IF NOT EXISTS `modulo` (
`id` int(11) NOT NULL,
  `nombre_modulo` varchar(255) DEFAULT NULL,
  `descripcion_modulo` varchar(255) DEFAULT NULL,
  `estado_id` int(11) NOT NULL,
  `operativo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nivel_menu`
--

CREATE TABLE IF NOT EXISTS `nivel_menu` (
`id` int(11) NOT NULL,
  `nombre_nivel` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `nivel_menu`
--

INSERT INTO `nivel_menu` (`id`, `nombre_nivel`, `activo`, `clave`) VALUES
(1, 'Módulo', 1, 'M'),
(2, 'Submodulo', 1, 'S'),
(3, 'Operación', 1, 'O');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operacion`
--

CREATE TABLE IF NOT EXISTS `operacion` (
`id` int(11) NOT NULL,
  `nombre_operacion` varchar(255) NOT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `operacion`
--

INSERT INTO `operacion` (`id`, `nombre_operacion`, `activo`, `clave`) VALUES
(1, 'Queja', 1, 'Q'),
(2, 'Petición', 1, 'P'),
(3, 'Atención', 1, 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operativo`
--

CREATE TABLE IF NOT EXISTS `operativo` (
`id` int(11) NOT NULL,
  `fecha_inicial` date DEFAULT NULL,
  `fecha_final` varchar(255) DEFAULT NULL,
  `tipo_operativo_id` int(11) NOT NULL,
  `anio_operativo_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pais`
--

CREATE TABLE IF NOT EXISTS `pais` (
`id` int(11) NOT NULL,
  `nombre_pais` varchar(255) NOT NULL,
  `nacionalidad` varchar(255) NOT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=178 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pais`
--

INSERT INTO `pais` (`id`, `nombre_pais`, `nacionalidad`, `activo`, `clave`) VALUES
(1, 'México', 'mexicana', 1, 'MEX'),
(2, 'Estados Unidos', 'estadounidense', 1, 'USA'),
(3, 'Canadá', 'canadiense', 1, 'CAN'),
(4, 'Afganistán', 'Afgana', 1, 'AF'),
(5, 'Albania', 'Albanesa', 1, 'AL'),
(6, 'Alemania', 'Alemana', 1, 'DE'),
(7, 'Andorra', 'Andorrana', 1, 'AD'),
(8, 'Angola', 'Angoleña', 1, 'AO'),
(9, 'Antigua y Barbuda', 'antiguano', 1, 'AG'),
(10, 'Arabia Saudita', 'saudí', 1, 'SA'),
(11, 'Argelia', 'Argelina', 1, 'DZ'),
(12, 'Argentina', 'Argentina', 1, 'AR'),
(13, 'Armenia', 'Armenia ', 1, 'AM'),
(14, 'Aruba', 'arubeño', 1, 'AW'),
(15, 'Australia', 'Australiana', 1, 'AU'),
(16, 'Austria', 'Austriaca', 1, 'AT'),
(17, 'Azerbaiyán', 'azerbaiyazerí', 1, 'AZ'),
(18, 'Bahamas', 'Bahamesa', 1, 'BS'),
(19, 'Bahréin', 'Bahreina', 1, 'BH'),
(20, 'Bangladesh', 'Bangladesha', 1, 'BD'),
(21, 'Barbados', 'Barbadesa', 1, 'BB'),
(22, 'Bielorrusia', 'Bielorrusa', 1, 'BY'),
(23, 'Bélgica', 'Belga', 1, 'BE'),
(24, 'Belice', 'Beliceña', 1, 'BZ'),
(25, 'Benin', 'Beninés', 1, 'BJ'),
(26, 'Bermudas', 'Bermudesa', 1, 'BM'),
(27, 'Bhután', 'butanésa', 1, 'BT'),
(28, 'Bolivia', 'Boliviana', 1, 'BO'),
(29, 'Bosnia y Herzegovina', 'Bosnioherzegovina', 1, 'BA'),
(30, 'Botsuana', 'Botsuanesa', 1, 'BW'),
(31, 'Brasil', 'Brasileña', 1, 'BR'),
(32, 'Brunéi', 'Bruneana', 1, 'BN'),
(33, 'Bulgaria', 'Bulgara', 1, 'BG'),
(34, 'Burkina Faso', 'Burkinés', 1, 'BF'),
(35, 'Burundi', 'Burundesa', 1, 'BI'),
(36, 'Cabo Verde', 'caboverdiana', 1, 'CV'),
(37, 'Camboya', 'Camboyana', 1, 'KH'),
(38, 'Camerún', 'Camerunesa', 1, 'CM'),
(39, 'República Centroafricana', 'Centroafricana', 1, 'CF'),
(40, 'Chad', 'Chadeña', 1, 'TD'),
(41, 'República Checa', 'Checoslovaca', 1, 'CZ'),
(42, 'Chile', 'Chilena', 1, 'CL'),
(43, 'China', 'China', 1, 'CN'),
(44, 'Chipre', 'Chipriota', 1, 'CY'),
(45, 'Ciudad del Vaticano', 'vaticana', 1, 'VA'),
(46, 'Colombia', 'Colombiana', 1, 'CO'),
(47, 'Comoras', 'Comorense', 1, 'KM'),
(48, 'República Democrática del Congo', 'Congoleña', 1, 'CD'),
(49, 'Congo', 'Congoleña', 1, 'CG'),
(50, 'Corea del Norte', 'Norcoreana', 1, 'KP'),
(51, 'Corea del Sur', 'Surcoreana', 1, 'KR'),
(52, 'Costa de Marfil', 'Marfilesa', 1, 'CI'),
(53, 'Costa Rica', 'Costarricense', 1, 'CR'),
(54, 'Croacia', 'Croata', 1, 'HR'),
(55, 'Cuba', 'Cubana', 1, 'CU'),
(56, 'Dinamarca', 'Danes', 1, 'DK'),
(57, 'Dominica', 'Dominicana', 1, 'DM'),
(58, 'República Dominicana', 'Dominicana', 1, 'DO'),
(59, 'Ecuador', 'Ecuatoriana', 1, 'EC'),
(60, 'Egipto', 'Egipcia', 1, 'EG'),
(61, 'El Salvador', 'Salvadoreña', 1, 'SV'),
(62, 'Emiratos Árabes Unidos', 'Emirata', 1, 'AE'),
(63, 'Eritrea', 'Eritrea', 1, 'ER'),
(64, 'Eslovaquia', 'Eslovaca', 1, 'SK'),
(65, 'Eslovenia', 'Eslovena', 1, 'SI'),
(66, 'España', 'Española', 1, 'ES'),
(67, 'Estonia', 'Estona', 1, 'EE'),
(68, 'Etiopía', 'Etiope', 1, 'ET'),
(69, 'Filipinas', 'Filipina', 1, 'PH'),
(70, 'Finlandia', 'Finlandesa', 1, 'FI'),
(71, 'Fiyi', 'Fiyena', 1, 'FJ'),
(72, 'Francia', 'Francesa', 1, 'FR'),
(73, 'Gabón', 'Gabona', 1, 'GA'),
(74, 'Gambia', 'Gabiana', 1, 'GM'),
(75, 'Georgia', 'Georgiana', 1, 'GE'),
(76, 'Ghana', 'Ghanesa', 1, 'GH'),
(77, 'Granada', 'Granadeña', 1, 'GD'),
(78, 'Grecia', 'Griega', 1, 'GR'),
(79, 'Groenlandia', 'groenlandésa', 1, 'GL'),
(80, 'Guatemala', 'Guatemalteca', 1, 'GT'),
(81, 'Guinea', 'Guinesa', 1, 'GN'),
(82, 'Guinea Ecuatorial', 'Guinesa Ecuatoriana', 1, 'GQ'),
(83, 'Guyana', 'Guyanesa', 1, 'GY'),
(84, 'Haití', 'Haitiana', 1, 'HT'),
(85, 'Honduras', 'Hondureña', 1, 'HN'),
(86, 'Hong Kong', 'hongkonés', 1, 'HK'),
(87, 'Hungría', 'Hungara', 1, 'HU'),
(88, 'India', 'India', 1, 'IN'),
(89, 'Indonesia', 'Indonesa', 1, 'ID'),
(90, 'Irán', 'Irani', 1, 'IR'),
(91, 'Irak', 'Iraki', 1, 'IQ'),
(92, 'Irlanda', 'Irlandesa', 1, 'IE'),
(93, 'Islandia', 'Islandesa', 1, 'IS'),
(94, 'Israel', 'Israeli', 1, 'IL'),
(95, 'Italia', 'Italiana', 1, 'IT'),
(96, 'Jamaica', 'Jamaiquina', 1, 'JM'),
(97, 'Japón', 'Japonesa', 1, 'JP'),
(98, 'Jordania', 'Jordana', 1, 'JO'),
(99, 'Kazajstán', 'kazako', 1, 'KZ'),
(100, 'Kenia', 'Keniana', 1, 'KE'),
(101, 'Kirguistán', 'Kirguís ', 1, 'KG'),
(102, 'Kiribati', 'Kiribatiana', 1, 'KI'),
(103, 'Kuwait', 'Kuwaiti', 1, 'KW'),
(104, 'Laos', 'Laosiana', 1, 'LA'),
(105, 'Lesotho', 'Lesothensa', 1, 'LS'),
(106, 'Letonia', 'Letonesa', 1, 'LV'),
(107, 'Líbano', 'Libanesa', 1, 'LB'),
(108, 'Liberia', 'Liberiana', 1, 'LR'),
(109, 'Libia', 'Libeña', 1, 'LY'),
(110, 'Liechtenstein', 'Liechtenstein', 1, 'LI'),
(111, 'Lituania', 'Lituana', 1, 'LT'),
(112, 'Luxemburgo', 'Luxemburgo', 1, 'LU'),
(113, 'ARY Macedonia', 'Macedonio', 1, 'MK'),
(114, 'Madagascar', 'Madagascar', 1, 'MG'),
(115, 'Malasia', 'Malaca', 1, 'MY'),
(116, 'Malawi', 'Malawi', 1, 'MW'),
(117, 'Maldivas', 'Maldivas', 1, 'MV'),
(118, 'Malí', 'Malí', 1, 'ML'),
(119, 'Malta', 'Maltesa', 1, 'MT'),
(120, 'Marruecos', 'Marroqui', 1, 'MA'),
(121, 'Mauricio', 'Mauricio', 1, 'MU'),
(122, 'Mauritania', 'Mauritana', 1, 'MR'),
(123, 'Mónaco', 'Monaco', 1, 'MC'),
(124, 'Mongolia', 'Mongolesa', 1, 'MN'),
(125, 'Mozambique', 'Mozambiqueña', 1, 'MZ'),
(126, 'Myanmar', 'Myanma', 1, 'MM'),
(127, 'Namibia', 'Namibia', 1, 'NA'),
(128, 'Nauru', 'Nauru', 1, 'NR'),
(129, 'Nepal', 'Nepalesa', 1, 'NP'),
(130, 'Nicaragua', 'Nicaraguense', 1, 'NI'),
(131, 'Níger', 'Nigerana', 1, 'NE'),
(132, 'Nigeria', 'Nigeriana', 1, 'NG'),
(133, 'Noruega', 'Noruega', 1, 'NO'),
(134, 'Países Bajos', 'Holandesa', 1, 'NL'),
(135, 'Nueva Zelanda', 'Neozelandesa', 1, 'NZ'),
(136, 'Omán', 'Omana', 1, 'OM'),
(137, 'Pakistán', 'Pakistani', 1, 'PK'),
(138, 'Panamá', 'Panameña', 1, 'PA'),
(139, 'Paraguay', 'Paraguaya', 1, 'PY'),
(140, 'Perú', 'Peruana', 1, 'PE'),
(141, 'Polonia', 'Polaca', 1, 'PL'),
(142, 'Portugal', 'Portuguesa', 1, 'PT'),
(143, 'Puerto Rico', 'Portoriqueña', 1, 'PR'),
(144, 'Reino Unido', 'Britanica', 1, 'GB'),
(145, 'Ruanda', 'Ruanda', 1, 'RW'),
(146, 'Rumania', 'Rumana', 1, 'RO'),
(147, 'Rusia', 'Rusa', 1, 'RU'),
(148, 'Samoa', 'Samoana', 1, 'WS'),
(149, 'San Cristóbal y Nevis', 'Sancristobaleña', 1, 'KN'),
(150, 'San Marino', 'San marino', 1, 'SM'),
(151, 'Senegal', 'Senegalesa', 1, 'SN'),
(152, 'Singapur', 'Singapur', 1, 'SG'),
(153, 'Siria', 'Siria', 1, 'SY'),
(154, 'Somalia', 'Somalia', 1, 'SO'),
(155, 'Sri Lanka', 'Sri Lanka', 1, 'LK'),
(156, 'Suazilandia', 'Suazilandesa', 1, 'SZ'),
(157, 'Sudáfrica', 'Sudafricana', 1, 'ZA'),
(158, 'Sudán', 'Sudanesa', 1, 'SD'),
(159, 'Suecia', 'Sueca', 1, 'SE'),
(160, 'Suiza', 'Suiza', 1, 'CH'),
(161, 'Surinam', 'Surinamésa', 1, 'SR'),
(162, 'Tailandia', 'Tailandesa', 1, 'TH'),
(163, 'Tanzania', 'Tanzana', 1, 'TZ'),
(164, 'Tayikistán', 'Tayika', 1, 'TJ'),
(165, 'Tonga', 'Tonga', 1, 'TO'),
(166, 'Trinidad y Tobago', 'Trinidad y Tobago', 1, 'TT'),
(167, 'Túnez', 'Tunecina', 1, 'TN'),
(168, 'Turquía', 'Turca', 1, 'TR'),
(169, 'Ucrania', 'Ucraniana', 1, 'UA'),
(170, 'Uganda', 'Ugandesa', 1, 'UG'),
(171, 'Uruguay', 'Uruguaya', 1, 'UY'),
(172, 'Uzbekistán', 'Uzbeka', 1, 'UZ'),
(173, 'Venezuela', 'Venezolana', 1, 'VE'),
(174, 'Vietnam', 'Vietnamita', 1, 'VN'),
(175, 'Yemen', 'Yemen Rep Arabe', 1, 'YE'),
(176, 'Zambia', 'Zambiana', 1, 'ZM'),
(177, 'Zimbabue', 'Zimbabue', 1, 'ZW');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE IF NOT EXISTS `permiso` (
`id` int(11) NOT NULL,
  `accion_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `activo` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`id`, `accion_id`, `usuario_id`, `activo`) VALUES
(1, 1, 1, 1),
(2, 2, 1, 1),
(3, 3, 1, 1),
(4, 4, 1, 1),
(5, 5, 1, 1),
(6, 6, 1, 1),
(7, 7, 1, 1),
(8, 8, 1, 1),
(9, 9, 1, 1),
(10, 10, 1, 1),
(11, 11, 1, 1),
(12, 12, 1, 1),
(13, 13, 1, 1),
(14, 14, 1, 1),
(15, 15, 1, 1),
(16, 16, 1, 1),
(17, 17, 1, 1),
(18, 18, 1, 1),
(19, 19, 1, 1),
(20, 20, 1, 1),
(21, 21, 1, 1),
(22, 22, 1, 1),
(23, 23, 1, 1),
(24, 24, 1, 1),
(25, 25, 1, 1),
(26, 26, 1, 1),
(27, 27, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE IF NOT EXISTS `persona` (
`id` int(11) NOT NULL,
  `nombre_persona` varchar(255) DEFAULT NULL,
  `apellidos_persona` varchar(255) DEFAULT NULL,
  `sexo_id` int(11) DEFAULT NULL,
  `pais_origen_id` int(11) DEFAULT NULL,
  `estado_origen_id` int(11) DEFAULT NULL,
  `ciudad_origen_id` int(11) DEFAULT NULL,
  `estado_residencia_id` int(11) DEFAULT NULL,
  `ciudad_residencia_id` int(11) DEFAULT NULL,
  `telefono_persona` varchar(255) DEFAULT NULL,
  `correo_persona` varchar(255) DEFAULT NULL,
  `direccion_persona` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_usuario`
--

CREATE TABLE IF NOT EXISTS `rol_usuario` (
`id` int(11) NOT NULL,
  `rol` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rol_usuario`
--

INSERT INTO `rol_usuario` (`id`, `rol`, `activo`, `clave`) VALUES
(1, 'Dirección Nacional del Programa Paisano', 1, 'DIR'),
(2, 'Representante', 1, 'REP'),
(3, 'Enlace', 1, 'EST'),
(4, 'OIC', 1, 'OIC'),
(5, 'Administrador del Sistema', 1, 'ADM');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sexo`
--

CREATE TABLE IF NOT EXISTS `sexo` (
`id` int(11) NOT NULL,
  `sexo` varchar(255) NOT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sexo`
--

INSERT INTO `sexo` (`id`, `sexo`, `activo`, `clave`) VALUES
(1, 'Masculino', 1, 'M'),
(2, 'Femenino', 1, 'F');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud`
--

CREATE TABLE IF NOT EXISTS `solicitud` (
`id` int(11) NOT NULL,
  `tipo_registro_operacion_id` int(11) NOT NULL,
  `fecha_recepcion` date NOT NULL,
  `medio_recepcion_id` int(11) NOT NULL,
  `fecha_hechos` date NOT NULL,
  `pais_hechos_id` int(11) DEFAULT NULL,
  `estado_hechos_id` int(11) DEFAULT NULL,
  `ciudad_hechos_id` int(11) DEFAULT NULL,
  `causa` int(11) DEFAULT NULL,
  `otra_causa` varchar(45) DEFAULT NULL,
  `lugar_hechos` varchar(600) DEFAULT NULL,
  `anonimo` int(11) NOT NULL,
  `solicitante` int(11) DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  `folio_id` int(11) NOT NULL,
  `aplica_estado_id` int(11) NOT NULL,
  `monitoreable` varchar(255) DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tema`
--

CREATE TABLE IF NOT EXISTS `tema` (
`id` int(11) NOT NULL,
  `nombre_tema` varchar(255) NOT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tema`
--

INSERT INTO `tema` (`id`, `nombre_tema`, `activo`, `clave`) VALUES
(1, 'Agentes aduanales', 1, 'AD'),
(2, 'Devolución de permisos migratorios', 1, 'DEV'),
(3, 'Cancelación de permisos de autos', 1, 'CAN'),
(4, 'Doble nacionalidad', 1, 'DB'),
(5, 'Empleo', 1, 'EMP'),
(6, 'Franquicia', 1, 'FR'),
(7, 'Importación definitiva', 1, 'ID'),
(8, 'Importación temporal', 1, 'IT'),
(9, 'Mascotas', 1, 'MC'),
(10, 'Menajes', 1, 'MN'),
(11, 'Otros', 1, 'OT'),
(12, 'Que mercancias pueden ingresar a México y cuáles no', 1, 'QLL'),
(13, 'Información de consulados', 1, 'ICON'),
(14, 'Información de hoy no circula', 1, 'HNC'),
(15, 'Registro Civil', 1, 'RC'),
(16, 'Requisitos para la obtención de documentos de Identidad', 1, 'ODI'),
(17, 'Retorno seguro', 1, 'RT'),
(18, 'Salud-IMSS', 1, 'SI'),
(19, 'SAM', 1, 'SAM'),
(20, 'Traza tu ruta', 1, 'TR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `testigo`
--

CREATE TABLE IF NOT EXISTS `testigo` (
`id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `testigo_queja`
--

CREATE TABLE IF NOT EXISTS `testigo_queja` (
`id` int(11) NOT NULL,
  `informacion_queja_id` int(11) NOT NULL,
  `testigo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_atencion`
--

CREATE TABLE IF NOT EXISTS `tipo_atencion` (
`id` int(11) NOT NULL,
  `tipo_atencion` varchar(255) NOT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_atencion`
--

INSERT INTO `tipo_atencion` (`id`, `tipo_atencion`, `activo`, `clave`) VALUES
(1, 'Telefónica', 1, 'T'),
(2, 'correo electrónico', 1, 'C'),
(3, 'personal', 1, 'P'),
(4, 'Grupal', 1, 'G'),
(5, 'Telefónica transferida', 1, 'TT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_evidencia`
--

CREATE TABLE IF NOT EXISTS `tipo_evidencia` (
`id` int(11) NOT NULL,
  `tipo_evidencia` varchar(45) NOT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_evidencia`
--

INSERT INTO `tipo_evidencia` (`id`, `tipo_evidencia`, `activo`, `clave`) VALUES
(1, 'Evidencia documental Quejas', 1, 'ED'),
(2, 'Identificación Solicitante', 1, 'IS'),
(3, 'Persona a localizar', 1, 'PL'),
(4, 'Evidencia documental Peticiones', 1, 'ED');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_operativo`
--

CREATE TABLE IF NOT EXISTS `tipo_operativo` (
`id` int(11) NOT NULL,
  `nombre_operativo` varchar(255) NOT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
`id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `paterno` varchar(255) NOT NULL,
  `materno` varchar(255) NOT NULL,
  `sexo_id` int(11) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `usuario_cuenta` varchar(255) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `estatus_id` int(11) NOT NULL,
  `fecha_registro` date NOT NULL,
  `rol_usuario_id` int(11) NOT NULL,
  `donde_representante_o_enlace_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` VALUES (1,'Administrador','del','sistema',1,'1991-09-20','rromero@externos.inami.gob.mx','adminIntranet','162039eabdbb6b9393cd3a1e19870c2b',1,'2016-09-09',5,83),
(2,'Allan','Hernández','Pardo',1,'2001-10-12','sdfsdf@fghjk','apardo','c0040ca7730ec746819b0f81e4b843e6',1,'2016-10-12',5,83),
(3,'Yasmin','Serna','Ruiz',2,'2001-10-12','uno@inami.gob.mx','yserna','22c46e113ae4e7d51b7769aa3dcfd1d5',1,'2016-10-12',1,83),
(4,'Zuleyka','Melo','Barajas',2,'1983-01-06','zuley@jsjsjs','zmelob','215a265f779bf3a75e1b926110508193',1,'2016-10-13',1,83),
(5,'Veronica','Cruz','Vilchis',2,'1983-02-10','vero@inami','vcruzv','587906454ae98c4c592697bc0b56b3d5',1,'2016-10-13',1,83),
(6,'Anel','Sanchez','Sanchez',2,'1987-04-16','anel@inami','asanchez','9405d3b8601c57ec2bc687a418432fe9',1,'2016-10-13',1,83),
(7,'Alan','Rodriguez','Rodriguez',1,'1983-10-06','alan@inami','arodriguez','7bdd78d56656e4c55eb4c3a1eb1e9b80',1,'2016-10-13',1,83),
(8,'Alexa','Flores','Flores',2,'1975-07-13','alexa@inami','aflores','49bfa5ce41c6323683b9bcddd8ca882c',1,'2016-10-13',1,83),
(9,'Enlace','Prueba','Prueba',2,'1983-09-28','jimena@inami','EnlacePrueba','c4a3c65481fa95d251c5d3c34c901986',1,'2016-10-13',3,1),
(10,'Eduardo','Diaz','Diaz',1,'1988-06-13','edu@inami','EduRepresent','d71ab4f9c9642080d63a67e57f74d6dc',3,'2016-10-13',2,49),
(11,'Representante','Prueba','prueba',2,'2001-10-04','kjk@uno.com','ReprPrueba','cd45e025f2a78a1649f6deab7dd49fa1',1,'2016-10-13',2,49),
(12,'Eduardo','Gutierrez','Hernández',1,'2001-10-13','egutierrezh@inami.gob.mx','egutierrez','ce0285bfce3cf48127cfa51a118332c0',1,'2016-10-13',1,83),
(13,'Eduardo','martinez','hernandez',1,'1988-06-13','','edulalo','0b2bd8606abf38181199c59da77a3d24',1,'2016-10-19',5,83),
(14,'Maribel','Ishizu','Espinoza',2,'0000-00-00','','mishizu','ce4443230d0904dcef87b5ade5ab26dd',1,'2016-10-19',5,83),
(15,'Aideé','Medina','Ayala',2,'0000-00-00','','amedina','da4d5f6ddeaf0440f126175cd9d9ad20',1,'2016-10-21',5,83);



--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accion`
--
ALTER TABLE `accion`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_accion_nivel_menu1_idx` (`nivel_menu_id`);

--
-- Indices de la tabla `accion_por_rol`
--
ALTER TABLE `accion_por_rol`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_accione_por_rol_accion1_idx` (`accion_id`), ADD KEY `fk_accione_por_rol_rol_usuario1_idx` (`rol_usuario_id`);

--
-- Indices de la tabla `actualizacion`
--
ALTER TABLE `actualizacion`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_actualizacion_usuario1_idx` (`usuario_id`), ADD KEY `fk_actualizacion_folio_operacion1_idx` (`folio_operacion_id`);

--
-- Indices de la tabla `anio_operativo`
--
ALTER TABLE `anio_operativo`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `atencion_enlace`
--
ALTER TABLE `atencion_enlace`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_atenciones_enlaces_modulos1_idx` (`modulo_id`), ADD KEY `fk_atenciones_enlaces_usuarios1_idx` (`usuario_id`), ADD KEY `fk_atencion_enlace_folio_operacion1_idx` (`folio_id`);

--
-- Indices de la tabla `atencion_representante`
--
ALTER TABLE `atencion_representante`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_atenciones_personas_atendidas1_idx` (`persona_id`), ADD KEY `fk_atenciones_usuarios1_idx` (`usuario_id`), ADD KEY `fk_atenciones_cat_temas1_idx` (`tema_id`), ADD KEY `fk_atenciones_cat_tipo_atenciones1_idx` (`tipo_atencion_representante_id`), ADD KEY `fk_atenciones_folios_operaciones1_idx` (`folio_id`), ADD KEY `fk_atencion_representante_estado1_idx` (`aplica_estado_id`), ADD KEY `fk_atencion_representante_estatus_peticion1_idx` (`estatus_peticion_id`);

--
-- Indices de la tabla `causa`
--
ALTER TABLE `causa`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ciudad`
--
ALTER TABLE `ciudad`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_ciudades_estados1_idx` (`estado_id`);

--
-- Indices de la tabla `dependencia`
--
ALTER TABLE `dependencia`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `dependencia_contactada`
--
ALTER TABLE `dependencia_contactada`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_dependencias_contactadas_informacion_peticiones1_idx` (`peticion_id`), ADD KEY `fk_dependencias_contactadas_cat_dependencias1_idx` (`dependencia_id`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_estados_paises1_idx` (`pais_id`);

--
-- Indices de la tabla `estatus_peticion`
--
ALTER TABLE `estatus_peticion`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estatus_usuario`
--
ALTER TABLE `estatus_usuario`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `evidencia`
--
ALTER TABLE `evidencia`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_evidencias_cat_tipo_evidencias1_idx` (`tipo_evidencia_id`);

--
-- Indices de la tabla `evidencia_peticion`
--
ALTER TABLE `evidencia_peticion`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_informacion_evidencias_peticiones_informacion_peticiones_idx` (`peticion_id`), ADD KEY `fk_informacion_evidencias_peticiones_evidencias1_idx` (`evidencia_id`);

--
-- Indices de la tabla `evidencia_queja`
--
ALTER TABLE `evidencia_queja`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_evidencias_quejas_evidencias1_idx` (`evidencia_id`), ADD KEY `fk_evidencias_quejas_informacion_quejas1_idx` (`queja_id`);

--
-- Indices de la tabla `folio_operacion`
--
ALTER TABLE `folio_operacion`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_folios_operaciones_cat_operacion1_idx` (`operacion_id`);

--
-- Indices de la tabla `historial_estatus`
--
ALTER TABLE `historial_estatus`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_historial_estatus_peticiones1_idx` (`solicitud_id`), ADD KEY `fk_historial_estatus_cat_estatus_peticiones1_idx` (`cve_estatus`), ADD KEY `fk_historial_estatus_usuarios1_idx` (`usuario_modifico_id`), ADD KEY `fk_historial_estatus_cat_roles_usuario1_idx` (`asignado`), ADD KEY `fk_historial_estatus_rol_usuario1_idx` (`asigno`);

--
-- Indices de la tabla `informacion_peticion`
--
ALTER TABLE `informacion_peticion`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_informacion_peticion_solicitud1_idx` (`solicitud_id`);

--
-- Indices de la tabla `informacion_queja`
--
ALTER TABLE `informacion_queja`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_informacion_queja_solicitud1_idx` (`solicitud_id`);

--
-- Indices de la tabla `informacion_vehiculo`
--
ALTER TABLE `informacion_vehiculo`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `involucrado`
--
ALTER TABLE `involucrado`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_involucrado_sexo1_idx` (`sexo_id`), ADD KEY `fk_involucrado_informacion_vehiculo1_idx` (`informacion_vehiculo_id`), ADD KEY `fk_involucrado_dependencia1_idx` (`dependencia_id`);

--
-- Indices de la tabla `involucrados_queja`
--
ALTER TABLE `involucrados_queja`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_involucrados_queja_informacion_queja1_idx` (`informacion_queja_id`), ADD KEY `fk_involucrados_queja_involucrado1_idx` (`involucrado_id`);

--
-- Indices de la tabla `medio_recepcion`
--
ALTER TABLE `medio_recepcion`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `modulo`
--
ALTER TABLE `modulo`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_Modulos_estados1_idx` (`estado_id`), ADD KEY `fk_Modulos_operativos1_idx` (`operativo_id`);

--
-- Indices de la tabla `nivel_menu`
--
ALTER TABLE `nivel_menu`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `operacion`
--
ALTER TABLE `operacion`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `operativo`
--
ALTER TABLE `operativo`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_operativos_tipos_operativos1_idx` (`tipo_operativo_id`), ADD KEY `fk_operativos_anio_operativos1_idx` (`anio_operativo_id`), ADD KEY `fk_operativos_usuarios1_idx` (`usuario_id`);

--
-- Indices de la tabla `pais`
--
ALTER TABLE `pais`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_permiso_table11_idx` (`accion_id`), ADD KEY `fk_permiso_usuario1_idx` (`usuario_id`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_personas_atendidas_paises1_idx` (`pais_origen_id`), ADD KEY `fk_personas_atendidas_estados1_idx` (`estado_origen_id`), ADD KEY `fk_personas_atendidas_ciudades1_idx` (`ciudad_origen_id`), ADD KEY `fk_personas_atendidas_estados2_idx` (`estado_residencia_id`), ADD KEY `fk_personas_atendidas_ciudades2_idx` (`ciudad_residencia_id`), ADD KEY `fk_personas_cat_sexos1_idx` (`sexo_id`);

--
-- Indices de la tabla `rol_usuario`
--
ALTER TABLE `rol_usuario`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sexo`
--
ALTER TABLE `sexo`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `solicitud`
--
ALTER TABLE `solicitud`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_peticiones_ciudades1_idx` (`ciudad_hechos_id`), ADD KEY `fk_peticiones_paises1_idx` (`pais_hechos_id`), ADD KEY `fk_peticiones_estados1_idx` (`estado_hechos_id`), ADD KEY `fk_peticiones_personas1_idx` (`solicitante`), ADD KEY `fk_peticiones_cat_causa1_idx` (`causa`), ADD KEY `fk_peticiones_usuarios1_idx` (`usuario_id`), ADD KEY `fk_peticiones_cat_medio0_recepciones1_idx` (`medio_recepcion_id`), ADD KEY `fk_solicitudes_folios_operaciones1_idx` (`folio_id`), ADD KEY `fk_solicitud_operacion1_idx` (`tipo_registro_operacion_id`), ADD KEY `fk_solicitud_estado1_idx` (`aplica_estado_id`), ADD KEY `solicitus_monitoreable` (`monitoreable`);

--
-- Indices de la tabla `tema`
--
ALTER TABLE `tema`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `testigo`
--
ALTER TABLE `testigo`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `testigo_queja`
--
ALTER TABLE `testigo_queja`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_testigo_queja_informacion_queja1_idx` (`informacion_queja_id`), ADD KEY `fk_testigo_queja_testigo1_idx` (`testigo_id`);

--
-- Indices de la tabla `tipo_atencion`
--
ALTER TABLE `tipo_atencion`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_evidencia`
--
ALTER TABLE `tipo_evidencia`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_operativo`
--
ALTER TABLE `tipo_operativo`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_usuarios_cat_roles_usuario1_idx` (`rol_usuario_id`), ADD KEY `fk_usuarios_cat_sexos1_idx` (`sexo_id`), ADD KEY `fk_usuarios_estados2_idx` (`donde_representante_o_enlace_id`), ADD KEY `fk_usuario_estatus_usuario1_idx` (`estatus_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accion`
--
ALTER TABLE `accion`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT de la tabla `accion_por_rol`
--
ALTER TABLE `accion_por_rol`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=80;
--
-- AUTO_INCREMENT de la tabla `actualizacion`
--
ALTER TABLE `actualizacion`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `anio_operativo`
--
ALTER TABLE `anio_operativo`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `atencion_enlace`
--
ALTER TABLE `atencion_enlace`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `atencion_representante`
--
ALTER TABLE `atencion_representante`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `causa`
--
ALTER TABLE `causa`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT de la tabla `ciudad`
--
ALTER TABLE `ciudad`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=401;
--
-- AUTO_INCREMENT de la tabla `dependencia`
--
ALTER TABLE `dependencia`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT de la tabla `dependencia_contactada`
--
ALTER TABLE `dependencia_contactada`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=84;
--
-- AUTO_INCREMENT de la tabla `estatus_peticion`
--
ALTER TABLE `estatus_peticion`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `estatus_usuario`
--
ALTER TABLE `estatus_usuario`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `evidencia`
--
ALTER TABLE `evidencia`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `evidencia_peticion`
--
ALTER TABLE `evidencia_peticion`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `evidencia_queja`
--
ALTER TABLE `evidencia_queja`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `folio_operacion`
--
ALTER TABLE `folio_operacion`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `historial_estatus`
--
ALTER TABLE `historial_estatus`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `informacion_peticion`
--
ALTER TABLE `informacion_peticion`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `informacion_queja`
--
ALTER TABLE `informacion_queja`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `informacion_vehiculo`
--
ALTER TABLE `informacion_vehiculo`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `involucrado`
--
ALTER TABLE `involucrado`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `involucrados_queja`
--
ALTER TABLE `involucrados_queja`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `medio_recepcion`
--
ALTER TABLE `medio_recepcion`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `modulo`
--
ALTER TABLE `modulo`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `nivel_menu`
--
ALTER TABLE `nivel_menu`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `operacion`
--
ALTER TABLE `operacion`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `operativo`
--
ALTER TABLE `operativo`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `pais`
--
ALTER TABLE `pais`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=178;
--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `rol_usuario`
--
ALTER TABLE `rol_usuario`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `sexo`
--
ALTER TABLE `sexo`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `solicitud`
--
ALTER TABLE `solicitud`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tema`
--
ALTER TABLE `tema`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT de la tabla `testigo`
--
ALTER TABLE `testigo`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `testigo_queja`
--
ALTER TABLE `testigo_queja`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tipo_atencion`
--
ALTER TABLE `tipo_atencion`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `tipo_evidencia`
--
ALTER TABLE `tipo_evidencia`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `tipo_operativo`
--
ALTER TABLE `tipo_operativo`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `accion`
--
ALTER TABLE `accion`
ADD CONSTRAINT `fk_accion_nivel_menu1` FOREIGN KEY (`nivel_menu_id`) REFERENCES `nivel_menu` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `accion_por_rol`
--
ALTER TABLE `accion_por_rol`
ADD CONSTRAINT `fk_accione_por_rol_accion1` FOREIGN KEY (`accion_id`) REFERENCES `accion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_accione_por_rol_rol_usuario1` FOREIGN KEY (`rol_usuario_id`) REFERENCES `rol_usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `actualizacion`
--
ALTER TABLE `actualizacion`
ADD CONSTRAINT `fk_actualizacion_folio_operacion1` FOREIGN KEY (`folio_operacion_id`) REFERENCES `folio_operacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_actualizacion_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `atencion_enlace`
--
ALTER TABLE `atencion_enlace`
ADD CONSTRAINT `fk_atencion_enlace_folio_operacion1` FOREIGN KEY (`folio_id`) REFERENCES `folio_operacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_atenciones_enlaces_modulos1` FOREIGN KEY (`modulo_id`) REFERENCES `modulo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_atenciones_enlaces_usuarios1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `atencion_representante`
--
ALTER TABLE `atencion_representante`
ADD CONSTRAINT `fk_atencion_representante_estado1` FOREIGN KEY (`aplica_estado_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_atencion_representante_estatus_peticion1` FOREIGN KEY (`estatus_peticion_id`) REFERENCES `estatus_peticion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_atenciones_cat_temas1` FOREIGN KEY (`tema_id`) REFERENCES `tema` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_atenciones_cat_tipo_atenciones1` FOREIGN KEY (`tipo_atencion_representante_id`) REFERENCES `tipo_atencion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_atenciones_folios_operaciones1` FOREIGN KEY (`folio_id`) REFERENCES `folio_operacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_atenciones_personas_atendidas1` FOREIGN KEY (`persona_id`) REFERENCES `persona` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_atenciones_usuarios1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ciudad`
--
ALTER TABLE `ciudad`
ADD CONSTRAINT `fk_ciudades_estados1` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dependencia_contactada`
--
ALTER TABLE `dependencia_contactada`
ADD CONSTRAINT `fk_dependencias_contactadas_cat_dependencias1` FOREIGN KEY (`dependencia_id`) REFERENCES `dependencia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_dependencias_contactadas_informacion_peticiones1` FOREIGN KEY (`peticion_id`) REFERENCES `informacion_peticion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `estado`
--
ALTER TABLE `estado`
ADD CONSTRAINT `fk_estados_paises1` FOREIGN KEY (`pais_id`) REFERENCES `pais` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `evidencia`
--
ALTER TABLE `evidencia`
ADD CONSTRAINT `fk_evidencias_cat_tipo_evidencias1` FOREIGN KEY (`tipo_evidencia_id`) REFERENCES `tipo_evidencia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `evidencia_peticion`
--
ALTER TABLE `evidencia_peticion`
ADD CONSTRAINT `fk_informacion_evidencias_peticiones_evidencias1` FOREIGN KEY (`evidencia_id`) REFERENCES `evidencia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_informacion_evidencias_peticiones_informacion_peticiones1` FOREIGN KEY (`peticion_id`) REFERENCES `informacion_peticion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `evidencia_queja`
--
ALTER TABLE `evidencia_queja`
ADD CONSTRAINT `fk_evidencias_quejas_evidencias1` FOREIGN KEY (`evidencia_id`) REFERENCES `evidencia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_evidencias_quejas_informacion_quejas1` FOREIGN KEY (`queja_id`) REFERENCES `informacion_queja` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `folio_operacion`
--
ALTER TABLE `folio_operacion`
ADD CONSTRAINT `fk_folios_operaciones_cat_operacion1` FOREIGN KEY (`operacion_id`) REFERENCES `operacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `historial_estatus`
--
ALTER TABLE `historial_estatus`
ADD CONSTRAINT `fk_historial_estatus_cat_estatus_peticiones1` FOREIGN KEY (`cve_estatus`) REFERENCES `estatus_peticion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_historial_estatus_cat_roles_usuario1` FOREIGN KEY (`asignado`) REFERENCES `rol_usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_historial_estatus_peticiones1` FOREIGN KEY (`solicitud_id`) REFERENCES `solicitud` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_historial_estatus_rol_usuario1` FOREIGN KEY (`asigno`) REFERENCES `rol_usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_historial_estatus_usuarios1` FOREIGN KEY (`usuario_modifico_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `informacion_peticion`
--
ALTER TABLE `informacion_peticion`
ADD CONSTRAINT `fk_informacion_peticion_solicitud1` FOREIGN KEY (`solicitud_id`) REFERENCES `solicitud` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `informacion_queja`
--
ALTER TABLE `informacion_queja`
ADD CONSTRAINT `fk_informacion_queja_solicitud1` FOREIGN KEY (`solicitud_id`) REFERENCES `solicitud` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `involucrado`
--
ALTER TABLE `involucrado`
ADD CONSTRAINT `fk_involucrado_dependencia1` FOREIGN KEY (`dependencia_id`) REFERENCES `dependencia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_involucrado_informacion_vehiculo1` FOREIGN KEY (`informacion_vehiculo_id`) REFERENCES `informacion_vehiculo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_involucrado_sexo1` FOREIGN KEY (`sexo_id`) REFERENCES `sexo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `involucrados_queja`
--
ALTER TABLE `involucrados_queja`
ADD CONSTRAINT `fk_involucrados_queja_informacion_queja1` FOREIGN KEY (`informacion_queja_id`) REFERENCES `informacion_queja` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_involucrados_queja_involucrado1` FOREIGN KEY (`involucrado_id`) REFERENCES `involucrado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `modulo`
--
ALTER TABLE `modulo`
ADD CONSTRAINT `fk_Modulos_estados1` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_Modulos_operativos1` FOREIGN KEY (`operativo_id`) REFERENCES `operativo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `operativo`
--
ALTER TABLE `operativo`
ADD CONSTRAINT `fk_operativos_anio_operativos1` FOREIGN KEY (`anio_operativo_id`) REFERENCES `anio_operativo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_operativos_tipos_operativos1` FOREIGN KEY (`tipo_operativo_id`) REFERENCES `tipo_operativo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_operativos_usuarios1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `permiso`
--
ALTER TABLE `permiso`
ADD CONSTRAINT `fk_permiso_table11` FOREIGN KEY (`accion_id`) REFERENCES `accion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_permiso_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `persona`
--
ALTER TABLE `persona`
ADD CONSTRAINT `fk_personas_atendidas_ciudades1` FOREIGN KEY (`ciudad_origen_id`) REFERENCES `ciudad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_personas_atendidas_ciudades2` FOREIGN KEY (`ciudad_residencia_id`) REFERENCES `ciudad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_personas_atendidas_estados1` FOREIGN KEY (`estado_origen_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_personas_atendidas_estados2` FOREIGN KEY (`estado_residencia_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_personas_atendidas_paises1` FOREIGN KEY (`pais_origen_id`) REFERENCES `pais` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_personas_cat_sexos1` FOREIGN KEY (`sexo_id`) REFERENCES `sexo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `solicitud`
--
ALTER TABLE `solicitud`
ADD CONSTRAINT `fk_peticiones_cat_causa1` FOREIGN KEY (`causa`) REFERENCES `causa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_peticiones_cat_medio0_recepciones1` FOREIGN KEY (`medio_recepcion_id`) REFERENCES `medio_recepcion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_peticiones_ciudades1` FOREIGN KEY (`ciudad_hechos_id`) REFERENCES `ciudad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_peticiones_estados1` FOREIGN KEY (`estado_hechos_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_peticiones_paises1` FOREIGN KEY (`pais_hechos_id`) REFERENCES `pais` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_peticiones_personas1` FOREIGN KEY (`solicitante`) REFERENCES `persona` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_peticiones_usuarios1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_solicitud_estado1` FOREIGN KEY (`aplica_estado_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_solicitud_operacion1` FOREIGN KEY (`tipo_registro_operacion_id`) REFERENCES `operacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_solicitudes_folios_operaciones1` FOREIGN KEY (`folio_id`) REFERENCES `folio_operacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `testigo_queja`
--
ALTER TABLE `testigo_queja`
ADD CONSTRAINT `fk_testigo_queja_informacion_queja1` FOREIGN KEY (`informacion_queja_id`) REFERENCES `informacion_queja` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_testigo_queja_testigo1` FOREIGN KEY (`testigo_id`) REFERENCES `testigo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
ADD CONSTRAINT `fk_usuario_estatus_usuario1` FOREIGN KEY (`estatus_id`) REFERENCES `estatus_usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_usuarios_cat_roles_usuario1` FOREIGN KEY (`rol_usuario_id`) REFERENCES `rol_usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_usuarios_cat_sexos1` FOREIGN KEY (`sexo_id`) REFERENCES `sexo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_usuarios_estados2` FOREIGN KEY (`donde_representante_o_enlace_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
