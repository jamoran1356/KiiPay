-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 17-04-2024 a las 19:06:04
-- Versión del servidor: 8.0.36-cll-lve
-- Versión de PHP: 8.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pydti_control`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades_solicitud`
--

CREATE TABLE `actividades_solicitud` (
  `id` int NOT NULL,
  `idusuario` int NOT NULL,
  `idempresa` int NOT NULL,
  `idunidad` int NOT NULL,
  `estado_unidad` varchar(25) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `km_actual` int NOT NULL,
  `km_ultima` int NOT NULL,
  `fecha_ultima` date NOT NULL,
  `tipo_servicio` varchar(25) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `contrato` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `taller` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `ubicacion` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `motivo` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `observaciones` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `estado_solicitud` int NOT NULL,
  `fecha_solicitud` date NOT NULL,
  `fecha_actualizado` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `actividades_solicitud`
--

INSERT INTO `actividades_solicitud` (`id`, `idusuario`, `idempresa`, `idunidad`, `estado_unidad`, `km_actual`, `km_ultima`, `fecha_ultima`, `tipo_servicio`, `contrato`, `taller`, `ubicacion`, `motivo`, `observaciones`, `estado_solicitud`, `fecha_solicitud`, `fecha_actualizado`) VALUES
(1, 1, 1, 29, 'MOVILIZADA', 158500, 155000, '2024-04-01', 'IP', 'CCEE', 'Taller las Mercedes', 'SANTIAGO', 'SE CUMPLE CON LOS REQUISITOS', '', 3, '2024-04-09', '0000-00-00'),
(2, 1, 3, 226, 'DESMOVILIZADA', 45678, 4567890, '2024-04-11', 'PM', 'COCU', 'Las Blancas', 'Las Blancas', 'Chasis ', 'Se debe enviar documentos', 3, '2024-04-10', '0000-00-00'),
(3, 1, 3, 208, 'LIBERADA', 64556456, 456776456, '2023-05-04', 'PM', 'COCU', 'Las Blancas', 'Las Blancas', '', '', 3, '2024-04-10', '0000-00-00'),
(4, 85, 3, 228, 'DESMOVILIZADO', 1000000, 10000525, '2024-04-01', 'IP', 'CCVV', 'Taller Buenaventura', 'SANTIAGO', '', '', 1, '2024-04-12', '0000-00-00'),
(5, 1, 3, 215, 'LIBERADO', 654, 3543, '2024-04-12', 'PM', 'COCU', 'las blancas', 'v region', '', '', 1, '2024-04-12', '0000-00-00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades_solicitud_panne`
--

CREATE TABLE `actividades_solicitud_panne` (
  `id` int NOT NULL,
  `idempresa` int NOT NULL,
  `idunidad` int NOT NULL,
  `ppu_semi` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `km_actual_tracto` int NOT NULL,
  `km_actual_semi` int NOT NULL,
  `fecha` date NOT NULL,
  `hora` int NOT NULL,
  `servicio` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `tipo_falla` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `transportista` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `supervisor` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `ubicacion` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `falla_preliminar` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `estado_solicitud` int NOT NULL,
  `fecha_creado` datetime NOT NULL,
  `creado_por` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `actividades_solicitud_panne`
--

INSERT INTO `actividades_solicitud_panne` (`id`, `idempresa`, `idunidad`, `ppu_semi`, `km_actual_tracto`, `km_actual_semi`, `fecha`, `hora`, `servicio`, `tipo_falla`, `transportista`, `supervisor`, `ubicacion`, `falla_preliminar`, `estado_solicitud`, `fecha_creado`, `creado_por`) VALUES
(1, 1, 30, '995258', 185258, 193000, '2024-04-09', 12, 'AI', 'LEVE', 'LUIS AMESTY', 'JOSE GARCIA', 'SANTIAGO', 'PINCHAZO EN EL NEUMATICO DELANTERO', 3, '2024-04-09 12:40:04', 1),
(2, 3, 29, '955844', 456890, 34567, '2024-04-10', 15, 'COCU', 'GRAVE', 'JUAN PEREZ', 'LUIS PEREZ', 'BASCULA N° 1', 'NO CARGA AIRE', 3, '2024-04-10 15:09:05', 1),
(3, 3, 206, '', 6556456, 456456, '2024-04-05', 10, 'CCEE', 'GRAVE', 'ewrwrew', 'werwer', 'fdsfsdf', 'sfsdfsdfsdf', 3, '2024-04-12 09:23:09', 1),
(4, 3, 206, 'sdfsdf', 234324, 243234, '2024-04-10', 10, 'CCEE', 'LEVE', 'etrert', 'ertert', 'ertert', 'retert', 1, '2024-04-12 09:27:25', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad_archivos`
--

CREATE TABLE `actividad_archivos` (
  `id` int NOT NULL,
  `idactividad` int NOT NULL,
  `archivo` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `actividad_archivos`
--

INSERT INTO `actividad_archivos` (`id`, `idactividad`, `archivo`) VALUES
(1, 1, '66156ebc18137.jpg'),
(2, 1, '66156ebc2678f.jpg'),
(3, 3, '661919f1da036.pdf'),
(4, 4, '66191b755ca12.jpg'),
(5, 5, '66191b94df631.pdf'),
(6, 6, '66191bb016260.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad_archivos_panne`
--

CREATE TABLE `actividad_archivos_panne` (
  `id` int NOT NULL,
  `idpanne` int NOT NULL,
  `archivo` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `actividad_archivos_panne`
--

INSERT INTO `actividad_archivos_panne` (`id`, `idpanne`, `archivo`) VALUES
(1, 1, '66156f962a3df.jpg'),
(2, 2, '6616e4f2cf8ca.pdf'),
(3, 2, '6616e565d1cbb.pdf'),
(4, 3, '6619364dbb826.pdf'),
(5, 3, '6619366c0634b.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad_panne`
--

CREATE TABLE `actividad_panne` (
  `id` int NOT NULL,
  `idsolicitud` int NOT NULL,
  `falla` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `causa` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `accion` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `observaciones` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `fecha_solicitud` timestamp NOT NULL,
  `solicitado_por` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `actividad_panne`
--

INSERT INTO `actividad_panne` (`id`, `idsolicitud`, `falla`, `causa`, `accion`, `observaciones`, `fecha_solicitud`, `solicitado_por`) VALUES
(1, 1, 'PINCHANZO EN EL NEUMATICO DELANTERO IZQUIERDO (COPILOTO)', 'VIDRIOS EN LA VIA', 'SE SUSTITUYE EL NEUMATICO', '', '2024-04-09 16:40:54', 1),
(2, 2, 'NO CARGA AIRE EN SISTEMA NEUMATICO', 'COMPRESOR CON FALLA ', 'SE CAMBIA COMPRESOR Y FILTRO DEPURADOR', 'SE CAMBIA POR REPUESTOS NUEVOS', '2024-04-10 19:13:54', 1),
(3, 3, 'gfds', 'ytre', 'ytre', 'gtfre', '2024-04-12 13:25:33', 1),
(4, 4, 'ertert', 'ertert', 'ertert', 'ertert', '2024-04-12 13:28:04', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad_panne_cierre`
--

CREATE TABLE `actividad_panne_cierre` (
  `id` int NOT NULL,
  `idpanne` int NOT NULL,
  `tipo_falla` varchar(25) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `accion` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `fecha_cierre` timestamp NOT NULL,
  `cerrado_por` int NOT NULL,
  `estado_unidad` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `observaciones` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `actividad_panne_cierre`
--

INSERT INTO `actividad_panne_cierre` (`id`, `idpanne`, `tipo_falla`, `accion`, `fecha_cierre`, `cerrado_por`, `estado_unidad`, `observaciones`) VALUES
(1, 1, 'LEVE', 'SUSTITUCION DE LA LLANTA', '2024-04-09 16:41:18', 1, 'MOVILIZADA', ''),
(2, 2, 'GRAVE', 'SE CAMBIA COMPRESOR Y FILTRO', '2024-04-10 19:15:49', 1, 'LIBERADA', 'SE ADJUNTA PAUTA Y FOTOGRAFIAS'),
(3, 3, '', '', '2024-04-12 13:26:03', 1, '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad_realizadas`
--

CREATE TABLE `actividad_realizadas` (
  `id` int NOT NULL,
  `idsolicitud` int NOT NULL,
  `fecha_inspeccion` date NOT NULL,
  `hora_inspeccion` time NOT NULL,
  `realizo` varchar(2) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `motivo` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `estado_unidad_sugerido` varchar(40) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `observaciones` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `fecha_actualizado` date NOT NULL,
  `actualizado_por` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `actividad_realizadas`
--

INSERT INTO `actividad_realizadas` (`id`, `idsolicitud`, `fecha_inspeccion`, `hora_inspeccion`, `realizo`, `motivo`, `estado_unidad_sugerido`, `observaciones`, `fecha_actualizado`, `actualizado_por`) VALUES
(1, 1, '2024-04-12', '13:00:00', 'Si', '', 'Condicionado', 'FALTAN DETALLES', '2024-04-09', 4),
(2, 3, '2024-04-12', '13:30:00', 'Si', '', 'Movilizada', 'Sin observaciones', '2024-04-10', 70),
(3, 4, '2024-04-12', '08:24:00', 'Si', '', 'Condicionado', '', '2024-04-12', 85),
(4, 4, '2024-04-05', '07:31:00', 'Si', '', 'Condicionado', '', '2024-04-12', 85),
(5, 4, '2024-04-23', '07:31:00', 'Si', '', 'Condicionado', '', '2024-04-12', 85),
(6, 4, '2024-04-16', '07:34:00', 'Si', '', 'Condicionado', '', '2024-04-12', 85);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad_tallerip`
--

CREATE TABLE `actividad_tallerip` (
  `id` int NOT NULL,
  `idsolicitud` int NOT NULL,
  `fecha_revision` date NOT NULL,
  `hora` time NOT NULL,
  `semana` int NOT NULL,
  `solicitado_por` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `autorizado_por` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `estado_solicitud` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `actividad_tallerip`
--

INSERT INTO `actividad_tallerip` (`id`, `idsolicitud`, `fecha_revision`, `hora`, `semana`, `solicitado_por`, `autorizado_por`, `estado_solicitud`) VALUES
(1, 1, '2024-04-12', '13:00:00', 23, 'Jesus Moran', 'Jesus Moran', 'Pendiente'),
(2, 2, '2024-04-11', '08:30:00', 15, 'Catalina', 'Claudio', 'Pendiente'),
(3, 3, '2024-04-12', '13:00:00', 15, 'Catalina', 'Claudio', 'Pendiente'),
(4, 4, '2024-04-15', '09:00:00', 25, 'Jesus Moran', 'Jesus Moran', 'Pendiente'),
(5, 5, '2024-04-19', '10:13:00', 6, 'cata', 'julio', 'Pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad_unidad_estados`
--

CREATE TABLE `actividad_unidad_estados` (
  `id` int NOT NULL,
  `idempresa` int NOT NULL,
  `idunidad` int NOT NULL,
  `estado` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `descripcion` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `actualizado_por` int NOT NULL,
  `fecha_actualizado` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `actividad_unidad_estados`
--

INSERT INTO `actividad_unidad_estados` (`id`, `idempresa`, `idunidad`, `estado`, `descripcion`, `actualizado_por`, `fecha_actualizado`) VALUES
(1, 1, 28, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-09'),
(2, 1, 29, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-09'),
(3, 1, 30, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-09'),
(4, 1, 29, 'MOVILIZADA', 'Unidad actualizada', 1, '2024-04-09'),
(5, 1, 30, 'DESMOVILIZADA', 'Unidad actualizada', 1, '2024-04-09'),
(6, 1, 30, 'MOVILIZADA', 'Unidad actualizada', 1, '2024-04-09'),
(7, 2, 31, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(8, 2, 32, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(9, 2, 33, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(10, 2, 34, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(11, 2, 35, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(12, 2, 36, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(13, 2, 37, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(14, 2, 38, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(15, 2, 39, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(16, 2, 40, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(17, 2, 41, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(18, 2, 42, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(19, 2, 43, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(20, 2, 44, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(21, 2, 45, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(22, 2, 46, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(23, 2, 47, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(24, 2, 48, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(25, 2, 49, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(26, 2, 50, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(27, 2, 51, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(28, 2, 52, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(29, 2, 53, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(30, 2, 54, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(31, 2, 55, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(32, 2, 56, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(33, 2, 57, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(34, 2, 58, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(35, 2, 59, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(36, 2, 60, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(37, 2, 61, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(38, 2, 62, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(39, 2, 63, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(40, 2, 64, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(41, 2, 65, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(42, 2, 66, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(43, 2, 67, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(44, 2, 68, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(45, 2, 69, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(46, 2, 70, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(47, 2, 71, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(48, 2, 72, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(49, 2, 73, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(50, 2, 74, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(51, 2, 75, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(52, 2, 76, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(53, 2, 77, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(54, 2, 78, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(55, 2, 79, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(56, 2, 80, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(57, 2, 81, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(58, 2, 82, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(59, 2, 83, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(60, 2, 84, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(61, 2, 85, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(62, 2, 86, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(63, 2, 87, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(64, 2, 88, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(65, 2, 89, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(66, 2, 90, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(67, 2, 91, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(68, 2, 92, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(69, 2, 93, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(70, 2, 94, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(71, 2, 95, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(72, 2, 96, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(73, 2, 97, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(74, 2, 98, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(75, 2, 99, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(76, 2, 100, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(77, 2, 101, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(78, 2, 102, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(79, 2, 103, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(80, 2, 104, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(81, 2, 105, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(82, 2, 106, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(83, 2, 107, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(84, 2, 108, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(85, 2, 109, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(86, 2, 110, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(87, 2, 111, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(88, 2, 112, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(89, 2, 113, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(90, 2, 114, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(91, 2, 115, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(92, 2, 116, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(93, 2, 117, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(94, 2, 118, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(95, 2, 119, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(96, 2, 120, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(97, 2, 121, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(98, 2, 122, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(99, 2, 123, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(100, 2, 124, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(101, 2, 125, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(102, 2, 126, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(103, 2, 127, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(104, 2, 128, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(105, 2, 129, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(106, 2, 130, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(107, 2, 131, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(108, 2, 132, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(109, 2, 133, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(110, 2, 134, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(111, 2, 135, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(112, 2, 136, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(113, 2, 137, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(114, 2, 138, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(115, 2, 139, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(116, 2, 140, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(117, 2, 141, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(118, 2, 142, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(119, 2, 143, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(120, 2, 144, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(121, 2, 145, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(122, 2, 146, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(123, 2, 147, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(124, 2, 148, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(125, 2, 149, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(126, 2, 150, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(127, 2, 151, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(128, 2, 152, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(129, 2, 153, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(130, 2, 154, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(131, 2, 155, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(132, 2, 156, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(133, 2, 157, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(134, 2, 158, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(135, 2, 159, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(136, 2, 160, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(137, 2, 161, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(138, 2, 162, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(139, 2, 163, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(140, 2, 164, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(141, 2, 165, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(142, 2, 166, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(143, 2, 167, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(144, 2, 168, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(145, 2, 169, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(146, 2, 170, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(147, 2, 171, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(148, 2, 172, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(149, 2, 173, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(150, 2, 174, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(151, 2, 175, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(152, 2, 176, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(153, 2, 177, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(154, 2, 178, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(155, 2, 179, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(156, 2, 180, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(157, 2, 181, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(158, 2, 182, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(159, 2, 183, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(160, 2, 184, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(161, 2, 185, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(162, 2, 186, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(163, 2, 187, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(164, 2, 188, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(165, 2, 189, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(166, 2, 190, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(167, 2, 191, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(168, 2, 192, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(169, 2, 193, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(170, 2, 194, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(171, 2, 195, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(172, 2, 196, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(173, 2, 197, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(174, 2, 198, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(175, 2, 199, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(176, 2, 200, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(177, 2, 201, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(178, 2, 202, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(179, 2, 203, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(180, 2, 204, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(181, 2, 205, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(182, 3, 206, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(183, 3, 207, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(184, 3, 208, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(185, 3, 209, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(186, 3, 210, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(187, 3, 211, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(188, 3, 212, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(189, 3, 213, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(190, 3, 214, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(191, 3, 215, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(192, 3, 216, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(193, 3, 217, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(194, 3, 218, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(195, 3, 219, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(196, 3, 220, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(197, 3, 221, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(198, 3, 222, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(199, 3, 223, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(200, 3, 224, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(201, 3, 225, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(202, 3, 226, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(203, 3, 227, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(204, 3, 228, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(205, 3, 229, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(206, 3, 230, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(207, 3, 231, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(208, 3, 232, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(209, 3, 233, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(210, 3, 234, 'MOVILIZADO', 'Unidad creada', 1, '2024-04-10'),
(211, 3, 226, 'DESMOVILIZADA', 'Unidad actualizada', 1, '2024-04-10'),
(212, 3, 208, 'LIBERADA', 'Unidad actualizada', 1, '2024-04-10'),
(213, 3, 0, 'DESMOVILIZADA', 'Unidad actualizada', 1, '2024-04-10'),
(214, 3, 0, 'LIBERADA', 'Unidad actualizada', 1, '2024-04-10'),
(215, 3, 206, 'DESMOVILIZADA', 'Unidad actualizada', 1, '2024-04-12'),
(216, 3, 206, '', 'Unidad actualizada', 1, '2024-04-12'),
(217, 3, 206, 'DESMOVILIZADA', 'Unidad actualizada', 1, '2024-04-12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaciones_inspector`
--

CREATE TABLE `asignaciones_inspector` (
  `id` int NOT NULL,
  `idactividad` int NOT NULL,
  `idinspector` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `asignaciones_inspector`
--

INSERT INTO `asignaciones_inspector` (`id`, `idactividad`, `idinspector`) VALUES
(1, 1, 2),
(2, 1, 4),
(3, 2, 70),
(4, 3, 70),
(5, 4, 70),
(6, 5, 70);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente_personal_profile`
--

CREATE TABLE `cliente_personal_profile` (
  `id` int NOT NULL,
  `idempresa` int NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `apellido` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `identificacion` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `correo` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `telefono` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `clave` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `nacimiento` date NOT NULL,
  `sexo` varchar(1) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `imagen` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `has_access` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente_persona_laboral`
--

CREATE TABLE `cliente_persona_laboral` (
  `id` int NOT NULL,
  `idempresa` int NOT NULL,
  `idusuario` int NOT NULL,
  `cargo` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `idunidad` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `control_acceso`
--

CREATE TABLE `control_acceso` (
  `id` int NOT NULL,
  `idusuario` int NOT NULL,
  `dispositivo` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `ip` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `session_id` varchar(32) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `estado` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `fecha_acceso` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `control_acceso`
--

INSERT INTO `control_acceso` (`id`, `idusuario`, `dispositivo`, `ip`, `session_id`, `estado`, `fecha_acceso`) VALUES
(1, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', '38.25.201.29', 'e316e1c8a424ea9ccb9a2a759fe6b7d0', 'cerrada', '2024-04-09'),
(2, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', '38.25.201.29', 'e316e1c8a424ea9ccb9a2a759fe6b7d0', 'cerrada', '2024-04-09'),
(3, 2, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', '38.25.201.29', 'e316e1c8a424ea9ccb9a2a759fe6b7d0', 'activa', '2024-04-09'),
(4, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', '38.25.201.29', 'e316e1c8a424ea9ccb9a2a759fe6b7d0', 'cerrada', '2024-04-09'),
(5, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', '38.25.201.29', 'e316e1c8a424ea9ccb9a2a759fe6b7d0', 'cerrada', '2024-04-09'),
(6, 1, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA', '38.25.201.29', 'e316e1c8a424ea9ccb9a2a759fe6b7d0', 'cerrada', '2024-04-09'),
(7, 1, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA', '38.25.201.29', 'e316e1c8a424ea9ccb9a2a759fe6b7d0', 'cerrada', '2024-04-09'),
(8, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', '38.25.201.29', 'e316e1c8a424ea9ccb9a2a759fe6b7d0', 'cerrada', '2024-04-09'),
(9, 4, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', '38.25.201.29', 'e316e1c8a424ea9ccb9a2a759fe6b7d0', 'activa', '2024-04-09'),
(10, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', '38.25.201.29', 'e316e1c8a424ea9ccb9a2a759fe6b7d0', 'cerrada', '2024-04-09'),
(11, 4, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', '38.25.201.29', 'e316e1c8a424ea9ccb9a2a759fe6b7d0', 'activa', '2024-04-09'),
(12, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', '38.25.201.29', 'e316e1c8a424ea9ccb9a2a759fe6b7d0', 'cerrada', '2024-04-09'),
(13, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', '186.79.139.239', 'eff2e827912a0ae3883e566fd78a91e5', 'cerrada', '2024-04-10'),
(14, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', '186.79.139.239', 'eff2e827912a0ae3883e566fd78a91e5', 'cerrada', '2024-04-10'),
(15, 70, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', '186.79.139.239', 'eff2e827912a0ae3883e566fd78a91e5', 'cerrada', '2024-04-10'),
(16, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', '186.79.139.239', 'eff2e827912a0ae3883e566fd78a91e5', 'cerrada', '2024-04-10'),
(17, 70, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', '186.79.139.239', 'eff2e827912a0ae3883e566fd78a91e5', 'cerrada', '2024-04-10'),
(18, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', '186.79.139.239', 'eff2e827912a0ae3883e566fd78a91e5', 'cerrada', '2024-04-10'),
(19, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', '186.79.139.239', 'eff2e827912a0ae3883e566fd78a91e5', 'cerrada', '2024-04-10'),
(20, 80, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', '186.79.139.239', 'eff2e827912a0ae3883e566fd78a91e5', 'activa', '2024-04-10'),
(21, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', '186.79.139.239', 'eff2e827912a0ae3883e566fd78a91e5', 'cerrada', '2024-04-10'),
(22, 80, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', '186.79.139.239', 'eff2e827912a0ae3883e566fd78a91e5', 'activa', '2024-04-10'),
(23, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', '186.79.139.239', 'eff2e827912a0ae3883e566fd78a91e5', 'cerrada', '2024-04-10'),
(24, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', '186.79.139.239', '5f400b4e65c3a0a94271d515bb423c63', 'cerrada', '2024-04-10'),
(25, 85, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', '38.25.149.233', 'e316e1c8a424ea9ccb9a2a759fe6b7d0', 'activa', '2024-04-12'),
(26, 85, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', '38.25.149.233', 'e316e1c8a424ea9ccb9a2a759fe6b7d0', 'activa', '2024-04-12'),
(27, 85, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', '38.25.149.233', 'e316e1c8a424ea9ccb9a2a759fe6b7d0', 'activa', '2024-04-12'),
(28, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', '186.79.143.197', '71b6ecd020590bd88a2e3f9390cb7dc8', 'activa', '2024-04-12'),
(29, 70, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', '186.79.143.197', '71b6ecd020590bd88a2e3f9390cb7dc8', 'activa', '2024-04-12'),
(30, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', '186.79.143.197', '71b6ecd020590bd88a2e3f9390cb7dc8', 'activa', '2024-04-12'),
(31, 70, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', '186.79.143.197', '71b6ecd020590bd88a2e3f9390cb7dc8', 'activa', '2024-04-12'),
(32, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', '186.79.143.197', '71b6ecd020590bd88a2e3f9390cb7dc8', 'activa', '2024-04-12'),
(33, 70, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', '186.79.143.197', '71b6ecd020590bd88a2e3f9390cb7dc8', 'activa', '2024-04-12'),
(34, 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', '186.79.143.197', '71b6ecd020590bd88a2e3f9390cb7dc8', 'activa', '2024-04-12'),
(35, 85, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb', '38.25.149.233', 'e316e1c8a424ea9ccb9a2a759fe6b7d0', 'activa', '2024-04-12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `control_tareas`
--

CREATE TABLE `control_tareas` (
  `id` int NOT NULL,
  `idcliente` int NOT NULL,
  `idunidad` int NOT NULL,
  `idinspector` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `tipo_actividad` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `solicitado_por` varchar(190) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `aprobado_por` varchar(190) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `ubicacion` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `estado_unidad` int NOT NULL,
  `estado_tarea` int NOT NULL,
  `fecha_solicitud` date NOT NULL,
  `fecha_agenda` date NOT NULL,
  `hora_agenda` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `iddepartamento` int NOT NULL,
  `titulo` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `fecha_creado` date NOT NULL,
  `creado_por` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`iddepartamento`, `titulo`, `descripcion`, `fecha_creado`, `creado_por`) VALUES
(15, 'Administración', 'Catalina Castro', '2024-01-20', 1),
(16, 'Inspección', '', '2024-02-07', 1),
(19, 'Ambipar', 'Departamento encargado de liberar unidad posterior a liberación SOPROCERT y fines de semana y días feriados solo liberación de unidad en caso de fallas leves', '2024-04-08', 1),
(20, 'Anglo American', 'Christopher Rodriguez', '2024-04-10', 1),
(21, 'TVP', 'TRANSPORTISTA SERVICIO COCU', '2024-04-10', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento_manager`
--

CREATE TABLE `departamento_manager` (
  `id` int NOT NULL,
  `departamento_id` int NOT NULL,
  `idpersona` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `departamento_manager`
--

INSERT INTO `departamento_manager` (`id`, `departamento_id`, `idpersona`) VALUES
(1, 15, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa_profile`
--

CREATE TABLE `empresa_profile` (
  `id` int NOT NULL,
  `nombre` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `nif` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `correo` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `clave` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `telefono` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `website` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `direccion` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `ciudad` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `provincia` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `imagen` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `empresa_profile`
--

INSERT INTO `empresa_profile` (`id`, `nombre`, `nif`, `correo`, `clave`, `telefono`, `website`, `direccion`, `ciudad`, `provincia`, `imagen`) VALUES
(1, 'FUXION', '401126103', 'info@fuxion.com', '$2y$10$OpXgMm9LWDAFYD8LGTwkoe8.boX7EAFV7gsxsLXV9MUdgX5c/kSRa', '998877665544', 'https://www.fuxion.com', 'SANTIAGO', 'SANTIAGO', 'PUERTO MONT', 'assest/images/clientes/66156da50c03b.png'),
(3, 'TVP', '', '', '$2y$10$pvchTjPdqV2f9AJxo.M2TOgtK06.gpnrpQhPTMeGY/UDDDQjXEPXW', '', '', 'Las Blancas', 'Ventanas', 'Puchuncaví', 'assest/images/no-image.webp');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `endpoints`
--

CREATE TABLE `endpoints` (
  `id` int NOT NULL,
  `titulo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `url` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `endpoints`
--

INSERT INTO `endpoints` (`id`, `titulo`, `url`) VALUES
(1, 'url_admin', 'https://pydti.com/portafolio/etbspace/admin/verificacion.php?tipo=1&token=$codigo&correo=$correo'),
(2, 'url_vendedores', ''),
(3, 'url_clientes', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `google_captcha`
--

CREATE TABLE `google_captcha` (
  `id` int NOT NULL,
  `clave_privada` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `clave_publica` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `activo` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `google_captcha`
--

INSERT INTO `google_captcha` (`id`, `clave_privada`, `clave_publica`, `activo`) VALUES
(1, '6Lf-5CwpAAAAAL5K1he2hr9zQ1GyjXnCLZqMo3Bp', '6Lf-5CwpAAAAAIg8n0aanBwXNYoToy24tvQCQypV', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mantenimientos`
--

CREATE TABLE `mantenimientos` (
  `id` int NOT NULL,
  `idunidad` int NOT NULL,
  `fecha_programada` date NOT NULL,
  `inspeccionado_por` int NOT NULL,
  `descripcion` int NOT NULL,
  `tipo` int NOT NULL,
  `autorizado_por` int NOT NULL,
  `status` int NOT NULL,
  `fecha_solicitud` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu_lateral`
--

CREATE TABLE `menu_lateral` (
  `id` int NOT NULL,
  `item` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `estado` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paises`
--

CREATE TABLE `paises` (
  `id` int NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `inicial` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `codigo` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `paises`
--

INSERT INTO `paises` (`id`, `nombre`, `inicial`, `codigo`) VALUES
(1, 'Alemania', 'DE', 'DE'),
(2, 'Andorra', 'AD', 'AD'),
(3, 'Angola', 'AO', 'AO'),
(4, 'Antigua y Barbuda', 'AG', 'AG'),
(5, 'Argentina', 'AR', 'AR'),
(6, 'Armenia', 'AM', 'AM'),
(7, 'Australia', 'AU', 'AU'),
(8, 'Austria', 'AT', 'AT'),
(9, 'Azerbaiyán', 'AZ', 'AZ'),
(10, 'Bahamas', 'BS', 'BS'),
(11, 'Bahrein', 'BH', 'BH'),
(12, 'Bangladés', 'BD', 'BD'),
(13, 'Barbados', 'BB', 'BB'),
(14, 'Bielorrusia', 'BY', 'BY'),
(15, 'Belice', 'BZ', 'BZ'),
(16, 'Benín', 'BJ', 'BJ'),
(17, 'Bután', 'BT', 'BT'),
(18, 'Bolivia', 'BO', 'BO'),
(19, 'Bosnia y Herzegovina', 'BA', 'BA'),
(20, 'Botsuana', 'BW', 'BW'),
(21, 'Brasil', 'BR', 'BR'),
(22, 'Brunéi', 'BN', 'BN'),
(23, 'Bulgaria', 'BG', 'BG'),
(24, 'Burkina Faso', 'BF', 'BF'),
(25, 'Burundi', 'BI', 'BI'),
(26, 'Camboya', 'KH', 'KH'),
(27, 'Camerún', 'CM', 'CM'),
(28, 'Canadá', 'CA', 'CA'),
(29, 'Cabo Verde', 'CV', 'CV'),
(30, 'Chad', 'TD', 'TD'),
(31, 'Chile', 'CL', 'CL'),
(32, 'China', 'CN', 'CN'),
(33, 'Chipre', 'CY', 'CY'),
(34, 'Ciudad del Vaticano', 'VA', 'VA'),
(35, 'Colombia', 'CO', 'CO'),
(36, 'Comoras', 'KM', 'KM'),
(37, 'Congo República del', 'CG', 'CG'),
(39, 'Costa Rica', 'CR', 'CR'),
(40, 'Costa de Marfil', 'CI', 'CI'),
(41, 'Croacia', 'HR', 'HR'),
(42, 'Cuba', 'CU', 'CU'),
(43, 'Chipre', 'CY', 'CY'),
(44, 'República Checa', 'CZ', 'CZ'),
(45, 'Dinamarca', 'DK', 'DK'),
(46, 'Yibuti', 'DJ', 'DJ'),
(47, 'Dominica', 'DM', 'DM'),
(48, 'República Dominicana', 'DO', 'DO'),
(49, 'Ecuador', 'EC', 'EC'),
(50, 'Egipto', 'EG', 'EG'),
(51, 'Afganistán', 'AF', 'AF'),
(52, 'Albania', 'AL', 'AL'),
(53, 'Alemania', 'DE', 'DE'),
(54, 'Andorra', 'AD', 'AD'),
(55, 'Angola', 'AO', 'AO'),
(56, 'Antigua y Barbuda', 'AG', 'AG'),
(57, 'Argentina', 'AR', 'AR'),
(58, 'Armenia', 'AM', 'AM'),
(59, 'Australia', 'AU', 'AU'),
(60, 'Austria', 'AT', 'AT'),
(61, 'Azerbaiyán', 'AZ', 'AZ'),
(62, 'Bahamas', 'BS', 'BS'),
(63, 'Bahrein', 'BH', 'BH'),
(64, 'Bangladés', 'BD', 'BD'),
(65, 'Barbados', 'BB', 'BB'),
(66, 'Bielorrusia', 'BY', 'BY'),
(67, 'Belice', 'BZ', 'BZ'),
(68, 'Benín', 'BJ', 'BJ'),
(69, 'Bután', 'BT', 'BT'),
(70, 'Bolivia', 'BO', 'BO'),
(71, 'Bosnia y Herzegovina', 'BA', 'BA'),
(72, 'Botsuana', 'BW', 'BW'),
(73, 'Brasil', 'BR', 'BR'),
(74, 'Brunéi', 'BN', 'BN'),
(75, 'Bulgaria', 'BG', 'BG'),
(76, 'Burkina Faso', 'BF', 'BF'),
(77, 'Burundi', 'BI', 'BI'),
(78, 'Camboya', 'KH', 'KH'),
(79, 'Camerún', 'CM', 'CM'),
(80, 'Canadá', 'CA', 'CA'),
(81, 'Cabo Verde', 'CV', 'CV'),
(82, 'Chad', 'TD', 'TD'),
(83, 'Chile', 'CL', 'CL'),
(84, 'China', 'CN', 'CN'),
(85, 'Chipre', 'CY', 'CY'),
(86, 'Ciudad del Vaticano', 'VA', 'VA'),
(87, 'Colombia', 'CO', 'CO'),
(88, 'Comoras', 'KM', 'KM'),
(91, 'Costa Rica', 'CR', 'CR'),
(92, 'Costa de Marfil', 'CI', 'CI'),
(93, 'Croacia', 'HR', 'HR'),
(94, 'Cuba', 'CU', 'CU'),
(95, 'Chipre', 'CY', 'CY'),
(96, 'República Checa', 'CZ', 'CZ'),
(97, 'Dinamarca', 'DK', 'DK'),
(98, 'Yibuti', 'DJ', 'DJ'),
(99, 'Dominica', 'DM', 'DM'),
(100, 'República Dominicana', 'DO', 'DO'),
(101, 'Ecuador', 'EC', 'EC'),
(102, 'Egipto', 'EG', 'EG'),
(103, 'El Salvador', 'SV', 'SV'),
(104, 'Guinea Ecuatorial', 'GQ', 'GQ'),
(105, 'Eritrea', 'ER', 'ER'),
(106, 'Estonia', 'EE', 'EE'),
(107, 'Etiopía', 'ET', 'ET'),
(108, 'Islas Feroe', 'FO', 'FO'),
(109, 'Fiyi', 'FJ', 'FJ'),
(110, 'Finlandia', 'FI', 'FI'),
(111, 'Francia', 'FR', 'FR'),
(112, 'Gabón', 'GA', 'GA'),
(113, 'Gambia', 'GM', 'GM'),
(114, 'Georgia', 'GE', 'GE'),
(115, 'Ghana', 'GH', 'GH'),
(116, 'Grecia', 'GR', 'GR'),
(117, 'Granada', 'GD', 'GD'),
(118, 'Guatemala', 'GT', 'GT'),
(119, 'Guinea', 'GN', 'GN'),
(120, 'Guinea-Bissau', 'GW', 'GW'),
(121, 'Guyana', 'GY', 'GY'),
(122, 'Haití', 'HT', 'HT'),
(123, 'Honduras', 'HN', 'HN'),
(124, 'Hungría', 'HU', 'HU'),
(125, 'Islandia', 'IS', 'IS'),
(126, 'India', 'IN', 'IN'),
(127, 'Indonesia', 'ID', 'ID'),
(128, 'Irán', 'IR', 'IR'),
(129, 'Irak', 'IQ', 'IQ'),
(130, 'Irlanda', 'IE', 'IE'),
(131, 'Israel', 'IL', 'IL'),
(132, 'Italia', 'IT', 'IT'),
(133, 'Jamaica', 'JM', 'JM'),
(134, 'Japón', 'JP', 'JP'),
(135, 'Jordania', 'JO', 'JO'),
(136, 'Kazajistán', 'KZ', 'KZ'),
(137, 'Kenia', 'KE', 'KE'),
(138, 'Kiribati', 'KI', 'KI'),
(139, 'Kuwait', 'KW', 'KW'),
(140, 'Kirguistán', 'KG', 'KG'),
(141, 'Laos', 'LA', 'LA'),
(142, 'Letonia', 'LV', 'LV'),
(143, 'Líbano', 'LB', 'LB'),
(144, 'Lesoto', 'LS', 'LS'),
(145, 'Liberia', 'LR', 'LR'),
(146, 'Libia', 'LY', 'LY'),
(147, 'Liechtenstein', 'LI', 'LI'),
(148, 'Lituania', 'LT', 'LT'),
(149, 'Luxemburgo', 'LU', 'LU'),
(150, 'Nueva Zelanda', 'NZ', 'NZ'),
(151, 'Nicaragua', 'NI', 'NI'),
(152, 'Níger', 'NE', 'NE'),
(153, 'Macedonia del Norte', 'MK', 'MK'),
(154, 'Madagascar', 'MG', 'MG'),
(155, 'Malawi', 'MW', 'MW'),
(156, 'Malasia', 'MY', 'MY'),
(157, 'Maldivas', 'MV', 'MV'),
(158, 'Malí', 'ML', 'ML'),
(159, 'Malta', 'MT', 'MT'),
(160, 'Islas Marshall', 'MH', 'MH'),
(161, 'Mauritania', 'MR', 'MR'),
(162, 'Mauricio', 'MU', 'MU'),
(163, 'México', 'MX', 'MX'),
(164, 'Micronesia\',\'Estados Federados de', 'FM', 'FM'),
(165, 'Moldavia', 'MD', 'MD'),
(166, 'Mongolia', 'MN', 'MN'),
(167, 'Montenegro', 'ME', 'ME'),
(168, 'Marruecos', 'MA', 'MA'),
(169, 'Mozambique', 'MZ', 'MZ'),
(170, 'Myanmar (Birmania)', 'MM', 'MM'),
(171, 'Namibia', 'NA', 'NA'),
(172, 'Nauru', 'NR', 'NR'),
(173, 'Nepal', 'NP', 'NP'),
(174, 'Países Bajos', 'NL', 'NL'),
(175, 'Nueva Zelanda', 'NZ', 'NZ'),
(176, 'Nicaragua', 'NI', 'NI'),
(177, 'Níger', 'NE', 'NE'),
(178, 'Nigeria', 'NG', 'NG'),
(179, 'Noruega', 'NO', 'NO'),
(180, 'Omán', 'OM', 'OM'),
(181, 'Pakistán', 'PK', 'PK'),
(182, 'Palaos', 'PW', 'PW'),
(183, 'Palestina', 'PS', 'PS'),
(184, 'Panamá', 'PA', 'PA'),
(185, 'Papúa Nueva Guinea', 'PG', 'PG'),
(186, 'Paraguay', 'PY', 'PY'),
(187, 'Perú', 'PE', 'PE'),
(188, 'Filipinas', 'PH', 'PH'),
(189, 'Polonia', 'PL', 'PL'),
(190, 'Portugal', 'PT', 'PT'),
(191, 'Qatar', 'QA', 'QA'),
(192, 'Reunión', 'RE', 'RE'),
(193, 'Rumanía', 'RO', 'RO'),
(194, 'Rusia', 'RU', 'RU'),
(195, 'Rwanda', 'RW', 'RW'),
(196, 'San Marino', 'SM', 'SM'),
(197, 'San Vicente y las Granadinas', 'VC', 'VC'),
(198, 'Arabia Saudita', 'SA', 'SA'),
(199, 'Senegal', 'SN', 'SN'),
(200, 'Serbia', 'RS', 'RS'),
(201, 'Seychelles', 'SC', 'SC'),
(202, 'Sierra Leona', 'SL', 'SL'),
(203, 'Singapur', 'SG', 'SG'),
(204, 'Eslovaquia', 'SK', 'SK'),
(205, 'Eslovenia', 'SI', 'SI'),
(206, 'Islas Salomón', 'SB', 'SB'),
(207, 'Somalia', 'SO', 'SO'),
(208, 'Sudáfrica', 'ZA', 'ZA'),
(209, 'Sudán', 'SD', 'SD'),
(210, 'Sudán del Sur', 'SS', 'SS'),
(211, 'Surinam', 'SR', 'SR'),
(212, 'Suecia', 'SE', 'SE'),
(213, 'Suiza', 'CH', 'CH'),
(214, 'Siria', 'SY', ''),
(215, 'Tayikistán', 'TJ', 'TJ'),
(216, 'Tanzania', 'TZ', 'TZ'),
(217, 'Tailandia', 'TH', 'TH'),
(218, 'Timor Oriental', 'TL', 'TL'),
(219, 'Togo', 'TG', 'TG'),
(220, 'Tonga', 'TO', 'TO'),
(221, 'Trinidad y Tobago', 'TT', 'TT'),
(222, 'Túnez', 'TN', 'TN'),
(223, 'Turquía', 'TR', 'TR'),
(224, 'Turkmenistán', 'TM', 'TM'),
(225, 'Tuvalu', 'TV', 'TV'),
(226, 'Uganda', 'UG', 'UG'),
(227, 'Ucrania', 'UA', 'UA'),
(228, 'Emiratos Árabes Unidos', 'AE', 'AE'),
(229, 'Reino Unido', 'GB', 'GB'),
(230, 'Estados Unidos', 'US', 'US'),
(231, 'Uruguay', 'UR', 'UR'),
(232, 'Uzbekistán', 'UZ', 'UZ'),
(233, 'Vanuatu', 'VU', 'VU'),
(234, 'Venezuela', 'VE', 'VE'),
(235, 'Vietnam', 'VN', 'VN'),
(236, 'Yemen', 'YE', 'YE'),
(237, 'Zambia', 'ZM', 'ZM'),
(238, 'Zimbabue', 'ZW', 'ZW'),
(239, 'España', 'ES', 'ES');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona_address`
--

CREATE TABLE `persona_address` (
  `idaddress` bigint NOT NULL,
  `idpersona` bigint NOT NULL,
  `address_line1` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `address_line2` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `city` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `estado` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `pais` int NOT NULL,
  `zipcode` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `persona_address`
--

INSERT INTO `persona_address` (`idaddress`, `idpersona`, `address_line1`, `address_line2`, `city`, `estado`, `pais`, `zipcode`) VALUES
(117, 1, 'Santa Teresa 1300', '', 'Los Andes', '', 31, '2100000'),
(119, 5, 'Santa Teresa 1300', '', 'Los Andes', '', 0, ''),
(120, 69, 'Santa Teresa 1300', '', 'Los Andes', '', 0, ''),
(121, 70, 'Santa Teresa 1300', '', 'Los Andes', '', 0, ''),
(122, 80, 'LAS BLANCAS', '', 'LLAY LLAY', '', 0, ''),
(123, 81, '', '', '', '', 0, ''),
(124, 86, '', '', '', '', 0, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona_laboral`
--

CREATE TABLE `persona_laboral` (
  `idhistorial` int NOT NULL,
  `idpersona` int NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `cargo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `is_manager` int NOT NULL,
  `departamento` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `persona_laboral`
--

INSERT INTO `persona_laboral` (`idhistorial`, `idpersona`, `fecha_ingreso`, `cargo`, `is_manager`, `departamento`) VALUES
(54, 5, '2023-12-11', 'Secretaria Tecnica', 1, 15),
(55, 69, '2023-12-11', 'Inspector Técnico', 0, 16),
(56, 70, '2024-02-20', 'Inspector Técnico', 0, 16),
(57, 80, '2024-04-10', 'CONTROL GESTION', 0, 21),
(58, 86, '2024-04-01', 'Ambipar', 0, 19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona_log`
--

CREATE TABLE `persona_log` (
  `id` int NOT NULL,
  `idpersona` int NOT NULL,
  `accion` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `tipo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `fecha_incidencia` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona_menu`
--

CREATE TABLE `persona_menu` (
  `id` int NOT NULL,
  `idpersona` int NOT NULL,
  `menu` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `acceso` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `persona_menu`
--

INSERT INTO `persona_menu` (`id`, `idpersona`, `menu`, `acceso`) VALUES
(1, 1, 'departamentos', 1),
(3, 1, 'empresa', 1),
(4, 1, 'unidades', 1),
(5, 1, 'tallerip', 1),
(6, 1, 'panne', 1),
(8, 1, 'personal', 1),
(83, 5, 'departamentos', 1),
(84, 5, 'personal', 1),
(85, 5, 'empresa', 1),
(86, 5, 'unidades', 1),
(87, 5, 'tallerip', 1),
(88, 5, 'panne', 1),
(89, 69, 'departamentos', 0),
(90, 69, 'personal', 0),
(91, 69, 'empresa', 0),
(92, 69, 'unidades', 1),
(93, 69, 'tallerip', 1),
(94, 69, 'panne', 0),
(95, 70, 'departamentos', 0),
(96, 70, 'personal', 0),
(97, 70, 'empresa', 0),
(98, 70, 'unidades', 1),
(99, 70, 'tallerip', 1),
(100, 70, 'panne', 0),
(101, 85, 'departamentos', 1),
(102, 85, 'unidades', 1),
(103, 85, 'empresa', 1),
(104, 85, 'tallerip', 1),
(105, 85, 'panne', 1),
(106, 85, 'personal', 1),
(107, 86, 'departamentos', 0),
(108, 86, 'personal', 0),
(109, 86, 'empresa', 0),
(110, 86, 'unidades', 0),
(111, 86, 'tallerip', 0),
(112, 86, 'panne', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona_profile`
--

CREATE TABLE `persona_profile` (
  `idpersona` bigint NOT NULL,
  `nombre` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `apellido` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `identificacion` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `email` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `telefono` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `imagen` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `sexo` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `clave` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `date_created` date NOT NULL,
  `verificado` int NOT NULL,
  `has_access` int NOT NULL,
  `tipo` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades_profile`
--

CREATE TABLE `unidades_profile` (
  `id` int NOT NULL,
  `idempresa` int NOT NULL,
  `tipo` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `marca` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `modelo` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `dv` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `year` varchar(4) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `chasis` varchar(80) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `ppu` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `ppu_semi` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `km_actual` decimal(10,2) NOT NULL,
  `km_proximo` decimal(10,2) NOT NULL,
  `ubicacion` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `contrato` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `estatus` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `fecha_creado` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `unidades_profile`
--

INSERT INTO `unidades_profile` (`id`, `idempresa`, `tipo`, `marca`, `modelo`, `dv`, `year`, `chasis`, `ppu`, `ppu_semi`, `km_actual`, `km_proximo`, `ubicacion`, `contrato`, `estatus`, `fecha_creado`) VALUES
(25, 16, 'TRACTOCAMIÓN', 'MITSUBISHI', 'C158', '', '2020', '885452154524', 'TRRY852114', '', 150000.00, 165000.00, 'SANTIAGO', '', 'MOVILIZADO', '2024-04-09'),
(26, 16, 'TRACTOCAMION', 'VOLVO', 'MY158', '', '2021', '985415254820', 'YB885458', '1', 155800.00, 195200.00, 'SANTIAGO', '', 'DESMOVILIZADO', '2024-04-09'),
(27, 16, 'SEMIREMOLQUE', 'VOLVO', 'M852', '', '2022', '8955852125EE', 'VV854152', '59852125', 252000.00, 285000.00, 'SANTIAGO', '', 'MOVILIZADO', '2024-04-09'),
(29, 1, 'TRACTOCAMION', 'VOLVO', 'MY158', '', '2021', '985415254820', 'YB885458', '1', 158500.00, 195200.00, 'SANTIAGO', '', 'DESMOVILIZADO', '2024-04-09'),
(30, 1, 'SEMIREMOLQUE', 'VOLVO', 'M852', '', '2022', '8955852125EE', 'VV854152', '59852125', 252000.00, 285000.00, 'SANTIAGO', '', 'MOVILIZADO', '2024-04-09'),
(206, 3, 'TRACTOCAMION', 'INTERNATIONAL', 'PROSTAR 6X4', '', '2019', '3HSDJAPT4KN595876', 'LHDK22', '1', 100000.00, 100000.00, 'LAS BLANCAS', '', 'MOVILIZADO', '2024-04-10'),
(207, 3, 'TRACTOCAMION', 'INTERNATIONAL', 'PROSTAR 6X4', '', '2019', '3HSDJAPT2KN580700', 'LHDK23', '1', 100000.00, 100000.00, 'LAS BLANCAS', '', 'MOVILIZADO', '2024-04-10'),
(208, 3, 'TRACTOCAMION', 'INTERNATIONAL', 'PROSTAR 6X4', '', '2019', '3HSDJAPTXKN707029', 'LHDK24', '1', 64556456.00, 100000.00, 'LAS BLANCAS', '', 'MOVILIZADO', '2024-04-10'),
(209, 3, 'TRACTOCAMION', 'INTERNATIONAL', 'PROSTAR 6X4', '', '2019', '3HSDJAPT5KN581016', 'LHDK25', '1', 100000.00, 100000.00, 'LAS BLANCAS', '', 'MOVILIZADO', '2024-04-10'),
(210, 3, 'TRACTOCAMION', 'INTERNATIONAL', 'PROSTAR 6X4', '', '2019', '3HSDJAPT6KN593725', 'LHDK26', '1', 100000.00, 100000.00, 'LAS BLANCAS', '', 'MOVILIZADO', '2024-04-10'),
(211, 3, 'TRACTOCAMION', 'INTERNATIONAL', 'PROSTAR 6X4', '', '2019', '3HSDJAPT1KN137101', 'LHDK27', '1', 100000.00, 100000.00, 'LAS BLANCAS', '', 'MOVILIZADO', '2024-04-10'),
(212, 3, 'TRACTOCAMION', 'INTERNATIONAL', 'PROSTAR 6X4', '', '2019', '3HSDJAPT1KN136711', 'LHDK28', '1', 100000.00, 100000.00, 'LAS BLANCAS', '', 'MOVILIZADO', '2024-04-10'),
(213, 3, 'TRACTOCAMION', 'INTERNATIONAL', 'PROSTAR 6X4', '', '2019', '3HSDJAPTXKN593694', 'LHDK29', '1', 100000.00, 100000.00, 'LAS BLANCAS', '', 'MOVILIZADO', '2024-04-10'),
(214, 3, 'TRACTOCAMION', 'INTERNATIONAL', 'PROSTAR 6X4', '', '2019', '3HSDJAPT9KN594609', 'LHDK30', '1', 100000.00, 100000.00, 'LAS BLANCAS', '', 'MOVILIZADO', '2024-04-10'),
(215, 3, 'TRACTOCAMION', 'INTERNATIONAL', 'PROSTAR 6X4', '', '2019', '3HSDJAPT4KN580732', 'LHDK31', '1', 654.00, 100000.00, 'LAS BLANCAS', '', 'LIBERADO', '2024-04-10'),
(216, 3, 'TRACTOCAMION', 'INTERNATIONAL', 'PROSTAR 6X4', '', '2019', '3HSDJAPT0KN707251', 'LHDK32', '1', 100000.00, 100000.00, 'LAS BLANCAS', '', 'MOVILIZADO', '2024-04-10'),
(217, 3, 'TRACTOCAMION', 'INTERNATIONAL', 'PROSTAR 6X4', '', '2019', '3HSDJAPT0KN706696', 'LHDK33', '1', 100000.00, 100000.00, 'LAS BLANCAS', '', 'MOVILIZADO', '2024-04-10'),
(218, 3, 'TRACTOCAMION', 'INTERNATIONAL', 'PROSTAR 6X4', '', '2019', '3HSDJAPT4KN580634', 'LHDK34', '1', 100000.00, 100000.00, 'LAS BLANCAS', '', 'MOVILIZADO', '2024-04-10'),
(219, 3, 'TRACTOCAMION', 'INTERNATIONAL', 'PROSTAR 6X4', '', '2019', '3HSDJAPT3KN593701', 'LHDK35', '1', 100000.00, 100000.00, 'LAS BLANCAS', '', 'MOVILIZADO', '2024-04-10'),
(220, 3, 'TRACTOCAMION', 'INTERNATIONAL', 'PROSTAR 6X4', '', '2019', '3HSDJAPT1KN409386', 'LGLD47', '1', 100000.00, 100000.00, 'LAS BLANCAS', '', 'MOVILIZADO', '2024-04-10'),
(221, 3, 'TRACTOCAMION', 'MAN', 'TGX 26480 BLS 6X4 TIPCMATIC', '', '2020', 'WMA30XZZ4KM829515', 'LGWT88', '1', 100000.00, 100000.00, 'LAS BLANCAS', '', 'MOVILIZADO', '2024-04-10'),
(222, 3, 'TRACTOCAMION', 'MAN', 'TGX 26480 BLS 6X4 TIPCMATIC', '', '2020', 'WMA30XZZ7KM831355', 'LGWT89', '1', 100000.00, 100000.00, 'LAS BLANCAS', '', 'MOVILIZADO', '2024-04-10'),
(223, 3, 'TRACTOCAMION', 'MAN', 'TGX 26480 BLS 6X4 TIPCMATIC', '', '2020', 'WMA30XZZ5KM829622', 'LGWT90', '1', 100000.00, 100000.00, 'LAS BLANCAS', '', 'MOVILIZADO', '2024-04-10'),
(224, 3, 'TRACTOCAMION', 'MAN', 'TGX 26480 BLS 6X4 TIPCMATIC', '', '2020', 'WMA30XZZ4KM829420', 'LPCR48', '1', 100000.00, 100000.00, 'LAS BLANCAS', '', 'MOVILIZADO', '2024-04-10'),
(225, 3, 'TRACTOCAMION', 'MAN', 'TGX 26480 BLS 6X4 TIPCMATIC', '', '2020', 'WMA30XZZ1KM831349', 'LPCR53', '1', 100000.00, 100000.00, 'LAS BLANCAS', '', 'MOVILIZADO', '2024-04-10'),
(226, 3, 'TRACTOCAMION', 'MAN', 'TGX 26480 BLS 6X4 TIPCMATIC', '', '2020', 'WMA30XZZ0KM831231', 'LPCR54', '1', 45678.00, 100000.00, 'LAS BLANCAS', '', 'MOVILIZADO', '2024-04-10'),
(227, 3, 'TRACTOCAMION', 'MAN', 'TGX 26480 BLS 6X4 TIPCMATIC', '', '2020', 'WMA30XZZ7KM831260', 'LPCR55', '1', 100000.00, 100000.00, 'LAS BLANCAS', '', 'MOVILIZADO', '2024-04-10'),
(228, 3, 'TRACTOCAMION', 'MAN', 'TGX 26480 BLS 6X4 TIPCMATIC', '', '2020', 'WMA30XZZ0KM831245', 'LPCR60', '1', 1000000.00, 100000.00, 'LAS BLANCAS', '', 'DESMOVILIZADO', '2024-04-10'),
(229, 3, 'TRACTOCAMION', 'MAN', 'TGX 26480 BLS 6X4 TIPCMATIC', '', '2020', 'WMA30XZZ9KM831258', 'LPCR61', '1', 100000.00, 100000.00, 'LAS BLANCAS', '', 'MOVILIZADO', '2024-04-10'),
(230, 3, 'TRACTOCAMION', 'MAN', 'TGX 26480 BLS 6X4 TIPCMATIC', '', '2021', 'WMA30XZZ6MM870702', 'PKZY57', '1', 100000.00, 100000.00, 'LAS BLANCAS', '', 'MOVILIZADO', '2024-04-10'),
(231, 3, 'TRACTOCAMION', 'MAN', 'TGX 26480 BLS 6X4 TIPCMATIC', '', '2021', 'WMA30XZZMM870091', 'PKZY58', '1', 100000.00, 100000.00, 'LAS BLANCAS', '', 'MOVILIZADO', '2024-04-10'),
(232, 3, 'TRACTOCAMION', 'MAN', 'TGX 26480 BLS 6X4 TIPCMATIC', '', '2021', 'WMA30XZZ0MY423128', 'PKZZ14', '1', 100000.00, 100000.00, 'LAS BLANCAS', '', 'MOVILIZADO', '2024-04-10'),
(233, 3, 'TRACTOCAMION', 'MAN', 'TGX 26480 BLS 6X4 TIPCMATIC', '', '2021', 'WMA30XZZ0MY423291', 'PKZZ42', '1', 100000.00, 100000.00, 'LAS BLANCAS', '', 'MOVILIZADO', '2024-04-10'),
(234, 3, 'TRACTOCAMION', 'MAN', 'TGX 26480 BLS 6X4 TIPCMATIC', '', '2020', 'WMA30XZZ5LM840878', 'LXTY71', '1', 100000.00, 100000.00, 'LAS BLANCAS', '', 'MOVILIZADO', '2024-04-10');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividades_solicitud`
--
ALTER TABLE `actividades_solicitud`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `actividades_solicitud_panne`
--
ALTER TABLE `actividades_solicitud_panne`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `actividad_archivos`
--
ALTER TABLE `actividad_archivos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `actividad_archivos_panne`
--
ALTER TABLE `actividad_archivos_panne`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `actividad_panne`
--
ALTER TABLE `actividad_panne`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `actividad_panne_cierre`
--
ALTER TABLE `actividad_panne_cierre`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `actividad_realizadas`
--
ALTER TABLE `actividad_realizadas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `actividad_tallerip`
--
ALTER TABLE `actividad_tallerip`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `actividad_unidad_estados`
--
ALTER TABLE `actividad_unidad_estados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `asignaciones_inspector`
--
ALTER TABLE `asignaciones_inspector`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cliente_personal_profile`
--
ALTER TABLE `cliente_personal_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cliente_persona_laboral`
--
ALTER TABLE `cliente_persona_laboral`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `control_acceso`
--
ALTER TABLE `control_acceso`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `control_tareas`
--
ALTER TABLE `control_tareas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`iddepartamento`);

--
-- Indices de la tabla `departamento_manager`
--
ALTER TABLE `departamento_manager`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empresa_profile`
--
ALTER TABLE `empresa_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `endpoints`
--
ALTER TABLE `endpoints`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `google_captcha`
--
ALTER TABLE `google_captcha`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mantenimientos`
--
ALTER TABLE `mantenimientos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `menu_lateral`
--
ALTER TABLE `menu_lateral`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `paises`
--
ALTER TABLE `paises`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `persona_address`
--
ALTER TABLE `persona_address`
  ADD PRIMARY KEY (`idaddress`),
  ADD KEY `idaddress` (`idaddress`);

--
-- Indices de la tabla `persona_laboral`
--
ALTER TABLE `persona_laboral`
  ADD PRIMARY KEY (`idhistorial`);

--
-- Indices de la tabla `persona_log`
--
ALTER TABLE `persona_log`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `persona_menu`
--
ALTER TABLE `persona_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `persona_profile`
--
ALTER TABLE `persona_profile`
  ADD PRIMARY KEY (`idpersona`),
  ADD UNIQUE KEY `correo` (`email`);

--
-- Indices de la tabla `unidades_profile`
--
ALTER TABLE `unidades_profile`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividades_solicitud`
--
ALTER TABLE `actividades_solicitud`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `actividades_solicitud_panne`
--
ALTER TABLE `actividades_solicitud_panne`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `actividad_archivos`
--
ALTER TABLE `actividad_archivos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `actividad_archivos_panne`
--
ALTER TABLE `actividad_archivos_panne`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `actividad_panne`
--
ALTER TABLE `actividad_panne`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `actividad_panne_cierre`
--
ALTER TABLE `actividad_panne_cierre`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `actividad_realizadas`
--
ALTER TABLE `actividad_realizadas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `actividad_tallerip`
--
ALTER TABLE `actividad_tallerip`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `actividad_unidad_estados`
--
ALTER TABLE `actividad_unidad_estados`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=218;

--
-- AUTO_INCREMENT de la tabla `asignaciones_inspector`
--
ALTER TABLE `asignaciones_inspector`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `cliente_personal_profile`
--
ALTER TABLE `cliente_personal_profile`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cliente_persona_laboral`
--
ALTER TABLE `cliente_persona_laboral`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `control_acceso`
--
ALTER TABLE `control_acceso`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `control_tareas`
--
ALTER TABLE `control_tareas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `iddepartamento` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `departamento_manager`
--
ALTER TABLE `departamento_manager`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `empresa_profile`
--
ALTER TABLE `empresa_profile`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `endpoints`
--
ALTER TABLE `endpoints`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `google_captcha`
--
ALTER TABLE `google_captcha`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `mantenimientos`
--
ALTER TABLE `mantenimientos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `menu_lateral`
--
ALTER TABLE `menu_lateral`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `paises`
--
ALTER TABLE `paises`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;

--
-- AUTO_INCREMENT de la tabla `persona_address`
--
ALTER TABLE `persona_address`
  MODIFY `idaddress` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT de la tabla `persona_laboral`
--
ALTER TABLE `persona_laboral`
  MODIFY `idhistorial` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de la tabla `persona_log`
--
ALTER TABLE `persona_log`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `persona_menu`
--
ALTER TABLE `persona_menu`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT de la tabla `persona_profile`
--
ALTER TABLE `persona_profile`
  MODIFY `idpersona` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT de la tabla `unidades_profile`
--
ALTER TABLE `unidades_profile`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=235;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
