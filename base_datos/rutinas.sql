
/* Conexión base de datos
mysql.exe -h localhost -u root -p
*/

/* Funcion para crear un nuevo estudiante*/
use tetuanjobs
drop FUNCTION if EXISTS nuevoEstudiante;

delimiter //

CREATE FUNCTION nuevoEstudiante(nomb varchar(25), ape varchar(50),ccl varchar(20),
	mail varchar(100)) returns varchar(250)
BEGIN
	declare mensaje varchar(250) default "";
	declare identificador int(11) unsigned;

	if length(nomb) < 3 then
		set mensaje = "Nombre demasiado corto";
		return mensaje;
	end if;

	INSERT INTO tetuanjobs.usuarios (email,tipo_usuario) 
		values(mail,'e');
		set identificador = @@IDENTITY;

	INSERT INTO tetuanjobs.estudiantes 
		(`id_estudiante`, `id_usuario`, `ciclo`, `nombre`, `apellidos`) 
		VALUES (NULL, identificador,ccl,nomb, ape);

	return concat("Usuario ",nomb," creado correctamente");

END;	
//
delimiter ;
SELECT nuevoEstudiante("Carlos","Navarro","ASIR", "prueba4@gmail.com");

/* Fin de funcion */

/* Funcion para crear una nueva empresa*/

drop FUNCTION if EXISTS nuevaEmpresa;

delimiter //

CREATE FUNCTION nuevaEmpresa(nombEmp varchar(25), contacto varchar(100),ccl varchar(20),
	mail varchar(100)) returns varchar(250)
BEGIN
	declare mensaje varchar(250) default "";
	declare identificador int(11) unsigned;

	if length(nomb) < 3 then
		set mensaje = "Nombre demasiado corto";
		return mensaje;
	end if;

	INSERT INTO tetuanjobs.usuarios (email,tipo_usuario) 
		values(mail,'e');
		set identificador = @@IDENTITY;

	INSERT INTO tetuanjobs.estudiantes 
		(`id_estudiante`, `id_usuario`, `ciclo`, `nombre`, `apellidos`) 
		VALUES (NULL, identificador,ccl,nomb, ape);

	return concat("Usuario ",nomb," creado correctamente");

END;	
//
delimiter ;
SELECT nuevaEmpresa("Carlos","Navarro","ASIR", "prueba4@gmail.com");

/* Fin funcion*/


/* Obtener la lista que contiene la columna de tipo enum */
drop PROCEDURE if EXISTS tetuanjobs.obtenerEnum;

delimiter //

CREATE PROCEDURE tetuanjobs.obtenerEnum(nomCol varchar(20)) 
BEGIN
	SELECT SUBSTRING(SUBSTRING(COLUMN_TYPE,6),((-1)*(length(SUBSTRING(COLUMN_TYPE,5))-1)),((length(SUBSTRING(COLUMN_TYPE,5)))-2))
		FROM information_schema.COLUMNS
			WHERE TABLE_SCHEMA='tetuanjobs' 
				AND TABLE_NAME='estudiantes'
				AND COLUMN_NAME=nomCol;
END;
//
delimiter ;	

call obtenerEnum('ciclo');

/* Fin del procedimiento */



