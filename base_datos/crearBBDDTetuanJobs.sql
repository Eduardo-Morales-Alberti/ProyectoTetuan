
-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 09-01-2017 a las 14:26:46
-- Versión del servidor: 10.0.28-MariaDB
-- Versión de PHP: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `tetuanjobs`
--

-- --------------------------------------------------------

/** REGISTRO **/

--
-- Estructura de tabla para la tabla `REGISTRO`
--
DROP TABLE IF EXISTS `REGISTRO`;
CREATE TABLE IF NOT EXISTS `REGISTRO` (
  `id_usuario` int(11) UNSIGNED AUTO_INCREMENT,
  `email` varchar(100) COLLATE utf8_unicode_ci,
  `alta` boolean DEFAULT FALSE,
  /* ¿Cómo enlazar con la tabla estudiantes si el administrador tiene un email diferente?*/
  /*`nombre` varchar(25) COLLATE utf8_unicode_ci NOT NULL,*/
  `password` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `tipo_usuario` enum('e','a') COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_usuario`,`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/** FIN DE REGISTRO **/

/** ESTUDIANTE **/

--
-- Estructura de tabla para la tabla `POBLACIONES`
--
DROP TABLE IF EXISTS `POBLACIONES`;
CREATE TABLE IF NOT EXISTS `POBLACIONES` (
  `id_poblacion` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nombre_poblacion` varchar(25) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ESTUDIANTES`
--
DROP TABLE IF EXISTS `ESTUDIANTES`;
CREATE TABLE IF NOT EXISTS `ESTUDIANTES` (
  `id_usuario` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nombre` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `apellidos` varchar(50) COLLATE utf8_unicode_ci ,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `telefono` varchar(9) COLLATE utf8_unicode_ci ,
  `provincia` varchar(250) COLLATE utf8_unicode_ci ,
  `cod_postal` int(5) ,
  `foto` varchar(250) ,
  `cv` varchar(250) ,
  `descripcion` varchar(3000) COLLATE utf8_unicode_ci ,
  `carnet` boolean DEFAULT FALSE,
  `id_poblacion` int(11),
  FOREIGN KEY (`id_poblacion`) REFERENCES POBLACIONES(`id_poblacion`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `EXPERIENCIA`
--
DROP TABLE IF EXISTS `EXPERIENCIA`;
CREATE TABLE IF NOT EXISTS `EXPERIENCIA` (
  `id_experiencia` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `titulo_puesto` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `nombre_empresa` varchar(200) COLLATE utf8_unicode_ci,
  `f_inicio` date,
  `f_fin` date,
  `actualmente` boolean DEFAULT FALSE,
  `experiencia_desc` varchar(3000) COLLATE utf8_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ESTUDIANTES_EXPERIENCIA`
--
DROP TABLE IF EXISTS `ESTUDIANTES_EXPERIENCIA`;
CREATE TABLE IF NOT EXISTS `ESTUDIANTES_EXPERIENCIA` (
  /* ¿Se permiten primary keys cómo foreign keys?*/
  `id_usuario` int(11) NOT NULL,
  `id_experiencia` int(11) NOT NULL,
  FOREIGN KEY (`id_usuario`) REFERENCES ESTUDIANTES(`id_usuario`),
  FOREIGN KEY (`id_experiencia`) REFERENCES EXPERIENCIA(`id_experiencia`),
  PRIMARY KEY (`id_usuario`,`id_experiencia`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `FORMACION`
--
DROP TABLE IF EXISTS `FORMACION`;
CREATE TABLE IF NOT EXISTS `FORMACION` (
  `id_formacion` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `titulo_formacion` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  /*`institucion` int(11),*/
  /*`formacion_clasificacion` enum('F.P. Básica','C.F. Grado Medio','Bachillerato','C.F. Grado Superior','Grado Universitario','Máster','Certificado Oficial','Otro') COLLATE utf8_unicode_ci NOT NULL,*/
  `tipo_formacion` varchar(50),
  `f_inicio` date ,
  `f_fin` date ,
  `actualmente` boolean DEFAULT FALSE,
  `formacion_desc` varchar(3000) COLLATE utf8_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ESTUDIANTES_FORMACION`
--
DROP TABLE IF EXISTS `ESTUDIANTES_FORMACION`;
CREATE TABLE IF NOT EXISTS `ESTUDIANTES_FORMACION` (
  `id_formacion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  FOREIGN KEY (`id_formacion`) REFERENCES FORMACION(`id_formacion`),
  FOREIGN KEY (`id_usuario`) REFERENCES ESTUDIANTES(`id_usuario`),
  PRIMARY KEY (`id_formacion`,`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ETIQUETAS`
--
DROP TABLE IF EXISTS `ETIQUETAS`;
CREATE TABLE IF NOT EXISTS `ETIQUETAS` (
  `id_etiquetas` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nombre_etiqueta` varchar(250) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ESTUDIANTES_ETIQUETAS`
--
DROP TABLE IF EXISTS `ESTUDIANTES_ETIQUETAS`;
CREATE TABLE IF NOT EXISTS `ESTUDIANTES_ETIQUETAS` (
  `id_etiquetas` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  FOREIGN KEY (`id_etiquetas`) REFERENCES ETIQUETAS(`id_etiquetas`),
  FOREIGN KEY (`id_usuario`) REFERENCES ESTUDIANTES(`id_usuario`),
  PRIMARY KEY (`id_etiquetas`,`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `IDIOMAS`
--
DROP TABLE IF EXISTS `IDIOMAS`;
CREATE TABLE IF NOT EXISTS `IDIOMAS` (
  `id_idioma` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nombre_idioma` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `hablado` enum('Bajo','Intermedio','Alto','Bilingüe') COLLATE utf8_unicode_ci NOT NULL,
  `escrito` enum('Bajo','Intermedio','Alto','Bilingüe') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ESTUDIANTES_IDIOMAS`
--
DROP TABLE IF EXISTS `ESTUDIANTES_IDIOMAS`;
CREATE TABLE IF NOT EXISTS `ESTUDIANTES_IDIOMAS` (
  `id_idioma` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  FOREIGN KEY (`id_idioma`) REFERENCES ESTUDIANTES(`id_idioma`),
  FOREIGN KEY (`id_usuario`) REFERENCES ESTUDIANTES(`id_usuario`),
  PRIMARY KEY (`id_idioma`,`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------


/** FIN DE ESTUDIANTE **/

/** EMPRESA **/

--
-- Estructura de tabla para la tabla `EMPRESAS`
--
DROP TABLE IF EXISTS `EMPRESAS`;
CREATE TABLE IF NOT EXISTS `EMPRESAS` (
  `id_empresa` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nombre_empresa` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `telefono` varchar(9) COLLATE utf8_unicode_ci ,
  `direccion` varchar(500) COLLATE utf8_unicode_ci ,
  `provincia` varchar(250) COLLATE utf8_unicode_ci,
  `id_poblacion` int(11) ,
  `persona_contacto` varchar(250) COLLATE utf8_unicode_ci ,
  `empresas_desc` varchar(3000) COLLATE utf8_unicode_ci,
  FOREIGN KEY (`id_poblacion`) REFERENCES POBLACIONES(`id_poblacion`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

/** FIN DE EMPRESA **/

/** PUESTOS **/

--
-- Estructura de tabla para la tabla `PUESTOS`
--
DROP TABLE IF EXISTS `PUESTOS`;
CREATE TABLE IF NOT EXISTS `PUESTOS` (
  `id_puesto` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `id_empresa` int(11) NOT NULL,
  `puesto_nombre` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `puesto_desc` varchar(3000) COLLATE utf8_unicode_ci NOT NULL,
  `puestos_carnet` boolean DEFAULT FALSE,
  /*`experiencia` enum('Sin experiencia','Al menos un año','Más de un año') COLLATE utf8_unicode_ci NOT NULL,*/
  `experiencia` varchar(25) COLLATE utf8_unicode_ci,
  /*`tipo_contrato` enum('Sin determinar','Indefinido','En prácticas','Por obra o servicio') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Sin determinar',
  `jornada` enum('Sin determinar','Completa','Sólo mañanas','Sólo tardes') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Sin determinar',
  `titulacion_minima` enum('F.P. Básica','C.F. Grado Medio','Bachillerato','C.F. Grado Superior','Grado Universitario','Máster','Certificado Oficial','Otro') COLLATE utf8_unicode_ci NOT NULL,*/
  `tipo_contrato` varchar(250) COLLATE utf8_unicode_ci,
  `jornada` varchar(250) COLLATE utf8_unicode_ci,
  `titulacion_minima` varchar(250) COLLATE utf8_unicode_ci,
  `f_publicacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_empresa`) REFERENCES EMPRESAS(`id_empresa`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `FUNCIONES`
--
DROP TABLE IF EXISTS `FUNCIONES`;
CREATE TABLE IF NOT EXISTS `FUNCIONES` (
  `id_funcion` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `funcion_desc` varchar(250) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `FUNCIONES_PUESTOS`
--
DROP TABLE IF EXISTS `PUESTOS_FUNCIONES`;
CREATE TABLE IF NOT EXISTS `PUESTOS_FUNCIONES` (
  `id_funcion` int(11) NOT NULL,
  `id_puesto` int(11) NOT NULL,
  FOREIGN KEY (`id_funcion`) REFERENCES FUNCIONES(`id_funcion`),
  FOREIGN KEY (`id_puesto`) REFERENCES PUESTOS(`id_puesto`),
  PRIMARY KEY (`id_funcion`,`id_puesto`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------


--
-- Estructura de tabla para la tabla `PUESTOS_ETIQUETAS`
--
DROP TABLE IF EXISTS `PUESTOS_ETIQUETAS`;
CREATE TABLE IF NOT EXISTS `PUESTOS_ETIQUETAS` (
  `id_etiqueta` int(11) NOT NULL,
  `id_puesto` int(11) NOT NULL,
  FOREIGN KEY (`id_etiqueta`) REFERENCES ETIQUETAS(`id_etiqueta`),
  FOREIGN KEY (`id_puesto`) REFERENCES PUESTOS(`id_puesto`),
  PRIMARY KEY (`id_etiqueta`,`id_puesto`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `PUESTOS_IDIOMAS`
--
DROP TABLE IF EXISTS `PUESTOS_IDIOMAS`;
CREATE TABLE IF NOT EXISTS `PUESTOS_IDIOMAS` (
  `id_puesto` int(11) NOT NULL,
  `id_idioma` int(11) NOT NULL,
  FOREIGN KEY (`id_idioma`) REFERENCES IDIOMAS(`id_idioma`),
  FOREIGN KEY (`id_puesto`) REFERENCES PUESTOS(`id_puesto`),
  PRIMARY KEY (`id_idioma`,`id_puesto`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

/** FIN DE PUESTOS **/




/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
