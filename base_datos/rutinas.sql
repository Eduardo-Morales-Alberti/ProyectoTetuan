
/* Conexión base de datos
mysql.exe -h localhost -u root -p
*/

/* Funcion para crear un nuevo estudiante*/
use tetuanjobs
drop FUNCTION if EXISTS tetuanjobs.nuevoEstudiante;

delimiter //

CREATE FUNCTION tetuanjobs.nuevoEstudiante(nomb varchar(25), ape varchar(50),ccl varchar(20),
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
SELECT tetuanjobs.nuevoEstudiante("Carlos","Navarro","ASIR", "prueba4@gmail.com");

/* Fin de funcion */

/* Función para modificar Usuario */
drop PROCEDURE if EXISTS tetuanjobs.modificarUsuario;

delimiter //
CREATE PROCEDURE tetuanjobs.modificarUsuario(id_est int, nomb varchar(25), ape varchar(50),
telef varchar(9),pobl varchar(250),codpos int, ft varchar(250),
  c_v varchar(250) , descp varchar(3000), carnt tinyint,
  id_prov int) 
	BEGIN

update tetuanjobs.estudiantes set nombre = if(nomb is not null, nomb, nombre), 
	apellidos = if(ape is not null, ape, apellidos),telefono = if(telef is not null, telef,telefono), 
	poblacion = if(pobl is not null, pobl, poblacion), 
	cod_postal = if(codpos is not null, codpos, cod_postal), 
	foto = if(ft is not null, ft, foto), cv = if(c_v is not null, c_v, cv), 
	descripcion = if(descp is not null, descp, descripcion),
	carnet = if(carnt is not null,carnt, carnet), 
	id_provincia = if(id_prov is not null, id_prov,id_provincia) 
	where id_estudiante = id_est;

	SELECT * from tetuanjobs.estudiantes where id_estudiante = id_est;

END;
//
delimiter ;

call tetuanjobs.modificarUsuario(1,null, null, "625879852",null,null,null,null,null,1,null );

/* fin Función para modificar Usuario*/

/* Función para modificar la contraseña */
drop FUNCTION if EXISTS tetuanjobs.cambiarContr;

delimiter //

CREATE FUNCTION tetuanjobs.cambiarContr(usid int,contract varchar(20), contrnv varchar(20)) 
	returns varchar(250)
	BEGIN
		declare c varchar(41);

		SELECT password into c from tetuanjobs.usuarios where id_usuario = usid;
		if c = password(contract) then 
			update tetuanjobs.usuarios set password = password(contrnv) where id_usuario = usid;
			return "contraseña actualizada";
		else

			return "contraseña no válida";		
		END IF;
		
	END;
//
delimiter ;
SELECT tetuanjobs.cambiarContr(4,"admintetuan","nuevacontraseña");

/* Función para modificar la contraseña */

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

call tetuanjobs.obtenerEnum('ciclo');

/* Fin del procedimiento */



