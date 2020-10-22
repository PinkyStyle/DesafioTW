-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-10-2020 a las 20:54:10
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `desafio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `centro`
--

CREATE TABLE `centro` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `latitud` double NOT NULL,
  `longitud` double NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `centro`
--

INSERT INTO `centro` (`id`, `nombre`, `direccion`, `latitud`, `longitud`, `estado`) VALUES
(11, 'Contabilidad', 'I', 0, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

CREATE TABLE `historial` (
  `id` int(11) NOT NULL,
  `user` varchar(12) NOT NULL,
  `fecha` datetime NOT NULL,
  `accion` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registros`
--

CREATE TABLE `registros` (
  `id` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `ingreso` int(11) NOT NULL,
  `egreso` int(11) NOT NULL,
  `saldo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `registros`
--

INSERT INTO `registros` (`id`, `fecha`, `descripcion`, `ingreso`, `egreso`, `saldo`) VALUES
(1, '2020-10-10 19:28:58', 'Pago Factura #1', 500000, 0, 500000),
(2, '2020-10-10 19:30:31', 'Combustible', 0, 150000, 350000),
(3, '2020-10-10 19:30:46', 'Sueldos', 0, 450000, -100000),
(4, '2020-10-10 19:31:27', 'Pago Factura #2', 5000000, 0, 4900000),
(5, '2020-10-10 20:52:31', 'Compra de Insumos', 0, 100000, 4800000),
(6, '2020-10-10 20:53:31', 'Sueldo', 0, 500000, 4300000),
(7, '2020-10-10 20:54:03', 'Prueba', 100, 0, 4300100),
(8, '2020-10-10 20:54:11', 'Prueba 2', 200, 0, 4300300),
(9, '2020-10-10 20:54:23', 'Prueba 3', 0, 100, 4300200),
(10, '2020-10-10 20:54:31', 'Prueba 4', 0, 100, 4300100),
(11, '2020-10-10 20:54:46', 'Prueba 5', 0, 500000, 3800100),
(12, '2020-10-10 20:55:42', 'Prueba 6', 0, 500000, 3300100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usce`
--

CREATE TABLE `usce` (
  `id` int(11) NOT NULL,
  `idce` int(11) NOT NULL,
  `idus` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usce`
--

INSERT INTO `usce` (`id`, `idce`, `idus`, `estado`, `fecha`) VALUES
(16, 11, 11, 0, '2020-07-27'),
(17, 11, 10, 1, '2020-07-27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `rut` varchar(12) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `clave` varchar(32) NOT NULL,
  `fnac` date NOT NULL,
  `especialidad` varchar(20) NOT NULL,
  `rol` varchar(20) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 0,
  `acceso` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `rut`, `nombre`, `apellido`, `nickname`, `clave`, `fnac`, `especialidad`, `rol`, `estado`, `acceso`) VALUES
(10, '2-7', 'Desafio', '', '', '202cb962ac59075b964b07152d234b70', '2000-01-11', 'Ingeniero', 'Funcionario', 0, '2020-10-15 20:52:34'),
(11, '1-7', 'Rodrigo Pavez', '', '', '08cdb0d85baa1afd57c6a2dd3dab3d59', '1985-09-24', 'Ingeniero', 'Administrador', 0, '2020-10-10 22:01:37');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `centro`
--
ALTER TABLE `centro`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `historial`
--
ALTER TABLE `historial`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `registros`
--
ALTER TABLE `registros`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usce`
--
ALTER TABLE `usce`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `centro`
--
ALTER TABLE `centro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `registros`
--
ALTER TABLE `registros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `usce`
--
ALTER TABLE `usce`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
