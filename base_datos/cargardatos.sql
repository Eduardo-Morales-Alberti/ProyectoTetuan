use tetuanjobs;

/* INSERTAR usuarios de ejemplo */

/* INSERTAR usuario administrador */
INSERT INTO `USUARIOS` (email, tipo_usuario,activo, password) values("admin@gmail.com",'administrador',1,
password('admintetuan'));
/* INSERTAR usuario administrador */


INSERT INTO `USUARIOS` (email, tipo_usuario,activo, password) values("eduardomoberti@hotmail.com",'estudiante',1,
password('estudiantetetuan'));

INSERT INTO tetuanjobs.estudiantes 
    (`id_estudiante`, `id_usuario`, `ciclo`, `nombre`, `apellidos`,`foto`,`cv`) 
    VALUES (NULL, @@IDENTITY,"ASIR","Eduardo", "Morales","eduardomoberti_hotmail_com_fotop.jpg","eduardomoberti_hotmail_com_cv.pdf");


INSERT INTO `USUARIOS` (email, tipo_usuario,activo, password) values("sara@hotmail.com",'estudiante',0,
password('estudiantetetuan'));

INSERT INTO tetuanjobs.estudiantes 
    (`id_estudiante`, `id_usuario`, `ciclo`, `nombre`, `apellidos`) 
    VALUES (NULL, @@IDENTITY,"TURISMO","Sara", "Perez");

INSERT INTO `USUARIOS` (email, tipo_usuario,activo, password) values("pedro@hotmail.com",'estudiante',0,
password('estudiantetetuan'));

INSERT INTO tetuanjobs.estudiantes 
    (`id_estudiante`, `id_usuario`, `ciclo`, `nombre`, `apellidos`) 
    VALUES (NULL, @@IDENTITY,"DAW","Pedro", "Molina");

INSERT INTO `USUARIOS` (email, tipo_usuario,activo, password) values("carlos@hotmail.com",'estudiante',0,
password('estudiantetetuan'));

INSERT INTO tetuanjobs.estudiantes 
    (`id_estudiante`, `id_usuario`, `ciclo`, `nombre`, `apellidos`) 
    VALUES (NULL, @@IDENTITY,"ASIR","Carlos", "Garcia");

/* FIN INSERTAR usuarios de ejemplo */

/** INSERTAR EMPRESAS DE EJEMPLO **/

INSERT INTO tetuanjobs.empresas
	(`id_empresa`,`nombre_empresa`,`emp_web`,`email`,`telefono`,`persona_contacto`)
	VALUES(NULL, "Microsoft","microsoft.com","gates@microsoft.com","658987456","Bill Gates");

INSERT INTO tetuanjobs.empresas
	(`id_empresa`,`nombre_empresa`,`emp_web`,`email`,`telefono`,`persona_contacto`)
	VALUES(NULL, "Apple","apple.com","steve@hotmail.com","698741239","Steve Jobs");

INSERT INTO tetuanjobs.empresas
	(`id_empresa`,`nombre_empresa`,`emp_web`,`email`,`telefono`,`persona_contacto`)
	VALUES(NULL, "Facebook","facebook.com","mack@facebook.com","654321789","Mack Zuckerberg");

INSERT INTO tetuanjobs.empresas
	(`id_empresa`,`nombre_empresa`,`emp_web`,`email`,`telefono`,`persona_contacto`)
	VALUES(NULL, "Hotel Buena Vista","hbuenavista.com","mariano@hotmail.com","915845796","Mariano Maldonado");

INSERT INTO tetuanjobs.empresas
	(`id_empresa`,`nombre_empresa`,`emp_web`,`email`,`telefono`,`persona_contacto`)
	VALUES(NULL, "Iberia","iberia.com","patricia@hotmail.com","644582369","Patricia Carrero");

/** INSERTAR EMPRESAS DE EJEMPLO **/

/* insertar etiquetas */
INSERT INTO `ETIQUETAS` (nombre_etiqueta) values
('java'),('php'),('javascript'),('html'),('css');
/* insertar etiquetas */


/* Insertar provincias */

