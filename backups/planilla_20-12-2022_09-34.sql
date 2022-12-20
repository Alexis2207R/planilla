-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 20-12-2022 a las 15:34:04
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `planilla`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `prdListarCondicion` ()   BEGIN
SELECT *, '' AS acciones
FROM condicion_laboral cl
WHERE cl.estado_condicion="1";
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `prdListarPerfiles` ()   BEGIN
SELECT *, '' AS acciones, '' AS modulos
FROM perfil p
WHERE p.estadoperfil = 1 OR p.estadoperfil=2;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `prdListarRemuneracion` ()   BEGIN
SELECT *, '' AS acciones
FROM nivel_remunerativo nr
WHERE nr.estado_nivel="1";
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `prdListarUsuarios` ()   BEGIN

SELECT *, '' AS acciones
FROM usuario u
INNER JOIN perfil p
ON p.id_perfil=u.idperfil_usuario
WHERE u.estado=1 OR u.estado=2;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ano`
--

CREATE TABLE `ano` (
  `id_year` int(11) NOT NULL,
  `nombre_year` int(5) NOT NULL,
  `estado_year` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ano`
--

INSERT INTO `ano` (`id_year`, `nombre_year`, `estado_year`) VALUES
(6, 2019, 1),
(7, 2020, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivos`
--

CREATE TABLE `archivos` (
  `id_archivo` int(11) NOT NULL,
  `nombre_archivo` text DEFAULT NULL,
  `creacion_archivo` datetime DEFAULT NULL,
  `ruta_archivo` text DEFAULT NULL,
  `fecha_archivo` date DEFAULT NULL,
  `estado_archivo` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `archivos`
--

INSERT INTO `archivos` (`id_archivo`, `nombre_archivo`, `creacion_archivo`, `ruta_archivo`, `fecha_archivo`, `estado_archivo`) VALUES
(1, 'FOTO1', '2022-12-14 18:04:32', '20221214/1671059072_f3f0352d1c7e964daef2.png', '2022-12-14', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bonificacion`
--

CREATE TABLE `bonificacion` (
  `id_bonificacion` int(11) NOT NULL,
  `id_tipo_bonificacion` int(11) NOT NULL,
  `nombre_bonificacion` varchar(200) NOT NULL,
  `cantidad_bonificacion` int(11) NOT NULL,
  `estado_bonificacion` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `bonificacion`
--

INSERT INTO `bonificacion` (`id_bonificacion`, `id_tipo_bonificacion`, `nombre_bonificacion`, `cantidad_bonificacion`, `estado_bonificacion`) VALUES
(13, 2, 'AGUINALDO', 130, 1),
(14, 3, 'DECRETO URGENCIA', 230, 1),
(15, 4, 'DECRETO SUPREMO', 231, 1),
(16, 3, 'DECRETO LEY', 321, 1),
(17, 4, 'EXTRA TRABAJO', 90, 1),
(18, 3, 'OTROS', 50, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

CREATE TABLE `cargo` (
  `id_cargo` int(11) NOT NULL,
  `nombre_cargo` varchar(200) NOT NULL,
  `estado_cargo` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cargo`
--

INSERT INTO `cargo` (`id_cargo`, `nombre_cargo`, `estado_cargo`) VALUES
(2, 'NOMBRADOS', 2),
(3, 'CONTRATADOS', 2),
(4, 'DIRECTOR', 1),
(5, 'AUDITOR', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `condicion_laboral`
--

CREATE TABLE `condicion_laboral` (
  `id_condicion` int(11) NOT NULL,
  `condicion` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `creacion_condicion` datetime NOT NULL,
  `estado_condicion` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `condicion_laboral`
--

INSERT INTO `condicion_laboral` (`id_condicion`, `condicion`, `creacion_condicion`, `estado_condicion`) VALUES
(31, 'GENERAL', '2022-12-09 13:38:58', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `pais` varchar(255) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `razon_social` varchar(255) DEFAULT NULL,
  `ruc` varchar(25) DEFAULT NULL,
  `registro_empresarial` varchar(255) DEFAULT NULL,
  `ciudad` varchar(255) DEFAULT NULL,
  `estado_confi` int(11) NOT NULL DEFAULT 1,
  `logo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `nombre`, `direccion`, `pais`, `telefono`, `razon_social`, `ruc`, `registro_empresarial`, `ciudad`, `estado_confi`, `logo`) VALUES
(1, 'HOTEL EDEN', 'DIRECCION EXACTA', 'MÃ©xico', '+52 1 953 114 9', 'NULL', '0038947384786', 'NULL', 'Mexico', 1, '122321_1.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descuentos`
--

CREATE TABLE `descuentos` (
  `id_descuento` int(11) NOT NULL,
  `id_tipo_descuento` int(11) NOT NULL,
  `nombre_descuento` varchar(200) NOT NULL,
  `cantidad_descuento` int(11) NOT NULL,
  `estado_descuento` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `descuentos`
--

INSERT INTO `descuentos` (`id_descuento`, `id_tipo_descuento`, `nombre_descuento`, `cantidad_descuento`, `estado_descuento`) VALUES
(8, 3, 'AFP', 100, 1),
(9, 4, 'ESSALUD', 210, 1),
(10, 5, 'BANCOS', 200, 1),
(11, 3, 'SEGUROS', 110, 1),
(12, 4, 'SNP', 80, 1),
(13, 1, 'OTROS', 60, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mes`
--

CREATE TABLE `mes` (
  `id_mes` int(11) NOT NULL,
  `nombre_mes` varchar(70) NOT NULL,
  `dias` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `mes`
--

INSERT INTO `mes` (`id_mes`, `nombre_mes`, `dias`) VALUES
(1, 'ENERO', 30),
(2, 'FEBRERO', 30),
(3, 'MARZO', 30),
(4, 'ABRIL', 30),
(5, 'MAYO', 30),
(6, 'JUNIO', 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo`
--

CREATE TABLE `modulo` (
  `id_modulo` int(11) NOT NULL,
  `nombremodulo` varchar(100) DEFAULT NULL,
  `urlmodulo` varchar(100) DEFAULT NULL,
  `idmodulopadre` int(11) DEFAULT NULL,
  `iconomodulo` varchar(100) DEFAULT NULL,
  `estadomodulo` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `modulo`
--

INSERT INTO `modulo` (`id_modulo`, `nombremodulo`, `urlmodulo`, `idmodulopadre`, `iconomodulo`, `estadomodulo`) VALUES
(1, 'Planilla', NULL, 1, '<i class=\"nav-icon far fa-calendar-alt\"></i>', 1),
(2, 'Personal', NULL, NULL, '<i class=\"nav-icon fas fa-sign-in-alt\"></i>', 1),
(3, 'Mantenimiento', NULL, NULL, '<i class=\"nav-icon fas fa-hand-holding-usd\"></i>', 1),
(4, 'Reportes', NULL, NULL, '<i class=\"nav-icon fas fa-file-alt\"></i>', 1),
(5, 'Seguridad', NULL, NULL, '<i class=\"nav-icon fas fa-user-shield\"></i>', 1),
(7, 'Remuneración', '/remuneracion', 2, NULL, 1),
(8, 'Condición Laboral', '/condiciones', 3, NULL, 1),
(10, 'Perfiles', '/perfil', 5, NULL, 1),
(11, 'Configuración', '/configuracion', 5, NULL, 1),
(12, 'Respaldo BD', '/respaldo', 5, NULL, 1),
(13, 'Tipo Bonificación', '/tipoBonificacion', 3, NULL, 1),
(14, 'Usuarios', '/usuario', 5, NULL, 1),
(35, 'Bonificaciones', '/bonificaciones', 3, NULL, 1),
(36, 'Descuentos', '/descuentos', 3, NULL, 1),
(37, 'Años', '/years', 3, NULL, 1),
(38, 'Tipo planilla', '/tipoPlanillas', 3, NULL, 1),
(39, 'Nivel remunerativo', '/nivelremunerativo', 3, NULL, 1),
(40, 'Planillas', '/planillas', 2, NULL, 1),
(41, 'Personal', '/personales', 2, NULL, 1),
(42, 'Cargos', '/cargos', 3, NULL, 1),
(43, 'Tipo Descuento', '/tipodescuentos', 3, NULL, 1),
(44, 'Pagos', '/pagos', 2, NULL, 1),
(45, 'Por persona', '/porPersonas', 4, NULL, 1),
(46, 'Régimen Pensional', '/regimenes', 3, NULL, 1),
(47, 'Archivos', '/archivos', 4, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nivel_remunerativo`
--

CREATE TABLE `nivel_remunerativo` (
  `id_remuneracion` int(11) NOT NULL,
  `nivel` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado_nivel` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `nivel_remunerativo`
--

INSERT INTO `nivel_remunerativo` (`id_remuneracion`, `nivel`, `fecha_registro`, `estado_nivel`) VALUES
(1, 'STA', '2022-10-09 14:20:06', 1),
(2, 'STB', '2022-10-09 14:20:15', 1),
(3, 'SPC', '2022-12-10 15:23:33', 1),
(4, 'STC', '2022-10-09 14:20:45', 1),
(5, 'F-1', '2022-10-09 14:21:01', 1),
(6, 'SPA', '2022-10-09 14:21:22', 1),
(7, 'F-4', '2022-10-09 14:21:37', 1),
(8, 'F-3', '2022-10-09 14:21:50', 1),
(9, 'STD', '2022-10-09 14:21:59', 1),
(10, 'F-2', '2022-10-09 14:22:13', 1),
(11, 'SN', '2022-10-09 14:23:17', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id_pago` int(11) NOT NULL,
  `id_personal` int(11) NOT NULL,
  `id_planilla` int(11) NOT NULL,
  `id_mes` int(11) NOT NULL,
  `total_ingreso` decimal(18,3) DEFAULT NULL,
  `total_egreso` decimal(18,3) DEFAULT NULL,
  `total_neto` decimal(18,3) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `estado_pago` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id_pago`, `id_personal`, `id_planilla`, `id_mes`, `total_ingreso`, `total_egreso`, `total_neto`, `fecha_creacion`, `estado_pago`) VALUES
(16, 5, 19, 1, '797.000', '100.000', '697.000', '2022-12-17 16:11:13', 1),
(17, 5, 18, 6, '44.000', '87.000', '-43.000', '2022-12-19 22:05:43', 1),
(18, 5, 16, 2, '56.000', '116.000', '-60.000', '2022-12-19 22:26:41', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago_bonificacion`
--

CREATE TABLE `pago_bonificacion` (
  `id_pago_bonificacion` int(11) NOT NULL,
  `id_pago` int(11) NOT NULL,
  `id_bonificacion` int(11) NOT NULL,
  `cantidad_pago_bonificacion` decimal(18,3) NOT NULL,
  `estado_pago_bonificacion` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pago_bonificacion`
--

INSERT INTO `pago_bonificacion` (`id_pago_bonificacion`, `id_pago`, `id_bonificacion`, `cantidad_pago_bonificacion`, `estado_pago_bonificacion`) VALUES
(7, 16, 13, '452.000', 1),
(8, 16, 17, '345.000', 1),
(9, 17, 15, '12.000', 0),
(10, 17, 17, '32.000', 0),
(11, 18, 14, '32.000', 0),
(12, 18, 16, '24.000', 0),
(13, 18, 14, '32.000', 1),
(14, 18, 16, '24.000', 1),
(15, 17, 15, '12.000', 1),
(16, 17, 17, '32.000', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago_descuento`
--

CREATE TABLE `pago_descuento` (
  `id_pago_descuento` int(11) NOT NULL,
  `id_pago` int(11) NOT NULL,
  `id_descuento` int(11) NOT NULL,
  `cantidad_pago_descuento` decimal(18,3) NOT NULL,
  `estado_pago_descuento` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pago_descuento`
--

INSERT INTO `pago_descuento` (`id_pago_descuento`, `id_pago`, `id_descuento`, `cantidad_pago_descuento`, `estado_pago_descuento`) VALUES
(4, 16, 11, '100.000', 1),
(5, 17, 12, '42.000', 0),
(6, 17, 13, '45.000', 0),
(7, 18, 13, '65.000', 0),
(8, 18, 13, '65.000', 1),
(9, 18, 9, '51.000', 1),
(10, 17, 12, '42.000', 1),
(11, 17, 13, '45.000', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `id_perfil` int(11) NOT NULL,
  `nombreperfil` varchar(100) DEFAULT NULL,
  `estadoperfil` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`id_perfil`, `nombreperfil`, `estadoperfil`) VALUES
(1, 'ADMINISTRADOR', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `id_permiso` int(11) NOT NULL,
  `idperfilpermiso` int(11) DEFAULT NULL,
  `idmodulo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`id_permiso`, `idperfilpermiso`, `idmodulo`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(10, 1, 10),
(11, 1, 11),
(12, 1, 12),
(18, 1, 14),
(19, 1, 35),
(20, 1, 36),
(21, 1, 37),
(22, 1, 38),
(23, 1, 39),
(24, 1, 40),
(25, 1, 41),
(26, 1, 8),
(27, 1, 42),
(28, 1, 13),
(29, 1, 43),
(30, 1, 44),
(31, 1, 45),
(32, 1, 46),
(33, 1, 47);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE `personal` (
  `id_personal` int(11) NOT NULL,
  `id_cargo` int(11) NOT NULL,
  `nombre_personal` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `apellido_personal` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `dni_personal` varchar(8) COLLATE utf8_spanish_ci DEFAULT NULL,
  `sexo_personal` char(1) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ubicacion_dpt` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ubicacion_prov` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ubicacion_dist` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion_personal` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nro_cuenta` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_regimen` int(11) NOT NULL,
  `id_remuneracion` int(11) NOT NULL,
  `id_condicion` int(11) NOT NULL,
  `dias_horas` decimal(18,1) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT NULL,
  `fecha_actualizacion` datetime DEFAULT NULL,
  `estado_personal` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`id_personal`, `id_cargo`, `nombre_personal`, `apellido_personal`, `dni_personal`, `sexo_personal`, `ubicacion_dpt`, `ubicacion_prov`, `ubicacion_dist`, `direccion_personal`, `nro_cuenta`, `id_regimen`, `id_remuneracion`, `id_condicion`, `dias_horas`, `fecha_registro`, `fecha_actualizacion`, `estado_personal`) VALUES
(5, 4, 'HERLYN CARLOS', 'PAZ VASQUEZ', '71700578', 'M', 'SAN MARTIN', 'RIOJA', 'PARDO MIGUEL', 'JR. FRANCISCO PIZARRO 968', '7742345543', 1, 2, 31, '30.0', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_planilla`
--

CREATE TABLE `personal_planilla` (
  `id_personal_planilla` int(11) NOT NULL,
  `id_personal` int(11) NOT NULL,
  `id_planilla` int(11) NOT NULL,
  `estado_personal_planilla` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planilla`
--

CREATE TABLE `planilla` (
  `id_planilla` int(11) NOT NULL,
  `id_tipo_planilla` int(11) NOT NULL,
  `id_year` int(11) NOT NULL,
  `numero_planilla` varchar(200) NOT NULL,
  `fecha_creacion_planilla` datetime DEFAULT NULL,
  `estado_planilla` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `planilla`
--

INSERT INTO `planilla` (`id_planilla`, `id_tipo_planilla`, `id_year`, `numero_planilla`, `fecha_creacion_planilla`, `estado_planilla`) VALUES
(9, 2, 6, '0875', NULL, 0),
(10, 4, 7, '6234', NULL, 0),
(11, 2, 6, '6342', NULL, 0),
(12, 5, 7, '6135', NULL, 0),
(13, 5, 6, '1564', NULL, 0),
(14, 5, 7, '8731', NULL, 0),
(15, 5, 7, '45345', '2022-12-11 08:30:28', 0),
(16, 2, 7, '123', '2022-12-12 00:34:53', 1),
(17, 2, 6, '421', '2022-12-12 00:35:48', 1),
(18, 5, 7, '654', '2022-12-12 00:38:16', 1),
(19, 4, 7, '985', '2022-12-17 10:33:42', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planilla_bonificacion`
--

CREATE TABLE `planilla_bonificacion` (
  `id_planilla_bonificacion` int(11) NOT NULL,
  `id_planilla` int(11) NOT NULL,
  `id_bonificacion` int(11) NOT NULL,
  `estado_planilla_bonificacion` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planilla_descuento`
--

CREATE TABLE `planilla_descuento` (
  `id_planilla_descuento` int(11) NOT NULL,
  `id_planilla` int(11) NOT NULL,
  `id_descuento` int(11) NOT NULL,
  `estado_planilla_descuento` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `regimen_pensional`
--

CREATE TABLE `regimen_pensional` (
  `id_regimen` int(11) NOT NULL,
  `nombre_regimen` varchar(100) DEFAULT NULL,
  `creacion_regimen` datetime DEFAULT NULL,
  `estado_regimen` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `regimen_pensional`
--

INSERT INTO `regimen_pensional` (`id_regimen`, `nombre_regimen`, `creacion_regimen`, `estado_regimen`) VALUES
(1, 'REGIMEN1', '2022-12-11 15:52:22', 1),
(2, 'REGIMEN2', NULL, 1),
(3, 'REGIMEN3', NULL, 0),
(4, 'REGIMEN4', '2022-12-14 17:03:05', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_bonificacion`
--

CREATE TABLE `tipo_bonificacion` (
  `id_tipo_bonificacion` int(11) NOT NULL,
  `nombre_tipo_bonificacion` varchar(200) NOT NULL,
  `estado_tipo_bonificacion` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_bonificacion`
--

INSERT INTO `tipo_bonificacion` (`id_tipo_bonificacion`, `nombre_tipo_bonificacion`, `estado_tipo_bonificacion`) VALUES
(1, 'BON1', 0),
(2, 'BON2', 1),
(3, 'BON3', 1),
(4, 'BON7', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_descuento`
--

CREATE TABLE `tipo_descuento` (
  `id_tipo_descuento` int(11) NOT NULL,
  `nombre_tipo_descuento` varchar(200) NOT NULL,
  `estado_tipo_descuento` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_descuento`
--

INSERT INTO `tipo_descuento` (`id_tipo_descuento`, `nombre_tipo_descuento`, `estado_tipo_descuento`) VALUES
(1, 'TDESC1', 1),
(2, 'TDESC20', 0),
(3, 'TDESC3', 1),
(4, 'TDESC4', 1),
(5, 'TDESC6', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_planilla`
--

CREATE TABLE `tipo_planilla` (
  `id_tipo_planilla` int(11) NOT NULL,
  `nombre_tipo_planilla` varchar(200) NOT NULL,
  `estado_tipo_planilla` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_planilla`
--

INSERT INTO `tipo_planilla` (`id_tipo_planilla`, `nombre_tipo_planilla`, `estado_tipo_planilla`) VALUES
(1, 'PLANILLA1', 2),
(2, 'OBREROS', 1),
(3, 'PLANILLA3', 2),
(4, 'NOMBRADOS', 1),
(5, 'CONTRATADOS', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `clave` varchar(100) DEFAULT NULL,
  `estado` char(1) DEFAULT '1',
  `dni` char(8) DEFAULT NULL,
  `telefono` varchar(16) DEFAULT NULL,
  `idperfil_usuario` int(11) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `estado_clave` int(11) NOT NULL DEFAULT 0,
  `fecha_clave` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `apellido`, `usuario`, `clave`, `estado`, `dni`, `telefono`, `idperfil_usuario`, `correo`, `direccion`, `estado_clave`, `fecha_clave`) VALUES
(7, 'GERARDO ALEXIS', 'RUIZ SANDOVAL', '76151674', '$2a$07$asxx54ahjppf45sd87a5aua5eRVf56/8V1YAqTOXmeTrW6EU.D5MK', '1', '76151674', NULL, 1, NULL, NULL, 0, NULL),
(8, 'JHON', 'ARISTA ALARCON', '76554593', '$2a$07$asxx54ahjppf45sd87a5au8yqMHgnx2DR9LpknQy5BimagwAsXpWu', '1', '76554593', NULL, 1, NULL, NULL, 0, NULL),
(9, 'HERLYN CARLOS', 'PAZ VASQUEZ', '71700578', '$2a$07$asxx54ahjppf45sd87a5auBy4nG8JPmqIL0BG8QSCJgUvGuuigtVy', '1', '71700578', NULL, 1, NULL, NULL, 0, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ano`
--
ALTER TABLE `ano`
  ADD PRIMARY KEY (`id_year`);

--
-- Indices de la tabla `archivos`
--
ALTER TABLE `archivos`
  ADD PRIMARY KEY (`id_archivo`);

--
-- Indices de la tabla `bonificacion`
--
ALTER TABLE `bonificacion`
  ADD PRIMARY KEY (`id_bonificacion`),
  ADD KEY `id_tipo_bonificacion` (`id_tipo_bonificacion`);

--
-- Indices de la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id_cargo`);

--
-- Indices de la tabla `condicion_laboral`
--
ALTER TABLE `condicion_laboral`
  ADD PRIMARY KEY (`id_condicion`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `descuentos`
--
ALTER TABLE `descuentos`
  ADD PRIMARY KEY (`id_descuento`),
  ADD KEY `id_tipo_descuento` (`id_tipo_descuento`) USING BTREE;

--
-- Indices de la tabla `mes`
--
ALTER TABLE `mes`
  ADD PRIMARY KEY (`id_mes`);

--
-- Indices de la tabla `modulo`
--
ALTER TABLE `modulo`
  ADD PRIMARY KEY (`id_modulo`),
  ADD KEY `idmodulopadre` (`idmodulopadre`);

--
-- Indices de la tabla `nivel_remunerativo`
--
ALTER TABLE `nivel_remunerativo`
  ADD PRIMARY KEY (`id_remuneracion`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id_pago`),
  ADD KEY `id_planilla` (`id_planilla`),
  ADD KEY `id_personal` (`id_personal`),
  ADD KEY `id_mes` (`id_mes`);

--
-- Indices de la tabla `pago_bonificacion`
--
ALTER TABLE `pago_bonificacion`
  ADD PRIMARY KEY (`id_pago_bonificacion`),
  ADD KEY `id_bonificacion` (`id_bonificacion`),
  ADD KEY `id_pago` (`id_pago`);

--
-- Indices de la tabla `pago_descuento`
--
ALTER TABLE `pago_descuento`
  ADD PRIMARY KEY (`id_pago_descuento`),
  ADD KEY `id_descuento` (`id_descuento`),
  ADD KEY `id_pago` (`id_pago`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id_perfil`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`id_permiso`),
  ADD KEY `fk_permiso_perfil` (`idperfilpermiso`),
  ADD KEY `permiso_idmodulo` (`idmodulo`) USING BTREE;

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`id_personal`),
  ADD KEY `id_cargo` (`id_cargo`) USING BTREE,
  ADD KEY `id_regimen` (`id_regimen`),
  ADD KEY `id_remuneracion` (`id_remuneracion`),
  ADD KEY `id_condicion` (`id_condicion`);

--
-- Indices de la tabla `personal_planilla`
--
ALTER TABLE `personal_planilla`
  ADD PRIMARY KEY (`id_personal_planilla`),
  ADD UNIQUE KEY `id_personal` (`id_personal`,`id_planilla`),
  ADD KEY `id_planilla` (`id_planilla`);

--
-- Indices de la tabla `planilla`
--
ALTER TABLE `planilla`
  ADD PRIMARY KEY (`id_planilla`),
  ADD KEY `id_tipo_planilla` (`id_tipo_planilla`) USING BTREE,
  ADD KEY `id_year` (`id_year`);

--
-- Indices de la tabla `planilla_bonificacion`
--
ALTER TABLE `planilla_bonificacion`
  ADD PRIMARY KEY (`id_planilla_bonificacion`),
  ADD KEY `id_planilla` (`id_planilla`),
  ADD KEY `id_bonificacion` (`id_bonificacion`);

--
-- Indices de la tabla `planilla_descuento`
--
ALTER TABLE `planilla_descuento`
  ADD PRIMARY KEY (`id_planilla_descuento`),
  ADD KEY `id_planilla` (`id_planilla`),
  ADD KEY `id_descuento` (`id_descuento`);

--
-- Indices de la tabla `regimen_pensional`
--
ALTER TABLE `regimen_pensional`
  ADD PRIMARY KEY (`id_regimen`);

--
-- Indices de la tabla `tipo_bonificacion`
--
ALTER TABLE `tipo_bonificacion`
  ADD PRIMARY KEY (`id_tipo_bonificacion`);

--
-- Indices de la tabla `tipo_descuento`
--
ALTER TABLE `tipo_descuento`
  ADD PRIMARY KEY (`id_tipo_descuento`);

--
-- Indices de la tabla `tipo_planilla`
--
ALTER TABLE `tipo_planilla`
  ADD PRIMARY KEY (`id_tipo_planilla`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`) USING BTREE,
  ADD KEY `id_perfil` (`idperfil_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ano`
--
ALTER TABLE `ano`
  MODIFY `id_year` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `archivos`
--
ALTER TABLE `archivos`
  MODIFY `id_archivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `bonificacion`
--
ALTER TABLE `bonificacion`
  MODIFY `id_bonificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id_cargo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `condicion_laboral`
--
ALTER TABLE `condicion_laboral`
  MODIFY `id_condicion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `descuentos`
--
ALTER TABLE `descuentos`
  MODIFY `id_descuento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `mes`
--
ALTER TABLE `mes`
  MODIFY `id_mes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `modulo`
--
ALTER TABLE `modulo`
  MODIFY `id_modulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `nivel_remunerativo`
--
ALTER TABLE `nivel_remunerativo`
  MODIFY `id_remuneracion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `pago_bonificacion`
--
ALTER TABLE `pago_bonificacion`
  MODIFY `id_pago_bonificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `pago_descuento`
--
ALTER TABLE `pago_descuento`
  MODIFY `id_pago_descuento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id_perfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `id_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `id_personal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `personal_planilla`
--
ALTER TABLE `personal_planilla`
  MODIFY `id_personal_planilla` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `planilla`
--
ALTER TABLE `planilla`
  MODIFY `id_planilla` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `planilla_bonificacion`
--
ALTER TABLE `planilla_bonificacion`
  MODIFY `id_planilla_bonificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `planilla_descuento`
--
ALTER TABLE `planilla_descuento`
  MODIFY `id_planilla_descuento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `regimen_pensional`
--
ALTER TABLE `regimen_pensional`
  MODIFY `id_regimen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipo_bonificacion`
--
ALTER TABLE `tipo_bonificacion`
  MODIFY `id_tipo_bonificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipo_descuento`
--
ALTER TABLE `tipo_descuento`
  MODIFY `id_tipo_descuento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipo_planilla`
--
ALTER TABLE `tipo_planilla`
  MODIFY `id_tipo_planilla` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bonificacion`
--
ALTER TABLE `bonificacion`
  ADD CONSTRAINT `bonificacion_ibfk_1` FOREIGN KEY (`id_tipo_bonificacion`) REFERENCES `tipo_bonificacion` (`id_tipo_bonificacion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `descuentos`
--
ALTER TABLE `descuentos`
  ADD CONSTRAINT `descuentos_ibfk_1` FOREIGN KEY (`id_tipo_descuento`) REFERENCES `tipo_descuento` (`id_tipo_descuento`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `modulo`
--
ALTER TABLE `modulo`
  ADD CONSTRAINT `modulo_ibfk_1` FOREIGN KEY (`idmodulopadre`) REFERENCES `modulo` (`id_modulo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`id_planilla`) REFERENCES `planilla` (`id_planilla`),
  ADD CONSTRAINT `pagos_ibfk_2` FOREIGN KEY (`id_personal`) REFERENCES `personal` (`id_personal`),
  ADD CONSTRAINT `pagos_ibfk_4` FOREIGN KEY (`id_mes`) REFERENCES `mes` (`id_mes`);

--
-- Filtros para la tabla `pago_bonificacion`
--
ALTER TABLE `pago_bonificacion`
  ADD CONSTRAINT `pago_bonificacion_ibfk_1` FOREIGN KEY (`id_bonificacion`) REFERENCES `bonificacion` (`id_bonificacion`),
  ADD CONSTRAINT `pago_bonificacion_ibfk_2` FOREIGN KEY (`id_pago`) REFERENCES `pagos` (`id_pago`);

--
-- Filtros para la tabla `pago_descuento`
--
ALTER TABLE `pago_descuento`
  ADD CONSTRAINT `pago_descuento_ibfk_1` FOREIGN KEY (`id_descuento`) REFERENCES `descuentos` (`id_descuento`),
  ADD CONSTRAINT `pago_descuento_ibfk_2` FOREIGN KEY (`id_pago`) REFERENCES `pagos` (`id_pago`);

--
-- Filtros para la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD CONSTRAINT `permiso_ibfk_1` FOREIGN KEY (`idperfilpermiso`) REFERENCES `perfil` (`id_perfil`) ON UPDATE CASCADE,
  ADD CONSTRAINT `permiso_ibfk_2` FOREIGN KEY (`idmodulo`) REFERENCES `modulo` (`id_modulo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `personal`
--
ALTER TABLE `personal`
  ADD CONSTRAINT `personal_ibfk_1` FOREIGN KEY (`id_cargo`) REFERENCES `cargo` (`id_cargo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `personal_ibfk_2` FOREIGN KEY (`id_regimen`) REFERENCES `regimen_pensional` (`id_regimen`),
  ADD CONSTRAINT `personal_ibfk_3` FOREIGN KEY (`id_remuneracion`) REFERENCES `nivel_remunerativo` (`id_remuneracion`),
  ADD CONSTRAINT `personal_ibfk_4` FOREIGN KEY (`id_condicion`) REFERENCES `condicion_laboral` (`id_condicion`);

--
-- Filtros para la tabla `personal_planilla`
--
ALTER TABLE `personal_planilla`
  ADD CONSTRAINT `personal_planilla_ibfk_1` FOREIGN KEY (`id_personal`) REFERENCES `personal` (`id_personal`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `personal_planilla_ibfk_3` FOREIGN KEY (`id_planilla`) REFERENCES `planilla` (`id_planilla`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `planilla`
--
ALTER TABLE `planilla`
  ADD CONSTRAINT `planilla_ibfk_1` FOREIGN KEY (`id_tipo_planilla`) REFERENCES `tipo_planilla` (`id_tipo_planilla`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `planilla_ibfk_3` FOREIGN KEY (`id_year`) REFERENCES `ano` (`id_year`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `planilla_ibfk_4` FOREIGN KEY (`id_year`) REFERENCES `ano` (`id_year`);

--
-- Filtros para la tabla `planilla_bonificacion`
--
ALTER TABLE `planilla_bonificacion`
  ADD CONSTRAINT `planilla_bonificacion_ibfk_1` FOREIGN KEY (`id_planilla`) REFERENCES `planilla` (`id_planilla`),
  ADD CONSTRAINT `planilla_bonificacion_ibfk_2` FOREIGN KEY (`id_bonificacion`) REFERENCES `bonificacion` (`id_bonificacion`);

--
-- Filtros para la tabla `planilla_descuento`
--
ALTER TABLE `planilla_descuento`
  ADD CONSTRAINT `planilla_descuento_ibfk_1` FOREIGN KEY (`id_planilla`) REFERENCES `planilla` (`id_planilla`),
  ADD CONSTRAINT `planilla_descuento_ibfk_2` FOREIGN KEY (`id_descuento`) REFERENCES `descuentos` (`id_descuento`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`idperfil_usuario`) REFERENCES `perfil` (`id_perfil`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
