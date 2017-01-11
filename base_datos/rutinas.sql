/* Funcion para crear un nuevo estudiante*/

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

	return concat("Usuario ",nomb,"creado correctamente");

END;	
//
delimiter ;
SELECT nuevoEstudiante("Pablo","Martinez","DAW", "prueba3@gmail.com");

/* Fin de funcion */

	
	/* Obtener el enums //No funciona
	drop PROCEDURE if EXISTS obtenerEnum;

	delimiter //

	CREATE PROCEDURE obtenerEnum(nomCol varchar(20)) 
	BEGIN
	SELECT SUBSTRING(SUBSTRING(COLUMN_TYPE,6),((-1)*(length(SUBSTRING(COLUMN_TYPE,5))-1)),((length(SUBSTRING(COLUMN_TYPE,5)))-2))
	FROM information_schema.COLUMNS
	WHERE TABLE_SCHEMA='tetuanjobs' 
	AND TABLE_NAME='estudiantes'
	AND COLUMN_NAME=nomCol;
	END;
	//
	delimiter ;

	call obtenerEnum('ciclo');*/



