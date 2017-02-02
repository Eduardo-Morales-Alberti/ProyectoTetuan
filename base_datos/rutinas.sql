
/* Conexión base de datos
mysql.exe -h localhost -u root -p

*/

/** RUTINAS GENERALES **/
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
END//
delimiter ;	

/*call tetuanjobs.obtenerEnum('ciclo');*/

/* Fin del procedimiento */

/** RUTINA PARA ELIMINAR UN USUARIO **/
drop PROCEDURE if EXISTS tetuanjobs.eliminarUsuario;

delimiter //
CREATE PROCEDURE tetuanjobs.eliminarUsuario(id_us int) 
	BEGIN
	delete from tetuanjobs.estudiantes where id_usuario = id_us;

	delete from tetuanjobs.usuarios where id_usuario = id_us and tipo_usuario = "estudiante";


END//
delimiter ;
/*call tetuanjobs.eliminarUsuario(1);*/

/** FIN RUTINA PARA ELIMINAR UN USUARIO **/

/** FIN RUTINAS GENERALES **/


/** RUTINAS LOGIN **/

/** RUTINA COMPROBACIÓN USUARIO EXISTE **/

DROP PROCEDURE IF EXISTS tetuanjobs.compAcceso;

delimiter //

CREATE PROCEDURE tetuanjobs.compAcceso(mail varchar(100), contr varchar(41)) 
BEGIN
	declare id int default -1;
	declare tipo varchar(20);

	SELECT id_usuario into id from tetuanjobs.usuarios where email = mail AND
	password = password(contr) AND activo = 1;

	SELECT tipo_usuario into tipo from tetuanjobs.usuarios where email = mail AND
	password = password(contr) AND activo = 1;
	

	if id >= 0 and tipo = "estudiante" then 
	SELECT nombre, id_usuario as identificador, "estudiante" as "tipo_usuario" from tetuanjobs.estudiantes where id_usuario = id;
	elseif id >= 0 and tipo = "administrador" then 
	SELECT "Administrador" as nombre, id as identificador, tipo as "tipo_usuario";
	else
	SELECT false as mensaje;
	END IF;

END//
delimiter ;	

/*call tetuanjobs.compAcceso('prueba4@gmail.com','pruebadeacceso');*/
/*call tetuanjobs.compAcceso('admin@gmail.com','admintetuan');*/
/*call tetuanjobs.compAcceso('eduardomoberti@hotmail.com','estudiantetetuan');*/


/** FIN RUTINA COMPROBACIÓN USUARIO EXISTE **/

/** RESTABLECER EMAIL **/

/** FUNCION PARA ESTABLECER LA CLAVE **/


DROP PROCEDURE IF EXISTS tetuanjobs.restEmail;

delimiter //

CREATE PROCEDURE tetuanjobs.restEmail(mail varchar(100)) 
BEGIN	
	declare clave varchar(41);
	declare existe boolean default false;

	select password(rand()) into clave;

	SELECT true into existe from tetuanjobs.usuarios where email = mail AND activo = 1;

	if existe then
		update tetuanjobs.usuarios set restablecer = 1, clave_rest=clave 
		where email = mail AND activo = 1;

		SELECT clave_rest as hashing, existe from tetuanjobs.usuarios where email = mail AND activo = 1;
	else
		SELECT false as existe;
	END IF;

	/*SELECT existe;*/
	

END//
delimiter ;	

/*call tetuanjobs.restEmail('eduardomoberti@hotmail.com');*/

/** FIN FUNCION PARA ESTABLECER LA CLAVE **/

/** RUTINA PARA COMPROBAR QUE TODO ES CORRECTO **/

DROP PROCEDURE IF EXISTS tetuanjobs.testRestContr;

delimiter //

CREATE PROCEDURE tetuanjobs.testRestContr(mail varchar(100), clave varchar(41)) 
BEGIN	
	
	declare existe boolean default false;	

	SELECT true into existe from tetuanjobs.usuarios 
	 where email = mail AND activo = 1 
	and restablecer = 1 and clave_rest = clave;	

	SELECT existe;

END//
delimiter ;	

/*call tetuanjobs.testRestContr('eduardomoberti@hotmail.com','*FA33BA8C06BF2BA5E47CB77823D126E1D78877C2');*/

