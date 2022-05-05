-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-05-2022 a las 19:59:52
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mdirectory`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `cliente_id` int(10) NOT NULL,
  `cliente_dni` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_apellido` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_telefono` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `cliente_direccion` varchar(200) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` bigint(20) NOT NULL,
  `nombre_cliente` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `apellido_p_cliente` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `apellido_m_cliente` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `edad` int(11) NOT NULL,
  `direccion` varchar(500) COLLATE utf8_spanish2_ci NOT NULL,
  `telefono` varchar(17) COLLATE utf8_spanish2_ci NOT NULL,
  `tipo_sangre` int(11) NOT NULL,
  `no_tarjeta` varchar(250) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `paypal` varchar(250) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `email` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `pass` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `privilegio` int(11) NOT NULL,
  `imagen` varchar(500) COLLATE utf8_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre_cliente`, `apellido_p_cliente`, `apellido_m_cliente`, `edad`, `direccion`, `telefono`, `tipo_sangre`, `no_tarjeta`, `paypal`, `email`, `usuario`, `pass`, `privilegio`, `imagen`) VALUES
(1, 'Hector', 'González', 'Corazón', 20, 'Dirección Prueba', '5571109185', 1, '', '', 'hgonzalez@junglesystem.com.mx', 'hector1', 'YnFJbE40K0VCenZzVUlna2pjOUN4QT09', 5, 'icon.png'),
(2, 'Karlyta', 'Esquivel', 'Armenta', 21, 'Dirección Ejemplo 2, México', '5612345679', 1, '', 'kesquivel9655', 'kesquivel@junglesystem.com.mx', 'kesquivel1', 'V1FFMFQ3WG9TZW5SSlRTMEpZdUJudz09', 5, 'icon-2.png'),
(3, 'Carlos', 'Pérez', 'López', 8, 'Dirección, Ciudad, 45123', '5546464678', 7, '', '', 'carlos1@correo.com', 'carlos1', 'UG9qMFRFRm50M0RqY1ZpR2ZDYmdhZz09', 5, 'chapatin.png'),
(4, 'Prueba', 'De', 'Cuenta', 20, 'Calle, Ciudad, 45687', '5546798123', 2, '0123457896524125', '', 'prueba@correo.com', 'pruebac', 'UkFyUUZRb09UbEZVQ29FOUt3R1M4UT09', 5, '6.png'),
(6, 'Prueba', 'Para', 'Externo', 25, 'Dirección para extranjero, México', '5678941548', 3, '', 'extranjeropaypal', 'extranjero1@correo.com', 'extranjero1', 'R2VERmdzOWc3Tys0dGphNFBadDJUZz09', 5, 'corazones.png'),
(7, 'Segunda', 'Prueba', 'Externo', 10, 'Dirección de extranjero 2, México', '56784912236', 4, '01800256892000', '', 'extranjero2@correo.com', 'extranjero2', 'R2VERmdzOWc3Tys0dGphNFBadDJUZz09', 5, 'WhatsApp_Image_2022-03-11_at_12.55.18_PM-removebg-preview.png'),
(8, 'Tercera', 'Preba', 'Redirección', 22, 'Dirección del extranjero 3, México', '5612346521', 5, 'extrajero3', '', 'extranjero3@correo.com', 'extranjero3', 'R2VERmdzOWc3Tys0dGphNFBadDJUZz09', 5, 'icon.png'),
(9, 'Cuarta', 'Prueba', 'Extranjero', 21, 'Dirección de extranjero 4, México', '5612345625', 5, '123456789101112', '', 'extranjero4@correo.com', 'extranjero4', 'R2VERmdzOWc3Tys0dGphNFBadDJUZz09', 5, '6.png'),
(10, 'Quinta', 'Prueba', 'Extranjero', 29, 'Dirección de extranjero 5, México', '5612345678', 5, '', '', 'extranjero5@correo.com', 'extranjero5', 'R2VERmdzOWc3Tys0dGphNFBadDJUZz09', 5, '5.jpg'),
(11, 'Maria Elizabet', 'Corazon', 'Medina', 40, 'Dirección de prueba, México', '5645123678', 5, '', '', 'elizabet1@correo.com', 'eliazabet1', 'dUJHVkJZVFRQYnlTWmt3b3lvbmJ5Zz09', 5, 'icon.png'),
(12, 'Pamela', 'Gonzalez', 'Lopez', 19, 'Dirección de prueba 2, México', '5678452105', 1, '', '', 'pamela1@correo.com', 'pamela1', 'TEN2N3BpNXV2dXQ4VjZLWlVuaFordz09', 5, 'icon-2.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctores`
--