INSERT INTO `provincias` (`id_provincia`, `slug`, `nombre_provincia`) VALUES
(1, 'alava', 'Álava'),
(2, 'albacete', 'Albacete'),
(3, 'alicante', 'Alicante'),
(4, 'almeria', 'Almería'),
(5, 'vila', 'Ávila'),
(6, 'badajoz', 'Badajoz'),
(7, 'illes-balears', 'Illes Balears'),
(8, 'barcelona', 'Barcelona'),
(9, 'burgos', 'Burgos'),
(10, 'caceres', 'Cáceres'),
(11, 'cadiz', 'Cádiz'),
(12, 'castellon', 'Castellón'),
(13, 'ciudad-real', 'Ciudad Real'),
(14, 'cordoba', 'Córdoba'),
(15, 'a-coruna', 'A Coruña'),
(16, 'cuenca', 'Cuenca'),
(17, 'girona', 'Girona'),
(18, 'granada', 'Granada'),
(19, 'guadalajara', 'Guadalajara'),
(20, 'guipuzcoa', 'Guipúzcoa'),
(21, 'huelva', 'Huelva'),
(22, 'huesca', 'Huesca'),
(23, 'jaen', 'Jaén'),
(24, 'leon', 'León'),
(25, 'lleida', 'Lleida'),
(26, 'la-rioja', 'La Rioja'),
(27, 'lugo', 'Lugo'),
(28, 'madrid', 'Madrid'),
(29, 'malaga', 'Málaga'),
(30, 'murcia', 'Murcia'),
(31, 'navarra', 'Navarra'),
(32, 'ourense', 'Ourense'),
(33, 'asturias', 'Asturias'),
(34, 'palencia', 'Palencia'),
(35, 'las-palmas', 'Las Palmas'),
(36, 'pontevedra', 'Pontevedra'),
(37, 'salamanca', 'Salamanca'),
(38, 'santa-cruz-de-tenerife', 'Santa Cruz de Tenerife'),
(39, 'cantabria', 'Cantabria'),
(40, 'segovia', 'Segovia'),
(41, 'sevilla', 'Sevilla'),
(42, 'soria', 'Soria'),
(43, 'tarragona', 'Tarragona'),
(44, 'teruel', 'Teruel'),
(45, 'toledo', 'Toledo'),
(46, 'valencia', 'Valencia'),
(47, 'valladolid', 'Valladolid'),
(48, 'vizcaya', 'Vizcaya'),
(49, 'zamora', 'Zamora'),
(50, 'zaragoza', 'Zaragoza'),
(51, 'ceuta', 'Ceuta'),
(52, 'melilla', 'Melilla');

/* Fin Insertar provincias */


/* Insertar experiencia */
	INSERT INTO tetuanjobs.experiencia (id_estudiante, titulo_puesto, nombre_empresa,
				f_inicio,f_fin,experiencia_desc) values(1, "Desarrollador web", "Microsoft",
				"2015-05-01","2016-05-01", "Un trabajo muy chulo");

	INSERT INTO tetuanjobs.experiencia (id_estudiante, titulo_puesto, nombre_empresa,
				f_inicio,actualmente,experiencia_desc) values(1, "Maquetador", "Facebook",
				"2015-06-01",true, "Otro trabajo muy chulo");

	INSERT INTO tetuanjobs.experiencia (id_estudiante, titulo_puesto, nombre_empresa,
				f_inicio,f_fin,experiencia_desc) values(1, "Programador PHP", "Ies Tetuan",
				"2015-05-01","2016-08-01", "Había que hacer algo");

/* Fin insertar experiencia */

/* insertar formacion */

INSERT INTO tetuanjobs.formacion (id_estudiante, titulo_formacion, institucion,
				f_inicio,f_fin,formacion_desc, formacion_clasificacion) values(1, "Desarrollador web", "IES Tetuan",
				"2015-05-01",true, "Aprendimos un montón", 4);

INSERT INTO tetuanjobs.formacion (id_estudiante, titulo_formacion, institucion,
			f_inicio,actualmente,formacion_desc, formacion_clasificacion) values(1, "ESO", "Las Codornices",
			"2010-06-01","2014-06-01", "Tenía que estudiarlo",8);

INSERT INTO tetuanjobs.formacion (id_estudiante, titulo_formacion, institucion,
			f_inicio,f_fin,formacion_desc, formacion_clasificacion) values(1, "Programacion O Objetos", "Corenetworks",
			"2015-05-01","2016-08-01", "Aprendí ha hacer clases",7);

/* Fin insertar formacion */

/* insertar idiomas */

INSERT INTO tetuanjobs.idiomas(nombre_idioma) values("inglés");
INSERT INTO tetuanjobs.idiomas(nombre_idioma) values("francés");
INSERT INTO tetuanjobs.idiomas(nombre_idioma) values("alemán");
INSERT INTO tetuanjobs.idiomas(nombre_idioma) values("chino");
/* fin insertar idiomas */