/** RUTINA PARA COMPROBAR QUE TODO ES CORRECTO **/

/** RUTINA PARA ACTUALIZAR LA CONTRASEÑA **/

DROP PROCEDURE IF EXISTS tetuanjobs.cambiarContrRest;

delimiter //

CREATE PROCEDURE tetuanjobs.cambiarContrRest(mail varchar(100), clave varchar(41), contr varchar(41)) 
BEGIN	
	declare existe boolean default false;	

	SELECT true into existe from tetuanjobs.usuarios where email = mail AND activo = 1 
	and restablecer = 1 and clave_rest = clave;	

	if existe then

		update tetuanjobs.usuarios set password = password(contr), clave_rest = null, restablecer = 0
		 where email = mail AND activo = 1 
		and restablecer = 1 and clave_rest = clave;	

		SELECT true as resultado, nombre, id_estudiante as identificador, tipo_usuario 
		from tetuanjobs.usuarios as usr join tetuanjobs.estudiantes as est
			on usr.id_usuario = est.id_usuario
	 			where email = mail AND activo = 1 and password = password(contr);	

	else
		select false as resultado;
	END IF;


END//
delimiter ;	

/*call tetuanjobs.cambiarContrRest('eduardomoberti@hotmail.com','*E65BE8C64909EA20CB232EE91E0E5230B4540214','prueba'); */

/** RUTINA PARA ACTUALIZAR LA CONTRASEÑA **/

/** FIN RESTABLECER EMAIL **/

/* Funcion para crear un nuevo estudiante */

drop PROCEDURE if EXISTS tetuanjobs.nuevoEstudiante;

delimiter //

CREATE PROCEDURE tetuanjobs.nuevoEstudiante(nomb varchar(25), ape varchar(50),ccl varchar(20),
	mail varchar(100)) 
BEGIN
	declare mensaje varchar(250) default "";
	declare identificador int(11) unsigned;
	

	INSERT INTO tetuanjobs.usuarios (email,tipo_usuario) 
		values(mail,'estudiante');
		set identificador = @@IDENTITY;

	INSERT INTO tetuanjobs.estudiantes 
		(`id_estudiante`, `id_usuario`, `ciclo`, `nombre`, `apellidos`) 
		VALUES (NULL, identificador,ccl,nomb, ape);

	select concat("Usuario ",nomb," creado correctamente") as mensaje;

END//
delimiter ;
/*call tetuanjobs.nuevoEstudiante("Carlos","Navarro","ASIR", "prueba4@gmail.com");*/

/* Fin de funcion */

/** FUNCION NUEVA EMPRESA **/

drop PROCEDURE if EXISTS tetuanjobs.nuevaEmpresa;

delimiter //

CREATE PROCEDURE tetuanjobs.nuevaEmpresa(nomb_emp varchar(250),nomb_c varchar(250),
 web varchar(250), mail varchar(100), telf varchar(9))
BEGIN
	declare creada boolean default false;
	declare identificador int(11) default -1;

	SELECT true into creada from tetuanjobs.empresas where nombre_empresa = nomb_emp AND
	email = mail;

	IF creada = false then 

		INSERT INTO tetuanjobs.empresas (nombre_empresa, persona_contacto,
			emp_web,email,telefono) 
			values(nomb_emp,nomb_c,web, mail,telf);
		/*if telf is not null then 
		 update tetuanjobs.empresas set telefono = telf where id_empresa = @@IDENTITY;
		end if;*/

		set identificador = @@IDENTITY;

		SELECT true as mensaje;
	
	else
		SELECT false as mensaje;
	END IF;


END//
delimiter ;
/*call tetuanjobs.nuevaEmpresa("Microsoft","Prueba","microsoft.com", "prueba@microsoft.com");*/

/* Fin de funcion */

/** FIN FUNCION NUEVA EMPRESA **/

/** FIN RUTINAS LOGIN **/


/** RUTINAS PERFIL ESTUDIANTE **/

/* Función para modificar Usuario */
drop PROCEDURE if EXISTS tetuanjobs.modificarUsuario;