CREATE TABLE `doctores` (
  `id_doctor` bigint(20) NOT NULL,
  `nombre_doctor` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `apellido_p_doctor` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `apellido_m_doctor` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `nombre_negocio` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `direccion_consultorio` varchar(500) COLLATE utf8_spanish2_ci NOT NULL,
  `telefono` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `descripcion` varchar(500) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `email` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `pass` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `privilegio` int(11) NOT NULL,
  `imagen` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `id_especialidad` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `doctores`
--

INSERT INTO `doctores` (`id_doctor`, `nombre_doctor`, `apellido_p_doctor`, `apellido_m_doctor`, `nombre_negocio`, `direccion_consultorio`, `telefono`, `descripcion`, `email`, `usuario`, `pass`, `privilegio`, `imagen`, `id_especialidad`) VALUES
(1, 'Hector', 'Gonzalez', 'Corazón', 'H Consultorios', 'Juan Colorado 240, Nezahualcóyotl, Estado de México.', '5512345678', 'Hola, me gustaría formar parte del buen desarrollo y crecimiento del estatus más importante de tu vida, tu salud.', 'hconsutorios@correo.com', 'hconsultorios', 'YnFJbE40K0VCenZzVUlna2pjOUN4QT09', 4, 'drmario.png', 1),
(2, 'Simi', 'Smith', 'Echeverría', 'Farmacias Similares Av. de las Torres', 'Avenida de las Torres, Chimalhuacán, Estado de México.', '5678491623', 'Un buen amigo es aquel que se preocupa por tu salud, por eso, Doctor Simi es tu mejor amigo.', 'simi1@correo.com', 'simi1', 'ZTY2dWhiWnpldWNyR0J5ME5zZ1NWUT09', 4, 'simi.png', 1),
(3, 'Prueba', 'Para', 'Especialidad', 'Especialidad Prueba Consultors', 'Dirección de Especialidad, México', '5546791328', 'Esta es una prueba para comprobar especialidad', 'especialidad@correo.com', 'especialidad1', 'MG5YWnlGWXVxeEN5OGFkTWtjaW5lUT09', 4, '5.jpg', 2),
(4, 'Prueba', 'Para', 'Cirujano', 'Prueba Cirujanos COnsultors', 'Dirección de prueba de Cirujano, México', '5646178946', 'Esta es una descripción de prueba para doctor cirujano 1', 'pruebacirujano1@correo.com', 'pruebacirujano1', 'd04zUUhYcW1RczBvRGQ5MXlTYnpjWHVJY3V5TytueW1qN0Nwd1hsamlzOD0=', 4, 'icon.png', 4),
(5, 'Prueba', 'Doctor', 'Neuronal', 'Consultorio de prueba', 'Dirección de prueba neuronal', '5612346789', 'Esta es una descripción de prueba para tipo de doctor', 'neuronal1@correo.com', 'neuronal1', 'Nm9tYVhCb0RjODB2Q0FqRC81UHljdz09', 4, '2.jpg', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `empresa_id` int(2) NOT NULL,
  `empresa_nombre` varchar(90) COLLATE utf8_spanish2_ci NOT NULL,
  `empresa_email` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `empresa_telefono` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `empresa_direccion` varchar(200) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidades`
--

CREATE TABLE `especialidades` (
  `id_especialidad` bigint(20) NOT NULL,
  `especialidad` varchar(250) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `especialidades`
--

INSERT INTO `especialidades` (`id_especialidad`, `especialidad`) VALUES
(1, 'Doctor Gral'),
(2, 'Psicólogía'),
(3, 'Neurología'),
(4, 'Cirujano'),
(5, 'Cirujano Plástico'),
(6, 'Anestesiología'),
(7, 'Cardiología'),
(8, 'Pediatría'),
(9, 'Dermatología'),
(10, 'Ginecología'),
(11, 'Neumología');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estatus`
--

CREATE TABLE `estatus` (
  `id_estatus` int(11) NOT NULL,
  `estatus` varchar(250) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `estatus`
--

INSERT INTO `estatus` (`id_estatus`, `estatus`) VALUES
(1, 'Reservado'),
(2, 'En Proceso'),
(3, 'Finalizado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nom_menu` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `icon_menu` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `ruta_menu` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `activo` int(11) NOT NULL,
  `id_padre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`id_menu`, `nom_menu`, `icon_menu`, `ruta_menu`, `activo`, `id_padre`) VALUES
(1, 'Dashboard', 'fab fa-dashcube fa-fw', 'home/', 1, 0),
(2, 'Catálogos', 'fa fa-clipboard-list fa-fw', '#/', 1, 0),
(3, 'Categorías', 'fa fa-star', '#/', 1, 0),
(4, 'Pacientes', 'fa fa-users fa-fw', 'client-list/', 0, 2),
(5, 'Usuarios', 'fa fa-users fa-fw', 'user-list/', 0, 2),
(6, 'Doctores', 'fa fa-hospital fa-fw', 'doctors-list/', 0, 2),
(7, 'Servicios', 'fas fa-clipboard-list fa-fw', 'service-list/', 0, 2),
(8, 'Empresa', 'fas fa-store-alt fa-fw', 'company/', 1, 0),
(9, 'Especialidades', 'fa fa-star', 'especialidad-list/', 0, 2),
(10, 'Menus', 'fa fa-bars', 'menu-list/', 0, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `pago_id` int(20) NOT NULL,
  `pago_total` decimal(30,2) NOT NULL,
  `pago_fecha` date NOT NULL,
  `prestamo_codigo` varchar(200) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil_menu`
--

CREATE TABLE `perfil_menu` (
  `id_perfil_menu` int(11) NOT NULL,
  `id_privilegio` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `perfil_menu`
--

INSERT INTO `perfil_menu` (`id_perfil_menu`, `id_privilegio`, `id_menu`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 2, 1),
(11, 2, 2),
(12, 2, 3),
(13, 2, 4),
(14, 2, 5),
(15, 2, 6),
(16, 2, 7),
(17, 2, 8),
(18, 2, 9),
(19, 3, 1),
(20, 3, 2),
(21, 3, 3),
(22, 3, 4),
(23, 3, 5),
(24, 3, 6),
(25, 3, 7),
(26, 3, 8),
(27, 3, 9),
(28, 4, 1),
(29, 4, 2),
(30, 4, 8),
(31, 5, 1),
(32, 5, 3),
(33, 5, 8),
(34, 1, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamo`
--

CREATE TABLE `prestamo` (
  `prestamo_id` int(50) NOT NULL,
  `prestamo_codigo` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `prestamo_fecha_inicio` date NOT NULL,
  `prestamo_hora_inicio` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `prestamo_fecha_final` date NOT NULL,
  `prestamo_hora_final` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `prestamo_cantidad` int(10) NOT NULL,
  `prestamo_total` decimal(30,2) NOT NULL,
  `prestamo_pagado` decimal(30,2) NOT NULL,
  `prestamo_estado` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `prestamo_observacion` varchar(535) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_id` int(10) NOT NULL,
  `cliente_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `privilegios`
--

CREATE TABLE `privilegios` (
  `id_privilegio` int(11) NOT NULL,
  `privilegio` varchar(250) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `privilegios`
--

INSERT INTO `privilegios` (`id_privilegio`, `privilegio`) VALUES
(1, 'Administrador'),
(2, 'Edición'),
(3, 'Registrar'),
(4, 'Doctor'),
(5, 'Cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservaciones`
--

CREATE TABLE `reservaciones` (
  `id_reservacion` bigint(20) NOT NULL,
  `id_doctor` bigint(20) NOT NULL,
  `id_servicio` bigint(20) NOT NULL,
  `id_cliente` bigint(20) NOT NULL,
  `id_estatus` int(11) NOT NULL,
  `id_visita` int(11) NOT NULL,
  `nota_paciente` varchar(500) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `nota_doctor` varchar(500) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `fecha_cita` date NOT NULL,
  `hora_cita` time NOT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_fin` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `reservaciones`
--

INSERT INTO `reservaciones` (`id_reservacion`, `id_doctor`, `id_servicio`, `id_cliente`, `id_estatus`, `id_visita`, `nota_paciente`, `nota_doctor`, `fecha_cita`, `hora_cita`, `hora_inicio`, `hora_fin`) VALUES
(2, 1, 1, 4, 3, 2, 'Esta es una prueba de reservación', 'Comentario de prueba', '2022-03-31', '18:30:00', '14:09:29', '14:12:20'),
(3, 1, 2, 4, 3, 2, 'Tengo gripa', 'Estabas tristón', '2022-04-01', '17:30:00', '12:34:45', '12:37:38'),
(4, 2, 3, 4, 3, 2, 'Comentario de prueba 2', 'Este es un comentario de prueba.', '2022-04-02', '13:30:00', '16:49:38', '16:50:36'),
(5, 1, 2, 6, 3, 2, 'Comentario de prueba 3', 'Este es un comentario de prueba', '2022-04-02', '13:30:00', '17:57:25', '17:59:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id_servicio` bigint(20) NOT NULL,
  `nombre_servicio` varchar(250) COLLATE utf8_spanish2_ci NOT NULL,
  `descripcion` varchar(500) COLLATE utf8_spanish2_ci NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(250) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `id_doctor` bigint(20) NOT NULL,
  `id_especialidad` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id_servicio`, `nombre_servicio`, `descripcion`, `precio`, `imagen`, `id_doctor`, `id_especialidad`) VALUES
(1, 'Aplicación de Inyección a Domicilo', 'Aplicación de inyecciones con control de seguimiento pre y pos aplicación. Solo Nezahualcóyotl.', '70.00', '2.jpg', 1, 1),
(2, 'Consulta Médica a domicilio - Solo Nezahualcóyotl.', 'Se realiza consulta médica en la comodidad de su casa atendiendo las medidas de seguridad para la sana distancia, solo en la zona de Nezahualcóyotl.', '250.50', '4.jpg', 1, 2),
(3, 'Consulta del Doctor Simi - Avenida de las torres', 'Agenda tu consulta en nuestro espacio para poder compartir con el Doctor Simi tu bienestar.', '245.65', '6.png', 2, 2),
(4, 'Envío de medicina a domicilio - Region Nezahualcóyotl', 'Deja el nombre de las medicinas en las notas de tu reserva y nuestro equipo se encargará de hacértelas llegar lo más pronto posible.', '150.00', '7.jpg', 1, 3),
(5, 'Veta masiva de cubrebocas', 'Pide por paquete de 100 piezas de cubrebocas en nuestro centro y pasa a recogerlas.', '200.00', '2.jpg', 1, 4),
(6, 'Seguimiento de tratamiento para COVID-19', 'Trae tu receta y nosotros nos encargamos de seguir al pie de la letra y, si es necesario, mejorar tu tratamiento hasta que termines tu periodo de aislamiento.', '400.00', 'corazones.png', 1, 1),
(7, 'Masaje desestresante para Hombre y Mujer', 'Acude a nuestra clínica y deja que tu cuerpo goce de un rico y delicado masaje para el desestrés.', '600.00', '1.jpg', 1, 1),
(8, 'Servicio de Prueba Hector', 'Este es un servicio de prueba para el doctor Hector', '500.00', '8.jpg', 1, 1),
(9, 'Servicio de Hector', 'Este es un servicio de Hector', '500.00', '9.jpg', 1, 1),
(10, 'Prueba rápida de Covid', 'Se realiza la prueba rápida de Covid en el consultorio o a domicilio', '350.00', '10.jpg', 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_sangre`
--

CREATE TABLE `tipo_sangre` (
  `id_tipo_sangre` int(11) NOT NULL,
  `tipo_sangre` varchar(250) COLLATE utf8_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tipo_sangre`
--

INSERT INTO `tipo_sangre` (`id_tipo_sangre`, `tipo_sangre`) VALUES
(1, 'A+'),
(2, 'A-'),
(3, 'B+'),
(4, 'B-'),
(5, 'AB+'),
(6, 'AB-'),
(7, 'O+'),
(8, 'O-');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` bigint(20) NOT NULL,
  `usuario_nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_apellido_p` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_apellido_m` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_telefono` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_direccion` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_email` varchar(150) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_usuario` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_clave` varchar(535) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_estado` varchar(17) COLLATE utf8_spanish2_ci NOT NULL,
  `usuario_privilegio` int(2) NOT NULL,
  `usuario_imagen` varchar(250) COLLATE utf8_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `usuario_nombre`, `usuario_apellido_p`, `usuario_apellido_m`, `usuario_telefono`, `usuario_direccion`, `usuario_email`, `usuario_usuario`, `usuario_clave`, `usuario_estado`, `usuario_privilegio`, `usuario_imagen`) VALUES
(1, 'Admin', 'Primero', 'User', '5514789665', 'Calle 1, Ciudad, 51111', 'admin@correo.com', 'Admin', 'MmJ0dWVGUEJCTzY3WVRLV1k2N1p1UT09', 'Activa', 1, 'icon.png'),
(2, 'Hector', 'Gonzalez', 'Lopez', '5612345678', 'Dirección de Ejemplo, 123, México', 'hgonzalez@junglesystem.com.mx', 'hgonzalez', 'ZW1jOXZCZ1QvVHBULzYzdlhaVVRSUT09', 'Activa', 1, '6.png'),
(3, 'Karly', 'Esquivel', 'Armenta', '5612345678', 'Dirección Ejemplo 2, México', 'kesquivel@junglesystem.com.mx', 'kesquivel', 'ZW1jOXZCZ1QvVHBULzYzdlhaVVRSUT09', 'Activa', 1, 'icon-2.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visita`
--

CREATE TABLE `visita` (
  `id_visita` int(11) NOT NULL,
  `tipo_visita` varchar(250) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `visita`
--

INSERT INTO `visita` (`id_visita`, `tipo_visita`) VALUES
(1, 'Local (En Casa)'),
(2, 'Consultorio');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cliente_id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD KEY `privilegio` (`privilegio`),
  ADD KEY `tipo_sangre` (`tipo_sangre`);

--
-- Indices de la tabla `doctores`
--
ALTER TABLE `doctores`
  ADD PRIMARY KEY (`id_doctor`),
  ADD KEY `id_especialidad` (`id_especialidad`),
  ADD KEY `privilegio` (`privilegio`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`empresa_id`);

--
-- Indices de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  ADD PRIMARY KEY (`id_especialidad`);

--
-- Indices de la tabla `estatus`
--
ALTER TABLE `estatus`
  ADD PRIMARY KEY (`id_estatus`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`pago_id`),
  ADD KEY `prestamo_codigo` (`prestamo_codigo`);

--
-- Indices de la tabla `perfil_menu`
--
ALTER TABLE `perfil_menu`
  ADD PRIMARY KEY (`id_perfil_menu`),
  ADD KEY `id_privilegio` (`id_privilegio`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indices de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD PRIMARY KEY (`prestamo_id`),
  ADD UNIQUE KEY `prestamo_codigo` (`prestamo_codigo`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Indices de la tabla `privilegios`
--
ALTER TABLE `privilegios`
  ADD PRIMARY KEY (`id_privilegio`);

--
-- Indices de la tabla `reservaciones`
--
ALTER TABLE `reservaciones`
  ADD PRIMARY KEY (`id_reservacion`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id_servicio`),
  ADD KEY `id_doctor` (`id_doctor`),
  ADD KEY `id_especialidad` (`id_especialidad`);

--
-- Indices de la tabla `tipo_sangre`
--
ALTER TABLE `tipo_sangre`
  ADD PRIMARY KEY (`id_tipo_sangre`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `visita`
--
ALTER TABLE `visita`
  ADD PRIMARY KEY (`id_visita`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `cliente_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `doctores`
--
ALTER TABLE `doctores`
  MODIFY `id_doctor` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `empresa_id` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  MODIFY `id_especialidad` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `estatus`
--
ALTER TABLE `estatus`
  MODIFY `id_estatus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `pago_id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `perfil_menu`
--
ALTER TABLE `perfil_menu`
  MODIFY `id_perfil_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  MODIFY `prestamo_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `privilegios`
--
ALTER TABLE `privilegios`
  MODIFY `id_privilegio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `reservaciones`
--
ALTER TABLE `reservaciones`
  MODIFY `id_reservacion` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id_servicio` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tipo_sangre`
--
ALTER TABLE `tipo_sangre`
  MODIFY `id_tipo_sangre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `visita`
--
ALTER TABLE `visita`
  MODIFY `id_visita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`privilegio`) REFERENCES `privilegios` (`id_privilegio`),
  ADD CONSTRAINT `clientes_ibfk_2` FOREIGN KEY (`tipo_sangre`) REFERENCES `tipo_sangre` (`id_tipo_sangre`);

--
-- Filtros para la tabla `doctores`
--
ALTER TABLE `doctores`
  ADD CONSTRAINT `doctores_ibfk_1` FOREIGN KEY (`id_especialidad`) REFERENCES `especialidades` (`id_especialidad`),
  ADD CONSTRAINT `doctores_ibfk_2` FOREIGN KEY (`privilegio`) REFERENCES `privilegios` (`id_privilegio`);

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `pago_ibfk_1` FOREIGN KEY (`prestamo_codigo`) REFERENCES `prestamo` (`prestamo_codigo`);

--
-- Filtros para la tabla `perfil_menu`
--
ALTER TABLE `perfil_menu`
  ADD CONSTRAINT `perfil_menu_ibfk_1` FOREIGN KEY (`id_privilegio`) REFERENCES `privilegios` (`id_privilegio`),
  ADD CONSTRAINT `perfil_menu_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`);

--
-- Filtros para la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD CONSTRAINT `servicios_ibfk_1` FOREIGN KEY (`id_especialidad`) REFERENCES `especialidades` (`id_especialidad`),
  ADD CONSTRAINT `servicios_ibfk_2` FOREIGN KEY (`id_doctor`) REFERENCES `doctores` (`id_doctor`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
