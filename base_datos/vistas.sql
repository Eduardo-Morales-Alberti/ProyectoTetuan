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

/** VISTA LISTAR EMPRESAS **/

CREATE OR REPLACE VIEW tetuanjobs.listarEmpresasSelect as 
     select id_empresa as identificador, nombre_empresa as nombre from tetuanjobs.empresas order by nombre;

GRANT select on tetuanjobs.listarEmpresasSelect To 'usertetuan'@'localhost';

/** FIN VISTA LISTAR EMPRESAS **/

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
/** FIN FILTRO DE USUARIOS**/

/** FILTRO DE empresas**/

/** VISTA LISTAR empresas **/

CREATE OR REPLACE VIEW tetuanjobs.listarEmpresas as 
	select nombre_empresa as nombre, id_empresa as identificador, emp_web as web, email as correo, 
      telefono, persona_contacto as contacto
             from tetuanjobs.empresas;

GRANT select on tetuanjobs.listarEmpresas To 'usertetuan'@'localhost';

/** FIN VISTA LISTAR empresas**/

/** FIN FILTRO DE empresas**/

/** Perfil estudiante **/

/** VISTA LISTAR EXPERIENCIA **/

CREATE OR REPLACE VIEW tetuanjobs.listarExperiencia as 
  select id_experiencia as identificador, titulo_puesto as titulo, nombre_empresa as empresa, f_inicio as fecha_ini, 
  if(actualmente,"actualmente",f_fin) as fecha_fin, experiencia_desc as descripcion,id_usuario as estudiante      
             from tetuanjobs.experiencia ex join tetuanjobs.estudiantes e on
             ex.id_estudiante = e.id_estudiante order by fecha_ini desc;

GRANT select on tetuanjobs.listarExperiencia To 'usertetuan'@'localhost';

/** FIN VISTA LISTAR EXPERIENCIA **/

/** VISTA LISTAR EDUCACION **/

CREATE OR REPLACE VIEW tetuanjobs.listarEducacion as 
  select id_formacion as identificador, titulo_formacion as titulo, institucion, formacion_clasificacion as grado,
  f_inicio as fecha_ini,  if(actualmente,"actualmente",f_fin) as fecha_fin, 
  formacion_desc as descripcion, id_usuario as estudiante
             from tetuanjobs.formacion f  join tetuanjobs.estudiantes e on
             f.id_estudiante = e.id_estudiante order by fecha_ini desc;

GRANT select on tetuanjobs.listarEducacion To 'usertetuan'@'localhost';

/** FIN VISTA LISTAR EDUCACION **/

/** VISTA LISTAR Idiomas **/

CREATE OR REPLACE VIEW tetuanjobs.listarIdiomasEst as 
  select id.id_idioma as identificador,nombre_idioma as nombre, hablado, escrito, id_usuario as estudiante
             from tetuanjobs.idiomas id join tetuanjobs.estudiantes_idiomas est_id on
             id.id_idioma = est_id.id_idioma
              join tetuanjobs.estudiantes e on
             est_id.id_estudiante = e.id_estudiante;

GRANT select on tetuanjobs.listarIdiomasEst To 'usertetuan'@'localhost';

/** FIN VISTA LISTAR Idiomas **/

/** vista listar skills **/

CREATE OR REPLACE VIEW tetuanjobs.listarSkills as 
     select etq.id_etiqueta as identificador, nombre_etiqueta as nombre, usu.id_usuario usuario 
     from tetuanjobs.etiquetas etq left join 
     tetuanjobs.estudiantes_etiquetas estetq on etq.id_etiqueta = estetq.id_etiqueta left join tetuanjobs.estudiantes est
     on estetq.id_estudiante = est.id_estudiante left join tetuanjobs.usuarios usu on est.id_usuario = usu.id_usuario 
      order by etq.id_etiqueta;

GRANT select on tetuanjobs.listarSkills To 'usertetuan'@'localhost';

/** fin vista listar skills **/

/** fin Perfil estudiante **/