delimiter //
CREATE PROCEDURE tetuanjobs.modificarUsuario(id_us int, nomb varchar(25), ape varchar(50),
telef varchar(9), id_prov int,pobl varchar(250),codpos int, ft varchar(250),
  c_v varchar(250) , descp varchar(3000), carnt tinyint) 
	BEGIN

update tetuanjobs.estudiantes set nombre = if(nomb is not null, nomb, nombre), 
	apellidos = if(ape is not null, ape, apellidos),telefono = if(telef is not null, telef,telefono), 
	poblacion = if(pobl is not null, pobl, poblacion), 
	cod_postal = if(codpos is not null, codpos, cod_postal), 
	foto = if(ft is not null, ft, foto), cv = if(c_v is not null, c_v, cv), 
	descripcion = if(descp is not null, descp, descripcion),
	carnet = if(carnt is not null,carnt, carnet), 
	id_provincia = if(id_prov is not null, id_prov,id_provincia) 
	where id_usuario = id_us;

	SELECT * from tetuanjobs.estudiantes where id_usuario = id_us;


END//
delimiter ;

/*call tetuanjobs.modificarUsuario(1,null, null, "625879852",null,null,null,null,null,1,null );*/

/* fin Función para modificar Usuario*/

/* Función para modificar la contraseña */
drop PROCEDURE if EXISTS tetuanjobs.cambiarContr;

delimiter //

CREATE PROCEDURE tetuanjobs.cambiarContr(usid int,contract varchar(20), contrnv varchar(20)) 
	BEGIN
		declare c varchar(41);

		SELECT password into c from tetuanjobs.usuarios where id_usuario = usid;
		if c = password(contract) then 
			update tetuanjobs.usuarios set password = password(contrnv) where id_usuario = usid;
			SELECT true as cambiada;
		else
			SELECT false as cambiada;		
		END IF;
		
	END//
delimiter ;
/*call tetuanjobs.cambiarContr(4,"admintetuan","nuevacontraseña");*/

/* fin Función para modificar la contraseña */

/** Funcion para crear nuevo experiencia de trabajo **/

drop PROCEDURE if EXISTS tetuanjobs.nuevaExperiencia;

delimiter //

CREATE PROCEDURE tetuanjobs.nuevaExperiencia(usid int, titulo varchar(200),nombre varchar(200),
f_ini date,f_final date,actualmente boolean, descripcion varchar(3000)) 
	BEGIN
		declare id int default -1;
		declare diferencia int default -1;

		SELECT id_estudiante into id from tetuanjobs.estudiantes where id_usuario = usid;

		if id >=0 then

			INSERT INTO tetuanjobs.experiencia (id_estudiante, titulo_puesto, nombre_empresa,
				f_inicio,experiencia_desc) values(id, titulo, nombre,f_ini, descripcion);

			select true as resultado;

			if actualmente is not null and actualmente then
				update tetuanjobs.experiencia set actualmente = true
					where id_estudiante = id;
			elseif f_final is not null then
				
				select datediff(f_final,f_ini) into diferencia;
				if diferencia >= 0 then 
					update tetuanjobs.experiencia set f_fin = f_final
						where id_estudiante = id;	
				else 
					update tetuanjobs.experiencia set f_fin = curdate()
						where id_estudiante = id;
				end if;
			end if;
			
		else 
			select false as resultado;
		end if;
		
		
	END//
delimiter ;

/*call tetuanjobs.nuevaExperiencia(2,"Prueba diff 1", "Apple", "2015-05-01","2015-06-01",
	null,"Un puesto bonito");*/

/** Fin Funcion para crear nuevo experiencia de trabajo **/


/** RUTINA PARA ELIMINAR UNA EXPERIENCIA **/
drop PROCEDURE if EXISTS tetuanjobs.eliminarExperiencia;

delimiter //
CREATE PROCEDURE tetuanjobs.eliminarExperiencia(id_us int,id_exp int) 
	BEGIN
	declare r boolean default false;
	declare ext boolean default false;

	select true into r from tetuanjobs.estudiantes est join tetuanjobs.experiencia exp 
	on est.id_estudiante =  exp.id_estudiante where id_usuario = id_us limit 1;

	select true into ext from tetuanjobs.experiencia where id_experiencia = id_exp;

	if r then
		delete from tetuanjobs.experiencia where id_experiencia = id_exp;
		select true as resultado;
	else 
		select false as resultado;
	end if;

