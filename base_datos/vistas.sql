/** VISTAS GENERALES **/

/** VISTA LISTAR PROVINCIAS **/

CREATE OR REPLACE VIEW tetuanjobs.listarProvincias as 
     select id_provincia as identificador, nombre_provincia as nombre from tetuanjobs.provincias order by nombre;

GRANT select on tetuanjobs.listarProvincias To 'usertetuan'@'localhost';

/** FIN VISTA LISTAR PROVINCIAS **/

/** VISTA LISTAR ETIQUETAS **/

CREATE OR REPLACE VIEW tetuanjobs.listarEtiquetas as 
     select id_etiqueta as identificador, nombre_etiqueta as nombre from tetuanjobs.etiquetas order by nombre;

GRANT select on tetuanjobs.listarEtiquetas To 'usertetuan'@'localhost';

/** FIN VISTA LISTAR ETIQUETAS **/

/** VISTA LISTAR Idiomas **/

CREATE OR REPLACE VIEW tetuanjobs.listarIdiomas as 
     select id_idioma as identificador, nombre_idioma as nombre from tetuanjobs.idiomas order by nombre;

GRANT select on tetuanjobs.listarIdiomas To 'usertetuan'@'localhost';

/** FIN VISTA LISTAR Idiomas **/

/** VISTAS GENERALES **/

/** FILTRO DE USUARIOS **/

/** VISTA LISTAR USUARIOS **/

CREATE OR REPLACE VIEW tetuanjobs.listarUsuarios as 
	select us.id_usuario as identificador,email, nombre, apellidos, ciclo,
             CASE 
                  WHEN activo = 1 
                  THEN "Activo" 
                  ELSE "Pendiente" 
             END as estado
             from tetuanjobs.usuarios as us join tetuanjobs.estudiantes as est 
             on us.id_usuario = est.id_usuario 
             where tipo_usuario = "estudiante";

GRANT select on tetuanjobs.listarUsuarios To 'usertetuan'@'localhost';

/** FIN VISTA LISTAR USUARIOS**/


/** VISTA LISTAR empresas **/

CREATE OR REPLACE VIEW tetuanjobs.listarEmpresas as 
	select id_empresa as identificador, nombre_empresa as nombre, emp_web as web, email as correo, 
      telefono, persona_contacto as contacto
             from tetuanjobs.empresas;

GRANT select on tetuanjobs.listarEmpresas To 'usertetuan'@'localhost';

/** FIN VISTA LISTAR empresas**/

/** VISTA LISTAR EXPERIENCIA **/

CREATE OR REPLACE VIEW tetuanjobs.listarExperiencia as 
  select id_experiencia as identificador, titulo_puesto as titulo, nombre_empresa as empresa, f_inicio as fecha_ini, 
  if(actualmente,"actualmente",f_fin) as fecha_fin, experiencia_desc as descripcion      
             from tetuanjobs.experiencia;

GRANT select on tetuanjobs.listarExperiencia To 'usertetuan'@'localhost';

/** FIN VISTA LISTAR EXPERIENCIA **/

/** FIN FILTRO DE USUARIOS**/




