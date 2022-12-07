-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 07-12-2022 a las 20:50:04
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
  `id_ano` int(11) NOT NULL,
  `ano` int(5) NOT NULL,
  `estado_ano` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

CREATE TABLE `cargo` (
  `id_cargo` int(11) NOT NULL,
  `nombre_cargo` varchar(200) NOT NULL,
  `estado_cargo` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `condicion_laboral`
--

CREATE TABLE `condicion_laboral` (
  `id_condicion` int(11) NOT NULL,
  `condicion` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `creacion_condicion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `estado_condicion` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `condicion_laboral`
--

INSERT INTO `condicion_laboral` (`id_condicion`, `condicion`, `creacion_condicion`, `estado_condicion`) VALUES
(28, 'prueba', '2022-11-23 18:20:53', 1),
(29, 'prueba 912239235347', '2022-11-23 18:24:18', 1),
(30, 'fecha actual', '2022-11-30 13:48:25', 1);

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mes`
--

CREATE TABLE `mes` (
  `id_mes` int(11) NOT NULL,
  `nombre_mes` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(2, 'Modulo Personal', NULL, NULL, '<i class=\"nav-icon fas fa-sign-in-alt\"></i>', 1),
(3, 'Modulo Horarios', NULL, NULL, '<i class=\"nav-icon fas fa-hand-holding-usd\"></i>', 1),
(4, 'Reportes', NULL, NULL, '<i class=\"nav-icon fas fa-file-alt\"></i>', 1),
(5, 'Seguridad', NULL, NULL, '<i class=\"nav-icon fas fa-user-shield\"></i>', 1),
(6, 'Personal', '/personal', 2, NULL, 1),
(7, 'Remuneración', '/remuneracion', 2, NULL, 1),
(8, 'Condición Laboral', '/condicion', 2, NULL, 1),
(9, 'Horario', NULL, 3, NULL, 1),
(10, 'Perfiles', '/perfil', 5, NULL, 1),
(11, 'Configuración', '/configuracion', 5, NULL, 1),
(12, 'Respaldo BD', '/respaldo', 5, NULL, 1),
(13, 'Tipo Bonificación', '/tipobonificacion', 1, NULL, 1),
(14, 'Usuarios', '/usuario', 5, NULL, 1),
(15, 'Personal Horario', '/personalhorario', 4, '', 0),
(32, 'planilla', '/planilla', 1, NULL, 1);

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
(3, 'SPC', '2022-10-09 14:20:27', 1),
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
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 1, 11),
(12, 1, 12),
(13, 1, 13),
(14, 1, 14),
(15, 1, 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE `personal` (
  `id_personal` int(11) NOT NULL,
  `id_cargo` int(11) NOT NULL,
  `nombre_personal` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `paterno_personal` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `materno_personal` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `dni_personal` varchar(8) COLLATE utf8_spanish_ci NOT NULL,
  `sexo_personal` char(1) COLLATE utf8_spanish_ci NOT NULL,
  `ubicacion_dpt` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ubicacion_prov` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ubicacion_dist` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion_personal` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_registro` date NOT NULL,
  `estado_personal` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

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
  `id_remuneracion` int(11) NOT NULL,
  `id_condicion` int(11) NOT NULL,
  `id_descuento` int(11) NOT NULL,
  `id_bonificacion` int(11) NOT NULL,
  `id_mes` int(11) NOT NULL,
  `id_año` int(11) NOT NULL,
  `numero_planilla` varchar(200) NOT NULL,
  `regimen_pensional` varchar(200) NOT NULL,
  `estado_planilla` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_bonificacion`
--

CREATE TABLE `tipo_bonificacion` (
  `id_tipo_bonificacion` int(11) NOT NULL,
  `nombre_tipo_bonificacion` varchar(200) NOT NULL,
  `estado_tipo_bonificacion` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_descuento`
--

CREATE TABLE `tipo_descuento` (
  `id_tipo_descuento` int(11) NOT NULL,
  `nombre_tipo_descuento` varchar(200) NOT NULL,
  `estado_tipo_descuento` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_planilla`
--

CREATE TABLE `tipo_planilla` (
  `id_tipo_planilla` int(11) NOT NULL,
  `nombre_tipo_planilla` varchar(200) NOT NULL,
  `estado_tipo_planilla` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(8, 'JHON', 'ARISTA ALARCON', '76554593', '$2a$07$asxx54ahjppf45sd87a5au8yqMHgnx2DR9LpknQy5BimagwAsXpWu', '1', '76554593', NULL, 1, NULL, NULL, 0, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ano`
--
ALTER TABLE `ano`
  ADD PRIMARY KEY (`id_ano`);

--
-- Indices de la tabla `bonificacion`
--
ALTER TABLE `bonificacion`
  ADD PRIMARY KEY (`id_bonificacion`),
  ADD UNIQUE KEY `id_tipo_bonificacion_3` (`id_tipo_bonificacion`),
  ADD KEY `id_tipo_bonificacion` (`id_tipo_bonificacion`),
  ADD KEY `id_tipo_bonificacion_2` (`id_tipo_bonificacion`);

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
  ADD UNIQUE KEY `id_tipo_descuento` (`id_tipo_descuento`);

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
  ADD UNIQUE KEY `id_cargo` (`id_cargo`);

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
  ADD UNIQUE KEY `id_tipo_planilla` (`id_tipo_planilla`,`id_remuneracion`,`id_condicion`,`id_descuento`,`id_bonificacion`,`id_mes`,`id_año`),
  ADD KEY `id_descuento` (`id_descuento`),
  ADD KEY `id_año` (`id_año`),
  ADD KEY `id_mes` (`id_mes`),
  ADD KEY `id_bonificacion` (`id_bonificacion`),
  ADD KEY `id_remuneracion` (`id_remuneracion`),
  ADD KEY `id_condicion` (`id_condicion`);

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
  MODIFY `id_ano` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `bonificacion`
--
ALTER TABLE `bonificacion`
  MODIFY `id_bonificacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id_cargo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `condicion_laboral`
--
ALTER TABLE `condicion_laboral`
  MODIFY `id_condicion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `descuentos`
--
ALTER TABLE `descuentos`
  MODIFY `id_descuento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mes`
--
ALTER TABLE `mes`
  MODIFY `id_mes` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `modulo`
--
ALTER TABLE `modulo`
  MODIFY `id_modulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `nivel_remunerativo`
--
ALTER TABLE `nivel_remunerativo`
  MODIFY `id_remuneracion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id_perfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `id_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `id_personal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `personal_planilla`
--
ALTER TABLE `personal_planilla`
  MODIFY `id_personal_planilla` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `planilla`
--
ALTER TABLE `planilla`
  MODIFY `id_planilla` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_bonificacion`
--
ALTER TABLE `tipo_bonificacion`
  MODIFY `id_tipo_bonificacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_descuento`
--
ALTER TABLE `tipo_descuento`
  MODIFY `id_tipo_descuento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_planilla`
--
ALTER TABLE `tipo_planilla`
  MODIFY `id_tipo_planilla` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
-- Filtros para la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD CONSTRAINT `permiso_ibfk_1` FOREIGN KEY (`idperfilpermiso`) REFERENCES `perfil` (`id_perfil`) ON UPDATE CASCADE,
  ADD CONSTRAINT `permiso_ibfk_2` FOREIGN KEY (`idmodulo`) REFERENCES `modulo` (`id_modulo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `personal`
--
ALTER TABLE `personal`
  ADD CONSTRAINT `personal_ibfk_1` FOREIGN KEY (`id_cargo`) REFERENCES `cargo` (`id_cargo`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `planilla_ibfk_2` FOREIGN KEY (`id_descuento`) REFERENCES `descuentos` (`id_descuento`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `planilla_ibfk_3` FOREIGN KEY (`id_año`) REFERENCES `ano` (`id_ano`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `planilla_ibfk_4` FOREIGN KEY (`id_mes`) REFERENCES `mes` (`id_mes`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `planilla_ibfk_5` FOREIGN KEY (`id_bonificacion`) REFERENCES `bonificacion` (`id_bonificacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `planilla_ibfk_6` FOREIGN KEY (`id_remuneracion`) REFERENCES `nivel_remunerativo` (`id_remuneracion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `planilla_ibfk_7` FOREIGN KEY (`id_condicion`) REFERENCES `condicion_laboral` (`id_condicion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`idperfil_usuario`) REFERENCES `perfil` (`id_perfil`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
