-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 23-02-2024 a las 15:22:15
-- Versión del servidor: 10.11.6-MariaDB-cll-lve
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u449361364_amigo_secreto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `id` int(11) NOT NULL,
  `id_sala` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_usuario_corresponde` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`id`, `id_sala`, `id_usuario`, `id_usuario_corresponde`) VALUES
(21, 7, 19, 42),
(22, 7, 33, 41),
(23, 7, 34, 19),
(24, 7, 35, 39),
(25, 7, 2, 33),
(26, 7, 37, 35),
(27, 7, 38, 40),
(28, 7, 39, 37),
(29, 7, 40, 38),
(30, 7, 41, 2),
(31, 7, 42, 34),
(32, 8, 43, 44),
(33, 8, 44, 2),
(34, 8, 2, 43);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salas`
--

CREATE TABLE `salas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_limite` date NOT NULL,
  `codigo` varchar(12) NOT NULL,
  `id_creador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `salas`
--

INSERT INTO `salas` (`id`, `nombre`, `descripcion`, `fecha_limite`, `codigo`, `id_creador`) VALUES
(7, 'Amigo Navideño 🤗', 'Regalos y compartir 🎁🎉', '2023-11-29', 'eAKvL6Dr3qsL', 19),
(8, 'Compartir amigo', 'Hola babys', '2023-11-30', 'gBO24vY138gy', 43);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `indicativo` int(3) NOT NULL,
  `whatsapp` bigint(20) DEFAULT NULL,
  `codigo` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `indicativo`, `whatsapp`, `codigo`) VALUES
(2, 'Juan Silva', 57, 3112119638, 2906),
(19, 'Alexa', 57, 3183607177, 9876),
(33, 'Diego Tovar', 57, 3054744178, 1992),
(34, 'Michelle Montoya', 57, 3182599888, 1589),
(35, 'Jose G', 57, 3105665746, 1525),
(36, 'Leslye Toro', 57, 3127369063, 1030),
(37, 'Leslye Toro', 57, 3142694524, 1030),
(38, 'Kelly Williamson', 57, 3186227701, 1277),
(39, 'LORE', 57, 3185769768, 1234),
(40, 'Juan Estevan Williamson', 57, 3214381717, 7712),
(41, 'Matheus 🔥💙', 57, 3053501708, 2911),
(42, 'Johan', 57, 3174352965, 9786),
(43, 'Andres Salazar', 57, 3132786951, 608),
(44, 'Banessa Barrios', 57, 3223852196, 2808);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sala` (`id_sala`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_usuario_corresponde` (`id_usuario_corresponde`);

--
-- Indices de la tabla `salas`
--
ALTER TABLE `salas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `id_creador` (`id_creador`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `whatsapp` (`whatsapp`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `salas`
--
ALTER TABLE `salas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD CONSTRAINT `grupos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `grupos_ibfk_2` FOREIGN KEY (`id_sala`) REFERENCES `salas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `grupos_ibfk_3` FOREIGN KEY (`id_usuario_corresponde`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `salas`
--
ALTER TABLE `salas`
  ADD CONSTRAINT `salas_ibfk_1` FOREIGN KEY (`id_creador`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
