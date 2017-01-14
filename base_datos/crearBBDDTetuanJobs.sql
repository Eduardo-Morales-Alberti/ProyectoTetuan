SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de datos: `tetuanjobs`
--

DROP DATABASE IF EXISTS `tetuanjobs`;
CREATE DATABASE `tetuanjobs` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

-- --------------------------------------------------------

--
-- Usuario rutinas: `usertetuan` password `tetuanjobs`
--
DROP USER 'usertetuan'@'localhost';
CREATE USER 'usertetuan'@'localhost' IDENTIFIED BY 'tetuanjobs';
GRANT EXECUTE ON `tetuanjobs`.* TO 'usertetuan'@'localhost';
-- --------------------------------------------------------

USE tetuanjobs;

/** USUARIOS **/

DROP TABLE IF EXISTS `USUARIOS`;
CREATE TABLE IF NOT EXISTS `USUARIOS`(
  `id_usuario` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `email` varchar(100) COLLATE utf8_general_ci NOT NULL,
  `password` varchar(20),
  `tipo_usuario` enum('e','a'),
  `activo` boolean DEFAULT FALSE
 ) ENGINE=InnoDB; 

/** FIN DE USUARIOS **/

/** ESTUDIANTE **/

--
-- Estructura de tabla para la tabla `PROVINCIAS`
--
DROP TABLE IF EXISTS `PROVINCIAS`;
CREATE TABLE IF NOT EXISTS `PROVINCIAS` (
  `id_provincia` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nombre_provincia` varchar(25) COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ESTUDIANTES`
--
DROP TABLE IF EXISTS `ESTUDIANTES`;
CREATE TABLE IF NOT EXISTS `ESTUDIANTES` (
  `id_estudiante` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `id_usuario` int(11) UNSIGNED,  
  `ciclo` enum('DAW','ASIR','TURISMO') NOT NULL,
  `nombre` varchar(25) COLLATE utf8_general_ci NOT NULL,
  `apellidos` varchar(50) COLLATE utf8_general_ci ,
  `telefono` varchar(9) COLLATE utf8_general_ci ,
  `poblacion` varchar(250) COLLATE utf8_general_ci ,
  `cod_postal` int(5) ,
  `foto` varchar(250) ,
  `cv` varchar(250) ,
  `descripcion` varchar(3000) COLLATE utf8_general_ci ,
  `carnet` boolean DEFAULT FALSE,
  `id_provincia` int(11) UNSIGNED,
  FOREIGN KEY (`id_usuario`) REFERENCES USUARIOS(`id_usuario`),
  FOREIGN KEY (`id_provincia`) REFERENCES PROVINCIAS(`id_provincia`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- --------------------------------------------------------




--
-- Estructura de tabla para la tabla `EXPERIENCIA`
--
DROP TABLE IF EXISTS `EXPERIENCIA`;
CREATE TABLE IF NOT EXISTS `EXPERIENCIA` (
  `id_experiencia` int(11) UNSIGNED AUTO_INCREMENT,
  `id_estudiante` int(11) UNSIGNED,
  `titulo_puesto` varchar(200) COLLATE utf8_general_ci NOT NULL,
  `nombre_empresa` varchar(200) COLLATE utf8_general_ci,
  `f_inicio` date,
  `f_fin` date,
  `actualmente` boolean DEFAULT FALSE,
  `experiencia_desc` varchar(3000) COLLATE utf8_general_ci,
  PRIMARY KEY (`id_experiencia`, `id_estudiante`),
  FOREIGN KEY (`id_estudiante`) REFERENCES ESTUDIANTES(`id_estudiante`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ESTUDIANTES_EXPERIENCIA`
--
/*DROP TABLE IF EXISTS `ESTUDIANTES_EXPERIENCIA`;
CREATE TABLE IF NOT EXISTS `ESTUDIANTES_EXPERIENCIA` (*/
  /* ¿Se permiten primary keys cómo foreign keys?*/
  /*`id_usuario` int(11) UNSIGNED NOT NULL,
  `id_experiencia` int(11) UNSIGNED NOT NULL,
  FOREIGN KEY (`id_usuario`) REFERENCES ESTUDIANTES(`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`id_experiencia`) REFERENCES EXPERIENCIA(`id_experiencia`) ON DELETE CASCADE ON UPDATE CASCADE,
  PRIMARY KEY (`id_usuario`,`id_experiencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;*/

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `FORMACION`
--
DROP TABLE IF EXISTS `FORMACION`;
CREATE TABLE IF NOT EXISTS `FORMACION` (
  `id_formacion` int(11) UNSIGNED AUTO_INCREMENT ,
  `id_estudiante` int(11) UNSIGNED,
  `titulo_formacion` varchar(500) COLLATE utf8_general_ci NOT NULL,
  `institucion` int(11),
  `formacion_clasificacion` enum('F.P. Básica','C.F. Grado Medio','Bachillerato','C.F. Grado Superior','Grado Universitario','Máster','Certificado Oficial','Otro') COLLATE utf8_general_ci NOT NULL,
  `tipo_formacion` varchar(50),
  `f_inicio` date ,
  `f_fin` date ,
  `actualmente` boolean DEFAULT FALSE,
  PRIMARY KEY(`id_formacion`,`id_estudiante`),
  FOREIGN KEY (`id_estudiante`) REFERENCES ESTUDIANTES(`id_estudiante`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ESTUDIANTES_FORMACION`
--
/*DROP TABLE IF EXISTS `ESTUDIANTES_FORMACION`;
CREATE TABLE IF NOT EXISTS `ESTUDIANTES_FORMACION` (
  `id_formacion` int(11) UNSIGNED NOT NULL,
  `id_usuario` int(11) UNSIGNED NOT NULL,
  FOREIGN KEY (`id_formacion`) REFERENCES FORMACION(`id_formacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`id_usuario`) REFERENCES ESTUDIANTES(`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  PRIMARY KEY (`id_formacion`,`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;*/

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ETIQUETAS`
--
DROP TABLE IF EXISTS `ETIQUETAS`;
CREATE TABLE IF NOT EXISTS `ETIQUETAS` (
  `id_etiquetas` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nombre_etiqueta` varchar(250) COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ESTUDIANTES_ETIQUETAS`
--
DROP TABLE IF EXISTS `ESTUDIANTES_ETIQUETAS`;
CREATE TABLE IF NOT EXISTS `ESTUDIANTES_ETIQUETAS` (
  `id_etiquetas` int(11) UNSIGNED NOT NULL,
  `id_estudiante` int(11) UNSIGNED NOT NULL,
  /*PRIMARY KEY (`id_etiquetas`,`id_usuario`),*/
  FOREIGN KEY (`id_etiquetas`) REFERENCES ETIQUETAS(`id_etiquetas`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`id_estudiante`) REFERENCES ESTUDIANTES(`id_estudiante`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `IDIOMAS`
--
DROP TABLE IF EXISTS `IDIOMAS`;
CREATE TABLE IF NOT EXISTS `IDIOMAS` (
  `id_idioma` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nombre_idioma` varchar(100) COLLATE utf8_general_ci NOT NULL,
  `hablado` enum('Bajo','Intermedio','Alto','Bilingüe') COLLATE utf8_general_ci NOT NULL,
  `escrito` enum('Bajo','Intermedio','Alto','Bilingüe') COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ESTUDIANTES_IDIOMAS`
--
DROP TABLE IF EXISTS `ESTUDIANTES_IDIOMAS`;
CREATE TABLE IF NOT EXISTS `ESTUDIANTES_IDIOMAS` (
  `id_idioma` int(11) UNSIGNED NOT NULL,
  `id_estudiante` int(11) UNSIGNED NOT NULL,
  FOREIGN KEY (`id_idioma`) REFERENCES IDIOMAS(`id_idioma`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`id_estudiante`) REFERENCES ESTUDIANTES(`id_estudiante`) ON DELETE CASCADE ON UPDATE CASCADE,
  PRIMARY KEY (`id_idioma`,`id_estudiante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------


/** FIN DE ESTUDIANTE **/

/** EMPRESA **/

--
-- Estructura de tabla para la tabla `EMPRESAS`
--
DROP TABLE IF EXISTS `EMPRESAS`;
CREATE TABLE IF NOT EXISTS `EMPRESAS` (
  `id_empresa` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nombre_empresa` varchar(250) COLLATE utf8_general_ci NOT NULL,
  `emp_web` varchar(250) COLLATE utf8_general_ci,
  `email` varchar(100) COLLATE utf8_general_ci NOT NULL,
  `telefono` varchar(9) COLLATE utf8_general_ci ,
  `direccion` varchar(500) COLLATE utf8_general_ci ,
  `poblacion` varchar(250) COLLATE utf8_general_ci,
  `id_provincia` int(11) UNSIGNED,
  `persona_contacto` varchar(250) COLLATE utf8_general_ci ,
  `empresas_desc` varchar(3000) COLLATE utf8_general_ci,
  FOREIGN KEY (`id_provincia`) REFERENCES PROVINCIAS(`id_provincia`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

/** FIN DE EMPRESA **/

/** PUESTOS **/

--
-- Estructura de tabla para la tabla `PUESTOS`
--
DROP TABLE IF EXISTS `PUESTOS`;
CREATE TABLE IF NOT EXISTS `PUESTOS` (
  `id_puesto` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `id_empresa` int(11) UNSIGNED NOT NULL,
  `puesto_nombre` varchar(500) COLLATE utf8_general_ci NOT NULL,
  `puesto_desc` varchar(3000) COLLATE utf8_general_ci NOT NULL,
  `puestos_carnet` boolean DEFAULT FALSE,
  `experiencia` enum('Sin experiencia','Al menos un año','Más de un año') COLLATE utf8_general_ci NOT NULL,
  `tipo_contrato` enum('Sin determinar','Indefinido','En prácticas','Por obra o servicio') COLLATE utf8_general_ci NOT NULL DEFAULT 'Sin determinar',
  `jornada` enum('Sin determinar','Completa','Sólo mañanas','Sólo tardes') COLLATE utf8_general_ci NOT NULL DEFAULT 'Sin determinar',
  `titulacion_minima` enum('F.P. Básica','C.F. Grado Medio','Bachillerato','C.F. Grado Superior','Grado Universitario','Máster','Certificado Oficial','Otro') COLLATE utf8_general_ci NOT NULL,
  `f_publicacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_empresa`) REFERENCES EMPRESAS(`id_empresa`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `FUNCIONES`
--
DROP TABLE IF EXISTS `FUNCIONES`;
CREATE TABLE IF NOT EXISTS `FUNCIONES` (
  `id_funcion` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `id_puesto` int(11) UNSIGNED NOT NULL,
  `funcion_desc` varchar(250) COLLATE utf8_general_ci NOT NULL,
  FOREIGN KEY (`id_puesto`) REFERENCES PUESTOS(`id_puesto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `FUNCIONES_PUESTOS`
--
/*DROP TABLE IF EXISTS `PUESTOS_FUNCIONES`;
CREATE TABLE IF NOT EXISTS `PUESTOS_FUNCIONES` (
  `id_funcion` int(11) UNSIGNED NOT NULL,
  `id_puesto` int(11) UNSIGNED NOT NULL,
  FOREIGN KEY (`id_funcion`) REFERENCES FUNCIONES(`id_funcion`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`id_puesto`) REFERENCES PUESTOS(`id_puesto`) ON DELETE CASCADE ON UPDATE CASCADE,
  PRIMARY KEY (`id_funcion`,`id_puesto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;*/


-- --------------------------------------------------------


--
-- Estructura de tabla para la tabla `PUESTOS_ETIQUETAS`
--
DROP TABLE IF EXISTS `PUESTOS_ETIQUETAS`;
CREATE TABLE IF NOT EXISTS `PUESTOS_ETIQUETAS` (
  `id_etiqueta` int(11) UNSIGNED NOT NULL,
  `id_puesto` int(11) UNSIGNED NOT NULL,
  FOREIGN KEY (`id_etiqueta`) REFERENCES ETIQUETAS(`id_etiquetas`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`id_puesto`) REFERENCES PUESTOS(`id_puesto`) ON DELETE CASCADE ON UPDATE CASCADE,
  PRIMARY KEY (`id_etiqueta`,`id_puesto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `PUESTOS_IDIOMAS`
--
DROP TABLE IF EXISTS `PUESTOS_IDIOMAS`;
CREATE TABLE IF NOT EXISTS `PUESTOS_IDIOMAS` (
  `id_puesto` int(11) UNSIGNED NOT NULL,
  `id_idioma` int(11) UNSIGNED NOT NULL,
  FOREIGN KEY (`id_idioma`) REFERENCES IDIOMAS(`id_idioma`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`id_puesto`) REFERENCES PUESTOS(`id_puesto`) ON DELETE CASCADE ON UPDATE CASCADE,
  PRIMARY KEY (`id_idioma`,`id_puesto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

/** FIN DE PUESTOS **/


