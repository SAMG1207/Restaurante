-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-09-2024 a las 15:44:17
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
-- Base de datos: `pizzeria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `id_servicio` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `totalPrecio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `tipo` enum('pizza','bebida','cafe') NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre`, `tipo`, `precio`, `descripcion`) VALUES
(1, 'Margarita', 'pizza', 5.50, 'Pizza Margarita: Tomate, AOVE, Albahaca, Queso'),
(2, 'Marinara', 'pizza', 6.00, 'Pizza Marinara: Tomate, aceite, ajo y albahaca'),
(3, 'Diavola', 'pizza', 8.00, 'Pizza Diavola: Tomate, queso, aceite, chorizo picante'),
(4, 'Napolitana', 'pizza', 8.00, 'Pizza Napolitana: Tomate, queso, aceite, anchoas, aceitunas'),
(5, 'Capuccino', 'cafe', 2.00, 'Cafe Capuccino: Café con crema de leche y leche por debajo'),
(6, 'Expreso', 'cafe', 1.00, 'Cafe Expreso: sencillamente café'),
(7, 'Americano', 'cafe', 1.20, 'Café Americano: café con agua'),
(8, 'Cafe con leche', 'cafe', 1.50, 'Cafe con leche: café con leche'),
(9, 'Mahou', 'bebida', 2.50, 'Cerveza Mahou'),
(10, 'Alhambra', 'bebida', 2.50, 'Cerveza Alhambra'),
(11, 'Coca Cola', 'bebida', 2.50, 'Coca Cola'),
(12, 'Coca Cola Zero', 'bebida', 2.50, 'Coca Cola Zero'),
(13, 'Agua', 'bebida', 1.50, 'Agua');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id_servicio` int(11) NOT NULL,
  `mesa` int(11) NOT NULL,
  `hora_entrada` datetime DEFAULT NULL,
  `hora_salida` datetime DEFAULT NULL,
  `total_gastado` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id_servicio`, `mesa`, `hora_entrada`, `hora_salida`, `total_gastado`) VALUES
(56, 4, '2024-09-27 12:26:02', NULL, NULL),
(57, 3, '2024-09-27 12:27:19', '2024-09-27 12:32:37', NULL),
(58, 5, '2024-09-27 13:27:13', NULL, NULL),
(59, 3, '2024-09-27 18:33:35', NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_servicio` (`id_servicio`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id_servicio`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`),
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
