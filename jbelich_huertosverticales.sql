-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 25-04-2025 a las 23:47:47
-- Versión del servidor: 8.0.41-0ubuntu0.20.04.1
-- Versión de PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `jbelich_huertosverticales`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Huertos`
--

CREATE TABLE `Huertos` (
  `huerto_id` int NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `ubicacion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `Huertos`
--

INSERT INTO `Huertos` (`huerto_id`, `nombre`, `ubicacion`) VALUES
(1, 'Huerto1', 'Calle 123, Ciudad'),
(2, 'Huerto2', 'Avenida 456, Ciudad'),
(3, 'Huerto3', 'Calle 123, Ciudad'),
(4, 'Huerto4', 'Avenida 456, Ciudad'),
(5, 'Huerto5', 'Calle 123, Ciudad'),
(6, 'Huerto6', 'Avenida 456, Ciudad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Instalaciones`
--

CREATE TABLE `Instalaciones` (
  `instalacion_id` int NOT NULL,
  `huerto_id` int DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL,
  `fecha_instalacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `Instalaciones`
--

INSERT INTO `Instalaciones` (`instalacion_id`, `huerto_id`, `token`, `fecha_instalacion`) VALUES
(1, 1, 'token-123', '2024-05-01'),
(2, 2, 'token-456', '2024-05-02'),
(1760, 1, 'token-123', '2025-02-28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Mediciones`
--

CREATE TABLE `Mediciones` (
  `medicion_id` int NOT NULL,
  `instalacion_id` int DEFAULT NULL,
  `fecha_medicion` datetime DEFAULT NULL,
  `tipo_medicion` varchar(50) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `Mediciones`
--

INSERT INTO `Mediciones` (`medicion_id`, `instalacion_id`, `fecha_medicion`, `tipo_medicion`, `valor`) VALUES
(1, 1, '2024-05-01 10:00:00', 'Temperatura', 23.50),
(2, 1, '2024-05-02 11:00:00', 'Temperatura', 24.00),
(3, 1, '2024-05-03 10:00:00', 'Temperatura', 23.50),
(4, 1, '2024-05-04 11:00:00', 'Temperatura', 24.00),
(5, 1, '2024-05-05 10:00:00', 'Temperatura', 23.50),
(6, 1, '2024-05-06 11:00:00', 'Temperatura', 24.00),
(7, 1, '2024-05-07 10:00:00', 'Temperatura', 23.50),
(8, 1, '2024-05-08 11:00:00', 'Temperatura', 24.00),
(9, 1, '2024-05-01 10:05:00', 'Humedad', 55.00),
(10, 1, '2024-05-02 11:05:00', 'Humedad', 54.50),
(11, 1, '2024-05-03 10:05:00', 'Humedad', 55.00),
(12, 1, '2024-05-04 11:05:00', 'Humedad', 54.50),
(13, 1, '2024-05-05 10:05:00', 'Humedad', 55.00),
(14, 1, '2024-05-06 11:05:00', 'Humedad', 54.50),
(15, 1, '2024-05-07 10:05:00', 'Humedad', 55.00),
(16, 1, '2024-05-08 11:05:00', 'Humedad', 54.50),
(17, 1, '2024-05-01 10:10:00', 'Luminosidad', 300.00),
(18, 1, '2024-05-02 11:10:00', 'Luminosidad', 305.00),
(19, 1, '2024-05-03 10:10:00', 'Luminosidad', 300.00),
(20, 1, '2024-05-04 11:10:00', 'Luminosidad', 305.00),
(21, 1, '2024-05-05 10:10:00', 'Luminosidad', 300.00),
(22, 1, '2024-05-06 11:10:00', 'Luminosidad', 305.00),
(23, 1, '2024-05-07 10:10:00', 'Luminosidad', 300.00),
(24, 1, '2024-05-08 11:10:00', 'Luminosidad', 305.00),
(25, 1, '2024-05-01 10:15:00', 'Ph', 6.50),
(26, 1, '2024-05-02 11:15:00', 'Ph', 6.40),
(27, 1, '2024-05-03 10:15:00', 'Ph', 6.50),
(28, 1, '2024-05-04 11:15:00', 'Ph', 6.40),
(29, 1, '2024-05-05 10:15:00', 'Ph', 6.50),
(30, 1, '2024-05-06 11:15:00', 'Ph', 6.40),
(31, 1, '2024-05-07 10:15:00', 'Ph', 6.50),
(32, 1, '2024-05-08 11:15:00', 'Ph', 6.40),
(33, 1, '2024-05-01 10:20:00', 'Salinidad', 1.20),
(34, 1, '2024-05-02 11:20:00', 'Salinidad', 1.30),
(35, 1, '2024-05-03 10:20:00', 'Salinidad', 1.20),
(36, 1, '2024-05-04 11:20:00', 'Salinidad', 1.30),
(37, 1, '2024-05-05 10:20:00', 'Salinidad', 1.20),
(38, 1, '2024-05-06 11:20:00', 'Salinidad', 1.30),
(39, 1, '2024-05-07 10:20:00', 'Salinidad', 1.20),
(40, 1, '2024-05-08 11:20:00', 'Salinidad', 1.30),
(41, 2, '2024-05-01 10:00:00', 'Temperatura', 22.50),
(42, 2, '2024-05-02 11:00:00', 'Temperatura', 23.00),
(43, 2, '2024-05-03 10:00:00', 'Temperatura', 22.50),
(44, 2, '2024-05-04 11:00:00', 'Temperatura', 23.00),
(45, 2, '2024-05-05 10:00:00', 'Temperatura', 22.50),
(46, 2, '2024-05-06 11:00:00', 'Temperatura', 23.00),
(47, 2, '2024-05-07 10:00:00', 'Temperatura', 22.50),
(48, 2, '2024-05-08 11:00:00', 'Temperatura', 23.00),
(49, 2, '2024-05-01 10:05:00', 'Humedad', 50.00),
(50, 2, '2024-05-02 11:05:00', 'Humedad', 49.50),
(51, 2, '2024-05-03 10:05:00', 'Humedad', 50.00),
(52, 2, '2024-05-04 11:05:00', 'Humedad', 49.50),
(53, 2, '2024-05-05 10:05:00', 'Humedad', 50.00),
(54, 2, '2024-05-06 11:05:00', 'Humedad', 49.50),
(55, 2, '2024-05-07 10:05:00', 'Humedad', 50.00),
(56, 2, '2024-05-08 11:05:00', 'Humedad', 49.50),
(57, 2, '2024-05-01 10:10:00', 'Luminosidad', 320.00),
(58, 2, '2024-05-02 11:10:00', 'Luminosidad', 315.00),
(59, 2, '2024-05-03 10:10:00', 'Luminosidad', 320.00),
(60, 2, '2024-05-04 11:10:00', 'Luminosidad', 315.00),
(61, 2, '2024-05-05 10:10:00', 'Luminosidad', 320.00),
(62, 2, '2024-05-06 11:10:00', 'Luminosidad', 315.00),
(63, 2, '2024-05-07 10:10:00', 'Luminosidad', 320.00),
(64, 2, '2024-05-08 11:10:00', 'Luminosidad', 315.00),
(65, 2, '2024-05-01 10:15:00', 'Ph', 6.70),
(66, 2, '2024-05-02 11:15:00', 'Ph', 6.60),
(67, 2, '2024-05-03 10:15:00', 'Ph', 6.70),
(68, 2, '2024-05-04 11:15:00', 'Ph', 6.60),
(69, 2, '2024-05-05 10:15:00', 'Ph', 6.70),
(70, 2, '2024-05-06 11:15:00', 'Ph', 6.60),
(71, 2, '2024-05-07 10:15:00', 'Ph', 6.70),
(72, 2, '2024-05-08 11:15:00', 'Ph', 6.60),
(73, 2, '2024-05-01 10:20:00', 'Salinidad', 1.10),
(74, 2, '2024-05-02 11:20:00', 'Salinidad', 1.00),
(75, 2, '2024-05-03 10:20:00', 'Salinidad', 1.10),
(76, 2, '2024-05-04 11:20:00', 'Salinidad', 1.00),
(77, 2, '2024-05-05 10:20:00', 'Salinidad', 1.10),
(78, 2, '2024-05-06 11:20:00', 'Salinidad', 1.00),
(79, 2, '2024-05-07 10:20:00', 'Salinidad', 1.10),
(80, 2, '2024-05-08 11:20:00', 'Salinidad', 1.00),
(81, 1760, '2024-05-01 00:00:00', 'Temperatura', 41.50),
(82, 1760, '2024-05-02 00:00:00', 'Temperatura', 47.30),
(83, 1760, '2024-05-03 00:00:00', 'Temperatura', 62.00),
(84, 1760, '2024-05-04 00:00:00', 'Temperatura', 41.20),
(85, 1760, '2024-05-05 00:00:00', 'Temperatura', 45.40),
(86, 1760, '2024-05-06 00:00:00', 'Temperatura', 57.30),
(87, 1760, '2024-05-07 00:00:00', 'Temperatura', 2.30),
(88, 1760, '2024-05-01 00:00:00', 'Humedad', 46.90),
(89, 1760, '2024-05-02 00:00:00', 'Humedad', 15.60),
(90, 1760, '2024-05-03 00:00:00', 'Humedad', 44.50),
(91, 1760, '2024-05-04 00:00:00', 'Humedad', 23.80),
(92, 1760, '2024-05-05 00:00:00', 'Humedad', 88.60),
(93, 1760, '2024-05-06 00:00:00', 'Humedad', 30.90),
(94, 1760, '2024-05-07 00:00:00', 'Humedad', 12.70),
(95, 1760, '2024-05-01 00:00:00', 'Luminosidad', 49.10),
(96, 1760, '2024-05-02 00:00:00', 'Luminosidad', 16.80),
(97, 1760, '2024-05-03 00:00:00', 'Luminosidad', 1.90),
(98, 1760, '2024-05-04 00:00:00', 'Luminosidad', 92.10),
(99, 1760, '2024-05-05 00:00:00', 'Luminosidad', 68.70),
(100, 1760, '2024-05-06 00:00:00', 'Luminosidad', 31.00),
(101, 1760, '2024-05-07 00:00:00', 'Luminosidad', 84.90),
(102, 1760, '2024-05-01 00:00:00', 'Ph', 4.30),
(103, 1760, '2024-05-02 00:00:00', 'Ph', 92.00),
(104, 1760, '2024-05-03 00:00:00', 'Ph', 56.60),
(105, 1760, '2024-05-04 00:00:00', 'Ph', 39.60),
(106, 1760, '2024-05-05 00:00:00', 'Ph', 74.80),
(107, 1760, '2024-05-06 00:00:00', 'Ph', 6.70),
(108, 1760, '2024-05-07 00:00:00', 'Ph', 90.10),
(109, 1760, '2024-05-01 00:00:00', 'Salinidad', 57.70),
(110, 1760, '2024-05-02 00:00:00', 'Salinidad', 88.60),
(111, 1760, '2024-05-03 00:00:00', 'Salinidad', 34.30),
(112, 1760, '2024-05-04 00:00:00', 'Salinidad', 74.20),
(113, 1760, '2024-05-05 00:00:00', 'Salinidad', 65.70),
(114, 1760, '2024-05-06 00:00:00', 'Salinidad', 52.40),
(115, 1760, '2024-05-07 00:00:00', 'Salinidad', 62.60);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Roles`
--

CREATE TABLE `Roles` (
  `rol_id` int NOT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `Roles`
--

INSERT INTO `Roles` (`rol_id`, `nombre`) VALUES
(2, 'Admin'),
(3, 'Usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Sondas`
--

CREATE TABLE `Sondas` (
  `sonda_id` int NOT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `modelo` varchar(50) DEFAULT NULL,
  `token` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `Sondas`
--

INSERT INTO `Sondas` (`sonda_id`, `tipo`, `modelo`, `token`) VALUES
(1, 'Multisensor', 'M-1000', 'token-123'),
(2, 'Multisensor', 'M-2000', 'token-456');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuarios`
--

CREATE TABLE `Usuarios` (
  `usuario_id` int NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `usuario` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `Usuarios`
--

INSERT INTO `Usuarios` (`usuario_id`, `nombre`, `email`, `usuario`, `contrasena`, `rol_id`) VALUES
(1, 'Juan Perez', 'juan.perez@example.com', 'usuario1', '$2y$10$2Mb53md2FgvtSo1ixv0mAePbU.G0YqCrtEh.1o6keYjYdtc4iZhfK', 3),
(2, 'Maria Gomez', 'maria.gomez@example.com', 'usuario2', '$2y$10$2Mb53md2FgvtSo1ixv0mAePbU.G0YqCrtEh.1o6keYjYdtc4iZhfK', 3),
(3, 'josue', 'josue123@gmail.com', 'josue123', '$2y$10$LCOVAZTStI71hd39kk.66O4P8m3G0101SPqc2vWUTpgVeuSkzX2ZG', 3),
(4, 'pepe', 'pepa123@gmail.com', 'pepe123', '$2y$10$0.aihCgS/OPj.g9w/YLo5ekM9yFfg/OzC8yMys2WtjV1crHkg5OXi', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuarios_Huertos`
--

CREATE TABLE `Usuarios_Huertos` (
  `usuario_id` int NOT NULL,
  `huerto_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `Usuarios_Huertos`
--

INSERT INTO `Usuarios_Huertos` (`usuario_id`, `huerto_id`) VALUES
(1, 1),
(2, 1),
(1, 2),
(2, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Huertos`
--
ALTER TABLE `Huertos`
  ADD PRIMARY KEY (`huerto_id`);

--
-- Indices de la tabla `Instalaciones`
--
ALTER TABLE `Instalaciones`
  ADD PRIMARY KEY (`instalacion_id`),
  ADD KEY `huerto_id` (`huerto_id`),
  ADD KEY `token` (`token`);

--
-- Indices de la tabla `Mediciones`
--
ALTER TABLE `Mediciones`
  ADD PRIMARY KEY (`medicion_id`),
  ADD KEY `instalacion_id` (`instalacion_id`);

--
-- Indices de la tabla `Roles`
--
ALTER TABLE `Roles`
  ADD PRIMARY KEY (`rol_id`);

--
-- Indices de la tabla `Sondas`
--
ALTER TABLE `Sondas`
  ADD PRIMARY KEY (`sonda_id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Indices de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  ADD PRIMARY KEY (`usuario_id`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD KEY `rol_id` (`rol_id`);

--
-- Indices de la tabla `Usuarios_Huertos`
--
ALTER TABLE `Usuarios_Huertos`
  ADD PRIMARY KEY (`usuario_id`,`huerto_id`),
  ADD KEY `huerto_id` (`huerto_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Huertos`
--
ALTER TABLE `Huertos`
  MODIFY `huerto_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  MODIFY `usuario_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Instalaciones`
--
ALTER TABLE `Instalaciones`
  ADD CONSTRAINT `Instalaciones_ibfk_1` FOREIGN KEY (`huerto_id`) REFERENCES `Huertos` (`huerto_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Instalaciones_ibfk_2` FOREIGN KEY (`token`) REFERENCES `Sondas` (`token`);

--
-- Filtros para la tabla `Mediciones`
--
ALTER TABLE `Mediciones`
  ADD CONSTRAINT `Mediciones_ibfk_1` FOREIGN KEY (`instalacion_id`) REFERENCES `Instalaciones` (`instalacion_id`);

--
-- Filtros para la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  ADD CONSTRAINT `Usuarios_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `Roles` (`rol_id`);

--
-- Filtros para la tabla `Usuarios_Huertos`
--
ALTER TABLE `Usuarios_Huertos`
  ADD CONSTRAINT `Usuarios_Huertos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `Usuarios` (`usuario_id`),
  ADD CONSTRAINT `Usuarios_Huertos_ibfk_2` FOREIGN KEY (`huerto_id`) REFERENCES `Huertos` (`huerto_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
