-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 26-05-2018 a las 06:14:20
-- Versión del servidor: 10.2.14-MariaDB
-- Versión de PHP: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `conekhub_test`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carreras`
--

CREATE TABLE `carreras` (
  `id_carrera` int(11) NOT NULL,
  `carrera` varchar(100) NOT NULL,
  `id_escuela` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `carreras`
--

INSERT INTO `carreras` (`id_carrera`, `carrera`, `id_escuela`) VALUES
(1, 'Contaduría Pública', 1),
(2, 'Licenciatura en Administración', 1),
(3, 'Licenciatura en Gastronomía', 2),
(4, 'Licenciatura en Negocios Internacionales', 2),
(5, 'Ingeniería en Mantenimiento Industrial', 3),
(6, 'Ingeniería Financiera y Fiscal', 3),
(7, 'Ingeniería en Sistemas Computacionales', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `escuelas`
--

CREATE TABLE `escuelas` (
  `id_escuela` int(11) NOT NULL,
  `escuela` varchar(100) NOT NULL,
  `matricula` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `escuelas`
--

INSERT INTO `escuelas` (`id_escuela`, `escuela`, `matricula`) VALUES
(1, 'Instituto Tecnológico de Cancún ', 1),
(2, 'Universidad del Caribe ', 2),
(3, 'Universidad Tecnológica de Cancún ', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `friendlist`
--

CREATE TABLE `friendlist` (
  `id_usuario` int(11) NOT NULL,
  `id_usuario_FK` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grados_escolares`
--

CREATE TABLE `grados_escolares` (
  `id_grado` int(11) NOT NULL,
  `grado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `grados_escolares`
--

INSERT INTO `grados_escolares` (`id_grado`, `grado`) VALUES
(1, '1er Semestre'),
(2, '2do Semestre'),
(3, '3er Semestre'),
(4, '4to Semestre'),
(5, '5to Semestre'),
(6, '6to Semestre');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habilidades`
--

CREATE TABLE `habilidades` (
  `id_habilidad` int(11) NOT NULL,
  `habilidad` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `habilidades`
--

INSERT INTO `habilidades` (`id_habilidad`, `habilidad`) VALUES
(1, 'UX'),
(2, 'UI'),
(3, 'HTML'),
(4, 'CSS'),
(5, 'SQL'),
(6, 'GIT'),
(7, 'Matematicas'),
(8, 'Ventas'),
(9, 'Trato con personas'),
(10, 'Contabilidad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `apellidos` varchar(40) NOT NULL,
  `correo` varchar(55) NOT NULL,
  `pass` varchar(20) NOT NULL,
  `id_escuela` int(11) DEFAULT NULL,
  `id_carrera` int(11) DEFAULT NULL,
  `id_grado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellidos`, `correo`, `pass`, `id_escuela`, `id_carrera`, `id_grado`) VALUES
(25, 'Josue ', 'Alonso Sanchez', 'alonsotec@itcancun.com', '123456', 1, 7, 5),
(26, 'Arturo', 'Medina Rios', 'artur@rios.com', '12345@2018', 1, 1, 1),
(27, 'Henrry', 'Ramirez', 'hramirez@itcancun.com', 'admin123', 1, 7, 6),
(28, 'Gameba ', 'Esteves Ceballos', 'gesteves@gmail.com', '123456', 1, 7, 5),
(30, 'Antonio', 'Hoil Gamboa', 'ahoil@itcancun.com', '123456', 2, 3, 1),
(31, 'Cristian', 'Gomez', 'henramirez@itcancun.com', '12222', 1, 2, 2),
(33, 'admin', 'admin', 'admin@admin.com', 'admin123', 1, 7, 6),
(34, 'Jose', 'Estrada', 'jestrada@gmail.com', '123456', 2, 3, 3),
(35, 'Luis', 'Escobedo Trenado', 'escobedotrenado@hotmail.com', '1234', 1, 7, 6),
(36, 'hola', '¿aaa', 'pitytezum@zaqutevedihotuq.com', 'Pa$$w0rd!', 2, 3, 4),
(37, 'josue', 'sanchez', 'josuesanchez1224@gmail.com', '12345', 1, 7, 6),
(38, 'ghh', 'NBVN', 'kapowomyr@tunuhaxamykocub.com', 'Pa$$w0rd!', 2, 4, 6),
(40, 'BBBH', 'BBB', 'xativele@fevytytoru.com', 'Pa$$w0rd!', 2, 4, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_has_habilidades`
--

CREATE TABLE `usuario_has_habilidades` (
  `id_usuario` int(11) DEFAULT NULL,
  `id_habilidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario_has_habilidades`
--

INSERT INTO `usuario_has_habilidades` (`id_usuario`, `id_habilidad`) VALUES
(27, 1),
(27, 2),
(28, 5),
(28, 7);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD PRIMARY KEY (`id_carrera`),
  ADD KEY `id_escuela` (`id_escuela`);

--
-- Indices de la tabla `escuelas`
--
ALTER TABLE `escuelas`
  ADD PRIMARY KEY (`id_escuela`);

--
-- Indices de la tabla `friendlist`
--
ALTER TABLE `friendlist`
  ADD PRIMARY KEY (`id_usuario`,`id_usuario_FK`),
  ADD KEY `id_usuario_FK` (`id_usuario_FK`);

--
-- Indices de la tabla `grados_escolares`
--
ALTER TABLE `grados_escolares`
  ADD PRIMARY KEY (`id_grado`);

--
-- Indices de la tabla `habilidades`
--
ALTER TABLE `habilidades`
  ADD PRIMARY KEY (`id_habilidad`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `id_escuela` (`id_escuela`),
  ADD KEY `id_carrera` (`id_carrera`),
  ADD KEY `id_grado` (`id_grado`);

--
-- Indices de la tabla `usuario_has_habilidades`
--
ALTER TABLE `usuario_has_habilidades`
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_habilidad` (`id_habilidad`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carreras`
--
ALTER TABLE `carreras`
  MODIFY `id_carrera` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `escuelas`
--
ALTER TABLE `escuelas`
  MODIFY `id_escuela` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `habilidades`
--
ALTER TABLE `habilidades`
  MODIFY `id_habilidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD CONSTRAINT `carreras_ibfk_1` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id_escuela`);

--
-- Filtros para la tabla `friendlist`
--
ALTER TABLE `friendlist`
  ADD CONSTRAINT `friendlist_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `friendlist_ibfk_2` FOREIGN KEY (`id_usuario_FK`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_escuela`) REFERENCES `escuelas` (`id_escuela`),
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`id_carrera`) REFERENCES `carreras` (`id_carrera`),
  ADD CONSTRAINT `usuarios_ibfk_3` FOREIGN KEY (`id_grado`) REFERENCES `grados_escolares` (`id_grado`);

--
-- Filtros para la tabla `usuario_has_habilidades`
--
ALTER TABLE `usuario_has_habilidades`
  ADD CONSTRAINT `usuario_has_habilidades_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `usuario_has_habilidades_ibfk_2` FOREIGN KEY (`id_habilidad`) REFERENCES `habilidades` (`id_habilidad`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
