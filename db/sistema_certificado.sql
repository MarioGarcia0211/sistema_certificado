-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-05-2024 a las 07:23:29
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
-- Base de datos: `sistema_certificado`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencias`
--

CREATE TABLE `asistencias` (
  `idAsistencia` int(11) NOT NULL,
  `idEstudianteA` int(11) NOT NULL,
  `idCursoA` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `estado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `idCurso` int(11) NOT NULL,
  `curso` varchar(50) NOT NULL,
  `idUsuarioProfesor` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `horaInicio` time NOT NULL,
  `horaFin` time NOT NULL,
  `precio` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`idCurso`, `curso`, `idUsuarioProfesor`, `descripcion`, `horaInicio`, `horaFin`, `precio`, `estado`) VALUES
(1, 'Español', 4, '', '00:00:00', '00:00:00', 110000, 1),
(2, 'Matematica', 3, '', '00:00:00', '00:00:00', 112000, 1),
(3, 'Quimica', 4, '', '00:00:00', '00:00:00', 103000, 1),
(4, 'Ingles', 3, 'Este curso está diseñado para aquellos que están dando sus primeros pasos en el mundo del idioma inglés. Desde las bases fundamentales hasta la práctica de conversación, te guiaremos en cada paso del camino para que desarrolles habilidades sólidas en el idioma.\r\n\r\nLo que Aprenderás:\r\n\r\n-Fundamentos del Idioma: Dominarás la gramática esencial y el vocabulario básico para construir una base sólida en inglés.\r\n-Habilidades de Conversación: Aprenderás a comunicarte con confianza en situaciones cotidianas, desarrollando habilidades prácticas para la vida diaria.\r\n-Comprensión Auditiva y Lectura: Mejorarás tu capacidad para entender y seguir conversaciones, así como la lectura de textos simples en inglés.\r\n-Ejercicios Prácticos: Aplicarás lo aprendido a través de ejercicios prácticos y tareas que refuercen tu comprensión y habilidades lingüísticas.', '13:30:00', '15:30:00', 120000, 1),
(5, 'Php', 7, 'asklndfoqeifoqihefd\r\nlasdnalknf\r\nnalse', '18:00:00', '20:00:00', 123000, 1),
(6, 'Operador de medios tecnologico', 7, 'aksldbalskdasdasdkasdlkasdsadsadasd', '05:12:00', '08:12:00', 120000, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matricula`
--

CREATE TABLE `matricula` (
  `idMatricula` int(11) NOT NULL,
  `idCursoM` int(11) NOT NULL,
  `idEstudianteM` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `matricula`
--

INSERT INTO `matricula` (`idMatricula`, `idCursoM`, `idEstudianteM`, `estado`, `fecha`) VALUES
(18, 3, 9, 0, '2024-05-17 11:01:24'),
(19, 6, 9, 1, '2024-05-17 11:03:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas`
--

CREATE TABLE `notas` (
  `idNota` int(11) NOT NULL,
  `idEstudiante` int(11) NOT NULL,
  `idCurso` int(11) NOT NULL,
  `notaUno` decimal(5,1) NOT NULL DEFAULT 0.0,
  `notaDos` decimal(5,1) NOT NULL DEFAULT 0.0,
  `notaTres` decimal(5,1) NOT NULL DEFAULT 0.0,
  `notaDefinitiva` decimal(5,2) NOT NULL DEFAULT 0.00,
  `estado` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notas`
--

INSERT INTO `notas` (`idNota`, `idEstudiante`, `idCurso`, `notaUno`, `notaDos`, `notaTres`, `notaDefinitiva`, `estado`) VALUES
(17, 9, 3, 0.0, 0.0, 0.0, 0.00, 0),
(18, 9, 6, 0.0, 0.0, 0.0, 0.00, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `idRol` int(11) NOT NULL,
  `rol` varchar(50) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`idRol`, `rol`, `estado`) VALUES
(1, 'Administrador', 1),
(2, 'Profesor', 1),
(3, 'Estudiante', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipodocumento`
--

CREATE TABLE `tipodocumento` (
  `idTipoDocumento` int(11) NOT NULL,
  `tipoDocumento` varchar(50) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipodocumento`
--

INSERT INTO `tipodocumento` (`idTipoDocumento`, `tipoDocumento`, `estado`) VALUES
(1, 'Cedula de ciudadania', 1),
(2, 'Cedula de extranjeria', 1),
(3, 'Tarjeta de identidad', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `email` text NOT NULL,
  `clave` text NOT NULL,
  `idTipoDocumento` int(11) NOT NULL,
  `numeroDocumento` int(11) NOT NULL,
  `idRol` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `nombre`, `apellido`, `email`, `clave`, `idTipoDocumento`, `numeroDocumento`, `idRol`, `estado`) VALUES
(1, 'Admin', 'Administra', 'admin@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 3, 123123, 1, 1),
(2, 'Mario', 'Garcia', 'mario@gmail.com', 'de2f15d014d40b93578d255e6221fd60', 1, 1007784144, 3, 1),
(3, 'Prueba', 'PruebaA', 'prueba@gmail.com', 'c893bad68927b457dbed39460e6afd62', 2, 12341234, 2, 1),
(4, 'PruebaDos', 'PruebaB', 'prueba2@gmail.com', '96080775c113b0e5c3e32bdd26214aec', 1, 222222, 2, 1),
(5, 'Luis', 'Diaz', 'luisdiaz@gmail.com', '502ff82f7f1f8218dd41201fe4353687', 1, 1234567, 3, 1),
(6, 'James', 'Rodrigúez', 'james@gmail.com', 'b4cc344d25a2efe540adbf2678e2304c', 1, 10101010, 3, 1),
(7, 'David', 'Portocarrero', 'david@gmail.com', '172522ec1028ab781d9dfd17eaca4427', 1, 11221122, 2, 1),
(8, 'Camila', 'Hurtado', 'camila@gmail.com', 'f5ffc847c2072ffb5fda82edd30bc19f', 1, 8080808, 3, 1),
(9, 'Leydi', 'Mosquera', 'leydi@gmail.com', '634fe12ec12b675660be97650f54c88d', 2, 20202020, 3, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD PRIMARY KEY (`idAsistencia`),
  ADD KEY `idCursoA` (`idCursoA`),
  ADD KEY `idEstudianteA` (`idEstudianteA`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`idCurso`),
  ADD KEY `idUsuarioProfesor` (`idUsuarioProfesor`);

--
-- Indices de la tabla `matricula`
--
ALTER TABLE `matricula`
  ADD PRIMARY KEY (`idMatricula`),
  ADD KEY `idCursoM` (`idCursoM`),
  ADD KEY `idEstudianteM` (`idEstudianteM`);

--
-- Indices de la tabla `notas`
--
ALTER TABLE `notas`
  ADD PRIMARY KEY (`idNota`),
  ADD KEY `idCurso` (`idCurso`),
  ADD KEY `idEstudiante` (`idEstudiante`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idRol`);

--
-- Indices de la tabla `tipodocumento`
--
ALTER TABLE `tipodocumento`
  ADD PRIMARY KEY (`idTipoDocumento`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `idRol` (`idRol`),
  ADD KEY `idTipoDocumento` (`idTipoDocumento`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  MODIFY `idAsistencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `idCurso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `matricula`
--
ALTER TABLE `matricula`
  MODIFY `idMatricula` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `notas`
--
ALTER TABLE `notas`
  MODIFY `idNota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `idRol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipodocumento`
--
ALTER TABLE `tipodocumento`
  MODIFY `idTipoDocumento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD CONSTRAINT `asistencias_ibfk_1` FOREIGN KEY (`idCursoA`) REFERENCES `cursos` (`idCurso`),
  ADD CONSTRAINT `asistencias_ibfk_2` FOREIGN KEY (`idEstudianteA`) REFERENCES `usuarios` (`idUsuario`);

--
-- Filtros para la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD CONSTRAINT `cursos_ibfk_1` FOREIGN KEY (`idUsuarioProfesor`) REFERENCES `usuarios` (`idUsuario`);

--
-- Filtros para la tabla `matricula`
--
ALTER TABLE `matricula`
  ADD CONSTRAINT `matricula_ibfk_1` FOREIGN KEY (`idCursoM`) REFERENCES `cursos` (`idCurso`),
  ADD CONSTRAINT `matricula_ibfk_2` FOREIGN KEY (`idEstudianteM`) REFERENCES `usuarios` (`idUsuario`);

--
-- Filtros para la tabla `notas`
--
ALTER TABLE `notas`
  ADD CONSTRAINT `notas_ibfk_1` FOREIGN KEY (`idCurso`) REFERENCES `cursos` (`idCurso`),
  ADD CONSTRAINT `notas_ibfk_2` FOREIGN KEY (`idEstudiante`) REFERENCES `usuarios` (`idUsuario`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`idRol`) REFERENCES `roles` (`idRol`),
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`idTipoDocumento`) REFERENCES `tipodocumento` (`idTipoDocumento`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
