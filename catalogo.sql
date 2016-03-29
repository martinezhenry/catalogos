-- phpMyAdmin SQL Dump
-- version 4.5.3.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-03-2016 a las 04:17:39
-- Versión del servidor: 5.7.10
-- Versión de PHP: 5.6.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cat`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo`
--

CREATE TABLE `catalogo` (
  `id` int(11) NOT NULL,
  `id_catalogo` int(11) NOT NULL,
  `titulo` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(800) COLLATE utf8_spanish_ci NOT NULL,
  `codigo` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `portada` varchar(800) COLLATE utf8_spanish_ci NOT NULL,
  `fondo` varchar(800) COLLATE utf8_spanish_ci NOT NULL,
  `precio_pdf` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `titulo_fuente` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `titulo_tamano` int(11) NOT NULL,
  `titulo_color` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `titulo_estilo` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `titulo_ali_hor` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `titulo_ali_ver` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `co_us_in` int(11) NOT NULL,
  `fe_us_in` datetime NOT NULL,
  `co_us_mo` int(11) NOT NULL,
  `fe_us_mo` datetime NOT NULL,
  `co_us_de` int(11) NOT NULL,
  `fe_us_de` datetime NOT NULL,
  `presentacion` varchar(50) COLLATE utf8_spanish_ci NOT NULL DEFAULT '5x4'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `catalogo`
--
ALTER TABLE `catalogo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD UNIQUE KEY `id_catalogo` (`id_catalogo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `catalogo`
--
ALTER TABLE `catalogo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