END//
delimiter ;

/** FIN RUTINA PARA ELIMINAR UNA EXPERIENCIA **/

/** Funcion para crear nueva educación **/

drop PROCEDURE if EXISTS tetuanjobs.nuevaFormacion;

delimiter //

CREATE PROCEDURE tetuanjobs.nuevaFormacion(usid int, titulo varchar(200),nombre varchar(200),
f_ini date,f_final date,actualmente boolean, descripcion varchar(3000), clasificacion varchar(200)) 
	BEGIN
		declare id int default -1;
		declare diferencia int default -1;

		SELECT id_estudiante into id from tetuanjobs.estudiantes where id_usuario = usid;

		if id >=0 then

			INSERT INTO tetuanjobs.formacion (id_estudiante, titulo_formacion, institucion,
				f_inicio,formacion_desc,formacion_clasificacion) values(id, titulo, nombre,f_ini, descripcion,clasificacion);

			select true as resultado;

			if actualmente is not null and actualmente then
				update tetuanjobs.formacion set actualmente = true
					where id_estudiante = id;
			elseif f_final is not null then
				
				select datediff(f_final,f_ini) into diferencia;
				if diferencia >= 0 then 
					update tetuanjobs.formacion set f_fin = f_final
						where id_estudiante = id;	
				else 
					update tetuanjobs.formacion set f_fin = curdate()
						where id_estudiante = id;
				end if;
			end if;
			
		else 
			select false as resultado;
		end if;
		
		
	END//
delimiter ;

/*call tetuanjobs.nuevaFormacion(2,"Prueba Formacion 1", "Desarrollo web", "2015-05-01","2015-06-01",
	null,"Hemos aprendido un montón", 1);*/

/** Fin Funcion para crear nueva educación **/

/** RUTINA PARA ELIMINAR UNA Educacion **/
drop PROCEDURE if EXISTS tetuanjobs.eliminarEducacion;

delimiter //
CREATE PROCEDURE tetuanjobs.eliminarEducacion(id_us int,id_edc int) 
	BEGIN
	declare r boolean default false;
	declare ext boolean default false;

	select true into r  from tetuanjobs.estudiantes est join tetuanjobs.formacion edc 
	on est.id_estudiante =  edc.id_estudiante where id_usuario = id_us limit 1;

	select true into ext from tetuanjobs.formacion where id_formacion = id_edc;

	if r then
		delete from tetuanjobs.formacion where id_formacion = id_edc;
		select true as resultado;
	else 
		select false as resultado;
	end if;

END//
delimiter ;

/** FIN RUTINA PARA ELIMINAR UNA Educacion **/

/** Funcion para crear nuevo Idioma **/

drop PROCEDURE if EXISTS tetuanjobs.nuevoIdioma;

delimiter //

CREATE PROCEDURE tetuanjobs.nuevoIdioma(usid int, ididioma int, habl int, esc int) 
	BEGIN
		declare id int default -1;

		SELECT id_estudiante into id from tetuanjobs.estudiantes where id_usuario = usid;

		if id >=0 then

			INSERT INTO tetuanjobs.estudiantes_idiomas (id_estudiante,id_idioma, hablado, escrito) 
			values(id, ididioma, habl, esc);

			select true as resultado;			
			
		else 
			select false as resultado;
		end if;
		
		
	END//
delimiter ;

/*call tetuanjobs.nuevoIdioma(2,1, 2,3);*/

/** Fin Funcion para crear nuevo Idioma **/

/** RUTINA PARA ELIMINAR UN Idioma **/
drop PROCEDURE if EXISTS tetuanjobs.eliminarIdioma;

delimiter //
CREATE PROCEDURE tetuanjobs.eliminarIdioma(id_us int,id_idm int) 
	BEGIN
	declare r boolean default false;
	declare ext boolean default false;

	select true into r  from tetuanjobs.estudiantes est join tetuanjobs.estudiantes_idiomas idm 
	on est.id_estudiante =  idm.id_estudiante where id_usuario = id_us limit 1;
	select true into ext from tetuanjobs.estudiantes_idiomas where id_idioma = id_idm;

	if r and ext then		

		delete from tetuanjobs.estudiantes_idiomas where id_idioma = id_idm;
		select true as resultado;
	else 
		select false as resultado;
	end if;

END//
delimiter ;

/** FIN RUTINA PARA ELIMINAR UN Idioma **/

/** RUTINA PARA MODIFICAR UN IDIOMA **/

drop PROCEDURE if EXISTS tetuanjobs.modificarIdioma;

delimiter //
CREATE PROCEDURE tetuanjobs.modificarIdioma(id_us int,id_idm int, h int, esc int) 
	BEGIN
	declare r boolean default false;
	declare ext boolean default false;

	select true into r  from tetuanjobs.estudiantes est join tetuanjobs.estudiantes_idiomas idm 
	on est.id_estudiante =  idm.id_estudiante where id_usuario = id_us limit 1;
	select true into ext from tetuanjobs.estudiantes_idiomas where id_idioma = id_idm;

	if r and ext then		

		update tetuanjobs.estudiantes_idiomas set hablado = h, escrito = esc where id_idioma = id_idm;
		select true as resultado;
	else 
		select false as resultado;
	end if;

END//
delimiter ;

/** RUTINA PARA MODIFICAR UN IDIOMA **/


/** funcion para cargar información de estudiante por id **/

drop PROCEDURE if EXISTS tetuanjobs.cargarInfoEstudiante;

delimiter //

CREATE PROCEDURE tetuanjobs.cargarInfoEstudiante(usid int) 
	BEGIN	

		SELECT nombre, apellidos, telefono, id_provincia as provincia, poblacion, cod_postal as cod_postal,
		foto as fotografia, cv as curriculum, descripcion, carnet
		 from tetuanjobs.estudiantes where id_usuario = usid;		
		
	END//
delimiter ;


/** fin funcion para cargar información de estudiante por id **/


/** FIN RUTINAS PERFIL ESTUDIANTE **/

/** RUTINAS FILTRO DE USUARIOS **/

/** FUNCION PARA DAR DE ALTA UN USUARIO O DAR DE BAJA SI ESTÁ DADO DE ALTA **/

drop PROCEDURE if EXISTS tetuanjobs.cambiarEstado;

delimiter //
CREATE PROCEDURE tetuanjobs.cambiarEstado(id_us int) 
	BEGIN

update tetuanjobs.usuarios set activo = if(activo = 1, 0, 1)
	where id_usuario = id_us and tipo_usuario = "estudiante";

	SELECT * from tetuanjobs.usuarios where id_usuario = id_us;

END//
delimiter ;

/*call tetuanjobs.cambiarEstado(2);*/


/** FIN FUNCION PARA DAR DE ALTA UN USUARIO O DAR DE BAJA SI ESTÁ DADO DE ALTA **/

/** FIN RUTINAS FILTRO DE USUARIOS **/


/** RUTINAS FILTRO DE EMPRESAS **/

/** RUTINA PARA ELIMINAR UNA EMPRESA **/

drop PROCEDURE if EXISTS tetuanjobs.eliminarEmpresa;

delimiter //
CREATE PROCEDURE tetuanjobs.eliminarEmpresa(id_emp int) 
	BEGIN
	delete from tetuanjobs.empresas where id_empresa = id_emp;

END//
delimiter ;


/** FIN RUTINA PARA ELIMINAR UNA EMPRESA **/

/** RUTINA PARA MODIFICAR UNA EMPRESA **/

drop PROCEDURE if EXISTS tetuanjobs.modificarEmpresa;

delimiter //
CREATE PROCEDURE tetuanjobs.modificarEmpresa(id_emp int, 
	web varchar(250), mail varchar(100),telef varchar(9), contacto varchar(250)) 
	BEGIN

update tetuanjobs.empresas set 
	emp_web = if(web is not null, web,emp_web), email = if(mail is not null, mail,email), 
	telefono = if(telef is not null, telef,telefono),persona_contacto = if(contacto is not null, contacto,persona_contacto)
	where id_empresa = id_emp;

	SELECT * from tetuanjobs.empresas where id_empresa  = id_emp;

END//
delimiter ;

/** FIN RUTINA PARA MODIFICAR UNA EMPRESA **/


/** FIN RUTINAS FILTRO DE EMPRESAS **/




